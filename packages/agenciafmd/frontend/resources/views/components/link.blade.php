@props([
    'link' => '#',
    'isExtern' => false,
    'icon' => false,
    'iconClass' => false,
    'iconChangePosition' => false,
    'label' => false,
    'ariaLabel' => false,
    'title' => false,
])

{{--
    aria-label só no link sem texto lido (só ícone, imagem ou conteúdo com aria-hidden): com texto, o nome acessível é o próprio
    texto. Um aria-label diferente do texto visível atrapalha quem navega por voz ("clicar em Leia mais") e o
    Lighthouse aponta (label-content-name-mismatch). Para dar contexto a um texto genérico, complete com
    <span class="visually-hidden">, que entra no nome acessível depois do texto visível.
--}}
@php
    $slotText = preg_replace('/<(\w+)\b[^>]*aria-hidden="true"[^>]*>.*?<\/\1>/s', '', (string) $slot);
    $hasVisibleText = $label || trim(strip_tags($slotText)) !== '';
@endphp
<a
    href="{{ $link }}"
    @if (! $hasVisibleText && $ariaLabel)
        aria-label="{{ $ariaLabel }}"
    @endif
    title="{{ ($title ? $title : $label) }}"
    @if ($isExtern)
        target="_blank"
        rel="noopener"
    @endif
    {{ $attributes->merge(['class' => ($icon ? 'icon-link icon-link-hover' : '') . ($iconChangePosition ? ' flex-row-reverse' : '')]) }}
>
    @if ($icon)
        <x-icon name="frontend-{{ $icon }}" class="bi {{ $iconClass }}" />
    @endif

    @if ($label)
        {{ $label }}
    @endif

    {{ $slot }}
</a>
