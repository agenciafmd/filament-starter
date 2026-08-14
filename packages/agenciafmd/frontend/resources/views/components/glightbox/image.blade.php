@props([
    'link',
    'title' => false,
    'description' => false,
    'gallery' => 'gallery',
])

<x-frontend::link
    link="{{ Vite::image($link) }}"
    data-glightbox=""
    data-gallery="{{ $gallery }}"
    data-description="{{ $description }}"
    title="{{ $title ? $title : $description }}"
    aria-label="Link: {{ $title ? $title : $description }}"
    {{ $attributes->merge(['class' => 'position-relative text-decoration-none glightbox text-primary text-secondary-hover']) }}
>
    {{ $slot }}

    <div class="m-0hq position-absolute ic-glightbox-zoom end-0 top-0">
        <x-icon name="frontend-ic-ui-expand" class="icon" />
    </div>
</x-frontend::link>
