@props([
    'message' => null,
    'icon' => null,
    'iconClass' => null,
    'hasDismissible' => null,
])
@php
    $alertClasses = 'alert';
    if ($hasDismissible) {
        $alertClasses .= ' alert-dismissible';
    }
@endphp

<div role="alert" {{ $attributes->merge(['class' => $alertClasses]) }}>
    @if ($icon)
        <x-icon name="frontend-{{ $icon }}" class="bi flex-shrink-0 {{ $iconClass }}" />
    @endif

    @if ($message)
        {!! $message !!}
    @endif

    {{ $slot }}

    @if ($hasDismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
