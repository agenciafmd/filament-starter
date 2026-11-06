<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\Listeners;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Banners\Models\Banner;
use Agenciafmd\Frontend\Listeners\PageCacheEventSubscriber;
use Agenciafmd\Frontend\Providers\EventServiceProvider;
use Agenciafmd\Settings\Settings\ScriptsSettings;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Silber\PageCache\Cache;
use Spatie\LaravelSettings\Events\SettingsSaved;
use Tests\TestCase;
use Throwable;

use function Illuminate\Support\defer;

pest()->extend(TestCase::class);

beforeEach(function (): void {
    $this->cachePath = storage_path('framework/testing/page-cache');
    File::ensureDirectoryExists($this->cachePath . '/blog');
    resolve(Cache::class)->setCachePath($this->cachePath);
});

afterEach(function (): void {
    File::deleteDirectory($this->cachePath);
});

function cachePage(string $file): string
{
    $path = test()->cachePath . '/' . $file;
    File::put($path, '<html></html>');

    return $path;
}

/**
 * O subscriber não registra eventos no console (e os testes rodam no console).
 */
function subscribeAsWebRequest(): void
{
    (fn (): false => $this->isRunningInConsole = false)->call(app());

    try {
        Event::subscribe(PageCacheEventSubscriber::class);
    } finally {
        (fn (): true => $this->isRunningInConsole = true)->call(app());
    }
}

function articleModel(string $slug): Model
{
    $model = new class extends Model
    {
        use HasFactory;

        /**
         * @return Attribute<string, never>
         */
        protected function url(): Attribute
        {
            return Attribute::get(static fn (mixed $value, array $attributes): string => url('blog/' . $attributes['slug']));
        }
    };

    $model->setRawAttributes(['slug' => $slug], sync: true);

    return $model;
}

it('registers the subscriber through the frontend service provider', function (): void {
    expect(app()->getProviders(EventServiceProvider::class))->not->toBeEmpty();
});

