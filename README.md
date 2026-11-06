<p align="center"><a href="https://fmd.ag/?utm_source=github" target="_blank"><img src="https://raw.githubusercontent.com/agenciafmd/starter/v11/public/vendor/admix-ui/images/fmd.svg" width="250" alt="Agência F&MD Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/dt/agenciafmd/filament-starter" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/l/agenciafmd/filament-starter" alt="License"></a>
</p>

## O que é?

Este é o esqueleto de desenvolvimento dos nossos sites e apps, com o painel administrativo (admix) construído sobre o [Filament](https://filamentphp.com).

Esta é a documentação da **v1** do Starter.

## Requisitos do projeto

- PHP **^8.4**
- Laravel **13**
- Filament **5**
- Node **24+** (veja o `.tool-versions`)
- Docker, para o [Laravel Sail](https://laravel.com/docs/13.x/sail)

Veja mais sobre o Sail na nossa documentação: https://agenciafmd.github.io/docs/sail/

## Criando o projeto

Para começar, crie o projeto com o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer create-project agenciafmd/filament-starter:v1.x-dev --ignore-platform-reqs nome-do-projeto
```

> O `v1.x-dev` no comando garante que a v1 do Starter (Laravel 13 + Filament 5) será usada.

Ao final, o `post-create-project-cmd` gera a chave da aplicação, sobe os containers do Sail e roda as migrations.

## Instalando o projeto

Quando clonamos o projeto, o Laravel Sail já está configurado. Para instalar as dependências, rode:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

Depois, copie o `.env`, suba os containers e gere a chave da aplicação:

```bash
cp .env.example .env
```

```bash
sail up -d
```

```bash
sail artisan key:generate
```

E instale as dependências do front-end:

```bash
sail npm install
```

```bash
sail npm run build
```

## Alimentando o projeto

Alimente o projeto com dados fictícios usando o comando:

```bash
sail artisan migrate:fresh --seed
```

O `DatabaseSeeder` cria o usuário administrador do admix. Ajuste o nome e o e-mail dele para o seu projeto.

## Rodando em desenvolvimento

```bash
sail composer run dev
```

O comando sobe, ao mesmo tempo, o servidor, a fila, os logs (`pail`) e o Vite.

Por padrão, as portas são:

| Serviço | URL |
|---|---|
| Site | http://localhost:8081 |
| Admix | http://localhost:8081/admix |
| Mailpit | http://localhost:8181 |

> As portas podem ser alteradas no `.env` (`APP_PORT`, `VITE_PORT`, `FORWARD_*`).

Em ambiente local, o admix faz o login automaticamente com o primeiro administrador ativo. Para desativar ou logar com um usuário específico, use a variável `ADMIX_AUTO_LOGIN` no `.env` (`false` ou o e-mail do usuário).

## Pacotes

A v1 já vem com os pacotes abaixo instalados pelo Composer:

| Pacote | O que faz |
|---|---|
| [filament-admix](https://github.com/agenciafmd/filament-admix) | Área administrativa: usuários, grupos/permissões e auditoria |
| [filament-leads](https://github.com/agenciafmd/filament-leads) | Leads recebidos pelos formulários do site |
| [filament-postal](https://github.com/agenciafmd/filament-postal) | Configuração dos e-mails disparados pelos formulários |
| [laravel-sitemap](https://github.com/agenciafmd/laravel-sitemap) | Geração do sitemap |
| [laravel-social-meta](https://github.com/agenciafmd/laravel-social-meta) | Meta tags de SEO e redes sociais |
| [laravel-support](https://github.com/agenciafmd/laravel-support) | Helpers e macros compartilhados |
| [laravel-turbo](https://github.com/agenciafmd/laravel-turbo) | Cache estático das páginas (`public/page-cache`) |
| [frontend](./packages/agenciafmd/frontend/README.md) | Rotas, views e componentes do site (pacote local) |

Os plugins ativos no admix ficam em `config/filament-admix.php`, na chave `plugins`.

### Adicionando um pacote da família

Instale o pacote e registre o plugin dele no `config/filament-admix.php`. Ex.:

```bash
sail composer require agenciafmd/filament-articles
```

```php
'plugins' => [
    LeadsPlugin::class,
    PostalPlugin::class,
    ArticlesPlugin::class,
],
```

Outros pacotes disponíveis: `filament-articles`, `filament-banners`, `filament-big-numbers`, `filament-faqs`, `filament-http-logs`, `filament-instagram`, `filament-partners`, `filament-redirects`, `filament-settings`, `filament-testimonials` e `laravel-rdstation` ([veja todos](https://github.com/agenciafmd?q=filament-&type=all)).

### Criando um recurso próprio

Recursos específicos do projeto viram pacotes locais em `packages/agenciafmd/local-{plural}` (ex.: `local-products`), carregados pelo `composer.json` como repositório do tipo `path`. As convenções estão no [AGENTS.md](./AGENTS.md) e nas skills em `.claude/skills`.

## Desenvolvendo com IA

O projeto usa o [Laravel Boost](https://github.com/laravel/boost). As instruções para os agentes ficam no [AGENTS.md](./AGENTS.md) e as skills (criação de pacotes, form, table, permissões, testes, etc.) em `.claude/skills`. Elas são atualizadas automaticamente no `composer update` (`boost:update`).

## Testes e qualidade

```bash
sail composer test
```

Roda a cobertura de tipos, os testes (Pest), o lint (Rector, Pint e Prettier) e a análise estática (PHPStan). Cada etapa também pode ser rodada separadamente:

| Comando | O que faz |
|---|---|
| `sail composer test:unit` | Testes com Pest |
| `sail composer test:type-coverage` | Cobertura de tipos (mínimo de 100%) |
| `sail composer test:lint` | Verifica o lint sem alterar os arquivos |
| `sail composer test:types` | PHPStan |
| `sail composer lint` | Corrige o lint (Rector, Pint e Prettier) |

## Problemas comuns

### Imagens quebradas?

Linke corretamente o `storage` para o public:

```bash
sail artisan storage:link
```

### SVGs não carregando?

Limpe o cache com o comando abaixo:

```bash
sail artisan cache:clear
```

### Alterei no admix e o site não mudou?

As páginas com a middleware `turbo` são gravadas em `public/page-cache` e servidas direto pelo servidor web. O `PageCacheEventSubscriber` do pacote `frontend` limpa as páginas quando um model é salvo, excluído, restaurado ou reordenado no admix — ajuste os models monitorados no `subscribe()` dele ao criar novos recursos ([ver mais](./packages/agenciafmd/frontend/README.md#limpeza-do-cache-estático-pagecacheeventsubscriber)).

Alterações feitas pelo console (seeders, imports, filas) não limpam o cache. Nesse caso, rode:

```bash
sail artisan page-cache:clear
```

### Alterei o front-end e nada mudou?

Rode o Vite em modo de desenvolvimento (`sail npm run dev`) ou gere o build (`sail npm run build`).

## Vai codar front-end?

Acesse a [documentação específica](./resources/README.md).

## Licença

Nossos pacotes são abertos, [MIT](https://opensource.org/licenses/MIT) para os
mais chegados.
