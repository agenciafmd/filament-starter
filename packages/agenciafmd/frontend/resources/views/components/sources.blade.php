@props([
    'image',
    'title',
    'alt' => $title,
    'breakpointDesktopWidth' => '1200px',
    'breakpointDesktopSuffix' => 'lg',
    'breakpointNotebookWidth' => '576px',
    'breakpointNotebookSuffix' => 'md',
])

@foreach ([
    'min-width: ' . $breakpointDesktopWidth => '-' . $breakpointDesktopSuffix,
    'min-width: ' . $breakpointNotebookWidth => '-' . $breakpointNotebookSuffix,
] as $breakpoint => $suffix)
    <source
        type="image/webp"
        media="({{ $breakpoint }})"
        srcset="{{ Vite::image(str($image)->replace(['.jpg', '.png'], '.webp')->replaceLast('.', "{$suffix}.")->toString()) }}, {{ Vite::image(str($image)->replace(['.jpg', '.png'], '.webp')->replaceLast('.', "{$suffix}@2x.")->toString()) }} 2x"
    />
    <source
        media="({{ $breakpoint }})"
        srcset="{{ Vite::image(str($image)->replaceLast('.', "{$suffix}.")->toString()) }}, {{ Vite::image(str($image)->replaceLast('.', "{$suffix}@2x.")->toString()) }} 2x"
    />
@endforeach

<x-frontend::single-source :image="$image" :alt="$alt" :title="$title" {{ $attributes }} />
