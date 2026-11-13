# Frontend – Agência F&MD

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/frontend.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/frontend)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Base do site público dos projetos: layout `master`, páginas e partials, rotas iniciais, biblioteca de componentes Blade (Bootstrap), imagens responsivas geradas sob demanda, CSS crítico, Google Tag Manager e o formulário de contato em Livewire.

## Requisitos

- Laravel ^13.15
- intervention/image ^3.11 (com a extensão `imagick`)

Também utilizados pelo código, mas não declarados no `composer.json` do pacote (precisam estar instalados na aplicação):

- livewire/livewire ^4 (namespace `frontend` e formulário de contato)
- vite-plugin-webfont-dl (npm; gera o `webfonts.css` carregado pelo `fonts-preload`)
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
| `resources/videos/` e `resources/pdf/` | Arquivos usados por `Vite::video()` e `Vite::pdf()` |
| `resources/svg/` | Ícones do icon set `frontend` (`<x-icon name="frontend-...">`) |
| `resources/views/errors/` | Registrado como namespace `errors::` |
| `public/css/critical/{nome}_critical.min.css` | CSS crítico lido pelo `<x-frontend::critical-css>`, gerado no build (`resources/js/utilities/critical.js`) |
| `public/manifest.json` | Manifest do PWA, gerado no build (`resources/js/utilities/create-manifest.js`) |

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
<video src="{{ Vite::video('institucional.mp4') }}" controls></video>   {{-- resources/videos/institucional.mp4 --}}
<a href="{{ Vite::pdf('regulamento.pdf') }}" target="_blank">Regulamento</a>   {{-- resources/pdf/regulamento.pdf --}}
```

Os arquivos passam pelo build: o nome ganha um hash, e o cache do navegador se renova a cada versão.

### Imagem responsiva (`<x-img>`)

Gera, na primeira renderização, as versões redimensionadas da imagem (da largura original até 200px, reduzindo 25% a cada passo) em `cache/.../responsive` no disco padrão, além de um placeholder em base64. O resultado fica em cache permanente.

```blade
<x-img src="banners/home.jpg" alt="Banner" />
<x-img :src="$article->image" :quality="70" class="rounded" alt="{{ $article->title }}" />
```

O `src` é procurado no disco padrão do Storage e em `resources/images/`.

### Imagem principal da página (`priority`)

Por padrão, o `<x-frontend::image>` e o `<x-frontend::picture>` carregam a imagem com `loading="lazy"`. Nas imagens da primeira dobra, use `priority`: elas são baixadas de imediato (`loading="eager"`), o que melhora o LCP.

```blade
<x-frontend::picture image="banners/home.jpg" title="Banner" has-breakpoints :priority="$loop->first" />

