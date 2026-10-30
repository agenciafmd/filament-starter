@props([
    'id',
    'accordionClass' => null,
    'accordions' => [],
])

<div class="accordion {{ $accordionClass }}" id="{{ $id }}">
    @foreach ($accordions as $accordion)
        <details class="accordion-item" name="{{ $id }}" @if ($loop->first) open @endif>
            <summary class="accordion-header">
                {{ $accordion['title'] }}
                <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                </svg>
            </summary>
            <div class="accordion-body">
                <p>{!! $accordion['description'] !!}</p>
            </div>
        </details>
    @endforeach
</div>
