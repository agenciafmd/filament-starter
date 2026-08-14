<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Providers;

use Agenciafmd\Frontend\View\Components\ResponsiveImage;
use BladeUI\Icons\Factory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class BladeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->bootBladeComponents();

        $this->bootBladeDirectives();

        $this->bootBladeComposers();

        $this->bootViews();

        $this->bootPublish();
    }

    public function register(): void
    {
        $this->registerIconSet();
    }

    private function bootBladeComponents(): void
    {
        Blade::componentNamespace('Agenciafmd\\Frontend\\View\\Components', 'frontend');
        Blade::component('img', ResponsiveImage::class);
    }

    private function bootBladeComposers(): void
    {
        //
    }

    private function bootBladeDirectives(): void
    {
        //
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'frontend');
        $this->loadViewsFrom(base_path('resources/views/errors'), 'errors');
        //        $this->loadViewsFrom(__DIR__ . '/../../resources/mail', 'frontend-mail');
    }

    private function bootPublish(): void
    {
        //
    }

    private function registerIconSet(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('frontend', [
                'path' => resource_path('svg'),
                'prefix' => 'frontend',
            ]);
        });
    }
}
