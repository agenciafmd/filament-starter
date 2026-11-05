<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

use function Pest\Laravel\get;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

beforeEach(function (): void {
    $this->hotFile = storage_path('framework/testing/color-mode.hot');
    File::ensureDirectoryExists(dirname($this->hotFile));
    File::put($this->hotFile, 'http://vite.test');
    Vite::useHotFile($this->hotFile);
});

afterEach(function (): void {
    File::delete($this->hotFile);
});

it('applies the saved theme or the system theme to the html element', function (): void {
    $view = $this->blade('<x-frontend::color-mode />');

    $view->assertSeeInOrder([
        "localStorage.getItem('theme')",
        "matchMedia('(prefers-color-scheme: dark)')",
        "document.documentElement.setAttribute('data-bs-theme', theme)",
    ], false);
});

it('applies the theme before loading the stylesheet on the html pages', function (): void {
    $response = get('/html/');

    $response->assertOk()
        ->assertSeeInOrder([
            "setAttribute('data-bs-theme', theme)",
            '<link rel="stylesheet" href="http://vite.test/resources/scss/frontend.scss"',
        ], false);
});

it('renders the theme toggle in the html header', function (): void {
    $response = get('/html/tema');

    $response->assertOk()
        ->assertSee('js-color-mode-toggle', false);
});
