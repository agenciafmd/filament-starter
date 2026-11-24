# Melhorias do frontend: decisões e convenções

> Branch `feat/frontend-update-bs5`, backport para o Bootstrap 5 das melhorias feitas em `feat/update-bs6`. Última atualização: 2026-11-23.

## 1. Resumo

- O Bootstrap 6 ainda está em alpha. As melhorias do `feat/update-bs6` que não dependem dele foram trazidas para o Bootstrap 5, para chegar à develop sem esperar a versão estável.
- Este guia registra **o que ficou decidido e por quê**. A lista do que mudou fica no PR e no `git log`.
- Como usar os componentes, o `priority`, o `.wysiwyg` e o checklist: [README do pacote frontend](../packages/agenciafmd/frontend/README.md).
- **Rotas de teste:** as páginas em `/html/*`. O catálogo de componentes fica em `/html/tema`.
- **Não veio do BS6:** o markup e a acessibilidade do catálogo `/html/tema` (que no BS6 usa as classes novas) e o dark mode.

## 2. CSS sob demanda e purge

O CSS global caiu de **212 KB** (develop) para **96 KB**.

| Decisão | Por quê | Onde |
| --- | --- | --- |
| CSS do sweetalert2, vLitejs e GLightbox fora do CSS global. Cada um tem uma entrada própria, carregada no `Promise.all` com o `import()` da lib | Eram baixados em todas as páginas, mesmo nas que nunca abrem um alerta, um vídeo ou uma galeria | `resources/scss/vendors/<lib>/<lib>.scss`, `resources/js/components/{swal,vlite,glightbox}.js` |
| Swiper dividido: o core fica no global e os módulos (navigation, pagination, fade) vêm sob demanda no `createSlider()` | Com o core no global, o slider não causa salto de layout. Os módulos só servem nas páginas com slider | `resources/scss/vendors/swiper/`, `resources/js/components/swiper.js` |
| sweetalert2 importado de `sweetalert2/dist/sweetalert2.esm.js` | O import padrão injeta o próprio CSS e duplicava o tema do projeto | `resources/js/components/swal.js` |
| Plyr trocado pelo vLitejs, um player só para o embed e para a galeria. No GLightbox, o vídeo vira slide inline com o player do projeto. Só o slide atual toca, o anterior pausa e fechar destrói os players. O botão de play do player (`.v-bigPlay`) usa o SVG e o visual do `.ic-play` das thumbs. Na pausa, o overlay desfoca a tela de pausa do YouTube (play, título, "Mais vídeos"). A proporção do vídeo segue as classes `.ratio-*` do `$aspect-ratios`: no embed e no `x-frontend::glightbox.video` pela prop `aspectRatio` (padrão 16x9). Na galeria, o vídeo vertical fica limitado a 90vh de altura | O Plyr foi descontinuado e o slide de vídeo do GLightbox só funciona com ele (baixava do `cdn.plyr.io`). O vLitejs dá ~9 KB gzip (core + CSS + YouTube), contra ~38 KB do Plyr | `resources/js/components/{vlite,player-embed,glightbox}.js` |
| O Vimeo foca o próprio iframe ao tocar: o foco volta para o container do player | Sem isso, as setas e o Esc ficavam presos no iframe e não chegavam ao GLightbox | `resources/js/components/vlite.js` |
| Galeria com um item só: setas escondidas e `loop()` desligado na instância | O CSS do GLightbox declara o `.glightbox-button-hidden` antes do `display: flex` das setas, e elas ficavam visíveis com cara de desabilitadas. Com o `loop`, a seta, o teclado e o swipe voltavam para o mesmo slide, que reanimava e reiniciava o vídeo | `resources/js/components/glightbox.js`, `resources/scss/vendors/glightbox/glightbox.scss` |
| Um CSS carregado sob demanda entra **depois** do global e ganha empates de especificidade. Regras que o Bootstrap aplica aos filhos (ex.: `.ratio > *`) precisam ser reforçadas no tema da lib | O `.v-vlite { position: relative }` vencia o `.ratio > * { position: absolute }`, e o player saía da caixa do vídeo | `resources/scss/vendors/vlite/vlite.scss` (`.ratio > .v-vlite`) |
| Catálogo (`/html/tema`) com entrada própria (`pages/theme.scss`), fora do purge global | O catálogo cita todos os componentes e mantinha o CSS de todos eles no global de todas as páginas | `vite.config.js`, `resources/scss/pages/` |
| Os masters aceitam `$stylesheet` | Uma página pode trocar o CSS global por uma entrada própria (o catálogo passa `pages/theme.scss`) | `packages/agenciafmd/frontend/resources/views/master.blade.php` |
| Classes montadas em tempo de execução ficam no safelist do purge, assim como as tags e as classes do rich editor (`grid-layout`, `grid-layout-col`) | O purge só enxerga classes escritas nas views e no JS lido. O conteúdo do admix vem do banco | `vite.config.js` (`safelist`) |
| Fonte externa restrita aos pesos em uso (Roboto 300–700, sem itálico) | Menos arquivos de fonte. A Roboto vem num único arquivo variável | `vite.config.js` (`webfonts`), `resources/scss/frontend/_fonts.scss` |

