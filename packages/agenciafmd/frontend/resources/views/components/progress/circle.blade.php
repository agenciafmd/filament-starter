@props([
    'percentage',
    'size' => '88',
    'strokeWidth' => '4',
])

@php
    $radius = ($size / 2) - $strokeWidth;
    $circumference = 3.14 * $radius * 2;
    $percentageCalculated = number_format($circumference * ((100 - (int) $percentage) / 100), 2);
    $viewBox = [
        'coordenate' => '-' . $size * 0.125,
        'size' => $size * 1.25,
    ];
@endphp

<div class="d-flex justify-content-end align-items-center flex-row-reverse gap-1">
    <div class="position-relative mb-1h">
        <svg
            class="stroke-secondary d-block mx-auto"
            width="{{ $size }}"
            height="{{ $size }}"
            xmlns="http://www.w3.org/2000/svg"
            style="transform: rotate(-90deg)"
        >
            <circle
                r="{{ $radius }}"
                cx="{{ $radius + $strokeWidth }}"
                cy="{{ $radius + $strokeWidth }}"
                fill="transparent"
                stroke="#D9E3F5"
                stroke-width="{{ $strokeWidth }}"
                stroke-dasharray="{{ $circumference }}"
                stroke-dashoffset="0px"
            ></circle>
            <circle
                r="{{ $radius }}"
                cx="{{ $radius + $strokeWidth }}"
                cy="{{ $radius + $strokeWidth }}"
                stroke="currentColor"
                class="text-primary rounded"
                stroke-width="{{ $strokeWidth }}"
                stroke-linecap="round"
                stroke-dashoffset="{{ $percentageCalculated }}"
                fill="transparent"
                stroke-dasharray="{{ $circumference }}"
            ></circle>
        </svg>
        <p class="position-absolute text-primary fw-bold translate-middle fs-xlarge start-50 top-50">
            {{ (int)$percentage }}%
        </p>
    </div>
</div>
