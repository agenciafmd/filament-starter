<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\View;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Tests\TestCase;

pest()->extend(TestCase::class)->use(RefreshDatabase::class);

it('fires the flash messages from a module script so they run after Swal is loaded', function (): void {
    session()->put('flash_notification', collect([
        ['level' => 'success', 'message' => 'Mensagem enviada'],
    ]));

    $view = $this->view('frontend::partials.message');

    $view->assertSee('<script type="module">', false)
        ->assertSee('Mensagem enviada');
    expect(session()->has('flash_notification'))->toBeFalse();
});

it('escapes the flash message so it cannot break out of the script', function (): void {
    session()->put('flash_notification', collect([
        ['level' => 'danger', 'message' => "'); </script><script>alert(1)</script>"],
    ]));

    $view = $this->view('frontend::partials.message');

    $view->assertDontSee('</script><script>alert(1)', false);
});

it('warns about the honeypot timer when there is no flash message', function (): void {
    session()->put('errors', new ViewErrorBag()->put('default', new MessageBag(['hp_time' => 'Muito rápido'])));

    $view = $this->view('frontend::partials.message');

    $view->assertSee('Por favor, aguarde alguns segundos para enviar os dados.');
});
