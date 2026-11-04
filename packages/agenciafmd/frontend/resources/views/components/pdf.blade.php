@props([
    'name',
    'label',
    'download' => false,
])

<a
    href="{{ asset('pdf/' . $name . '.pdf') }}"
    @if ($download)
        download
    @else
        target="_blank"
    @endif
    {{ $attributes }}
>
    <span aria-hidden="true"> {{ $label }} </span>
</a>
