# Migração Bootstrap 5.3 → 6.0 Alpha

> Status: **fases 1–6 concluídas** — restam as decisões pendentes de aprovação abaixo.
> Última atualização: 2026-10-30.

## Contexto

O frontend (Laravel + Vite + Sass) usava Bootstrap 5.3.8 compilado do fonte com `@import`. O objetivo é levar o projeto ao Bootstrap 6 alpha numa branch isolada, preservando arquitetura, customizações e comportamento. A ideia é reavaliar quando o v6 estável for lançado.

- **Branch:** `feat/update-bs6`, criada a partir da develop.
- **Proibido:** merge em `develop` ou `master`.
- **Versão instalada:** `bootstrap@6.0.0-alpha.1`, fixa e sem `^`. Na tag npm `next`, essa é a única versão 6.x publicada.
- **Rota de teste do frontend:** http://localhost:8081/html/tema
- **Referências:**
  - Guia de migração oficial: https://getbootstrap.com/docs/6.0/guides/migration/
  - Skill oficial (material de apoio, não é prioridade sobre as decisões deste documento): https://github.com/twbs/bootstrap/blob/main/skills/bootstrap-v5-v6-migration/SKILL.md
  - Fonte da verdade da alpha: `node_modules/bootstrap/scss` e `node_modules/bootstrap/js/src`

## Regras combinadas

- Não remover componentes, funcionalidades, classes personalizadas ou dependências sem aprovação. Se algo foi removido ou ficou incompatível, informar onde é usado, o impacto e a alternativa, e esperar o ok.
- Manter `resources/scss/frontend/tokens/*`, que é o tema do starter, ao máximo. Só adaptar o que for necessário.
- Em `_variables.scss`, manter os breakpoints e os containers do projeto.
- Executar por fases, parando ao fim de cada uma para revisão.
- Sem commits até o pedido do usuário.
- Respostas em pt-BR.

## Fases

| Fase | Escopo | Status |
| --- | --- | --- |
| 1 | Dependências e build | ✅ |
| 2 | SCSS | ✅ |
| 3 | JavaScript | ✅ |
| 4 | Blade (markup) | ✅ |
| 5 | Novidades do v6 no tema | ✅ |
| 6 | Validação (navegador, a11y, responsivo) | ✅ (pendências listadas) |

### Fase 1 — Dependências e build ✅

Dependências aprovadas:
- `bootstrap@6.0.0-alpha.1`
- `@floating-ui/dom`, que substitui o Popper
- `vanilla-calendar-pro`, usado pelo Datepicker
- `postcss-prefix-custom-properties` (dev)

Mudanças no `vite.config.js`:
- **PostCSS:** entrou o plugin `postcss-prefix-custom-properties` com prefixo `bs-`. O Sass do v6 gera as variáveis CSS sem prefixo. Ficam de fora do prefixo:
  - variáveis que já começam com `bs-`;
  - variáveis das bibliotecas: swal2, swiper, plyr, ts (tom-select) e loading;
  - variáveis do projeto: `glow-*` e `header-*`.
- **PurgeCSS:** usa um `defaultExtractor` que aceita `:` (`md:col-6`, `hover:opacity-50`) e também guarda as palavras separadas.
- **Sass:** saiu o `silenceDeprecations: ['import']`, porque não sobrou nenhum `@import`.

### Fase 2 — SCSS ✅

O Sass compila sem nenhum warning. Toda a estrutura passou para `@use`/`@forward`.

**Arquivos**

| Arquivo | Papel |
| --- | --- |
| `resources/scss/frontend.scss` | Usa `frontend/bootstrap` e carrega os parciais do projeto com `meta.load-css` dentro de `@layer custom` |
| `frontend/_variables.scss` | Valores do projeto: tokens, breakpoints, containers e variáveis usadas pelos parciais. As cópias dos defaults do BS5 saíram (de 1930 para cerca de 470 linhas) |
| `frontend/_variables-dark.scss` | Valores do modo escuro, combinados com `light-dark()` |
| `frontend/_maps.scss` | Mapas do projeto e mapas no formato do v6 (`$bs-theme-colors`, `$bs-font-sizes`, `$bs-gray-tokens`) |
| `frontend/_bootstrap.scss` (novo) | Configura cada módulo do v6 com `@use ... with (...)` a partir das variáveis do projeto |
| `frontend/_functions.scss` (novo) | `tint-color`, `shade-color`, `shift-color` e `color-contrast`, que o v6 removeu |
| `frontend/_utilities.scss` | Altera o `$utilities` gerado pelo v6 antes do `utilities/api` |
| `components/_icon-sizes.scss` (novo) | Mixin de tamanhos de ícone, que tinha dependência circular com `_icon-link` |
| `tokens/_design-tokens.scss`, `tokens/_font-tokens.scss` | Só ganharam 1 ou 2 linhas de `@use`. Valores intactos |

