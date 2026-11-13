@props([
    'progress' => [],
    'progressHeight' => '4px',
    'theme' => 'bg-primary',
    'percentageEmbedded' => false,
])

{{-- percentage aceita 80, "80" ou "80%": o aria-valuenow só aceita número --}}
@php
    $percentage = (int) $progress->percentage;
@endphp

@if (! $percentageEmbedded)
    <div class="hstack mb-0hq justify-content-between gap-1">
        <p class="fs-small xl:fs-base mb-0">{{ $progress->name }}</p>
        <p class="fs-small xl:fs-base fw-bold">{{ $percentage }}%</p>
    </div>
@endif
<div
    class="progress rounded"
    role="progressbar"
    aria-label="{{ $progress->name }}"
    aria-valuenow="{{ $percentage }}"
    aria-valuemin="0"
    aria-valuemax="100"
    style="height: {{ $progressHeight }}"
>
    <div class="progress-bar {{ $theme }}" style="width: {{ $percentage }}%">
        {{ $percentageEmbedded ? "{$percentage}%" : '' }}
    </div>
</div>
