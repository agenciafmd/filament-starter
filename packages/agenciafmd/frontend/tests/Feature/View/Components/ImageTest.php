<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

beforeEach(function (): void {
    $this->hotFile = storage_path('framework/testing/image.hot');
    File::ensureDirectoryExists(dirname($this->hotFile));
    File::put($this->hotFile, 'http://vite.test');
    Vite::useHotFile($this->hotFile);
});

afterEach(function (): void {
    File::delete($this->hotFile);
});

it('lazy loads the image with a placeholder by default', function (): void {
    $view = $this->blade('<x-frontend::picture image="banner.jpg" title="Banner" has-breakpoints />');

    $view->assertSee('loading="lazy"', false)
        ->assertSee('src="data:image/gif;base64,', false)
        ->assertDontSee('fetchpriority', false);
});

it('loads the image eagerly with high priority when it is a priority image', function (): void {
    $view = $this->blade('<x-frontend::picture image="banner.jpg" title="Banner" has-breakpoints :priority="true" />');

    $view->assertSee('loading="eager"', false)
        ->assertSee('fetchpriority="high"', false)
        ->assertSee('src="http://vite.test/resources/images/banner.jpg"', false)
        ->assertDontSee('loading="lazy"', false);
});

it('reserves the space of the image with its real size', function (): void {
    $view = $this->blade('<x-frontend::image image="logo.png" title="Logo" is-single-image />');

    $view->assertSee('width="200"', false)
        ->assertSee('height="70"', false);
});

it('uses the size passed to the image', function (): void {
    $view = $this->blade('<x-frontend::image image="logo.png" title="Logo" width="100" height="34" is-single-image />');

    $view->assertSee('width="100"', false)
        ->assertSee('height="34"', false)
        ->assertDontSee('width="200"', false);
});

it('leaves the size out when it cannot read the image', function (string $image): void {
    $view = $this->blade('<x-frontend::image :image="$image" title="Imagem" is-single-image />', ['image' => $image]);

    $view->assertDontSee('width=', false)
        ->assertDontSee('height=', false);
})->with([
    'svg' => 'icons/safari-pinned-tab.svg',
    'missing file' => 'missing.png',
]);

it('uses an external image as it is', function (): void {
    $view = $this->blade('<x-frontend::image image="https://example.com/thumb.jpg" title="Thumb" :priority="true" />');

    $view->assertSee('src="https://example.com/thumb.jpg"', false)
        ->assertSee('srcset="https://example.com/thumb.jpg"', false)
        ->assertDontSee('vite.test', false)
        ->assertDontSee('@2x', false);
});

it('falls back to the youtube thumbnail when the player embed has no image', function (): void {
    $view = $this->blade('<x-frontend::glightbox.player-embed id="video" link="https://www.youtube.com/watch?v=dQw4w9WgXcQ" />');

    $view->assertSee('srcset="https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg"', false)
        ->assertSee('width="480"', false)
        ->assertSee('height="360"', false);
});

it('adds the 2x image to the srcset by default', function (): void {
    $view = $this->blade('<x-frontend::image image="logo.png" title="Logo" />');

    $view->assertSee('srcset="http://vite.test/resources/images/logo.png, http://vite.test/resources/images/logo@2x.png 2x"', false);
});

it('leaves the 2x image out of the srcset when it is a single image', function (): void {
    $view = $this->blade('<x-frontend::image image="logo.png" title="Logo" is-single-image />');

    $view->assertSee('srcset="http://vite.test/resources/images/logo.png"', false)
        ->assertDontSee('@2x', false);
});
