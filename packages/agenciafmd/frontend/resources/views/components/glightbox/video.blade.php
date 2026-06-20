@props([
'link',
'title' => false,
'description' => false,
'gallery' => 'video',
])

<x-frontend::link link="{{ $link }}"
                  data-glightbox=""
                  data-gallery="{{ $gallery }}"
                  data-description="{{ $description }}"
                  title="{{ $title ? $title : $description }}"
                  aria-label="Link: {{ $title ? $title : $description }}"
                  {{ $attributes->merge(['class' => 'position-relative glightbox ic-play-container']) }}>
  {{ $slot }}

  <x-icon
          name="frontend-ic-ui-play"
          class="vstack align-items-center justify-content-center rounded-circle ic-play position-absolute top-50 start-50 translate-middle z-1"
   />
</x-frontend::link>