**Decisões técnicas**
- **Camadas:** o v6 gera CSS em cascade layers e reserva a camada `custom`, que fica acima de `components` e abaixo de `helpers`/`utilities`. O CSS do projeto e das bibliotecas vai nessa camada. Assim o projeto sobrescreve os componentes e os utilitários continuam vencendo, como acontecia com o `!important` do BS5.
- **Breakpoints:** xs 0 / sm 576 / md 992 / lg 1200 / xl 1600, sem 2xl.
- **Containers:** sm 944 / md 960 / lg 1140 / xl 1520. O `2xl` do v6 é removido com `(2xl: null)`. A chave `2xl` sem aspas é um número com unidade; `"2xl"` entre aspas não funciona.
- **Espaçamento:** os utilitários usam a escala do projeto (`.p-3` = 3rem, `q`/`h`/`hq`, `block*`, `header-height`). Os componentes internos do v6 mantêm a escala do v6.
- **Raios:** `$radius` = `$border-radius` (1rem) e `radius-7` = 1rem. Os utilitários `.rounded-*` usam o `$border-radius-map` do projeto.
- **Cores:**
  - O `$theme-colors` no formato do v6 (`base`, `fg`, `fg-emphasis`, `bg`, `bg-subtle`, `bg-muted`, `border`, `focus-ring`, `contrast`) é gerado a partir de `$ds-*`, com dark via `light-dark()`.
  - O contraste usa o mesmo algoritmo do BS5.
  - Foram criados os temas `light` e `dark`, que o v6 não tem por padrão.
- **Dark mode:** com `$color-mode-type: data`, o site fica claro a menos que tenha `data-bs-theme="dark"`. Isso é forçado em `_root.scss`, porque o v6 segue o sistema operacional por padrão.
- **Utilitários do projeto preservados:**
  - `fs-1..6` e `fs-xxsmall..xlarge`
  - `lh-base`/`sm`/`md`/`lg` e `ls-*`
  - `fw-extrabold`/`black`
  - `rounded-*` (inclusive por canto)
  - `fill-*` e `stroke-*`
  - `ratio-*` extras
  - `w`/`h`/`max-*` com `$sizing-values`
  - opacidade com hover e as cores extras de `bg-*`
- **Classes recriadas (o v6 removeu):**
  - `.ratio`, com os filhos posicionados de forma absoluta
  - `h1–h6` com os tamanhos dos tokens
  - `.display-*` e `.lead`
  - `.card-link`
  - os passos de opacidade 25 e 75 (`.fg-75`)
- **Classes do projeto mantidas:** `.btn-whatsapp`, `.text-bg-outline-*`, `.breadcrumb-dark`, `.menu-hover` (abre no hover; antes `.dropdown`), `.menu-toggle` (caret; antes `.dropdown-toggle`), `.ic-*`, `.icon-link-hover-*`, `.text-truncate-*`.
- **Bibliotecas de terceiros:**
  - O CSS é carregado com `meta.load-css("pacote/arquivo.css")`. O `.css` explícito é obrigatório por causa do campo `exports` dos pacotes.
  - O sweetalert2 é configurado com `meta.load-css(..., $with)`, passando só as variáveis `!default` que ele aceita.
- **Floating labels:** os valores do projeto viraram `$form-floating-tokens`. O seletor do select passou a ser `label:has(~ select)`.

**Variáveis do BS5 que não foram migradas:** cerca de 60 ajustes finos de componentes (paddings de nav, tabelas, paginação, SVGs de dark mode etc.) ficaram com o padrão do v6. Os relevantes serão revisados na Fase 6.

### Fase 3 — JavaScript ✅

- **`frontend.js`:**
  - `Modal` virou `Dialog`, e o `setupModalConfig` cria um `Dialog` para cada `.dialog`.
  - `bootstrap.Tooltip` passou a usar o `Tooltip` importado, porque o v6 não tem objeto global.
  - As cores são lidas de `--bs-{cor}-base`.
  - Na validação, o form inválido recebe `data-bs-validate` além de `was-validated`.
- **`components/smooth-scroll.js`:** offcanvas virou drawer (`.drawer`, `data-bs-dismiss="drawer"`, `hidden.bs.drawer`).
- **`helpers/form-helpers.js`:** usa `.dialog[open] .dialog-body` e `html.dialog-open`.
- **`components/tom-select.js`:** `text-primary` virou `fg-primary`.

### Fase 4 — Blade ✅

Os scripts de migração ficam no scratchpad da sessão e não são versionados. Eles trocam token a token, só dentro de `class="..."`, e preservam as expressões Blade.

**Mapeamento aplicado**

| v5 | v6 |
| --- | --- |
| `col-md-6`, `d-lg-none`, `fs-xl-base`, `py-md-1h`... | `md:col-6`, `lg:d-none`, `xl:fs-base`, `md:py-1h`... |
| `navbar-expand-md` | `md:navbar-expand` |
| `btn-{cor}` / `btn-outline-{cor}` | `btn-solid theme-{cor}` / `btn-outline theme-{cor}` |
| `alert-{cor}`, `table-{cor}` | `theme-{cor}` |
| `text-{cor}` / `text-{cor}-hover` | `fg-{cor}` / `hover:fg-{cor}` |
| `text-muted`, `text-body-secondary` | `fg-2` |
| `text-bg-{cor}` | `bg-{cor} fg-contrast-{cor}` |
| `text-opacity-75` | `fg-75` |
| `mw-100` / `mh-100` | `max-w-100` / `max-h-100` |
| `dropdown-menu` / `-item` / `-divider` | `menu` / `menu-item` / `menu-divider` |
| `modal-*` | `dialog-*` |
| `offcanvas*` | `drawer*` |
| `form-select(-sm/-lg)` | `form-control(-sm/-lg)` |
| `spinner-grow-sm` | `spinner-grow spinner-sm` |
| `has-validation` | removido |
| `data-bs-toggle/dismiss="modal\|offcanvas\|dropdown"` | `dialog` / `drawer` / `menu` |

