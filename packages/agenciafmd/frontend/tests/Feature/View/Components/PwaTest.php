<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

beforeEach(function (): void {
    $this->hotFile = storage_path('framework/testing/pwa.hot');
    File::ensureDirectoryExists(dirname($this->hotFile));
    File::put($this->hotFile, 'http://vite.test');
    Vite::useHotFile($this->hotFile);

    $this->manifestPath = public_path('manifest.json');
    $this->originalManifest = File::exists($this->manifestPath) ? File::get($this->manifestPath) : null;
});

afterEach(function (): void {
    File::delete($this->hotFile);

    $this->originalManifest === null
        ? File::delete($this->manifestPath)
        : File::put($this->manifestPath, $this->originalManifest);
});

it('uses the manifest theme color in the head metas', function (): void {
    File::put($this->manifestPath, json_encode(['theme_color' => '#123456']));

    $view = $this->blade('<x-frontend::pwa />');

    $view->assertSee('<link rel="manifest"', false)
        ->assertSee('<meta name="theme-color" content="#123456" />', false)
        ->assertSee('<meta name="msapplication-TileColor" content="#123456" />', false)
        ->assertSee('color="#123456"', false);
});

it('falls back to white and omits the manifest link when the manifest was not generated', function (): void {
    File::delete($this->manifestPath);

    $this->blade('<x-frontend::pwa />')
        ->assertDontSee('<link rel="manifest"', false)
        ->assertSee('<meta name="theme-color" content="#ffffff" />', false);
});
