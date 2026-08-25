<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

final class LivewireServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Livewire::addNamespace(
            namespace: 'frontend',
            classNamespace: 'Agenciafmd\\Frontend\\Livewire',
        );
    }

    public function register(): void
    {
        //
    }
}
