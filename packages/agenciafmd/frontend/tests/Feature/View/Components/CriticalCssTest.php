<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Vite;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

// A built project (manifest, no hot file): the critical css only applies outside `npm run dev`
beforeEach(function (): void {
    $this->hotFile = storage_path('framework/testing/critical-css.hot');
    File::ensureDirectoryExists(dirname($this->hotFile));
    Vite::useHotFile($this->hotFile);

    $this->buildDirectory = 'pest-critical-css-build';
    File::ensureDirectoryExists(public_path($this->buildDirectory));
    File::put(public_path("{$this->buildDirectory}/manifest.json"), json_encode([
        'resources/scss/frontend.scss' => [
            'file' => 'assets/css/frontend-pest.css',
            'src' => 'resources/scss/frontend.scss',
            'isEntry' => true,
        ],
    ]));
    Vite::useBuildDirectory($this->buildDirectory);

    $this->criticalFile = public_path('css/critical/pest-critical-css_critical.min.css');
});

afterEach(function (): void {
    File::delete([$this->hotFile, $this->criticalFile]);
    File::deleteDirectory(public_path($this->buildDirectory));
});

it('loads the stylesheet as render blocking when the critical css file does not exist', function (): void {
    $view = $this->blade('<x-frontend::critical-css critical="arquivo-inexistente.css" />');

    $view->assertSee('rel="stylesheet" href="' . asset("{$this->buildDirectory}/assets/css/frontend-pest.css") . '"', false)
        ->assertDontSee('<style>', false)
        ->assertDontSee('media="print"', false);
});

it('inlines the critical css and loads the stylesheet asynchronously when the critical css file exists', function (): void {
    File::put($this->criticalFile, '.critical-rule{color:red}');

    $view = $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />');

    $view->assertSee('.critical-rule{color:red}', false)
        ->assertSee('<link rel="stylesheet" href="' . asset("{$this->buildDirectory}/assets/css/frontend-pest.css") . '" media="print" onload="this.media=\'all\'"', false)
        ->assertSee('<noscript>', false);
});

it('skips the critical css and loads the stylesheet with vite while npm run dev is running', function (): void {
    File::put($this->hotFile, 'http://vite.test');
    File::put($this->criticalFile, '.stale-rule{color:red}');

    $view = $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />');

    $view->assertSee('<link rel="stylesheet" href="http://vite.test/resources/scss/frontend.scss"', false)
        ->assertSee('<script type="module" src="http://vite.test/@vite/client"', false)
        ->assertDontSee('.stale-rule{color:red}', false)
        ->assertDontSee('media="print"', false);
});

it('inlines the new critical css after the file is regenerated, without clearing the cache', function (): void {
    File::put($this->criticalFile, '.old-rule{color:red}');
    touch($this->criticalFile, now()->subMinute()->getTimestamp());
    $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />');

    File::put($this->criticalFile, '.new-rule{color:blue}');
    touch($this->criticalFile, now()->getTimestamp());
    clearstatcache();

    $view = $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />');

    $view->assertSee('.new-rule{color:blue}', false)
        ->assertDontSee('.old-rule{color:red}', false);
});

it('inlines the critical css generated after a request without it', function (): void {
    $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />')
        ->assertDontSee('<style>', false);

    File::put($this->criticalFile, '.late-rule{color:red}');

    $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />')
        ->assertSee('.late-rule{color:red}', false);
});

it('declares the cascade layer order before the inlined critical css', function (): void {
    File::put($this->criticalFile, '@layer reboot{body{margin:0}}');

    $view = $this->blade('<x-frontend::critical-css critical="pest-critical-css.css" />');

    $view->assertSeeInOrder([
        '@layer colors, config, root, reboot, layout, content, forms, components, custom, helpers, utilities;',
        '@layer reboot{body{margin:0}}',
    ], false);
});
