# Frontend – Agência F&MD

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/frontend.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/frontend)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Base do site público dos projetos: layout `master`, páginas e partials, rotas iniciais, biblioteca de componentes Blade (Bootstrap), imagens responsivas geradas sob demanda, CSS crítico, Google Tag Manager e o formulário de contato em Livewire.

## Requisitos

- Laravel ^13.15
- intervention/image ^3.11 (com a extensão `imagick`)

Também utilizados pelo código, mas não declarados no `composer.json` do pacote (precisam estar instalados na aplicação):

- livewire/livewire ^4 (namespace `frontend` e formulário de contato)
- spatie/laravel-google-fonts (diretiva `@googlefonts` no `fonts-preload`)
- blade-ui-kit/blade-icons (componente `<x-icon>` e icon set `frontend`)
- agenciafmd/laravel-social-meta (componente `<x-social-meta>` no `master`)
- agenciafmd/laravel-support (regra `HumanName` e trait `FormRateLimiter`)
- agenciafmd/filament-postal (envio do formulário de contato)

## Instalação

O pacote é carregado localmente pelo repositório `path` do `composer.json` da aplicação:

```json
"repositories": {
    "agenciafmd/frontend": {
        "type": "path",
        "url": "packages/agenciafmd/frontend",
        "options": {
            "symlink": true
        }
    }
},
```

```bash
composer require agenciafmd/frontend:*
```

O service provider é registrado automaticamente (package discovery).

## Configuração

```dotenv
GOOGLE_TAGMANAGER=GTM-XXXXXXX
GOOGLE_SITE_VERIFICATION=
```

| Variável | Config | Descrição |
|---|---|---|
| `GOOGLE_TAGMANAGER` | `frontend.google.tagmanager` | ID do GTM; os componentes `gtm-head` / `gtm-body` só renderizam quando preenchido |
| `GOOGLE_SITE_VERIFICATION` | `frontend.google.site_verification` | Token do Google Search Console (`google-site-verification`) |

O pacote não publica arquivos (config, views ou assets); as views são carregadas com o namespace `frontend::`.

### Arquivos esperados na aplicação

| Caminho | Uso |
|---|---|
| `resources/scss/frontend.scss` e `resources/js/frontend-imports.js` | Entradas do Vite carregadas no `master` |
| `resources/images/` | Imagens usadas por `Vite::image()` e pelo `<x-img>` |
| `resources/fonts/` | Fontes usadas por `Vite::font()` |
| `resources/svg/` | Ícones do icon set `frontend` (`<x-icon name="frontend-...">`) |
| `resources/views/errors/` | Registrado como namespace `errors::` |
| `public/css/critical/{nome}_critical.min.css` | CSS crítico lido pelo `<x-frontend::critical-css>` |

## Uso

### Rotas

| Método | URI | Nome | Descrição |
|---|---|---|---|
| `GET` | `/` | `frontend.index` | Home (`frontend::pages.index`) |
| `GET` | `/html/{any?}` | `frontend.html` | Protótipos estáticos de `resources/views/html` (ex.: `/html/tema`). Cai no `html.index` quando a view não existe e redireciona (301) para `/` em produção |

### Layout

As páginas estendem o `frontend::master`, que já inclui GTM, `<x-social-meta>`, PWA, preload de fontes, verificação do Google, CSS crítico, Vite e Livewire:

```blade
@extends('frontend::master', [
    'bodyClass' => 'internal',
    'critical' => 'index.css',
])

@section('title', 'A cultura come a estratégia no café da manhã')
@section('description', 'Esta é uma frase de Peter Drucker, considerado o pai da administração moderna.')

@section('content')
    ...
@endsection
```

Seções e stacks disponíveis: `@section('header')`, `@section('content')`, `@section('footer')`, `@push('head')`, `@push('header')`, `@push('footer')`, `@push('scripts')`. A variável `$bodyClass` define a classe do `<body>` e `$critical` o arquivo de CSS crítico. Para páginas internas existe também o layout `frontend::internal`.

### Macros do Vite

```blade
<img src="{{ Vite::image('logo.png') }}" alt="Logo" />   {{-- resources/images/logo.png --}}
<link rel="preload" href="{{ Vite::font('Roboto-Regular.woff2') }}" as="font" crossorigin />
```

### Imagem responsiva (`<x-img>`)

Gera, na primeira renderização, as versões redimensionadas da imagem (da largura original até 200px, reduzindo 25% a cada passo) em `cache/.../responsive` no disco padrão, além de um placeholder em base64. O resultado fica em cache permanente.

```blade
<x-img src="banners/home.jpg" alt="Banner" />
<x-img :src="$article->image" :quality="70" class="rounded" alt="{{ $article->title }}" />
```

O `src` é procurado no disco padrão do Storage e em `resources/images/`.

### CSS crítico

```blade
<x-frontend::critical-css critical="index.css" />
```

Lê `public/css/critical/index_critical.min.css` (em cache permanente) e imprime dentro de `<style>`. Não renderiza nada se o arquivo não existir.

### Componentes Blade

Todos disponíveis como `<x-frontend::nome>`:

| Grupo | Componentes |
|---|---|
| Head / tracking | `gtm-head`, `gtm-body`, `site-verification`, `pwa`, `fonts-preload`, `critical-css` |
| Imagens | `image`, `picture`, `sources`, `single-source` (WebP + `@2x` via `Vite::image()`) |
| Navegação | `link`, `link-share`, `breadcrumb`, `social-network`, `privacy-policy-link`, `privacy-terms-message` |
| Conteúdo | `alert`, `badge`, `list-icon`, `pdf`, `cards.card`, `cards.card-picture`, `articles.item`, `articles.item-no-image` |
| Interação | `accordions.accordion`, `accordions.accordion-faq`, `modals.modal`, `modals.modal-base` |
| Mídia | `glightbox.image`, `glightbox.video`, `glightbox.player-embed` |
| Sliders | `sliders.banner`, `sliders.articles-gallery`, `swiper-buttons` |
| Progresso | `progress.bar`, `progress.circle` |

Exemplos:

```blade
<x-frontend::breadcrumb :list="['Home' => route('frontend.index'), 'Blog' => '#']" />

<x-frontend::link link="/html/index" label="Ver protótipos" icon="ic-ui-chevron-right" />

<x-frontend::modals.modal id="modalContato" title="Fale conosco">
    ...
</x-frontend::modals.modal>
```

### Formulário de contato (Livewire)

```blade
<livewire:frontend::contact />
```

Valida `name` (com `HumanName`), `email` (`email:rfc,dns`), `phone` e `terms`, aplica rate limit (5 tentativas por IP) e envia a notificação pelo Postal cadastrado com o slug **`contato`**. Ao final, dispara os eventos de browser `swal` (mensagem de sucesso/erro) e `datalayer` (`form_name: contato`).

> Sem um Postal com slug `contato`, o formulário exibe "Formulário de disparo não configurado.".

## Testes

Os testes ficam em `tests/` e usam o `Tests\TestCase` da aplicação, então são executados de dentro do projeto:

```bash
vendor/bin/pest packages/agenciafmd/frontend/tests
```

## Licença

Este pacote é software livre e está disponível nos termos da licença MIT.
