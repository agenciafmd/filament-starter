{{-- Troque o link padrão pela rota real da política: /html/* redireciona para a home em produção --}}
@props([
    'link' => '/html/politica-de-privacidade',
    'isExtern' => false,
])

<x-frontend::link
    :link="$link"
    :is-extern="$isExtern"
    label="Política de Privacidade"
    title="Política de Privacidade"
    :attributes="$attributes->merge(['class' => 'text-reset text-decoration-none'])"
/>
