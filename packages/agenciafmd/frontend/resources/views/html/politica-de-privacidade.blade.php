@extends('frontend::html.master', [
    'bodyClass' => 'privacy-policy',
    'critical' => 'politica-de-privacidade.css',
])

@section('title', 'Política de Privacidade')
@section('description', 'Como coletamos, usamos e protegemos os seus dados pessoais.')

{{--
    Estrutura de exemplo: troque o texto pelo aprovado pelo jurídico do cliente (LGPD) e aponte o
    <x-frontend::privacy-policy-link> para a rota real da página.
--}}
@section('content')
    <main>
        <section class="mb-block-small mb-md-block">
            <div class="container">
                <div class="mb-block-small">
                    @php
                        $breadcrumb = [
                            'Home' => '/html',
                            'Política de Privacidade' => '',
                        ];
                    @endphp

                    <x-frontend::breadcrumb :list="$breadcrumb" />
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <h1 class="mb-block-small h2">Política de Privacidade</h1>

                        <div class="mb-block-small wysiwyg">
                            <h2>Quais dados coletamos</h2>
                            <p>
                                Lorem ipsum dolor sit amet consectetur. Mattis morbi tellus purus tincidunt sagittis.
                                Pellentesque quis feugiat pellentesque eget interdum. Dui ut at dignissim neque praesent
                                ridiculus.
                            </p>
                        </div>

                        <div class="mb-block-small wysiwyg">
                            <h2>Para que usamos os dados</h2>
                            <p>
                                Vulputate suscipit turpis ultrices tristique iaculis penatibus. Malesuada a sem eget id.
                                Sed a consectetur eget feugiat. Sed tincidunt purus aliquam lectus.
                            </p>
                        </div>

                        <div class="mb-block-small wysiwyg">
                            <h2>Compartilhamento e cookies</h2>
                            <p>
                                Urna orci at mattis non. Sed faucibus consectetur quis et id bibendum dictum orci morbi.
                                Natoque sem et enim ligula neque amet. Id diam porta id diam leo.
                            </p>
                        </div>

                        <div class="wysiwyg">
                            <h2>Seus direitos e contato</h2>
                            <p>
                                Lorem ipsum dolor sit amet consectetur. Lectus arcu mauris elementum sit id ut eu metus
                                feugiat. Para exercer os seus direitos, fale com o encarregado pelo e-mail
                                privacidade@exemplo.com.br.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