it('clears only the home page and warms it up once after the response', function (): void {
    Http::preventStrayRequests();
    Http::fake([url('/') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');

    $subscriber = new PageCacheEventSubscriber();
    $subscriber->homeHandler();
    $subscriber->homeHandler();

    expect($home)->not->toBeFile()
        ->and($article)->toBeFile();
    Http::assertNothingSent();

    defer()->invoke();

    Http::assertSentCount(1);
});

it('clears the page of the model and of its previous url when the slug changes', function (): void {
    Http::preventStrayRequests();
    Http::fake([url('blog/novo') => Http::response()]);
    $previous = cachePage('blog/antigo.html');
    $current = cachePage('blog/novo.html');
    $other = cachePage('blog/outro.html');
    $model = articleModel('antigo');
    $model->setAttribute('slug', 'novo');

    new PageCacheEventSubscriber()->modelUrlHandler($model);
    defer()->invoke();

    expect($previous)->not->toBeFile()
        ->and($current)->not->toBeFile()
        ->and($other)->toBeFile();
    Http::assertSent(static fn (Request $request): bool => $request->url() === url('blog/novo'));
});

it('does not clear the whole cache when the model url is the home page', function (): void {
    Http::fake([url('/') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');
    $model = new class extends Model
    {
        use HasFactory;

        /**
         * @return Attribute<string, never>
         */
        protected function url(): Attribute
        {
            return Attribute::get(static fn (): string => url('/'));
        }
    };

    new PageCacheEventSubscriber()->modelUrlHandler($model);

    expect($home)->not->toBeFile()
        ->and($article)->toBeFile();
});

it('leaves the detail pages untouched when the table is reordered', function (): void {
    Http::preventStrayRequests();
    $article = cachePage('blog/artigo.html');

    new PageCacheEventSubscriber()->modelUrlHandler(['3', '1', '2']);
    defer()->invoke();

    expect($article)->toBeFile();
    Http::assertNothingSent();
});

it('keeps the admin flow working when the warm up request fails', function (): void {
    Http::fake([url('/') => static fn (): never => throw new ConnectionException('timeout')]);

    new PageCacheEventSubscriber()->homeHandler();

    expect(fn () => defer()->invoke())->not->toThrow(Throwable::class);
});

it('clears and warms up only the given page', function (): void {
    Http::preventStrayRequests();
    Http::fake([url('contato') => Http::response()]);
    $contact = cachePage('contato.html');
    $home = cachePage('pc__index__pc.html');

    new PageCacheEventSubscriber()->urlHandler('/contato');
    defer()->invoke();

    expect($contact)->not->toBeFile()
        ->and($home)->toBeFile();
    Http::assertSent(static fn (Request $request): bool => $request->url() === url('contato'));
});

it('does not subscribe to any event when running in the console', function (): void {
    expect(new PageCacheEventSubscriber()->subscribe())->toBeEmpty();
});

it('clears the home page when a banner is saved, deleted, restored or reordered', function (string $event, mixed $payload): void {
    Http::fake([url('/') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    subscribeAsWebRequest();

    Event::dispatch("eloquent.{$event}: " . Banner::class, [$payload]);

    expect($home)->not->toBeFile();
})->with([
    'saved' => ['saved', fn (): Model => articleModel('artigo')],
    'deleted' => ['deleted', fn (): Model => articleModel('artigo')],
    'restored' => ['restored', fn (): Model => articleModel('artigo')],
    'reordered' => ['reordered', fn (): array => ['3', '1', '2']],
]);

it('clears the home and the article page when an article is saved', function (): void {
    Http::fake([url('/') => Http::response(), url('blog/artigo') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');
    subscribeAsWebRequest();

    Event::dispatch('eloquent.saved: ' . Article::class, [articleModel('artigo')]);

    expect($home)->not->toBeFile()
        ->and($article)->not->toBeFile();
});

it('clears the whole cache and warms up the home page', function (): void {
    Http::preventStrayRequests();
    Http::fake([url('/') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');

    new PageCacheEventSubscriber()->clearAll();
    defer()->invoke();

    expect($home)->not->toBeFile()
        ->and($article)->not->toBeFile();
    Http::assertSent(static fn (Request $request): bool => $request->url() === url('/'));
});

it('uses only the url path when the model url has another host', function (): void {
    Http::fake(['https://www.example.com/*' => Http::response()]);
    $article = cachePage('blog/artigo.html');
    $model = new class extends Model
    {
        use HasFactory;

        /**
         * @return Attribute<string, never>
         */
        protected function url(): Attribute
        {
            return Attribute::get(static fn (): string => 'https://www.example.com/blog/artigo');
        }
    };

    new PageCacheEventSubscriber()->modelUrlHandler($model);

    expect($article)->not->toBeFile();
});

it('does nothing when the model has no url', function (): void {
    Http::preventStrayRequests();
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');

    new PageCacheEventSubscriber()->modelUrlHandler(new class extends Model
    {
        use HasFactory;
    });
    defer()->invoke();

    expect($home)->toBeFile()
        ->and($article)->toBeFile();
    Http::assertNothingSent();
});

it('reports the failure to clear the cache and still warms up the page', function (): void {
    Exceptions::fake();
    Http::preventStrayRequests();
    Http::fake([url('/') => Http::response()]);
    $this->mock(Cache::class)
        ->shouldReceive('forget')
        ->andThrow(new RuntimeException('disk full'));

    new PageCacheEventSubscriber()->homeHandler();
    defer()->invoke();

    Exceptions::assertReported(RuntimeException::class);
    Http::assertSent(static fn (Request $request): bool => $request->url() === url('/'));
});

it('clears the whole cache when the admix settings are saved', function (): void {
    Http::fake([url('/') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');
    subscribeAsWebRequest();

    Event::dispatch(new SettingsSaved(new ScriptsSettings()));

    expect($home)->not->toBeFile()
        ->and($article)->not->toBeFile();
});
