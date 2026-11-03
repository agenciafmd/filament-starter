# Bootstrap 6 no frontend: guia de consulta

> Bootstrap `6.0.0-alpha.1` na branch `feat/update-bs6`. Última atualização: 2026-11-03.

## 1. Resumo

- O frontend (Laravel + Vite + Sass) saiu do Bootstrap 5.3.8 (`@import`) para o 6.0 alpha (`@use` e cascade layers).
- A arquitetura, os tokens do tema (`resources/scss/frontend/tokens/*`), os breakpoints, os containers e as classes do projeto foram mantidos.
- **Estado:** alpha. A branch fica isolada, sem merge em `develop`/`master`, até o v6 estável. Reavaliar este guia a cada alpha/beta.
- **Rota de teste:** http://localhost:8081/html/tema (catálogo) e as páginas reais em `/html/*`.
- **Fontes da verdade:**
  - [guia de migração](https://getbootstrap.com/docs/6.0/guides/migration/), [Customize › Sass](https://getbootstrap.com/docs/6.0/customize/sass/), [Utilities API](https://getbootstrap.com/docs/6.0/utilities/api/);
  - o código instalado: `node_modules/bootstrap/scss` e `node_modules/bootstrap/js/src`;
  - material de apoio: a [skill oficial de migração](https://github.com/twbs/bootstrap/blob/main/skills/bootstrap-v5-v6-migration/SKILL.md).

## 2. Dependências

| Pacote | Antes | Agora | Por quê |
| --- | --- | --- | --- |
| `bootstrap` | `^5.3.8` | `6.0.0-alpha.1` (fixo, sem `^`) | Única 6.x publicada (tag `next`) |
| `@floating-ui/dom` | — | sim | `peerDependency` do v6, substitui o Popper |
| `vanilla-calendar-pro` | — | sim | `peerDependency` do v6, usado pelo Datepicker |
| `postcss-prefix-custom-properties` (dev) | — | sim | O Sass do v6 gera as variáveis sem `bs-`, mas o JS espera `--bs-*` (#43098). O próprio build do Bootstrap usa esse plugin |
| `tom-select` | sim | — | Substituído pelo Combobox do v6 |

**`vite.config.js`**
- **PostCSS:** prefixo `bs-` em todas as variáveis CSS, exceto as que já têm `bs-`, as das bibliotecas (`swal2`, `swiper`, `plyr`, `loading`) e as do projeto (`glow-*`, `header-*`).
- **PurgeCSS:**
  - o `defaultExtractor` aceita `:` (`md:col-6`, `hover:opacity-50`);
  - lê `node_modules/bootstrap/js/dist/**/*.js`;
  - safelist `/data-vc/` para o calendário do Datepicker, que é montado em tempo de execução.
- **Sass:** sem `silenceDeprecations`, porque não existe mais `@import`.
- **Critical CSS:** `rollup-plugin-critical` gera `public/css/critical/*_critical.min.css`, que o `<x-frontend::critical-css>` injeta no `master.blade.php` (ver armadilhas).

## 3. Estrutura do SCSS

### Pilha do `resources/scss/frontend.scss`

Espelha o `node_modules/bootstrap/scss/bootstrap.scss`, com um `@use` por módulo e na mesma ordem. Compare os dois a cada atualização do Bootstrap.

1. `bootstrap/scss/banner`
2. Valores do projeto: `frontend/variables`, `frontend/variables-dark` e `frontend/maps` (`as *`)
3. Configuração: `config`, `colors` e `theme`, com `with (...)`
4. `frontend/utilities`, que altera o `$utilities` antes da API
5. `root`, `content`, `layout`, `forms` e `buttons`
6. Componentes. Ficam de fora `carousel` (o projeto usa Swiper) e `placeholder`
7. `helpers` e `utilities/api`
8. Parciais do projeto (`as *`). Cada um declara a própria layer

**Ordem obrigatória:** config → `frontend/utilities` → resto do Bootstrap. O `frontend/utilities` carrega `config`/`colors`/`theme` para ler o `$utilities` padrão. Um módulo só pode ser configurado (`with`) na primeira carga.

### Onde fica cada valor

| Arquivo | Conteúdo |
| --- | --- |
| `frontend/tokens/*` | Tema do starter (`$ds-*`). Não alterar sem necessidade |
| `frontend/_variables.scss` | Escalares do projeto: cores, opções `$enable-*` (só as que diferem do v6), espaçamento, breakpoints, containers, tipografia e o que os parciais usam |
| `frontend/_variables-dark.scss` | Valores do modo escuro, combinados com os claros via `light-dark()` |
| `frontend/_maps.scss` | Mapas: os de configuração do v6 (`$bs-theme-colors`, `$bs-font-sizes`, `$bs-shadows`…), os tokens de componente (`$menu-tokens`, `$dialog-tokens`…) e os mapas do projeto (`$spacers-map`, `$border-radius-map`…) |
| `frontend/_functions.scss` | `color-contrast` (escolhe a cor na compilação), mais `tint-color`/`shade-color`/`shift-color`, que geram `color-mix()` |
| `frontend/_utilities.scss` | Utilities do projeto (two-file pattern da doc) |
| `frontend/_root.scss` | Variáveis extras no `:root` e o `color-scheme` (fora de layer) |

**Breakpoints e containers do projeto (não mudar):**
- **Breakpoints:** xs 0 / sm 576 / md 992 / lg 1200 / xl 1600, sem `2xl`.
- **Containers:** sm 944 / md 960 / lg 1140 / xl 1520. O `2xl` do v6 é removido com `(2xl: null)`. A chave vai sem aspas: `"2xl"` não funciona.

### Cascade layers

#### Por que `@layer custom` (para quem nunca usou)

**Camada (`@layer`)** é um recurso nativo do CSS: o navegador decide quem vence pela **ordem das camadas**, antes de olhar a especificidade do seletor. O Bootstrap 6 coloca todo o CSS dele em camadas e reserva a `custom` para o site.

```
reboot → layout → content → forms → components → custom → helpers → utilities
                                      (Bootstrap)   (projeto)   (Bootstrap)
mais fraca ──────────────────────────────────────────────────────► mais forte
```

O efeito: o CSS do projeto **vence os componentes** (`.btn`, `.card`…) e **perde para as utilities** (`.p-0`, `.d-none`…). As utilities continuam funcionando no markup.

**Antes (v5) e agora (v6):**

```scss
// v5: para vencer o Bootstrap era preciso aumentar a especificidade ou usar !important
.header .navbar .nav-link { color: $primary; }
.card { padding: 2rem !important; } // e aí o .p-0 no markup parava de funcionar

// v6: um seletor simples basta, e as utilities continuam vencendo
@layer custom {
    .nav-link { color: $primary; }
    .card { padding: 2rem; } // <div class="card p-0"> ainda fica sem padding
}
```

**Se esquecer o `@layer`:** CSS fora de camada vence **todas** as camadas, inclusive as utilities. O sintoma é uma utility (`.p-0`, `.d-none`, `.fg-*`) que "não funciona" num elemento. A primeira coisa a conferir é se o parcial tem o `@layer`.

Cada parcial tem, acima do `@layer`, um comentário de uma linha que diz o papel da camada e aponta para esta seção. Ao criar um parcial, copie de um existente (ex.: `components/_list.scss`).

#### Qual camada usar

Ordem completa: `colors, config, root, reboot, layout, content, forms, components, custom, helpers, utilities`.

| Onde | Para quê | Exemplos |
| --- | --- | --- |
| `@layer custom` | Padrão do projeto. Vence os componentes e perde para helpers/utilities (como o `!important` das utilities do v5) | Quase todos os parciais e o CSS dos vendors |
| `@layer reboot` | Estilos de elemento que não podem vencer componentes | `frontend/_headings.scss` (o `.popover-header` é um `<h3>`) |
| `@layer helpers` | Override de helpers do v6 (`icon-link`, `stretched-link`, `vstack`, `ratio`…) | `components/_icon-link.scss`, `components/_navbar-brand.scss` |
| Sem layer | Override de algo que o v6 declara fora de layer | `frontend/_root.scss` (`color-scheme`) |

**Regras dos parciais:**
- Os `@use`, as variáveis e os mixins ficam fora do bloco `@layer`.
- O `@use` não pode ficar dentro de `@layer`, e o `@import` aninhado está deprecated.
- **`as *`:** tira o namespace (não é alias). É necessário porque vários parciais teriam o mesmo namespace de um módulo do Bootstrap (`menu`, `navbar`, `dialog`…).
- O `@use` emite o CSS na primeira carga. Se um parcial que gera CSS tiver mixins que outros usam, separe os mixins em outro arquivo (ex.: `components/_icon-sizes.scss`, `frontend/_mixins.scss`).

## 4. Receitas

### Mudar um token de componente

O v6 não tem variáveis Sass por componente: o `$dropdown-box-shadow` do BS5 não existe mais. Cada componente lê um mapa `$<componente>-tokens`, que é mesclado com os padrões.
1. Em `frontend/_maps.scss`, coloque só o que muda:
   ```scss
   $menu-tokens: (
       --menu-box-shadow: var(--box-shadow),
   );
   ```
2. No `frontend.scss`, passe o mapa ao módulo dono: `@use "bootstrap/scss/menu" with ($menu-tokens: $menu-tokens);`
3. **Valor responsivo ou por contexto:** redefina a variável CSS no seletor, dentro da layer `custom`:
   ```scss
   .dialog {
       @include media-breakpoint-up(md) {
           --bs-dialog-padding: 2rem 4rem;
       }
   }
   ```
4. Os nomes dos tokens estão no topo de cada `node_modules/bootstrap/scss/_<componente>.scss`. Alguns componentes também leem fallbacks fora do mapa, ex.: `var(--accordion-btn-padding-y, var(--accordion-padding-y))`.
5. **Prefira token a propriedade.** Defina a propriedade direto só quando não houver token ou quando o componente ler `--theme-*` (ver armadilhas).

### Mudar uma opção global (`config`)

- Declare em `frontend/_variables.scss` e acrescente no `with` do `@use "bootstrap/scss/config"`.
- Só declare o que difere do padrão do v6 (`node_modules/bootstrap/scss/_config.scss`). Hoje são: `shadows`, `gradients` e `cssgrid` em `false`, `smooth-scroll` em `true` e `color-mode-type: data`.

### Mudar as cores do tema

- As cores da marca vêm dos `$ds-*`. O `theme-color-tokens()` (`_maps.scss`) monta cada cor no formato do v6: `base`, `fg`, `fg-emphasis`, `bg`, `bg-subtle`, `bg-muted`, `border`, `focus-ring` e `contrast`.
- **Cada cor vai completa:** o v6 troca o mapa da cor inteiro, e os padrões dele apontam para a paleta azul.
- **Nova cor de tema:** inclua em `$custom-theme-colors` (`_variables.scss`). Ela gera `.theme-*` e as utilities.
- `light` e `dark` existem aqui porque foram adicionadas ao `$theme-colors`. O v6 não tem.

### Mudar uma utility

Em `frontend/_utilities.scss`: `@use "bootstrap/scss/config" as *` e `$utilities: map.merge($utilities, (...))`.
- A escala de espaçamento do projeto se chama `$spacers-map`, porque o `config` também tem um `$spacers` e, com dois `as *`, a referência seria ambígua.
- **Escala do projeto:** `.p-3` = 3rem, com `q`/`h`/`hq`, `block*` e `header-height`. Os componentes do v6 continuam na escala do v6.

### Criar um parcial

1. Crie o arquivo em `components/`, `pages/` ou `frontend/`.
2. Envolva as regras em `@layer custom { ... }`, ou na layer certa conforme a tabela acima. **Sem layer, o CSS vence até as utilities.**
3. Adicione `@use "components/nome" as *;` na seção Custom do `frontend.scss`.

### Trazer de volta um módulo removido (`carousel`, `placeholder`)

1. Adicione o `@use "bootstrap/scss/<módulo>"` no `frontend.scss`, na mesma posição em que ele aparece no `bootstrap.scss`.
2. Se houver JS, adicione `import "bootstrap/js/dist/<módulo>.js"` (ver seção 5).

### Dark mode (botão de tema)

O tema é o atributo `data-bs-theme` no `<html>`. Com `$color-mode-type: data` (+ `frontend/_root.scss`), sem o atributo o site fica claro, como no v5.

| Peça | Arquivo | Papel |
| --- | --- | --- |
| Script no `<head>` | `<x-frontend::color-mode />` (`packages/agenciafmd/frontend/resources/views/components/color-mode.blade.php`) | Antes do CSS, aplica a escolha salva (`localStorage.theme`) ou o tema do sistema. Evita piscar o tema claro. Já está nos dois layouts (`master` e `html/master`) |
| Botão | `.js-color-mode-toggle` no header de `/html` (`html/partials/header.blade.php`) | Alterna, salva a escolha e atualiza `aria-pressed`/`aria-label`. Ícones `ic-moon` (no claro) e `ic-sun` (no escuro) |
| JS | `resources/js/components/color-mode.js` (`setupColorMode()`, chamado no `frontend.js`) | Clique, persistência e, sem escolha salva, acompanha a mudança do sistema. Troca o tema com as transições desligadas por um frame, porque o navbar e os links têm `transition: all` e o header piscava claro por 200 ms |
| CSS | `components/_color-mode.scss` | Troca os ícones do botão |

- **Header de um projeto novo** (`partials/header.blade.php` é um esqueleto vazio): copie o `<button class="... js-color-mode-toggle">` do header de `/html`. O script do `<head>` já está no layout.
- **Sem botão, só seguindo o sistema:** troque para `$color-mode-type: media-query` e remova o `<x-frontend::color-mode />`.
- **Um bloco sempre claro ou escuro:** `data-bs-theme="light|dark"` no elemento (ex.: demos de navbar no tema).

**Regras para a página funcionar nos dois temas:**
- **Superfície ou texto:** use os tokens do v6, nunca a cor da marca.
  - Superfícies: `bg-body`, `bg-1..4` (`bg-3` = `#f8f9fa` no claro, o antigo `bg-light`).
  - Textos: `fg-body`, `fg-1..3`.
- **`bg-light`, `bg-white`, `bg-gray-*`, `fg-dark`:** são cores fixas e não mudam com o tema. Use-as só quando a cor tiver que ser a mesma nos dois, ex.: `bg-warning fg-dark`.
- **No Sass, sem `$white`/`$body-bg`/`$body-color` em fundo ou texto:** use `var(--bs-bg-body)`/`var(--bs-fg-body)` ou `light-dark($claro, $escuro)` (ex.: `$progress-tokens`).
- **SVG que precisa trocar de cor:** use `fill="currentColor"` e defina a `color` com `light-dark()` (ex.: o logo em `components/_navbar-brand.scss`).
- **As cores escuras** ficam em `frontend/_variables-dark.scss`. Não altere os `$ds-*`.

### Menu dentro de navbar (hover no desktop e push no mobile)

```blade
<li class="nav-item menu-hover">
    <button class="nav-link menu-toggle" data-bs-toggle="menu" data-bs-display="static" aria-expanded="false">Blog</button>
    <div class="menu">
        <a class="menu-item" href="...">Item</a>
    </div>
</li>
```
- **`data-bs-display="static"` é obrigatório.** Sem ele, o Floating UI posiciona o menu via `style` inline e ele flutua sobre o conteúdo do drawer. O v6 só põe o atributo no `.menu` na primeira abertura, então o CSS não pode depender dele.
- **Desktop** (`components/_menu.scss`):
  - o hover usa `@media (hover: hover) and (pointer: fine)`, porque o header expande em `md`;
  - o menu fica em `top: 100%; left: 0` e precisa de `opacity: 1; transform: none` além do `display`;
  - o hover é ignorado dentro do drawer aberto;
  - o caret gira com `[aria-expanded="true"]`.
- **Mobile** (`components/_navbar.scss`):
  - `.drawer[open] .menu` fica estático e sem caixa, e empurra os irmãos;
  - `.drawer[open] .menu-hover` usa `flex-direction: column`.
- A sombra do menu é `var(--box-shadow)` (`$menu-tokens`). O `box-shadow-lg` do projeto tem um brilho ciano.

### Plugin JS novo

- **Usado no site todo:** `import "bootstrap/js/dist/<plugin>.js"` em `resources/js/frontend-imports.js`.
- **Usado só em uma página:** no JS da página (ex.: `resources/js/pages/theme.js`).
- Os plugins se registram pelo data API e não precisam de código.

## 5. JavaScript

- **O v6 é só ESM:** não existe `window.bootstrap`.
  - Para usar a API, importe direto: `import Tooltip from "bootstrap/js/dist/tooltip.js"`.
  - Nunca importe `from "bootstrap"`, que traz a biblioteca inteira (o JS caiu de 207 para 107 KB).
- **Plugins em `frontend-imports.js`:** alert, button, collapse, combobox, dialog, drawer, menu, popover, scrollspy, tab, toast e tooltip.
- **Plugins em `pages/theme.js`** (só no catálogo): chips, datepicker, nav-overflow, otp-input, range, strength e toggler, mais o `share-api-polyfill`.
- **Renomeações:**
  - Modal → Dialog: `setupDialogConfig` foi removido, porque o data API já cria a instância.
  - Offcanvas → Drawer: `setupSmoothScrollInDrawer`, `hidden.bs.drawer`, `data-bs-dismiss="drawer"`.
- **Cores lidas no JS:** `--bs-{cor}-base`.
- **Validação:** o form inválido recebe `data-bs-validate` (além de `was-validated`), e o CSS usa `:user-invalid`.
- **Combobox + Livewire:** o Combobox não dispara eventos no input oculto.
  - Markup: `.combobox` com `<input type="hidden" data-combobox-input wire:model...>`.
  - `resources/js/components/combobox.js` sincroniza no `change.bs.combobox`, disparando `input` e `change`.

## 6. Classes e markup: v5 → v6

| v5 | v6 |
| --- | --- |
| `col-md-6`, `d-lg-none`, `py-md-1h` | `md:col-6`, `lg:d-none`, `md:py-1h` |
| `navbar-expand-md` | `md:navbar-expand` |
| `btn-{cor}` / `btn-outline-{cor}` | `btn-solid theme-{cor}` / `btn-outline theme-{cor}` |
| `alert-{cor}`, `table-{cor}`, `badge text-bg-{cor}` | `theme-{cor}` |
| `text-{cor}` / `text-{cor}-hover` | `fg-{cor}` / `hover:fg-{cor}` |
| `text-muted`, `text-body-secondary` | `fg-2` |
| `text-bg-{cor}` | `bg-{cor} fg-contrast-{cor}` |
| `text-opacity-75` | `fg-75` |
| `mw-100` / `mh-100` | `max-w-100` / `max-h-100` |
| `dropdown-menu` / `-item` / `-divider` | `menu` / `menu-item` / `menu-divider` |
| `.dropdown` (hover do projeto) / `.dropdown-toggle` | `.menu-hover` / `.menu-toggle` |
| `modal`, `modal-*` | `<dialog class="dialog">`, `dialog-*` |
| `offcanvas*` | `<dialog class="drawer">`, `drawer*` |
| `form-select` | `form-control` |
| `form-check` + `form-check-input` | `.form-field` + `.check`/`.radio` no input |
| `form-switch` | `.form-field` + wrapper `.switch` (o input recebe o atributo `switch`) |
| `btn-check` (input + label) | `<label class="btn-check btn ...">` com o `<input>` dentro |
| `form-range` | `.form-range` + `.form-range-input` |
| Accordion com `collapse` | `<details name="id">` + `<summary class="accordion-header">` |
| `spinner-grow-sm` | `spinner-grow spinner-sm` |
| `has-validation`, `alert-dismissible` | removidos |
| `data-bs-toggle="modal\|offcanvas\|dropdown"` | `dialog` / `drawer` / `menu` |
| `navbar-dark` / `navbar-light` | `data-bs-theme` |

### Classes de cor

O v6 separa as cores em dois grupos.

**1. Superfície e texto neutros: seguem o tema.** São do próprio Bootstrap 6 (`$theme-bgs`/`$theme-fgs` em `node_modules/bootstrap/scss/_theme.scss`) e já trazem o claro e o escuro com `light-dark()`.

| Classe | Claro | Escuro | Uso |
| --- | --- | --- | --- |
| `bg-body` | branco | quase preto | fundo da página |
| `bg-1` … `bg-4` | do cinza mais claro ao mais escuro (`bg-3` = `#f8f9fa`) | do mais escuro ao mais claro | seções, cards, áreas destacadas |
| `fg-body` | texto principal | texto claro | texto comum |
| `fg-1` … `fg-4` | do texto mais forte ao mais fraco | idem | títulos secundários, legendas, texto apagado (era `text-muted`) |
| `border-body`, `border-muted`, `border-subtle`, `border-emphasized` | bordas neutras | idem | — |

**2. Cores da marca e de status: fixas.** Vêm do `$bs-theme-colors` do projeto (`$ds-*`): `primary`, `secondary`, `success`, `info`, `warning`, `danger`, `light` e `dark`.

| Classe | Exemplo |
| --- | --- |
| `bg-{cor}` | `bg-primary`, `bg-light` |
| `fg-{cor}` | `fg-primary`, `fg-dark` (era `text-*`) |
| `bg-{cor} fg-contrast-{cor}` | fundo da cor com texto legível em cima (era `text-bg-*`) |
| `bg-subtle-{cor}`, `bg-muted-{cor}`, `fg-emphasis-{cor}` | versões suaves e texto mais forte da cor |
| `theme-{cor}` nos componentes | `btn btn-solid theme-primary`, `alert theme-danger`, `badge theme-success` |

**Regra prática:**
- **Fundo ou texto neutro** (seção, card, legenda, data): `bg-body`, `bg-1..4`, `fg-body`, `fg-1..4`.
- **Cor da marca ou de status:** `bg-{cor}`, `fg-{cor}`, `theme-{cor}`.
- **`bg-light`, `bg-white`, `fg-dark`:** só quando a cor tiver que ser a mesma nos dois temas, ex.: `bg-warning fg-dark` (texto escuro sobre o amarelo).

`bg-light` continua existindo, mas é fixo (`#f8f9fa` nos dois temas), como no v5. No v5, a versão adaptável era o `bg-body-tertiary`; no v6, é `bg-1..4`. Onde ele era usado como superfície, virou `bg-3`, com o mesmo hex no claro.

O CSS final passa pelo PurgeCSS, então só ficam no build as classes que aparecem no markup.

**Classes recriadas pelo projeto** (o v6 removeu):
- `.ratio`, `h1`–`h6` com os tamanhos dos tokens, `.display-*`, `.lead` e `.card-link`;
- os passos de opacidade 25/75;
- `fs-1..6`, `fs-xxsmall..xlarge`, `lh-*`, `ls-*`, `fw-extrabold`/`black`, `rounded-*`, `fill-*`, `stroke-*` e `ratio-*` extras.

**Classes só do projeto:** `.btn-whatsapp`, `.text-bg-outline-*`, `.breadcrumb-dark`, `.ic-*`, `.icon-link-hover-*`, `.text-truncate-*`.

**Nomes mantidos de propósito:**
- `fs-1..6` e `lh-base` não foram trocados pelos nomes do v6 (`fs-4xl`, `lh-md`);
- o breadcrumb usa o markup próprio, com ícone, e não o `.breadcrumb-link`/`.breadcrumb-divider` do v6;
- raios: `$radius` = `$border-radius` (1rem) e `radius-7` = 1rem. As `.rounded-*` usam o `$border-radius-map` do projeto.

**Componentes Blade:**
- os `@props` não mudaram;
- novo `x-frontend::avatar`;
- o `x-frontend::badge` usa `theme-*` (padrão `theme-primary`);
- **campos de formulário** (input, select, textarea, radio, checkbox, combobox) ficam sempre em markup padrão, nunca em componente Blade.

## 7. Armadilhas conhecidas

**CSS e layers**
- **Helpers do v6 na camada `custom` perdem.** `.icon-link > .bi` encolhia o logo e os `.ic-*`. Override de helper vai em `@layer helpers`.
- **Override de algo que o componente lê de `--theme-*`:** defina a propriedade, não a variável. Ex.: `.alert.theme-primary { background-color }` e a cor do texto do alerta via `--bs-theme-fg-emphasis`.
- **`color-scheme`:** o v6 declara `:root { color-scheme: light dark }` fora de layer, então o override também fica fora (`frontend/_root.scss`).
- **`:has()` dentro de `:has()`** é inválido e descarta a lista de seletores inteira. Coloque o `:has()` no wrapper: `.form-floating:has(> select option:checked) > label`.
- **`secondary`:** o v6 usa `secondary` como cinza em alguns lugares (ex.: label do radio desabilitado, corrigido em `components/_checks.scss`), mas no projeto ele é o amarelo da marca. Procure `--secondary-` em `node_modules/bootstrap/scss` a cada versão.
- **Critical CSS:**
  - o lightningcss remove a declaração de ordem das layers, e `content`/`forms` venceriam as utilities;
  - por isso o `CriticalCss.php` (`packages/agenciafmd/frontend/src/View/Components`) prefixa a constante `LAYER_ORDER`, coberta pelo `CriticalCssTest`;
  - se o v6 mudar as layers, atualize a constante.
- **`tint-color`/`shade-color` geram `color-mix()`:** use o resultado só como valor CSS, nunca em contas de cor do Sass. O minificador converte o `color-mix` com cores fixas em hex.

**Componentes**
- **Dialog fechado:** o v6 o mantém no layout (`visibility: hidden`) e ele estica a página. O projeto usa `.dialog:not([open]) { position: fixed }`.
- **Botões:** o v6 força `white-space: nowrap`. O projeto usa `$btn-white-space: normal`, como no v5.
- **Menu:** `.menu-item` precisa ser filho direto de `.menu`, sem `<ul>`/`<li>`. Senão a navegação pelas setas não funciona.
- **Toast estático** (sem JS): precisa de `.show`. Sem ela fica com `opacity: 0`.
- **ScrollSpy:**
  - use um único `data-bs-spy` com alvo em uma lista que tenha todos os links (no tema, `#bd-sidebar-nav`). Com vários, aparecem dois links ativos;
  - o `<div>` sentinela do fim do container não pode sair do fluxo. No tema, uma margem negativa igual ao `gap` cancela o espaço extra.
- **Container queries:** navbar, card-group, list-group horizontal, stacks responsivos e tabelas empilhadas reagem à largura do pai, não da tela. Use `.contains-inline` onde for preciso.
- **`.nav` vertical** precisa de `flex-nowrap`. Não use `.navbar` em sidebar.
- **`.nav-link`** usa `align-items: flex-start`. Com badge ou ícone ao lado, adicione `align-items-center`.
- **Input-group com feedback dentro:** adicione `.input-group-ignore` no `.invalid-feedback`/`.valid-feedback`, porque o `.has-validation` não existe mais.
- **`btn-check` sem cor:** use `class="btn-check btn"`.
- **`.form-field` é grid:** confira o `.invalid-feedback` dentro dele.
- **Checks:** o v6 calcula o tamanho para line-height 1.5. O projeto usa 1.2, então os tokens `--check-size`, `--radio-size` e `--switch-height` valem `1em` e a margem fica centralizada (`$checks-margin-block`).
- **Superfícies `bg-1..4`** são mais claras que os cinzas do BS5. O progress e o range usam `$gray-200` (`$gray-700` no escuro).
- **Breadcrumb:** o v6 não lê o `--breadcrumb-item-active-color` do BS5. O `.breadcrumb-item.active` do projeto aplica `var(--bs-breadcrumb-item-active-color)` para o item ativo do `.breadcrumb-dark` ficar branco.
- **Floating label:** o `<label>` vem antes do campo, e o seletor do select é `label:has(~ select)`.
- **Demo `was-validated`** só pinta depois da interação (`:user-invalid`).

**Build e ferramentas**
- **`public/build/` é versionado:** o `vite build` limpa a pasta. Se o build falhar, rode `git checkout -- public/build`. Depois do `npm run dev`, remova o `public/hot`.
- **CSS sem build:** `npx sass --load-path=node_modules --pkg-importer=node resources/scss/frontend.scss`.
- **Prettier em mapas Sass:** dentro de um mapa, `(expr) * 0.5em` vira a lista `(expr,) * 0.5em` e o Sass falha (*Undefined operation*). Calcule em uma variável fora do mapa (ex.: `$checks-margin-block`).
- **O Prettier do projeto só formata `resources/`.**
- **Classes passadas por props ou arrays** (`bodyClass`, `icon-class`, `'class' =>`, `@class`, strings no JS) não são pegas por busca em `class="..."`.
- **Bibliotecas de terceiros:** `meta.load-css("pacote/arquivo.css")` dentro do `@layer custom` de `vendors/_vendors.scss`. O `.css` explícito é obrigatório (campo `exports` dos pacotes). O sweetalert2 recebe `$with` só com as variáveis `!default` que aceita.
- **HTML gerado em tempo de execução** (`[data-vc]`) precisa estar no safelist do PurgeCSS.
- **Testes do pacote `agenciafmd/frontend`** (incluindo o `CriticalCssTest`) não estão no `phpunit.xml`. Rode com `vendor/bin/sail bin pest packages/agenciafmd/frontend/tests`.
- **`vendors/_hubspot-form.scss`** tem código BS4 e não é compilado. É anterior à migração.
- **`livewire.js` de 595 KB** é a versão não minificada do ambiente local. Com `APP_DEBUG=false`, o Livewire serve a minificada.
- **Fontes:** `$should-use-local-font-face: false`. O Roboto vem do `vite-plugin-webfont-dl`; os arquivos locais duplicavam a família.

## 8. Decisões

| Tema | Decisão |
| --- | --- |
| Drawer do header | `<dialog>` modal no formato do v6 (painel flutuante, título "Menu" e `btn-close`). Alternativa: não-modal (`backdrop: false, scroll: true`) |
| Hover dos botões sólidos | Comportamento do v6, que não escurece (no BS5 escurecia 15%) |
| `.lead` / `.display-*` | Recriados como classes do projeto |
| Validação | `data-bs-validate` + `:user-invalid`, adicionado pelo JS no submit |
| Dialog | Foca ao abrir (nativo do `<dialog>`). A opção `focus: false` não existe mais |
| Foco em links | `a:focus:not(:focus-visible) { outline: none }`, mantendo o foco do teclado visível |
| Range e progress | Os dois mantidos (campo de formulário e exibição) |
| Tom-select | Substituído pelo Combobox |
| Dark mode | Botão de tema no header: sem escolha salva, segue o sistema; com escolha, ela vale. Corpo do texto escuro em `$gray-500` e sombra dos cards com brilho `$ds-info` mantidos (opções de design em aberto) |
| `$bs-theme-colors` | Mapa completo por cor (os padrões do v6 usam a paleta azul) |
| Ajustes finos do BS5 (cerca de 60 variáveis) | Seguem o padrão do v6. Ajustar sob demanda |
| CSS separado para o catálogo | Não aplicado. Reduziria 15% do CSS gzip, mas exige trocar o plugin de purge |
| Navegadores | Chrome/Edge 130, Firefox 132, Safari 18 (requisito do v6) |

**Pendentes ou monitorar**

| Tema | Situação |
| --- | --- |
| Erro de console do Combobox ("more than one instance per element") | Bug da alpha: o Combobox cria um `new Menu()` no mesmo elemento. Funciona; acompanhar o próximo alpha |
| Scroll horizontal de 16 px no blog em 375 px | Já existia no v5: `.stretch-on-mobile` usa `100vw`. Não ocorre em celular. Alternativa: `overflow-x: clip` no `html`/`body` |
| Layers `custom`, `helpers` e `reboot` | Vêm do código da alpha e não estão documentadas. Conferir a cada versão |

## 9. Checklist de validação

Use em páginas novas, em projetos que receberem esta migração e a cada atualização do Bootstrap.

**Código**
- [ ] Classes v5 em qualquer lugar, não só em `class="..."`:
  `grep -rnE "text-bg-|btn-(primary|secondary|success|danger|warning|info|light|dark)\b|btn-outline-|text-(primary|secondary|success|danger|warning|info|muted|white|black)\b|(col|d|g|gx|gy|offset|order|flex|fs|p[xytbse]?|m[xytbse]?)-(sm|md|lg|xl)-|form-select|form-check|dropdown-(menu|item|divider|toggle)|modal-|offcanvas|navbar-(dark|light)|was-validated|needs-validation|card-link|lead\b|display-[1-6]"`
- [ ] Atributos JS antigos: `data-bs-toggle="modal|offcanvas|dropdown|collapse"`, `data-bs-parent`, `data-bs-ride`, `data-bs-offset`, `popperConfig` e eventos `*.bs.modal|offcanvas|dropdown`.
- [ ] Seletores JS antigos: `.modal`, `.show`, `body.modal-open`, `.form-select`, `.form-check-input`, `.collapsed`.
- [ ] Variáveis CSS removidas: `--bs-*-rgb`, `rgba(var(--bs-...))` e `--bs-{cor}` sem `-base`.
- [ ] `bootstrap.X` sem import.
- [ ] `frontend.scss` comparado com `node_modules/bootstrap/scss/bootstrap.scss`.

**Markup**
- [ ] Dialog e drawer são `<dialog>`, e menus não têm `<ul>`/`<li>`.
- [ ] Toggle de menu dentro de navbar com `data-bs-display="static"`.
- [ ] Floating label com o `<label>` antes do campo.
- [ ] Accordion com `<details>`/`<summary>`.
- [ ] Checks no formato `.form-field`.
- [ ] `.contains-inline` onde houver container query.
- [ ] `.input-group-ignore` nos feedbacks dentro de input-group.
- [ ] `<textarea>`/`<pre>` sem reindentação.

**CSS**
- [ ] Parcial novo com a layer certa.
- [ ] Override por token antes de propriedade.
- [ ] Critical CSS começa com a ordem completa das layers e inclui a regra `[data-bs-theme=dark]`.
- [ ] Seletores de HTML gerado em runtime no safelist.

**Navegador** (375, 992, 1200 e 1600 px)
- [ ] Console sem erros, exceto o erro conhecido do Combobox.
- [ ] Sem scroll horizontal (`scrollWidth === clientWidth`), com a exceção conhecida.
- [ ] Logo e ícones do `.icon-link` no tamanho certo.
- [ ] Contraste em `theme-secondary`/`warning`/`light`.
- [ ] Dialog e drawer abrem, fecham com Esc e devolvem o foco.
- [ ] Menu:
  - [ ] navegação pelas setas e Esc;
  - [ ] hover a partir de `md`;
  - [ ] no drawer mobile, abre por clique e empurra os itens.
- [ ] Formulários: `data-bs-validate`, `.is-invalid` do Livewire, floating label e combobox com `wire:model`.
- [ ] Dark mode:
  - [ ] o botão alterna e a escolha continua depois do reload;
  - [ ] sem escolha salva, o tema segue o sistema e acompanha a mudança dele;
  - [ ] a página não pisca clara ao abrir no escuro;
  - [ ] no escuro, nenhuma superfície fica clara e nenhum texto ou logo fica preto (cor fixa no markup ou no Sass).
- [ ] Foco visível no Tab.
- [ ] `npm run build` sem warning do Sass.
- [ ] Pest na raiz e no pacote `agenciafmd/frontend`.
- [ ] Prettier em `resources/`.

## 10. Limitações da alpha

- **#43098:** o JS usa o prefixo `bs-` fixo, por isso o plugin de prefixo do PostCSS é obrigatório.
- **#43070:** o Esc fecha o Dialog/Drawer mesmo com `keyboard: false`.
- **#43120:** o Drawer não move o foco para dentro ao abrir.
- **#43051:** o drawer do navbar responsivo fica mal posicionado.
- **#43149:** o Datepicker envia a data no formato do locale, não em ISO.
- **#43214:** o Nav overflow move o último item mesmo quando tudo cabe.
- **Collapse/accordion** abrem sem animação no Firefox (`interpolate-size` não suportado).
- Pode haver mudanças incompatíveis antes do beta.