**Reescrita estrutural**
- **Modal** (`components/modals/modal.blade.php`): virou `<dialog class="dialog dialog-lg">`. Os `@props` são os mesmos.
- **Accordion** (`components/accordions/accordion.blade.php`): virou `<details name="{id}">` + `<summary class="accordion-header">` + `.accordion-icon` em SVG. O primeiro item fica com `open`.
- **Header** (`html/partials/header.blade.php`):
  - O menu virou `<dialog class="drawer drawer-end" id="navbarDrawer">`, com `drawer-header` (título oculto e `btn-close`).
  - O id mudou de `offcanvasNavbar` para `navbarDrawer`.
  - O `.navbar-toggler-icon` está sem a máscara do v6, porque o projeto desenha as próprias barras.
- **Formulários:**
  - `form-check` virou `.form-field` com `.check` ou `.radio` direto no input.
  - `form-switch` virou `.form-field` com `.switch` como wrapper do input (que recebe o atributo `switch`).
  - `btn-check` virou `<label class="btn-check ...">` com o `<input>` dentro.
  - `form-range` virou `.form-range` com `.form-range-input`.
  - Floating labels: o `<label>` vem antes do campo.
- **Tema, demos de navbar:** o `collapse` virou drawer e `navbar-dark`/`navbar-light` viraram `data-bs-theme`.
- **Tema, demo `was-validated`:** ganhou `data-bs-validate`.

**Classes que não existem no CSS:** já não existiam antes da migração e não foram tocadas. São hooks `js-*`, classes de layout do projeto e algumas mortas (`fs-7`, `ls-1`, `ls-xl`, `rounded-md`, `mw-unset`, `text-gray-500`, `w-border-sm`, `md:gy-block-medium`).

### Fase 5 — Novidades no tema ✅

Nova seção **"Bootstrap 6"** em `html/tema.blade.php`, com grupo próprio na sidebar (`#nav-links-bootstrap-6`) e ScrollSpy. Os exemplos seguem a documentação oficial do v6:

- Componentes:
  - Avatar (tamanhos, status e stack)
  - Stepper (vertical e `md:stepper-horizontal` dentro de `.contains-inline`)
  - Nav overflow
  - Toggler
  - Dialog não-modal, slide-up e scrollable
  - Drawer sheet
- Botões e badges:
  - Botões `btn-subtle`, `btn-text`, `btn-xs` e `btn-icon`
  - Badges `badge-subtle` e `badge-outline` com `theme-*`
- Cards: `card-row` e `card-subtle`
- Formulários:
  - `form-field`
  - `form-adorn` (R$ e .com.br)
  - Combobox
  - Datepicker
  - Chips e chip input
  - OTP input
  - Password strength
- Conteúdo e helpers: `.prose`, `.hover-lift` e `.text-balance`

Os plugins JS novos inicializam sozinhos pelo data API do v6, então nenhum JS foi alterado.

Mudança no `vite.config.js`: entrou `/data-vc/` no safelist do PurgeCSS. O Datepicker (vanilla-calendar-pro) monta o calendário em tempo de execução, e o purge apagava os 45 seletores `[data-vc...]`.

As imagens usam `<x-frontend::image>`, que exige o atributo `title`.

### Fase 6 — Validação ✅

**Como testar**
- E2E com Playwright (Chromium do host) contra http://localhost:8081. O script fica no scratchpad da sessão e não é versionado.
- Com o dev server do Vite rodando, as páginas carregam os assets do `:5181`. O purge e o critical CSS são validados pelo `npm run build`.

**Resultado:** 65 checks OK.
- **Páginas e larguras:** `/`, `/html`, `/html/tema`, `/html/blog`, `/html/blog-detalhe` e `/html/blog-resultado`, cada uma em 375, 992, 1200 e 1600 px.
- **Itens verificados:**
  - Console limpo, exceto pelo erro de alpha do Combobox (ver abaixo).
  - Sem scroll horizontal, exceto no blog em 375 px (decisão 8).
  - Container de 1520 px e breakpoints do projeto.
  - Ordem das layers: os utilitários vencem a camada `custom`.
  - Dialog: abre, fecha com Esc e devolve o foco.
  - Menu: abre, navega pelas setas e fecha com Esc.
  - Tooltip, popover e toast.
  - Accordion exclusivo.
  - Floating label.
  - Validação: `data-bs-validate` + `:user-invalid` pintam a borda após o submit.
  - Drawer do header: abre no mobile, fecha no `btn-close` e fica inline no desktop.
  - Componentes novos: toggler, combobox, datepicker, OTP, strength, chips e nav overflow.
  - Sistema operacional em dark mantém o site claro; `data-bs-theme="dark"` escurece.
- **Build, testes e lint:** build e critical CSS ok, 10 testes passando, Prettier e Pint ok.

