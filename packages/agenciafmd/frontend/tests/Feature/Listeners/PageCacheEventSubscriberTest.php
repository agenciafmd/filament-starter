<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\Listeners;

use Agenciafmd\Frontend\Listeners\PageCacheEventSubscriber;
use Agenciafmd\Frontend\Providers\EventServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Silber\PageCache\Cache;
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

function articleModel(string $slug): Model
{
    $model = new class extends Model
    {
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
    Http::assertSent(static fn ($request): bool => $request->url() === url('blog/novo'));
});

it('does not clear the whole cache when the model url is the home page', function (): void {
    Http::fake([url('/') => Http::response()]);
    $home = cachePage('pc__index__pc.html');
    $article = cachePage('blog/artigo.html');
    $model = new class extends Model
    {
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
    Http::fake([url('/') => static fn () => throw new ConnectionException('timeout')]);

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
    Http::assertSent(static fn ($request): bool => $request->url() === url('contato'));
});
