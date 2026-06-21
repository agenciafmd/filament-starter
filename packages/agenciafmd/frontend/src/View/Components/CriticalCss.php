<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

final class CriticalCss extends Component
{
    public string $content;

    public function __construct(
        public ?string $critical = null,
    ) {
        $this->content = Cache::rememberForever('critical-css-' . $critical, static function () use ($critical) {
            $criticalCss = str($critical)
                ->beforeLast('.css')
                ->append('_critical.min.css');

            return @file_get_contents(public_path('/css/critical/' . $criticalCss));
        });
    }

    public function render(): string
    {
        if (! $this->content) {
            return '';
        }

        return <<<'blade'
        <style>
            {!! $content !!}
        </style>
        blade;
    }
}