{{-- grade de cards: a primeira linha (3 colunas no desktop), qualquer que seja a quantidade de itens --}}
<x-frontend::articles.item :article="$article" :priority="$loop->index < 3" />
```

A **primeira** imagem com `priority` da página também ganha `fetchpriority="high"`. As outras ficam só `eager`, para não disputar a banda com ela. Isso é automático: o componente guarda no request que a prioridade alta já foi usada.

### Tamanho das imagens (`width`/`height`)

Com `width` e `height` no `<img>`, o navegador reserva o espaço da imagem antes de ela carregar. Sem eles, a imagem lazy ocupa 0 px e empurra a página quando chega (layout shift, que piora o CLS e faz âncoras pararem no lugar errado).

O `<x-frontend::image>` (e o `picture`, que usa ele) preenche o tamanho sozinho em **PNG e JPG**, lendo o arquivo em `resources/images/`. Com breakpoints (`has-breakpoints`), vale o tamanho da imagem base, a do mobile: as variantes `-lg`/`-xl` devem manter a proporção, ou a imagem fica dentro de um `.ratio`.

Nos outros casos (SVG, ICO, URL externa e `<img>` escrito à mão), passe `width` e `height`:

```blade
<x-frontend::image image="icons/safari-pinned-tab.svg" width="512" height="512" title="Safari pinned tab" />
```

**Aviso no navegador:** todo `<img>` sem `width` e `height` ganha o mesmo contorno vermelho do aviso de imagem sem `alt` (`resources/scss/components/_accessibilities.scss`). Ficam de fora:
- imagens dentro de `.wysiwyg`, que vêm do admin;
- `.fslightbox-source`;
- imagens com a classe `skip-warning`, para quando o tamanho realmente não pode ser informado.

### CSS crítico

```blade
<x-frontend::critical-css critical="index.css" />
```

Lê `public/css/critical/index_critical.min.css` e imprime dentro de `<style>`. Os arquivos são gerados no `npm run build` por `resources/js/utilities/critical.js`: cada página de `views/html` (menos os layouts e o catálogo `tema`) é aberta num navegador real. A aplicação precisa estar rodando. Se não estiver, o build mantém o CSS crítico anterior.

- **Cache:** a chave inclui a data de modificação do arquivo, então um novo build renova o cache sozinho, sem `cache:clear`.
- **Sem arquivo:** não renderiza nada e não guarda cache. O CSS crítico passa a valer assim que o arquivo for gerado.
- **Com o `vite dev` rodando:** não renderiza nada, para o CSS antigo do build não brigar com o do dev server.

### Componentes Blade

Todos disponíveis como `<x-frontend::nome>`:

| Grupo | Componentes |
|---|---|
| Head / tracking | `gtm-head`, `gtm-body`, `site-verification`, `pwa`, `fonts-preload`, `critical-css`, `color-mode` |
| Imagens | `image`, `picture`, `sources`, `single-source` (WebP + `@2x` via `Vite::image()`), `avatar` |
| Navegação | `link`, `link-share`, `breadcrumb`, `social-network`, `privacy-policy-link`, `privacy-terms-message` |
| Conteúdo | `alert`, `badge`, `list-icon`, `pdf`, `cards.card`, `cards.card-picture`, `articles.item`, `articles.item-no-image` |
| Interação | `accordions.accordion`, `accordions.accordion-faq`, `dialogs.dialog`, `dialogs.dialog-base` |
| Mídia | `glightbox.image`, `glightbox.video`, `glightbox.player-embed` |
| Sliders | `sliders.banner`, `sliders.articles-gallery`, `swiper-buttons` |
| Progresso | `progress.bar`, `progress.circle` |

Exemplos:

```blade
<x-frontend::breadcrumb :list="['Home' => route('frontend.index'), 'Blog' => '#']" />

<x-frontend::link link="/html/index" label="Ver protótipos" icon="ic-ui-chevron-right" />

<x-frontend::dialogs.dialog id="dialogContato" title="Fale conosco">
    ...
</x-frontend::dialogs.dialog>
<button type="button" class="btn" data-bs-toggle="dialog" data-bs-target="#dialogContato">Abrir</button>
```

**`color-mode`** (dark mode): fica no `<head>`, antes do CSS, e o `frontend::master` já inclui. Aplica o tema salvo pelo botão de tema ou, sem escolha, o tema do sistema, para a página não piscar no tema claro.

### JS e CSS dos componentes

Componentes que precisam de JS ou CSS próprio (`sliders.banner`, `sliders.articles-gallery`, `link-share`) carregam esses arquivos sozinhos, só nas páginas em que aparecem:

```blade
@pushOnce('scripts')
    @vite('resources/js/components/sliders/banners.js')
@endPushOnce
```

- O `@vite` gera o `modulepreload` dos chunks importados, e o navegador baixa tudo em paralelo.
- O `@pushOnce` imprime a tag uma vez só, mesmo com o componente repetido na página.
- O layout precisa do `@stack('scripts')`. O `frontend::master` já inclui.

Ao criar um componente com JS, siga o mesmo padrão e liste a entrada no `input` do `vite.config.js`.

### PWA

O `<x-frontend::pwa>` liga o `public/manifest.json` e os ícones (`apple-touch-icon`, `favicon`, `mask-icon`). Não há service worker: o site fica instalável, mas sem cache offline.

A `theme_color` vem dos tokens do tema. O build a grava no manifest (`create-manifest.js`), e o componente usa a mesma cor nas metas `theme-color` e `msapplication-TileColor`.

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
