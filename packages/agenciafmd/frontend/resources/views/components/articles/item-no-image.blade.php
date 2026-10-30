@props([
    'article' => [],
])

<x-frontend::cards.card card-body-class="vstack p-0" class="vstack rounded-0 border-0">
    <x-frontend::link
        link="{{ $article->route }}"
        aria-label="Link para {{ $article->name }}"
        title="Ir para {{ $article->name }}"
        class="btn-link text-decoration-none"
    >
        <span class="card-subtitle fg-primary fs-base"> {{ $article->subtitle }} </span>
        <h2 class="card-title fg-body">{{ $article->name }}</h2>
        <p class="fs-small fg-body">{{ $article->date }}</p>
    </x-frontend::link>
</x-frontend::cards.card>