**Correções feitas nesta fase**
- **Classes passadas por props:** `bodyClass`, `icon-class`, `list-class` e o `'class' =>` do glightbox foram migrados. O script da Fase 4 só tratava `class="..."`.
- **`helpers/form-helpers.js`:** os seletores de erro passaram a usar `select.form-control`, `.check`, `.radio` e `.form-range-input`.
- **Critical CSS:**
  - Problema: o lightningcss remove a declaração de ordem das layers, e com isso `content` e `forms` venceriam os utilitários.
  - Correção: `CriticalCss.php` prefixa a constante `LAYER_ORDER`, coberta por teste.
- **`color-scheme`:**
  - Problema: o v6 declara `:root { color-scheme: light dark }` fora de layer, então a correção do projeto dentro de `@layer custom` não tinha efeito.
  - Correção: `frontend/root` passou a ser carregado fora das layers.
- **Botões:**
  - Problema: o v6 força `--btn-white-space: nowrap`, causando overflow em linhas de botões no tema em 992 px.
  - Correção: voltou ao comportamento do v5 (`$btn-white-space: normal`).
- **Menu aberto por hover:**
  - Problema: o menu ficava sem posição e cobria o toggle.
  - Correção: `.dropdown { position: relative }` e `top: 100%; left: 0` no hover.
- **Menu e teclado:**
  - Problema: o v6 só navega por teclado em `.menu-item` que sejam filhos diretos de `.menu`.
  - Correção: o markup foi achatado (`<div class="menu"><a class="menu-item">`, sem `<ul>`/`<li>`), e o espaçamento entre itens passou do `li` para `.menu-item + .menu-item`.
- **Helpers do v6 acima da camada `custom`:**
  - Problema: o `.icon-link > .bi` encolhia o logo e os ícones `.ic-*`, e o hover do helper sobrescrevia os efeitos `icon-link-hover-*`.
  - Correção:
    - `components/_icon-link.scss` e o novo `components/_navbar-brand.scss` (tamanho do logo) passaram a ser carregados em `@layer helpers`, depois do Bootstrap.
    - As variáveis de tamanho do logo saíram de `_navbar.scss` e foram para esse novo parcial.
- **Texto dos alertas:**
  - Problema: o v6 usa o `fg` do tema, e o texto do alerta `secondary` ficava ilegível.
  - Correção: voltou a usar `--bs-theme-fg-emphasis`, como o `*-text-emphasis` do v5.

**Regra prática da arquitetura de layers**
- **Overrides de componentes:** ficam na camada `custom`.
- **Overrides de helpers do v6** (`icon-link`, `stretched-link`, `vstack` etc.): ficam em `@layer helpers`, carregados depois do Bootstrap.
- **O que o v6 declara fora de layer** (`:root`): o override também precisa ficar fora de layer.

### Reorganização do tema (pós-Fase 6) ✅

**Estrutura**
- O grupo "Bootstrap 6" deixou de existir. As novidades foram distribuídas nas categorias do tema (Components, Content, Forms e Helpers), no mesmo modelo da documentação do v6.
- As seções novas levam o badge **"Novo"**, tanto na sidebar (`'new' => true` no array de links) quanto no título da seção.
- **Seções novas:**
  - Components: Avatar, Drawer, Stepper e Toggler
  - Forms: Form Field, Form Adorn, Combobox, Datepicker, Chips, OTP Input e Password Strength
  - Helpers: Hover Lift e Text Balance
- **Variantes juntadas às seções existentes**, como subseção marcada "Novo" (mesmo propósito, nada foi removido):
  - Modal virou **Dialog**, com as variantes não-modal, slide-up e scrollable
  - Badge ganhou subtle e outline
  - Buttons ganhou subtle, text, xs e icon
  - Card ganhou row e subtle
  - Navs ganhou Nav overflow
  - Typography ganhou Prose

**Componentes Blade**
- Novo `x-frontend::avatar` (props `image`, `title`, `alt`, `size`, `status`).
- **Regra do usuário:** campos de formulário (input, select, textarea, radio, checkbox, combobox) ficam em markup padrão, nunca em componente Blade.

**Tom-select → Combobox (aprovado pelo usuário)**
- O tom-select foi removido: dependência npm, `resources/js/components/tom-select.js`, `vendors/_tom-select.scss`, o CSS e as entradas no purge e no PostCSS.
- A busca do blog e o Search do tema passaram a usar o markup do Combobox: `data-bs-search`, `.combobox-search`, itens ordenados e `.combobox-no-results` com o mesmo texto do tom-select. O exemplo do tema com cidade mantém a descrição via `.menu-item-description`.
- **Livewire:** o Combobox do v6 não dispara eventos no input oculto. O markup usa um `.combobox` com `<input type="hidden" data-combobox-input wire:model...>`, e o novo `resources/js/components/combobox.js` sincroniza esse input no `change.bs.combobox`, disparando `input` e `change`. Testado: a busca filtra, a seleção atualiza o input e dispara o evento.

**Visual inspirado na documentação do v6, com o mínimo de CSS**
- Sidebar sem caixa: títulos de grupo pequenos em caixa alta e lista `nav flex-column flex-nowrap`. O badge "Novo" fica antes do nome; o nome vai no slot do `x-frontend::link` e quebra linha (`text-wrap min-w-0`). Não usa `.navbar`, que no v6 vira container query e colocava os grupos em linha. O link ativo do ScrollSpy fica destacado.
- Título de cada seção fora da caixa do exemplo (`<section class="bd-section">` com `h2` e âncora `#`), e o exemplo dentro de `.bd-example`.
- Estilos só no `<style>` que já existia no tema, agora com tokens (`--bs-border-color`, `--bs-radius-5`, `--bs-bg-*`). Sem SCSS novo para o tema.

