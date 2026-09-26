<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View\Components;

use Agenciafmd\Frontend\View\Components\CriticalCss;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('renders nothing when the critical css file does not exist', function (): void {
    expect(new CriticalCss('arquivo-inexistente.css')->render())->toBe('');
});
