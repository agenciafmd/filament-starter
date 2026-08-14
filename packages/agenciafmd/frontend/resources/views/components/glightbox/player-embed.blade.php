@props([
    'id',
    'provider' => 'youtube',
    'link',
    'image' => '',
    'title' => '',
    'aspectRatio' => '',
    'alt' => '',
    'picture' => '',
    'iconClass' => '',
])

<div class="position-relative js-player-embed-container {{ $aspectRatio }}">
    @if ($picture)
        {!! $picture !!}

    @elseif ($image)
        <x-frontend::picture
            image="{{ $image }}"
            title="{{ $title }}"
            alt="{{ $alt }}"
            pictureClass="{{ $aspectRatio }}"
            hasBreakpoints
            breakpointDesktopWidth="1400px"
            breakpointDesktopSuffix="xl"
            breakpointNotebookWidth="768px"
            breakpointNotebookSuffix="lg"
            {{ $attributes->merge(['class' => 'img-cover']) }}
        />
    @elseif ($link)
        <x-frontend::image
            is-single-image="true"
            image="https://i3.ytimg.com/vi/{{ \Agenciafmd\Support\Helper::youtubeId($link) }}/maxresdefault.jpg"
            alt="Thumb do vídeo"
            title="Thumb do vídeo"
            class="img-cover rounded-1"
        />
    @endif

    <x-frontend::link
        link="#"
        data-plyr-provider="{{ $provider }}"
        data-plyr-embed-id="{{ $link }}"
        id="player-{{ $id }}"
        class="stretched-link {{ $iconClass }} js-player-embed-link ic-play-container"
        aria-label="Clique para assistir o vídeo"
        title="Ver vídeo"
    >
        <x-icon
            name="frontend-ic-ui-play"
            class="vstack align-items-center justify-content-center rounded-circle ic-play position-absolute translate-middle start-50 top-50 z-1"
        />
    </x-frontend::link>
</div>