**Correções encontradas na revisão**
- `x-frontend::badge` recebia `theme="text-bg-*"` (classe v5) por prop: virou `theme-*`, e o padrão do componente passou a ser `theme-primary`.
- No radio desabilitado, o v6 alpha pinta o label com `--secondary-fg`, que no projeto é amarelo de marca. O novo `components/_checks.scss` alinha o radio ao checkbox (`--bs-fg-3`).

### Padronização de nomes e visual dos componentes renomeados ✅

**Renomeações**

| v5 | Antes nesta branch | Agora |
| --- | --- | --- |
| Modal | `components/modals/modal`, `modal-base`, `#modalBase`, "Modal Base", `components/_modal.scss`, `$modal-inner-padding*`, `setupModalConfig()`, `_isFormOnModal()` | `components/dialogs/dialog`, `dialog-base`, `#dialogBase`, "Dialog Base", `components/_dialog.scss`, `$dialog-inner-padding*`, `setupDialogConfig()`, `_isFormOnDialog()` |
| Dropdown | `components/_dropdown.scss`, classes do projeto `.dropdown` (hover) e `.dropdown-toggle` (caret) | `components/_menu.scss`, `.menu-hover` e `.menu-toggle` (não colidem com o v6, que só tem `.menu-toggle-split`) |
| Offcanvas | — | Drawer (já migrado) |
| Form Select | Seção "Form Select" (`#form-select`) | Seção "Select" (`#select`). O v6 não tem `.form-select` |

"Modal video" (GLightbox) mantém o nome, porque não é um componente do Bootstrap.

**Visual no formato do v6**
- **Drawer:** removidos os tokens que imitavam o offcanvas do BS5 (inset 0, largura de 100%, sem raio, sem desfoque) e os ajustes de padding e altura do `_navbar.scss`. Agora é um painel flutuante com margem, raio, sombra e backdrop com desfoque.
- **Header:** o drawer do menu mostra o título "Menu" e o `btn-close`.
- **Dialog:** passou a usar o raio e o backdrop do v6, consistente com o drawer. Os paddings do projeto foram mantidos.
- **Alertas:**
  - O `btn-close` fica à direita e centralizado (`ms-auto align-self-center`).
  - Saiu o `alert-dismissible`, removido no v6.
  - O ícone e o texto ficam alinhados com `align-items-center`.
- **Tema, seção Drawer:** exemplos de início, fim, topo, base e sheet.

### Performance e refatorações (pós-migração) ✅

Medido em `/html` (página real), build de produção:

| Recurso | Antes | Depois |
| --- | --- | --- |
| JS do site (`frontend-imports` + `frontend` + chunks) | 207 KB | 107 KB (-48%) |
| Fontes | 126–168 KB (Roboto local + Google duplicado) | 42 KB (-67% a -75%) |
| CSS | 306 KB / 47 KB gzip | 294 KB / 46,6 KB gzip (sem os `@font-face` locais) |
| FCP local | cerca de 165 ms | cerca de 105 ms |

- **Bootstrap por demanda:**
  - `frontend-imports.js` importa só os plugins usados no site (`bootstrap/js/dist/{alert,button,collapse,combobox,dialog,drawer,menu,popover,scrollspy,tab,toast,tooltip}.js`).
  - Os plugins exclusivos do catálogo (datepicker com o vanilla-calendar-pro, chips, otp-input, strength, range, nav-overflow e toggler) ficam em `pages/theme.js`.
  - `frontend.js` passou a usar imports diretos (`import Tooltip from "bootstrap/js/dist/tooltip.js"`). Importar `from "bootstrap"` traria a biblioteca inteira de volta.
  - O carousel não é importado, porque o projeto usa Swiper. Se uma página precisar, basta adicionar o import.
- **Fontes:** `$should-use-local-font-face: false` em `frontend/_fonts.scss`. O Roboto variável (100–900, normal e itálico, em subsets) vem do `vite-plugin-webfont-dl` (`webfonts.css`); os arquivos locais duplicavam a família.
- **`vite.config.js`:**
  - Removidos o input `frontend-imports.js` duplicado e os safelists `/^hs-/` (HubSpot, não compilado) e `/^was-/` (o v6 não estiliza `.was-validated`).
  - O purge passou a ler `node_modules/bootstrap/js/dist/**/*.js` (o código realmente empacotado).
- **JS:**
  - Removido o `setupDialogConfig()`, que era redundante (o data API do v6 já cria o Dialog, e a opção `focus` não existe mais).
  - `setupSmoothScrollInOffcanvas` foi renomeada para `setupSmoothScrollInDrawer`.
  - Removida a leitura de `--bs-breakpoint-xxl`, que não existe no projeto e dava `NaN`.
  - Corrigido o `focusout` do `setupInvalidElements` (`this` virou `element`).
