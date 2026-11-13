@props([
    'article' => [],
    'priority' => false,
    'headingTag' => 'h2',
])
<x-frontend::cards.card-picture
    :image="$article->image"
    :priority="$priority"
    :has-shadow="true"
    card-body-class="vstack"
    class="vstack overflow-hidden"
>
    <div class="mb-2">
        <span class="card-subtitle fg-primary"> {{ $article->subtitle }} </span>
        <{{ $headingTag }} class="card-title">{{ $article->name }}</{{ $headingTag }}>
        <p class="fs-small fg-body">{{ $article->date }}</p>
    </div>
    <x-frontend::link
        link="{{ $article->route }}"
        title="Ir para {{ $article->name }}"
        label="Leia mais"
        class="btn btn-solid theme-primary btn-lg stretched-link mt-auto w-100"
    >
        <span class="visually-hidden">: {{ $article->name }}</span>
    </x-frontend::link>
</x-frontend::cards.card-picture>
