@props([
    'listClass' => null,
    'iconClass' => null,
    'content' => [],
    'sanitizeList' => null,
])

<ul {{ $attributes->merge(['class' => ($sanitizeList ? 'list-unstyled' : '' )]) }}>
    @foreach ($content as $list)
        <li class="{{ $listClass }}">
            @if (! empty($list->icon))
                <span>
                    <x-icon name="frontend-{{ $list->icon }}" class="mw-unset {{ $iconClass }}" />
                </span>
            @endif
            {!! $list->text !!}
        </li>
    @endforeach
</ul>