- **Não aplicado (decisão do usuário):** CSS separado para o catálogo. Medido com o PurgeCSS, excluir o `tema.blade.php` do purge reduziria o CSS das páginas de 286,7 para 236,9 KB (45,4 para 38,4 KB gzip, -15%). Exige trocar ou estender o plugin de purge, que não permite regras por arquivo, e manter um CSS próprio para o tema.
- **Produção:** o `livewire.js` (595 KB) é a versão não minificada do ambiente local; com `APP_DEBUG=false` o Livewire serve a minificada.

## Decisões pendentes de aprovação

Os itens marcados com "padrão aplicado" já foram feitos de forma reversível, enquanto o usuário não confirma.

| # | Tema | Situação |
| --- | --- | --- |
| 1 | **Drawer do header**: o v6 usa `<dialog>` modal, que cobre o header e o hambúrguer animado | ✅ Definido pelo usuário: drawer modal no formato do v6 (painel flutuante com título "Menu" e `btn-close`). Alternativa: não-modal (`backdrop: false, scroll: true`), que mantém o toggler visível, mas sem backdrop e sem travar a rolagem |
| 2 | **Hover dos botões sólidos**: no BS5 escurecia 15%, no v6 não escurece | Padrão aplicado: v6 |
| 3 | **`.lead` / `.display-*`** removidos no v6 | Padrão aplicado: recriados como classes do projeto. Alternativa: receitas do v6 (`fs-lg fw-light`) |
| 4 | **Validação**: o v6 usa `data-bs-validate` + `:user-invalid` | Feito: o JS adiciona `data-bs-validate` no submit. Validar no navegador se os campos ficam pintados depois de `preventDefault`. Alternativas: colocar `data-bs-validate` direto no `<form>` (como recomenda a skill) ou aplicar `.is-invalid` via JS |
| 5 | **Dialog sem a opção `focus: false`** | O modal passa a focar ao abrir (comportamento nativo do `<dialog>`) |
| 6 | **Suporte a navegadores**: Chrome/Edge 130, Firefox 132, Safari 18 | Inerente ao v6, sem alternativa |
| 7 | **Ajustes finos do BS5 não migrados** (cerca de 60 variáveis de componente) | Revisão visual dos testes ok; ajustar sob demanda |
| 8 | **Scroll horizontal de 16 px no blog em 375 px** | Diagnóstico corrigido: não é causado pelo v6. `.stretch-on-mobile` usa `width: 100vw`, que inclui a barra de rolagem clássica, e já acontecia no v5. Em celulares (barra sobreposta) não ocorre. O `scrollbar-gutter: stable` do v6 foi mantido. Se quiser eliminar, a alternativa é `overflow-x: clip` no `html`/`body` (decisão do usuário) |
| 9 | **Foco visível em links** | ✅ Aplicado: `a { outline: none !important }` virou `a:focus:not(:focus-visible) { outline: none; }` em `frontend/_reboot.scss`. O foco por teclado agora aparece |
| 11 | **Range e progress** | São componentes diferentes e ambos existem na documentação do v6: o range é campo de formulário (Forms › Range) e o progress é exibição (Components › Progress). Os dois foram mantidos |
| 12 | **Button Share no tema** | O `share-api-polyfill` só era carregado pelo `link-share`, e em navegadores sem Web Share nativo o botão do tema dava erro. Agora o `pages/theme.js` importa o polyfill |
| 10 | **Erro de console do Combobox**: "Bootstrap doesn't allow more than one instance per element" | Mantido (decisão do usuário). Bug da alpha: o `Combobox` cria internamente `new Menu()` no mesmo elemento. O componente funciona. Acompanhar o próximo alpha |

## Pontos de atenção conhecidos

- **`public/build/` é versionado.** O `vite build` limpa a pasta antes de compilar. Se o build falhar, rodar `git checkout -- public/build`. Para testar só o CSS sem build, usar `npx sass --load-path=node_modules --pkg-importer=node resources/scss/frontend.scss` ou o `preprocessCSS` do Vite.
- **O Prettier do projeto só formata `resources/`.** Alguns blocos migrados do `tema.blade.php` ficaram com indentação irregular.
- **`.form-field` usa grid.** Conferir o `.invalid-feedback` dentro dele (termos de privacidade no contato e no tema).
- **Menu aberto por hover** (`.dropdown:hover .menu`): sem o JS, o Floating UI não posiciona o menu. Conferir no header.
- **Demo `was-validated`:** só pinta depois da interação do usuário (`:user-invalid`).
- **Problemas antigos, fora do escopo e não alterados:**
  - `frontend.js` lê `--bs-breakpoint-xxl`, que não existe e dá `NaN`.
  - `this` dentro de arrow function no `focusout` do `setupInvalidElements`.
  - `vendors/_hubspot-form.scss` tem código BS4 e não é compilado.
- **Itens da skill oficial para não esquecer:**
  - Card groups, list-group horizontal, stacks responsivos e tabelas empilhadas exigem um pai com `.contains-inline` (container query). Hoje não são usados.
  - O breadcrumb oficial do v6 usa `.breadcrumb-link` e `.breadcrumb-divider`. O projeto mantém o próprio markup com ícone.
  - O v6 não tem `.theme-light`/`.theme-dark`. Aqui eles existem porque `light` e `dark` foram adicionados ao `$theme-colors`.
  - `fs-1..6` e `lh-base` continuam como classes do projeto, mapeadas para os tokens, e não foram trocados pelos nomes do v6 (`fs-4xl`, `lh-md`).

