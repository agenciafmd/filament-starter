<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\View\Components;

use Illuminate\Foundation\Vite;
use Illuminate\View\Component;

final class CriticalCss extends Component
{
    /**
     * Ordem das cascade layers do Bootstrap 6 (`bootstrap/scss/_root.scss`).
     * O minificador remove a declaração de ordem do CSS, e o CSS crítico só traz parte das layers;
     * sem ela, as layers que faltam (ex.: `forms`) seriam criadas depois de `utilities` ao carregar o stylesheet.
     */
    private const string LAYER_ORDER = '@layer colors, config, root, reboot, layout, content, forms, components, custom, helpers, utilities;';

    public string $content;

    public function __construct(
        public ?string $critical = null,
        public string $stylesheet = 'resources/scss/frontend.scss',
    ) {
        $this->content = $this->isViteRunningHot() ? '' : $this->loadCriticalCss($critical);

        if ($this->content) {
            $this->content = self::LAYER_ORDER . $this->content;
        }
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

    /**
     * Com o `npm run dev` rodando (arquivo `public/hot`), o CSS crítico do último build ficaria no `<head>`
     * por cima do SCSS que está sendo editado (uma propriedade apagada continuaria valendo), e o stylesheet
     * assíncrono não teria HMR. Nesse caso o componente carrega o stylesheet com o `@vite` normal.
     */
    private function isViteRunningHot(): bool
    {
        return resolve(Vite::class)->isRunningHot();
    }

    /**
     * Lê o CSS crítico gerado no build pelo `rollup-plugin-critical` (`public/css/critical/{pagina}_critical.min.css`).
     * As páginas saem de `views/html` (`resources/js/utilities/critical.js`), renderizadas no Chromium do Playwright.
     *
     * Antes, o conteúdo ficava em `rememberForever` com a chave `critical-css-{pagina}`: depois de um novo build,
     * o inline continuava com o CSS antigo (que podia divergir do stylesheet novo) até alguém rodar `cache:clear`;
     * e, se a página fosse acessada antes do arquivo existir, a string vazia ficava cacheada para sempre.
     *
     * Agora:
     * - a chave inclui o `filemtime` do arquivo: um novo build gera outra chave e o cache se renova sozinho;
     * - sem arquivo, nada é cacheado: o CSS crítico passa a ser usado assim que for gerado.
     *
     * As chaves antigas ficam órfãs no cache (sem impacto além do espaço) e somem no próximo `cache:clear`.
     */
    private function loadCriticalCss(?string $critical): string
    {
        $criticalCssPath = public_path('css/critical/' . str($critical)
            ->beforeLast('.css')
            ->append('_critical.min.css')
            ->toString());

        if (! is_file($criticalCssPath)) {
            return '';
        }

        return cache()->rememberForever(
            'critical-css-' . $critical . '-' . filemtime($criticalCssPath),
            static fn (): string => (string) file_get_contents($criticalCssPath),
        );
    }
}
