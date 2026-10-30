@props([
    'image',
    'title',
    'alt' => null,
    'size' => null,
    'status' => null,
])

@php
    $statusLabels = [
        'online' => 'Online',
        'offline' => 'Offline',
        'away' => 'Ausente',
        'busy' => 'Ocupado',
    ];
@endphp

<span {{ $attributes->class(['avatar', "avatar-{$size}" => $size]) }}>
    <x-frontend::image :image="$image" :title="$title" :alt="$alt ?? $title" class="avatar-img" />

    @if ($status)
        <span
            class="avatar-status status-{{ $status }}"
            role="img"
            aria-label="{{ $statusLabels[$status] ?? $status }}"
        ></span>
    @endif
</span>

{{-- Example:
    <x-frontend::avatar image="ratios/img-1x1.jpg" title="Nome da pessoa" size="lg" status="online" />
    sizes: xs, sm, lg, xl | status: online, offline, away, busy
--}}
