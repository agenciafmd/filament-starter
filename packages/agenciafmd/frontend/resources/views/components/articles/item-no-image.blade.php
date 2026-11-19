@props([
    'article' => [],
    'headingTag' => 'h2',
])

<x-frontend::cards.card card-body-class="vstack p-0" class="vstack rounded-0 border-0">
    <x-frontend::link
        link="{{ $article->route }}"
        title="Ir para {{ $article->name }}"
        class="d-block text-decoration-none"
    >
        <span class="card-subtitle text-primary fs-base"> {{ $article->subtitle }} </span>
        <{{ $headingTag }} class="card-title text-body">{{ $article->name }}</{{ $headingTag }}>
        <p class="fs-small text-body">{{ $article->date }}</p>
    </x-frontend::link>
</x-frontend::cards.card>
