# Melhorias do frontend: decisões e convenções

> Branch `feat/update-bs6`, a partir de 2026-11-04. Última atualização: 2026-11-18.

## 1. Resumo

- A atualização para o Bootstrap 6 foi aproveitada para revisar o resto do frontend: carregamento de CSS e JS, critical CSS, scripts de build, imagens, SEO, acessibilidade e PWA.
- Este guia registra **o que ficou decidido e por quê**. A lista do que mudou fica no PR e no `git log`.
- **Fora daqui:**
  - o Bootstrap 6 (estrutura do Sass, layers, classes e armadilhas): [bootstrap-6-migration.md](bootstrap-6-migration.md);
  - como usar os componentes, as macros e o `priority`: [README do pacote frontend](../packages/agenciafmd/frontend/README.md).
- **Rota de teste:** http://localhost:8081/html/tema (catálogo) e as páginas em `/html/*`.

## 2. CSS sob demanda e purge

| Decisão | Por quê | Onde |
| --- | --- | --- |
| CSS do sweetalert2, Plyr e GLightbox fora do CSS global. Cada um tem uma entrada própria, carregada no `Promise.all` com o `import()` da lib | Eram baixados em todas as páginas, mesmo nas que nunca abrem um alerta, um vídeo ou uma galeria. O CSS global caiu de 289,5 para 215 KB | `resources/scss/vendors/<lib>/<lib>.scss`, `resources/js/components/{swal,plyr,glightbox}.js` |
| Swiper dividido: o core fica no global (sub-layer `custom.swiper`) e os módulos (navigation, pagination, fade) vêm sob demanda no `createSlider()` | Com o core no global, o slider não causa salto de layout. Os módulos só servem nas páginas com slider | `resources/scss/vendors/swiper/`, `resources/js/components/swiper.js` |
| Swiper sem efeitos 3D, scrollbar, zoom, virtual e grid | Nenhuma página usa. Para usar um deles, importe-o no `swiper-modules.scss` | `resources/scss/vendors/swiper/swiper-modules.scss` |
| sweetalert2 importado de `sweetalert2/dist/sweetalert2.esm.js` | O import padrão (`esm.all`) injeta o próprio CSS e duplicava o tema do projeto (chunk de 78 para 47 KB) | `resources/js/components/swal.js` |
| GLightbox reaproveita o `loadPlyr()` | Antes ele baixava o Plyr 3.6.12 do `cdn.plyr.io` | `resources/js/components/glightbox.js` |
| Catálogo (`/html/tema`) com entrada própria, `pages/theme.scss`, fora do purge global | O catálogo cita todos os componentes e mantinha o CSS de todos eles no global de todas as páginas | `vite.config.js` (`purgeOnly()`, `skippedContentGlobs`), `resources/scss/pages/_catalog.scss` |
| Os masters aceitam `$stylesheet` | Uma página pode trocar o CSS global por uma entrada própria (o catálogo passa `pages/theme.scss`) | `packages/agenciafmd/frontend/resources/views/master.blade.php` |
| Classes montadas em tempo de execução ficam no safelist do purge (`desc-*`, `description-*`, `avatar-*`, `status-*`, tags do rich editor) | O purge só enxerga classes escritas no markup e no JS lido | `vite.config.js` |
| Fonte externa restrita aos pesos em uso (Roboto 300–700, sem itálico) | Caiu de 21 para 12 arquivos de fonte | `vite.config.js` (`webfonts`), `resources/scss/frontend/_fonts.scss` |