## 3. Critical CSS

| Decisão | Por quê | Onde |
| --- | --- | --- |
| A configuração do critical fica em `critical.js`, e todas as páginas de `views/html` recebem um crítico (menos `internal`, `master` e `tema`) | Uma página nova ganha o dela sem configuração | `resources/js/utilities/critical.js` |
| O crítico é gerado com o JS rodando, no Chromium do Playwright, e força regras de estados de runtime (header fixo/oculto, swiper, `ratio-*`) | Sem isso, a primeira dobra aparecia sem estilo até o JS rodar | `critical.js` (`alwaysIncludedRules`) |
| Um viewport por breakpoint do projeto | O crítico cobre a primeira dobra de cada layout | `critical.js` (`viewports`) |
| App fora do ar só avisa e mantém os arquivos. Página sem status 200 falha o build | O build não quebra sem o Sail, mas uma página quebrada não passa despercebida | `critical.js` |
| A chave do cache do `CriticalCss` inclui o `filemtime` do arquivo | Um build novo renova o CSS inline sem `cache:clear` | `packages/agenciafmd/frontend/src/View/Components/CriticalCss.php` |
| Com o Vite dev rodando (`isRunningHot()`), o crítico não é injetado | O crítico da última build ficava por cima do SCSS em edição e travava o HMR | idem |

## 4. JavaScript

| Decisão | Por quê | Onde |
| --- | --- | --- |
| `frontend.js` só importa e inicializa. Cada helper fica no próprio módulo | O arquivo concentrava tudo, e outras entradas importavam tudo para usar uma função | `resources/js/components/`, `resources/js/helpers/` |
| `frontend.js` em dois blocos: os helpers leves, sempre ligados, com um listener delegado no `document`; e os opcionais (CEP, estados/cidades, clipboard, WOW, sliders), que o projeto descomenta quando usa | A delegação funciona com HTML inserido depois do load (Livewire, scroll infinito). As libs pesadas só são baixadas quando usadas | `resources/js/frontend.js` |
| Helpers sem chamada (`getFieldValue`, cookies, `disableFormFields`/`enableFormFields`) ficam no starter | Fazem parte do kit. Cada projeto decide se usa | `resources/js/helpers/` |
| Validação de CPF/CNPJ delegada no `focusout` do `document` | Vale também para campos inseridos depois do load | `resources/js/helpers/input-masks.js` |
| `guideUserToTheFirstError(form)` rola até o primeiro erro **do próprio form**. Dentro de um modal, rola o modal do form (o `.modal-body` quando ele rola sozinho, com `.modal-dialog-scrollable`; senão o `.modal`) | Com dois forms na página, o envio de um rolava até o erro do outro. No modal padrão, nada rolava | `resources/js/helpers/form-helpers.js` |
| Header: scroll passivo limitado por `requestAnimationFrame`, no lugar de `setInterval` | O intervalo rodava para sempre | `resources/js/components/fmd-header.js` |
| Header oculto com `transform: translateY(-100%)` | Anima no compositor, sem recalcular o layout a cada frame. Testar mudanças de header nos dois modos (por cima da imagem e com fundo) | `resources/scss/components/_fmd-header.scss` |
| Embed de vídeo montado com a API do DOM (`createElement`, `dataset`, `replaceChildren`). No clique, a caixa copia o `border-radius` da thumb | O id vem do admin: interpolado em `innerHTML`, permitia injetar HTML. Sem copiar o raio, a borda arredondada sumia ao dar play | `resources/js/components/{vlite,player-embed}.js` |
| `dataLayer` com `(window.dataLayer ??= []).push(evt)` | Recriar o array perdia o hook de `push` do GTM, e os eventos não chegavam | `resources/js/helpers/data-layer.js` |
| Modais iniciados com `focus: false` | O foco automático no modal fazia a página pular de posição | `resources/js/components/bootstrap-helpers.js` (`setupModalConfig`) |