## Checklist de validação (ocorrências que podem ter escapado)

Use em páginas novas, em outros projetos que receberem esta migração e antes do merge. Cada item já causou problema nesta migração ou é um risco conhecido do v6.

### Busca no código

Rodar em `packages/*/resources/views`, `resources/views` e `resources/js`.

- [ ] **Classes v5 em atributos que não são `class="..."`**: props de componente (`theme=`, `icon-class=`, `list-class=`, `body-class=`), arrays (`'class' =>`, `'bodyClass' =>`), `$attributes->merge([...])`, `@class([...])`, strings JS (`classList.add`, template literals) e PHP (`app/`, `src/View/Components`).
  `grep -rnE "text-bg-|btn-(primary|secondary|success|danger|warning|info|light|dark)\b|btn-outline-|text-(primary|secondary|success|danger|warning|info|muted|white|black)\b|(col|d|g|gx|gy|offset|order|flex|fs|p[xytbse]?|m[xytbse]?)-(sm|md|lg|xl)-|form-select|form-check|dropdown-(menu|item|divider|toggle)|modal-|offcanvas|navbar-(dark|light)|was-validated|needs-validation|card-link|lead\b|display-[1-6]"`
- [ ] **Atributos de JS:** `data-bs-toggle="modal|offcanvas|dropdown|collapse"`, `data-bs-parent`, `data-bs-ride`, `data-bs-offset`, `popperConfig` e eventos `*.bs.modal|offcanvas|dropdown`.
- [ ] **Seletores JS com classes antigas:** `.modal`, `.show`, `body.modal-open`, `.form-select`, `.form-check-input` e `.collapsed`.
- [ ] **Variáveis CSS removidas no v6:** `var(--bs-*-rgb)`, `rgba(var(--bs-...))` e `--bs-{cor}` sem `-base` (no v6 é `--bs-primary-base`).
- [ ] **Bootstrap global:** `bootstrap.X` sem import. O v6 é só ESM, não existe `window.bootstrap`.

### Estrutura de markup

- [ ] **Menus:** `.menu-item` precisa ser filho direto de `.menu`, sem `<ul>`/`<li>`; senão a navegação por setas não funciona.
- [ ] **Dialog e Drawer:** precisam ser `<dialog>` nativo, não `<div>`.
- [ ] **Floating label:** o `<label>` vem antes do campo.
- [ ] **Accordion:** `<details>`/`<summary>`; para abrir um por vez, usar o mesmo `name`.
- [ ] **Checkbox e radio:** `.form-field` com `.check`/`.radio` no input; switch com o wrapper `.switch`; `btn-check` é um `<label>` com o input dentro.
- [ ] **Container queries:** navbar, card-group, list-group horizontal, stacks responsivos e tabelas empilhadas reagem à largura do **pai**, não da tela. Conferir `lg:navbar-expand` dentro de colunas estreitas e usar `.contains-inline` onde for preciso.
- [ ] **Lista vertical com `.nav`:** precisa de `flex-nowrap`. O `flex-wrap: wrap` padrão faz todos os itens ficarem da largura do maior.
- [ ] **Combobox com Livewire:** markup com wrapper `.combobox` e `<input type="hidden" data-combobox-input wire:model...>`, sincronizado pelo `resources/js/components/combobox.js`.
- [ ] **Classes responsivas passadas por props:** ex.: `pictureClass` com `ratio-md-21x9`, que vira `md:ratio-21x9`.
- [ ] **Input-group com `.invalid-feedback`/`.valid-feedback` dentro:** adicionar `.input-group-ignore`. O v6 removeu o `.has-validation`; sem essa classe, o último campo perde o arredondamento.
- [ ] **`btn-check` sem variante de cor:** usar `class="btn-check btn"`. Sem o `btn`, o label vira texto solto.
- [ ] **Conteúdo de `<textarea>` e `<pre>`:** não reindentar. O espaço aparece dentro do campo.
- [ ] **Badge ou ícone ao lado de texto num flex** (`.nav-link`, títulos): o `.nav-link` do v6 usa `align-items: flex-start`; adicionar `align-items-center`.
- [ ] **Campos de formulário:** sempre em markup padrão (input, select, textarea, radio, checkbox, combobox), nunca em componente Blade.

### CSS e cascade layers

