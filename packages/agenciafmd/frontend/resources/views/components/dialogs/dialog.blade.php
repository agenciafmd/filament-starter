@props([
    'id',
    'title',
])

<dialog class="dialog dialog-lg" id="{{ $id }}" aria-labelledby="{{ $id }}-title">
    <div class="dialog-header">
        <h2 class="dialog-title text-center" id="{{ $id }}-title">{!! $title !!}</h2>
        <button type="button" class="btn-close" data-bs-dismiss="dialog" aria-label="Fechar"></button>
    </div>
    <div class="dialog-body">{{ $slot }}</div>
</dialog>
