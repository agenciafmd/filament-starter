@props([
    'name',
    'label',
    'download' => false,
])

<a
    href="{{ Vite::pdf($name . '.pdf') }}"
    @if ($download)
        download
    @else
        target="_blank"
    @endif
    {{ $attributes }}
>
    <span aria-hidden="true"> {{ $label }} </span>
</a>