- [ ] **Overrides de componentes do v6** (`.btn`, `.card`, `.alert`...): ficam na camada `custom` e vencem.
- [ ] **Overrides de helpers do v6** (`.icon-link`, `.vstack`/`.hstack`, `.stretched-link`, `.visually-hidden`, `.ratio`...): perdem se estiverem na camada `custom`. Carregar em `@layer helpers` depois do Bootstrap (ver `components/_icon-link.scss` e `_navbar-brand.scss`).
- [ ] **Regras do v6 fora de layer** (ex.: `:root { color-scheme }`): o override também precisa ficar fora de layer (ver `frontend/_root.scss`).
- [ ] **Override de propriedade que o componente lê de `--theme-*`:** definir a propriedade em si (ex.: `.alert.theme-primary { background-color }`), não a variável `--bs-alert-*`.
- [ ] **`:has()` dentro de `:has()`:** é inválido, e uma lista de seletores com um item inválido é descartada inteira. Colocar o `:has()` no wrapper (ex.: `.form-floating:has(> select option:checked) > label`).
- [ ] **Tamanho de checkbox, radio e switch:** o v6 calcula para line-height 1.5. O projeto usa 1.2, então os tokens `--check-size`/`--radio-size`/`--switch-height` = 1em e a margem é centralizada na line-height (`frontend/_bootstrap.scss`).
- [ ] **Estilos de elemento do projeto** (ex.: tamanhos de `h1`–`h6`): na camada `custom` eles vencem os componentes (o `.popover-header` é um `<h3>`). Carregar em `@layer reboot` (ver `frontend/_headings.scss`).
- [ ] **Dialog fechado:** o v6 o mantém no layout (`visibility: hidden`) e ele estica a página. O projeto usa `.dialog:not([open]) { position: fixed }` (`components/_dialog.scss`).
- [ ] **Toast estático** (sem JS): precisa da classe `.show`; sem ela fica com `opacity: 0`.
- [ ] **ScrollSpy:**
  - Usar **um único** `data-bs-spy` envolvendo todas as seções, com alvo em uma lista que tenha todos os links (no tema, `#bd-sidebar-nav`). Com vários ScrollSpy, cada um mantém o seu último link ativo e aparecem dois ativos ao mesmo tempo.
  - O v6 adiciona um `<div>` sentinela no fim do container para detectar o fim da página. Ele não pode sair do fluxo (com `position: absolute` vai para o topo e quebra a detecção). No tema, uma margem negativa igual ao `gap` cancela o espaço extra.
- [ ] **Superfícies neutras do v6** (`bg-1`…`bg-4`) são mais claras que os cinzas do BS5. O progress e o range usam `$gray-200`, como no v5.
- [ ] **Usos internos do `secondary`:** o v6 usa `secondary` como cinza neutro em alguns lugares (ex.: label do radio desabilitado), e no projeto ele é o amarelo da marca. Procurar `--secondary-` em `node_modules/bootstrap/scss` a cada nova versão.
- [ ] **Novos padrões do v6 que mudam o visual:** `white-space: nowrap` nos botões (o projeto usa `normal`), `scrollbar-gutter: stable`, `--btn-input-min-height` e os raios `radius-5`/`radius-7`.
- [ ] **CSS de bibliotecas de terceiros:** carregar com `meta.load-css("pacote/arquivo.css")`, com o `.css` explícito.
- [ ] **HTML gerado em tempo de execução** (datepicker etc.): seletores por atributo (`[data-vc]`) precisam estar no safelist do PurgeCSS.
- [ ] **Critical CSS:** confirmar que começa com a ordem completa das layers (`CriticalCss::LAYER_ORDER`). Se o v6 mudar as layers, atualizar a constante.

### No navegador

Em http://localhost:8081/html/tema e nas páginas reais, nas larguras 375, 992, 1200 e 1600 px.

- [ ] Console sem erros, exceto o erro conhecido do Combobox alpha.
- [ ] Sem scroll horizontal, nem na página nem na sidebar: `scrollWidth === clientWidth`. Exceção conhecida: `.stretch-on-mobile` com `100vw`.
- [ ] Logo e ícones dentro de `.icon-link` com o tamanho certo.
- [ ] Contraste de texto em alertas, badges e botões `theme-secondary`/`theme-warning`/`theme-light` (marca amarela).
- [ ] Dialog e drawer: abrir, fechar com Esc ou com o botão, e o foco voltando ao gatilho.
- [ ] Menu: abrir com teclado, navegar pelas setas e fechar com Esc. Conferir o hover no `lg` do header.
- [ ] Formulários: validação no submit (`data-bs-validate`), `.is-invalid` do Livewire, floating label, combobox com busca e o `wire:model` recebendo o valor.
- [ ] Dark mode: com o sistema operacional escuro, o site continua claro; com `data-bs-theme="dark"`, ele escurece.
- [ ] Tab mostra foco visível em links e botões.
- [ ] Firefox: collapse e accordion abrem sem animação (limitação da alpha, ok).

## Limitações da alpha (issues abertas relevantes)

- **#43098:** o JS usa o prefixo `bs-` fixo. Por isso o plugin de prefixo do PostCSS é obrigatório.
- **Dialog/Drawer:**
  - #43070: o Esc fecha mesmo com `keyboard: false`.
  - #43120: o Drawer não move o foco para dentro ao abrir.
  - #43051: o drawer do navbar responsivo fica mal posicionado.
- **#43149:** o Datepicker envia a data no formato do locale, não em ISO.
- **#43214:** o Nav overflow move o último item mesmo quando tudo cabe.
- **Collapse/accordion:** abre sem animação no Firefox, porque `interpolate-size` ainda não é suportado.
- Pode haver mudanças incompatíveis antes do beta. Reavaliar este documento quando sair o alpha.2 ou o beta.

## Como retomar

1. `git checkout feat/update-bs6` e conferir `git status`. Nada foi commitado até agora.
2. `vendor/bin/sail up -d` e `vendor/bin/sail npm run build`.
3. Abrir http://localhost:8081/html/tema.
4. Resolver as decisões pendentes e, quando o usuário pedir, commitar.