As regras de layer do CSS de terceiros (global × sob demanda × lib dividida) estão em [bootstrap-6-migration.md › Armadilhas › Build e ferramentas](bootstrap-6-migration.md#7-armadilhas-conhecidas).

## 3. Critical CSS

| Decisão | Por quê | Onde |
| --- | --- | --- |
| A configuração do `rollup-plugin-critical` fica em `critical.js`, e todas as páginas de `views/html` recebem um crítico (menos `internal`, `master` e `tema`) | Antes só a `index` tinha crítico. Uma página nova ganha o dela sem configuração | `resources/js/utilities/critical.js` |
| O crítico é gerado com o JS rodando, no Chromium do Playwright, e força regras de estados de runtime (`data-bs-theme`, header fixo/oculto, swiper, `ratio-*`) | Sem isso, a primeira dobra aparecia sem estilo (FOUC) até o JS rodar | `critical.js` (`alwaysIncludedRules`, `waitForJsTime`) |
| Um viewport por breakpoint do projeto | O crítico cobre a primeira dobra de cada layout | `critical.js` (`viewports`) |
| App fora do ar só avisa e mantém os arquivos. Página sem status 200 ou erro na geração falha o build | O build não quebra sem o Sail, mas uma página quebrada não passa despercebida | `critical.js` |
| A chave do cache do `CriticalCss` inclui o `mtime` do arquivo, e arquivo ausente não é cacheado | Um build novo renova o CSS inline sem `cache:clear` | `packages/agenciafmd/frontend/src/View/Components/CriticalCss.php` |
| Com o Vite dev rodando (`isRunningHot()`), o crítico não é injetado | O crítico da última build ficava por cima do SCSS em edição e travava o HMR | idem |
| O master dos mocks (`/html/*`) usa `<x-frontend::critical-css>`, menos o catálogo | Os mocks reproduzem o carregamento de produção: crítico inline e CSS completo assíncrono | `packages/agenciafmd/frontend/resources/views/html/master.blade.php` |

Uso e opções: [README › CSS crítico](../packages/agenciafmd/frontend/README.md#css-crítico).

## 4. JavaScript

| Decisão | Por quê | Onde |
| --- | --- | --- |
| `frontend.js` só importa e inicializa. Cada helper fica no próprio módulo | O arquivo tinha 599 linhas, e outras entradas importavam tudo para usar uma função | `resources/js/components/`, `resources/js/helpers/` |
| `frontend.js` em dois blocos: **ALWAYS ON** (helpers leves com um listener delegado no `document`) e **OPT-IN** (descomentar o que o projeto usa) | A delegação funciona com qualquer quantidade de elementos e com HTML inserido depois do load (Livewire, scroll infinito). Os helpers pesados só pesam quando são usados | `resources/js/frontend.js` |
| Helpers sem chamada (`getFieldValue`, `getCookiesAsObject`, `getCookieByName`, `disableFormFields`/`enableFormFields`) ficam no starter | Fazem parte do kit. Cada projeto decide se usa | `resources/js/helpers/` |
| JS de componente Blade via `@pushOnce('scripts')` + `@vite(...)` | O `@vite` gera o `modulepreload` dos chunks, e o `@pushOnce` evita tag repetida | ver [bootstrap-6-migration.md › JS de um componente Blade](bootstrap-6-migration.md#js-de-um-componente-blade) |
| Máscaras registradas no `alpine:init` (`Alpine.plugin`, `addInitSelector`, `interceptInit`), e o `x-mask` volta no `morph.updated` do Livewire | Campos inseridos depois do load ganham máscara, e o morph do Livewire não apaga mais o atributo | `resources/js/helpers/input-masks.js` |
| Header: scroll passivo limitado por `requestAnimationFrame` (no lugar de `setInterval` de 200 ms) e alvos relidos a cada scroll | O intervalo rodava para sempre. O alvo final lido no load ficava desatualizado quando a página crescia | `resources/js/components/fmd-header.js` |
| Header oculto com `transform: translateY(-100%)`, com `transition-property` explícito e uma única duração | Anima no compositor, sem layout a cada frame. O JS lê a duração como número (duas durações dariam `NaN`). Testar nos dois modos de header | `resources/scss/components/_fmd-header.scss` |
| Embed de vídeo montado com a API do DOM (`createElement`, `dataset`, `replaceChildren`) | O id vem do admin. Interpolado em `innerHTML`, permitia injetar HTML | `resources/js/components/plyr.js` |
| `dataLayer` com `(window.dataLayer ??= []).push(evt)` | Recriar o array perdia o hook de `push` do GTM, e os eventos não chegavam | `resources/js/helpers/data-layer.js` |
| JS de página via `@vite` na própria view, não no `frontend-imports.js` | Cada página baixa só o que usa | `resources/js/frontend-imports.js` (comentário) |

## 5. Build

| Decisão | Por quê | Onde |
| --- | --- | --- |
| Scripts de build em dois blocos: **PROJECT SETTINGS** (o que cada projeto ajusta, com um comentário dizendo quando mudar) e **BUILD INFRASTRUCTURE** (não mexer) | Quem começa um projeto sabe o que pode mudar sem ler a infraestrutura | `vite.config.js`, `resources/js/utilities/{critical,webp,create-manifest}.js` |
| `refresh` do Vite com lista explícita de caminhos (views, `src` e `lang` dos pacotes) | Os caminhos padrão do `refresh: true` não incluem `packages/`, então editar uma view de pacote não recarregava o navegador | `vite.config.js` (`refreshPaths`) |
| Conversão para webp com `sharp` (qualidade 90, effort 4), pulando arquivos com webp atualizado (`mtime`) | Troca o `imagemin` por uma dependência só e não reconverte o que não mudou | `resources/js/utilities/webp.js` |
| PDFs e vídeos passam pelo Vite (`Vite::pdf()`, `Vite::video()`, alias `@pdf`) | Recebem hash e são servidos pelo build, como as imagens | `resources/pdf/`, `resources/videos/`, `FrontendServiceProvider` |
| Node 24 no Sail (`NODE_VERSION`) e `.tool-versions` com a mesma versão do container | Evita diferença entre o ambiente local e o container | `compose.yaml`, `.tool-versions` |
| `postinstall` com `playwright install chromium` | No Sail o Chromium fica dentro de `node_modules` e some a cada reinstalação. O critical e os testes de browser dependem dele | `package.json` |
| Removidos os scripts legados (`compress`, `spritemap`, `lax`, `lighthouse`, `create-page`, `greetings`, `app.js`, `bootstrap.js`) e o `axios` | Sem uso ou da era webpack | — |

## 6. Imagens e Core Web Vitals

| Decisão | Por quê | Onde |
| --- | --- | --- |
| Só a primeira imagem com `priority` recebe `fetchpriority="high"`. As outras ficam só `eager` | Várias imagens com prioridade alta disputavam banda e atrasavam o LCP | `components/image.blade.php`, props `priority` em `articles.item`, `cards.card-picture` e `sliders.banner` |
| `width`/`height` reais: lidos com `getimagesize()` (PNG/JPG) ou passados por prop. Sai o `1x1` falso e o `width: auto` | As imagens lazy cresciam ao carregar e deslocavam as âncoras (CLS) | `components/image.blade.php`, `resources/scss/components/_images.scss` |
| `<img>` sem `width`/`height` ganha outline nos avisos de acessibilidade | Mostra no mock o que vai causar salto de layout | `resources/scss/components/_accessibilities.scss` |
| `x-frontend::image` aceita URL externa (`http://`, `https://`, `//`) sem passar pelo Vite e sem `@2x` | Dava erro 500 ao procurar a URL no manifest | `components/image.blade.php` |
| Player embed sem imagem usa `hqdefault.jpg` do YouTube (480×360) | É a única miniatura que existe para qualquer vídeo. A `maxresdefault` nem sempre existe | `components/glightbox/player-embed.blade.php` |

Uso: [README › Imagem principal da página](../packages/agenciafmd/frontend/README.md#imagem-principal-da-página-priority) e [Tamanho das imagens](../packages/agenciafmd/frontend/README.md#tamanho-das-imagens-widthheight).

## 7. SEO, acessibilidade e PWA

| Decisão | Por quê | Onde |
| --- | --- | --- |
| `<link rel="canonical">` com `url()->current()`, sobrescrevível com `@section('canonical')`. O `og:url` dos mocks usa o mesmo valor | Sem canonical, cada query string (utm, fbclid) virava uma URL duplicada | `master.blade.php`, `html/master.blade.php` |
| `h1` visualmente oculto nas páginas iniciais | Toda página precisa de um `h1` | `pages/index.blade.php`, `html/index.blade.php` |
| `aria-label` em link só quando não há texto legível | Nome acessível diferente do texto visível falha no Lighthouse (*label in name*) | `components/link.blade.php` |
| Prop `headingTag` em `articles.item` (padrão `h2`) e `sliders.banner` | A página define o nível do título e mantém a hierarquia | componentes citados |
| Toggles de menu como `<button>` e `drawerId` parametrizável no header | Controle sem semântica de botão não é acessível pelo teclado | `html/partials/header.blade.php` |
| Ícones com `aria-hidden` por padrão | Ícone decorativo não deve ser lido pelo leitor de tela | `BladeServiceProvider` |
| Badges `subtle` com `fg-emphasis-*` | Contraste mínimo | `resources/scss/frontend/_maps.scss` |
| Margem de 0.375rem entre `.form-field` de check/radio/switch empilhados | Alvo de toque mínimo de 24 px (WCAG 2.5.8). Com o line-height base sobravam 14,4 px | `resources/scss/components/_checks.scss` |
| A paleta do starter não é ajustada para contraste | É placeholder: cada projeto troca a base de cores | — |
| PWA sem service worker. O manifest fica, então o site continua instalável, mas sem modo offline | O `pwaManager()` nunca era chamado, e o SW cacheava caminhos do Laravel Mix que dão 404 | — |
| `theme_color` e `background_color` compilados dos tokens (`$ds-primary`, `$ds-body-bg`). As metas do `<head>` leem o manifest gerado | Antes, um parser de linhas frágil e cores fixas | `resources/js/utilities/create-manifest.js`, `components/pwa.blade.php` |
| Ícones e logos nos tamanhos do Design System (logo 200×70, mstile 150×150, apple-touch 180×180) | Tamanhos fora do padrão | `resources/images/`, `create-manifest.js` |

Uso do PWA: [README › PWA](../packages/agenciafmd/frontend/README.md#pwa).

## 8. Pendentes ou monitorar

| Tema | Situação |
| --- | --- |
| Canonical no pacote `laravel-social-meta` | O pacote emite `og:url`, mas não o canonical. Hoje o canonical fica nos masters do frontend. Levar para o pacote (upstream) |
| Plyr → Video.js | Plyr descontinuado. Migração adiada: o Video.js é cerca de 3× maior e o GLightbox depende do Plyr |
| `livewire.js` de 610 KB no Lighthouse local | É o build de debug. A produção serve o `.min` (262 KB / 86 KB gzip). O servidor local não comprime |
