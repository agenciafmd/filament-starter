<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

beforeEach(function (): void {
    $this->hotFile = storage_path('framework/testing/critical-css.hot');
    File::ensureDirectoryExists(dirname($this->hotFile));
    File::put($this->hotFile, 'http://vite.test');
    Vite::useHotFile($this->hotFile);

    $this->criticalFile = public_path('css/critical/pest-critical-css_critical.min.css');
});

afterEach(function (): void {
    File::delete([$this->hotFile, $this->criticalFile]);
});

it('loads the stylesheet as render blocking when the critical css file does not exist', function (): void {
    $view = $this->blade('<x-frontend::critical-css critical="arquivo-inexistente.css" />');

    $view->assertSee('<link rel="stylesheet" href="http://vite.test/resources/scss/frontend.scss"', false)
        ->assertDontSee('<style>', false)
        ->assertDontSee('media="print"', false);
});

it('inlines the critical css and loads the stylesheet asynchronously when the critical css file exists', function (): void {
    File::put($this->criticalFile, '.critical-rule{color:red}');

    $view = $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />');

    $view->assertSee('.critical-rule{color:red}', false)
        ->assertSee('<link rel="stylesheet" href="http://vite.test/resources/scss/frontend.scss" media="print" onload="this.media=\'all\'"', false)
        ->assertSee('<noscript>', false);
});
