<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\View\Components;

use Illuminate\View\Component;

final class CriticalCss extends Component
{
    public string $content;

    public function __construct(
        public ?string $critical = null,
        public string $stylesheet = 'resources/scss/frontend.scss',
    ) {
        $this->content = cache()->rememberForever('critical-css-' . $critical, static function () use ($critical): string {
            $criticalCss = str($critical)
                ->beforeLast('.css')
                ->append('_critical.min.css');

            return @file_get_contents(public_path('/css/critical/' . $criticalCss)) ?: '';
        });
    }

    /**
     * Sem CSS crítico, o stylesheet é carregado normalmente (bloqueante).
     * Com CSS crítico, ele já cobre a primeira dobra, então o stylesheet
     * completo é carregado de forma assíncrona para não bloquear a renderização.
     */
    public function render(): string
    {
        if (! $this->content) {
            return <<<'blade'
            @vite($stylesheet)
            blade;
        }

        return <<<'blade'
        <style>
            {!! $content !!}
        </style>
        <link rel="preload" as="style" href="{{ Vite::asset($stylesheet) }}" />
        <link rel="stylesheet" href="{{ Vite::asset($stylesheet) }}" media="print" onload="this.media='all'" data-navigate-track="reload" />
        <noscript>
            <link rel="stylesheet" href="{{ Vite::asset($stylesheet) }}" />
        </noscript>
        blade;
    }
}
