<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

beforeEach(function (): void {
    $this->hotFile = storage_path('framework/testing/pdf.hot');
    File::ensureDirectoryExists(dirname($this->hotFile));
    File::put($this->hotFile, 'http://vite.test');
    Vite::useHotFile($this->hotFile);
});

afterEach(function (): void {
    File::delete($this->hotFile);
});

it('links the pdf served by vite and opens it in a new tab', function (): void {
    $view = $this->blade('<x-frontend::pdf name="catalogo" label="Catálogo" />');

    $view->assertSee('href="http://vite.test/resources/pdf/catalogo.pdf"', false)
        ->assertSee('target="_blank"', false)
        ->assertDontSee('download', false);
});

it('downloads the pdf when asked to', function (): void {
    $view = $this->blade('<x-frontend::pdf name="catalogo" label="Catálogo" :download="true" />');

    $view->assertSee('download', false)
        ->assertDontSee('target="_blank"', false);
});
