@extends('frontend::html.master', [
    'bodyClass' => 'blog -header-overlap',
    'critical' => 'blog.css',
])

@section('title', 'Título de página')
@section('description', 'Descrição de página.')

@section('content')
    <main>
        <section class="pb-block-small md:pb-block">
            <div class="py-block-small md:py-block bg-light">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="md:col-8">
                            <h1 class="text-center">Blog</h1>
                            <p class="mb-block-small text-center">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus at cupiditate
                                expedita inventore quam rem sit velit vitae voluptas voluptatum. Ad consequuntur
                                dignissimos dolorem maiores minus quibusdam tenetur voluptate voluptatem.
                            </p>
                        </div>
                        <div class="md:col-6">
                            <form wire:submit.prevent="submit" class="needs-validation" novalidate>
                                <div class="position-relative">
                                    @php
                                            $articles = [

                                            (object)[
                                            'name' => 'Artigo 1',
                                            ],

                                            (object)[
                                            'name' => 'Artigo 2',
                                            ],

                                            (object)[
                                            'name' => 'Artigo 3',
                                            ],
                                            ]
                                        @endphp
                                    <div class="combobox position-relative">
                                        <input type="hidden" name="search" value="" data-combobox-input wire:model.lazy="search" />
                                        <button
                                            type="button"
                                            class="form-control combobox-toggle ps-2hq pe-5hq form-control-lg @error('search-select') is-invalid @enderror"
                                            data-bs-toggle="combobox"
                                            data-bs-placeholder="Pesquisar"
                                            data-bs-search="true"
                                        >
                                            <span class="combobox-value">Pesquisar</span>
                                            <svg class="combobox-caret" width="10" height="16" viewBox="0 0 10 16" fill="none" aria-hidden="true"><path d="M0.46967 5.46967C0.762563 5.17678 1.23744 5.17678 1.53033 5.46967L5 8.93934L8.46967 5.46967C8.76256 5.17678 9.23744 5.17678 9.53033 5.46967C9.82322 5.76256 9.82322 6.23744 9.53033 6.53033L5.53033 10.5303C5.23744 10.8232 4.76256 10.8232 4.46967 10.5303L0.46967 6.53033C0.176777 6.23744 0.176777 5.76256 0.46967 5.46967Z" fill="currentcolor" /></svg>
                                        </button>
                                        <div class="menu">
                                            <div class="combobox-search">
                                                <input type="text" class="form-control combobox-search-input" placeholder="Pesquisar…" autocomplete="off" aria-label="Pesquisar…" />
                                            </div>
                                            @foreach (collect($articles)->sortBy('name') as $article)
                                                <button class="menu-item" type="button" data-bs-value="{{ $article->name }}">{{ $article->name }}</button>
                                            @endforeach
                                            <div class="combobox-no-results d-none">Não foi encontrando resultados</div>
                                        </div>
                                    </div>

                                    <x-icon
                                        name="frontend-ic-ui-search"
                                        class="ms-0hq fg-primary ic-xxsm position-absolute translate-middle-y start-0 top-50 z-1"
                                    />

                                    <button
                                        type="submit"
                                        wire:loading.attr="disabled"
                                        wire:target="submit"
                                        aria-label="enviar formulário"
                                        class="me-0q btn btn-solid theme-primary position-absolute translate-middle-y end-0 top-50 z-1"
                                    >
                                        <span wire:loading.remove wire:target="submit">Buscar </span>
                                        <span wire:loading wire:target="submit">
                                            <span
                                                class="spinner-grow spinner-sm ms-0h"
                                                role="status"
                                                aria-hidden="true"
                                            ></span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="mb-block-small">
                    <div class="row align-items-center">
                        <div class="md:col">
                            @php
                                $breadcrumb = [
                                    'Home' => '/html',
                                    'Blog' => '',
                                ];
                            @endphp

                            <x-frontend::breadcrumb :list="$breadcrumb" />
                        </div>
                        <div class="md:col-auto">
                            @php
                                $links = [
                                    (object) [
                                        'label' => 'Todos',
                                        'link' => '/html/blog',
                                    ],

                                    (object) [
                                        'label' => 'Empreendimentos',
                                        'link' => '/html/blog',
                                    ],

                                ];
                            @endphp
                            <ul class="nav nav-pills stretch-on-mobile">
                                @foreach ($links as $link)
                                    <li class="nav-item">
                                        <x-frontend::link
                                            link="{{ $link->link }}"
                                            class="nav-link {{ $loop->first ? 'active' : '' }}"
                                            label="{{ $link->label }}"
                                        />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                @php
                    $articles = [

                        (object) [
                            'name' => str('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')->squish()->toString(),
                            'subtitle' => 'Categoria',
                            'date' => '01 de janeiro de 2025',
                            'route' => '/html/blog-detalhe',
                            'image' => (object) [
                                'src' => 'ratios/img-4x3.jpg',
                                'name' => 'Imagem 4x3',
                                'pictureClass' => 'ratio ratio-4x3',
                                'imageClass' => 'img-cover',
                            ],
                        ],

                        (object) [
                            'name' => str('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')->squish()->toString(),
                            'subtitle' => 'Categoria',
                            'date' => '01 de janeiro de 2025',
                            'route' => '/html/blog-detalhe',
                            'image' => (object) [
                                'src' => 'ratios/img-4x3.jpg',
                                'name' => 'Imagem 4x3',
                                'pictureClass' => 'ratio ratio-4x3',
                                'imageClass' => 'img-cover',
                            ],
                        ],

                        (object) [
                            'name' => str('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')->squish()->toString(),
                            'subtitle' => 'Categoria',
                            'date' => '01 de janeiro de 2025',
                            'route' => '/html/blog-detalhe',
                            'image' => (object) [
                                'src' => 'ratios/img-4x3.jpg',
                                'name' => 'Imagem 4x3',
                                'pictureClass' => 'ratio ratio-4x3',
                                'imageClass' => 'img-cover',
                            ],
                        ],

                        (object) [
                            'name' => str('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')->squish()->toString(),
                            'subtitle' => 'Categoria',
                            'date' => '01 de janeiro de 2025',
                            'route' => '/html/blog-detalhe',
                            'image' => (object) [
                                'src' => 'ratios/img-4x3.jpg',
                                'name' => 'Imagem 4x3',
                                'pictureClass' => 'ratio ratio-4x3',
                                'imageClass' => 'img-cover',
                            ],
                        ],

                        (object) [
                            'name' => str('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')->squish()->toString(),
                            'subtitle' => 'Categoria',
                            'date' => '01 de janeiro de 2025',
                            'route' => '/html/blog-detalhe',
                            'image' => (object) [
                                'src' => 'ratios/img-4x3.jpg',
                                'name' => 'Imagem 4x3',
                                'pictureClass' => 'ratio ratio-4x3',
                                'imageClass' => 'img-cover',
                            ],
                        ],

                        (object) [
                            'name' => str('Lorem ipsum dolor sit amet, consectetur adipisicing elit.')->squish()->toString(),
                            'subtitle' => 'Categoria',
                            'date' => '01 de janeiro de 2025',
                            'route' => '/html/blog-detalhe',
                            'image' => (object) [
                                'src' => 'ratios/img-4x3.jpg',
                                'name' => 'Imagem 4x3',
                                'pictureClass' => 'ratio ratio-4x3',
                                'imageClass' => 'img-cover',
                            ],
                        ],

                    ];
                @endphp

                @if (! count($articles))
                    <x-frontend::alert
                        message="Não foi encontrado nenhum artigo no momento"
                        class="theme-primary hstack justify-content-center"
                    />

                @else
                    <div class="row gy-2h infinite-scroll">
                        @foreach ($articles as $article)
                            @if (! str(request()->getRequestUri())->startsWith('/html'))
                                <div class="sm:col-6 md:col-4">
                                    {{--
                                    Resolução das imagens para utilização:
                                    mobile: 360x270 - ratio 3x4
                                    notebook: 348x261 - ratio 3x4
                                    desktop: 475x356 - ratio 3x4
                                    --}}

                                    <x-frontend::articles.item :article="$article" />
                                </div>

                            @else
                                <div class="sm:col-6 md:col-4">
                                    {{--
                                    Resolução das imagens para utilização:
                                    mobile: 360x270 - ratio 3x4
                                    notebook: 348x261 - ratio 3x4
                                    desktop: 475x356 - ratio 3x4
                                    --}}

                                    <x-frontend::articles.item :article="$article" />
                                </div>

                            @endif
                        @endforeach
                    </div>

                    {{--
                    $articles->appends(request()->except('page'))->links('agenciafmd/frontend::partials.pagination')
                    --}}

                    {{-- para exemplo, isso já vem da partials.pagination acima --}}
                    <div class="page-load-status mx-auto">
                        <div class="infinite-scroll-request text-center">
                            <x-icon name="frontend-ic-loading" class="animation-spin-right ic-xl fg-primary" />
                        </div>
                        <p class="infinite-scroll-last"></p>
                        <p class="infinite-scroll-error"></p>
                    </div>

                @endif
            </div>
        </section>
    </main>
@endsection