## 5. Build

| Decisão | Por quê | Onde |
| --- | --- | --- |
| `vite.config.js` em dois blocos: **PROJECT SETTINGS** (o que cada projeto ajusta) e **BUILD INFRASTRUCTURE** (não mexer) | Quem começa um projeto sabe o que pode mudar sem ler a infraestrutura | `vite.config.js` |
| `refresh` do Vite com lista explícita de caminhos, incluindo as views e o `src` dos pacotes | Os caminhos padrão não incluem `packages/`, então editar uma view de pacote não recarregava o navegador | `vite.config.js` (`refreshPaths`) |
| Conversão para webp com `sharp` (qualidade 90, effort 4), pulando o que já está convertido | Uma dependência só, e o build não reconverte o que não mudou | `resources/js/utilities/webp.js` |
| PDFs e vídeos passam pelo Vite (`Vite::pdf()`, `Vite::video()`) | Recebem hash e são servidos pelo build, como as imagens | `resources/pdf/`, `resources/videos/` |
| Node 24 no Sail e `.tool-versions` com a mesma versão do container | Evita diferença entre o ambiente local e o container | `compose.yaml`, `.tool-versions` |
| `postinstall` com `playwright install chromium` | No Sail o Chromium fica em `node_modules` e some a cada reinstalação. O critical e o checklist dependem dele | `package.json` |
| Checklist de frontend automatizado (`npm run checklist-frontend`): PWA, fontes, critical, política de privacidade, 3 navegadores, breakpoints e Lighthouse | Os itens revisados antes de entregar o site passam a ser conferidos por script | `resources/js/utilities/checklist-frontend.js` |

## 6. Imagens e Core Web Vitals

| Decisão | Por quê | Onde |
| --- | --- | --- |
| Só a primeira imagem com `priority` recebe `fetchpriority="high"`. As outras ficam só `eager`. Nas grades de cards, a primeira linha (`$loop->index < 3`) recebe `priority` | Várias imagens com prioridade alta disputavam banda e atrasavam o LCP | `components/image.blade.php`, prop `priority` em `articles.item`, `cards.card-picture` e `sliders.banner` |
| `width`/`height` reais: lidos com `getimagesize()` (PNG/JPG) ou passados por prop. SVG e ICO precisam do tamanho passado à mão | As imagens lazy cresciam ao carregar e deslocavam a página e as âncoras (CLS) | `components/image.blade.php` |
| `<img>` sem `width`/`height` ganha contorno vermelho, em qualquer ambiente | Mostra o que vai causar salto de layout. Se aparecer em produção, é sinal de que passou sem revisão | `resources/scss/components/_accessibilities.scss` |
| `x-frontend::image` aceita URL externa sem passar pelo Vite e sem `@2x` | Dava erro 500 ao procurar a URL no manifest | `components/image.blade.php` |
| Player embed sem imagem usa a `hqdefault.jpg` do YouTube (480×360) | É a única miniatura que existe para qualquer vídeo. A `maxresdefault` nem sempre existe | `components/glightbox/player-embed.blade.php` |

## 7. Conteúdo do admix (`.wysiwyg`)

