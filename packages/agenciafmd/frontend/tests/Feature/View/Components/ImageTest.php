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
