@props([
    'image',
    'title',
    'alt' => $title,
])

<source
    type="image/webp"
    srcset="{{ Vite::image(str($image)->replace(['.jpg', '.png'], '.webp')->toString()) }}, {{ Vite::image(str($image)->replace(['.jpg', '.png'], '.webp')->replaceLast('.', '@2x.')->toString()) }} 2x"
/>
<source srcset="{{ Vite::image($image) }}, {{ Vite::image(str($image)->replaceLast('.', '@2x.')->toString()) }} 2x" />

<x-frontend::image :image="$image" :alt="$alt" :title="$title" {{ $attributes }} />
