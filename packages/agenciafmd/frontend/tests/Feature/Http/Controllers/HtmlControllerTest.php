<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class, RefreshDatabase::class);

it('renders the requested html page', function (): void {
    get('/html/tema')->assertViewIs('frontend::html.tema');
});

it('falls back to the index page when the html page does not exist', function (): void {
    get('/html/pagina-inexistente')->assertViewIs('frontend::html.index');
});
