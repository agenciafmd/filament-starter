@props([
    'image',
    'title',
    'alt' => $title,
    'isSingleImage' => false,
    'priority' => false,
    'width' => null,
    'height' => null,
])

@php
    $file = resource_path("images/{$image}");

    if ((! $width || ! $height) && preg_match('/\.(png|jpe?g)$/i', $image) && is_file($file)) {
        [$width, $height] = getimagesize($file) ?: [null, null];
    }

    $isHighPriority = $priority && ! request()->attributes->get('frontend.image.high-priority');

    if ($isHighPriority) {
        request()->attributes->set('frontend.image.high-priority', true);
    }
@endphp

{{--
    priority: use nas imagens da primeira dobra (ex.: primeiro slide do banner, primeira linha de cards).
    Elas são baixadas de imediato (eager); a primeira da página também ganha fetchpriority="high",
    melhorando o LCP. As outras não disputam a banda com ela.

    width/height: em PNG e JPG, vêm do arquivo em resources/images. Com o tamanho no html, o navegador
    reserva o espaço antes da imagem lazy carregar (sem layout shift). Nos outros formatos (SVG, ICO, URL
    externa), passe width/height: sem eles, a imagem ganha o contorno de aviso (_accessibilities.scss).
    Com breakpoints (x-frontend::picture has-breakpoints), vale o tamanho da imagem base (a do mobile).
--}}
<img
    @if ($priority)
        loading="eager"
        @if ($isHighPriority)
            fetchpriority="high"
        @endif
        src="{{ Vite::image($image) }}"
    @else
        loading="lazy"
        src="data:image/gif;base64,R0lGODlhAQABAIAAAMLCwgAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="
    @endif
    decoding="async"
    srcset="{{ Vite::image($image).($isSingleImage ? '' : ', '. Vite::image(str($image)->replaceLast('.', '@2x.')->toString()) .' 2x') }}"
    alt="{{ $alt ?? $title }}"
    title="{{ $title }}"
    @if ($width && $height)
        width="{{ $width }}"
        height="{{ $height }}"
    @endif
    {{ $attributes->merge(['class' => 'img-fluid']) }}
/>