| Decisão | Por quê | Onde |
| --- | --- | --- |
| Um único `.wysiwyg` por conteúdo, com o espaço entre as seções (margem antes dos títulos) definido pelo próprio `.wysiwyg` | O rich editor salva o corpo inteiro como um HTML só. As páginas de exemplo simulavam seções com vários `.wysiwyg` | `resources/scss/components/_wysiwyg.scss`, `html/blog-detalhe.blade.php`, `html/politica-de-privacidade.blade.php` |
| Estilos só para o que o `RichEditorWithDefault` gera: imagem com 100% da largura, citação, tabela (`.table`) e colunas da ferramenta `grid` | O editor não salva classes do Bootstrap. Ferramentas que o admix não liga (lead, cor de texto, bloco de código) ficam de fora | idem |
| Colunas do `grid` lado a lado a partir do `lg` (o padrão do editor), sem tratar o breakpoint escolhido no editor | Cobre o uso real com menos CSS e sem seletor de atributo no safelist | idem |

## 8. SEO, acessibilidade e PWA

| Decisão | Por quê | Onde |
| --- | --- | --- |
| `<link rel="canonical">` com `url()->current()`, sobrescrevível com `@section('canonical')`. O `og:url` dos mocks usa o mesmo valor | Sem canonical, cada query string (utm, fbclid) virava uma URL duplicada | `master.blade.php`, `html/master.blade.php` |
| `h1` visualmente oculto nas páginas iniciais | Toda página precisa de um `h1` | `pages/index.blade.php`, `html/index.blade.php` |
| `aria-label` em link só quando não há texto legível. Texto genérico ganha contexto com um `visually-hidden` colado ao texto ("Leia mais: título") | Nome acessível diferente do texto visível falha no Lighthouse e atrapalha quem navega por voz | `components/link.blade.php`, `components/articles/item.blade.php` |
| Setas da paginação com `aria-label` ("Página anterior"/"Próxima página") e o símbolo em `aria-hidden` | Sem isso, o leitor de tela lia "aspas angulares duplas" | `partials/pagination.blade.php` |
| Prop `headingTag` em `articles.item` (padrão `h2`) e `sliders.banner` | A página define o nível do título e mantém a hierarquia | componentes citados |
| Toggles do menu como `<button>` e `offcanvasId` parametrizável no header. "Produtos" virou um `button` de dropdown | Controle sem semântica de botão não é acessível pelo teclado | `html/partials/header.blade.php` |
| Ícones com `aria-hidden` por padrão | Ícone decorativo não deve ser lido pelo leitor de tela | `BladeServiceProvider` |
| Label flutuante do select com a mesma cor dos de input e textarea | O `color: inherit` deixava o label do select mais escuro | `resources/scss/components/_floating-labels.scss` |
| PWA sem service worker. O manifest fica, então o site continua instalável, mas sem modo offline | O service worker nunca era registrado e cacheava caminhos que davam 404 | — |
| `theme_color` e `background_color` vindos dos tokens do tema. As metas do `<head>` leem o manifest gerado | Antes eram cores fixas | `resources/js/utilities/create-manifest.js`, `components/pwa.blade.php` |
| Ícones e logos nos tamanhos do Design System. Página de política de privacidade com link no rodapé e no `privacy-terms-message` | Tamanhos fora do padrão. O checklist exige um link de política que leve a uma página | `resources/images/`, `html/politica-de-privacidade.blade.php` |

## 9. Pendentes ou monitorar

| Tema | Situação |
| --- | --- |
| Canonical no pacote `laravel-social-meta` | O pacote emite `og:url`, mas não o canonical. Hoje o canonical fica nos masters do frontend. Levar para o pacote (upstream) |
| vLitejs | Projeto pequeno, com um mantenedor só. Se for abandonado, o código é pequeno o bastante para manter um fork |
| `/data-bs-theme/` no `alwaysIncludedRules` do `critical.js` | Sobra do BS6, que tem dark mode. No BS5 não há `color-mode.blade.php`, então a regra não tem efeito |
| `feat/update-bs6` | Fica parada até o Bootstrap 6 sair estável. Aí recebe a develop (merge ou rebase), mantendo a versão BS6 nos conflitos. As correções feitas nesta branch (vLitejs no lugar do Plyr, validação em modal, label do select, `.wysiwyg`) precisam ser levadas para lá |
