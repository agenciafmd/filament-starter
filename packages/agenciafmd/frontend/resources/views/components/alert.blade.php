@props([
    'message' => null,
    'icon' => null,
    'iconClass' => null,
    'hasDismissible' => null,
])
<div role="alert" {{ $attributes->merge(['class' => 'alert']) }}>
    @if ($icon)
        <x-icon name="frontend-{{ $icon }}" class="bi flex-shrink-0 {{ $iconClass }}" />
    @endif

    @if ($message)
        {!! $message !!}
    @endif

    {{ $slot }}

    @if ($hasDismissible)
        {{-- Bootstrap 6: last flex item, pushed to the end and vertically centered --}}
        <button type="button" class="btn-close ms-auto align-self-center" data-bs-dismiss="alert" aria-label="Fechar"></button>
    @endif
</div>
