@props([
    'theme' => 'bg-primary',
    'label' => '',
    'icon' => false,
    'iconClass' => false,
    'iconChangePosition' => false,
    'isRounded' => false,
])
<span {{ $attributes->merge(['class' => 'badge d-inline-flex align-items-center ' . $theme . ($iconChangePosition ? ' flex-row-reverse' : '') . ($isRounded ? ' rounded-pill' : '')]) }}>
    @if ($icon)
        <x-icon name="frontend-{{ $icon }}" class="bi {{ $iconClass }}" />
    @endif
    {{ $label }}

    {{ $slot }}
</span>
