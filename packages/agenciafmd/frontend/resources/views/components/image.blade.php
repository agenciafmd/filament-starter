@props([
    'image',
    'title',
    'alt' => $title,
    'isSingleImage' => false,
    'priority' => false,
])

{{--
    priority: use na imagem principal da primeira dobra (ex.: primeiro slide do banner).
    Ela é baixada de imediato e com prioridade alta, melhorando o LCP.
--}}
<img
    @if ($priority)
        loading="eager"
        fetchpriority="high"
        src="{{ Vite::image($image) }}"
    @else
        loading="lazy"
        src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
    @endif
    decoding="async"
    srcset="{{ Vite::image($image).($isSingleImage ? '' : ', '. Vite::image(str($image)->replaceLast('.', '@2x.')->toString()) .' 2x') }}"
    alt="{{ $alt ?? $title }}"
    title="{{ $title }}"
    width="1"
    height="1"
    {{ $attributes->merge(['class' => 'img-fluid']) }}
/>
