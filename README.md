<p align="center"><a href="https://fmd.ag/?utm_source=github" target="_blank"><img src="https://raw.githubusercontent.com/agenciafmd/starter/v11/public/vendor/admix-ui/images/fmd.svg" width="250" alt="Agência F&MD Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/dt/agenciafmd/filament-starter" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/l/agenciafmd/filament-starter" alt="License"></a>
</p>

## O que é?

Este é o esqueleto de desenvolvimento dos nossos sites e apps.

## Requisitos

Usamos Docker com as imagens [serversideup/php](https://serversideup.net/open-source/docker-php/docs/getting-started) (NGINX + PHP-FPM) para desenvolvimento. Você precisa do Docker com o Docker Compose v2 (`docker compose`).

Não é preciso PHP nem Node no host. Todos os comandos PHP, Artisan, Composer e Node rodam dentro do container `app`, com `docker compose exec app ...`.

## Criando o projeto

Para começar, crie o projeto com o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -e COMPOSER_HOME=/tmp/composer \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    serversideup/php:8.4-cli-v5.1.1 \
    composer create-project agenciafmd/filament-starter:dev-master --ignore-platform-reqs nome-do-projeto
```

O `.env` e a chave da aplicação já são criados. Entre na pasta do projeto e siga para [Subindo o ambiente](#subindo-o-ambiente).

## Instalando o projeto

Depois de clonar o projeto, instale as dependências PHP e crie o `.env`:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -e COMPOSER_HOME=/tmp/composer \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    serversideup/php:8.4-cli-v5.1.1 \
    composer install --ignore-platform-reqs

cp .env.example .env
```

## Subindo o ambiente

Antes de subir, confira no `.env`:

- as portas do projeto (`APP_PORT`, `VITE_PORT`, `FORWARD_DB_PORT`, `FORWARD_REDIS_PORT`, `FORWARD_MAILPIT_PORT` e `FORWARD_MAILPIT_DASHBOARD_PORT`), para não conflitar com outros projetos;
- `USER_ID` e `GROUP_ID` com o resultado de `id -u` e `id -g` (o padrão é `1000`), para que os arquivos criados no container pertençam ao seu usuário;
- `NODE_VERSION`, só com a versão major do Node (o padrão é `24`). Depois de mudar, reconstrua a imagem com `docker compose up -d --build --wait`.

```bash
docker compose up -d --build --wait
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app npm install
docker compose exec app npx playwright install chromium
```

> Rode o `key:generate` só em um projeto clonado. O `create-project` já gera a chave.

A aplicação fica em `http://localhost:${APP_PORT}`, o painel em `/admix` e o Mailpit em `http://localhost:${FORWARD_MAILPIT_DASHBOARD_PORT}`.

## Comandos do dia a dia

```bash
# subir e parar os serviços
docker compose up -d --wait
docker compose stop

# reconstruir a imagem depois de mudar o Dockerfile
docker compose up -d --build --wait

# artisan, composer, npm e binários do vendor
docker compose exec app php artisan route:list
docker compose exec app composer require vendor/pacote
docker compose exec app npm run dev
docker compose exec app vendor/bin/pint --dirty

# testes (inclusive os de browser, com Playwright)
docker compose exec app php artisan test --compact

# terminal dentro do container
docker compose exec app bash
```

O `npm run dev` sobe o Vite com HMR na porta `VITE_PORT`.

Para usar o Xdebug, defina `XDEBUG_MODE=debug` no `.env` e rode `docker compose up -d`. Volte para `off` quando terminar.

## Alimentando o projeto

Alimente o projeto com dados fictícios usando o comando:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

## Banco não encontrado?

O ambiente Docker sobe um MySQL (serviço `mysql`) com o banco do `.env` e um banco `testing` para os testes. Confira se o `.env` usa `DB_CONNECTION=mysql` e `DB_HOST=mysql`.

Se o projeto usar SQLite (`DB_CONNECTION=sqlite`), crie o banco com o comando:

```bash
touch database/database.sqlite
```

## Imagens quebradas?

Linke corretamente o `storage` para o public:

```bash
docker compose exec app php artisan storage:link
```

## SVGs não carregando?

Limpe o cache com o comando abaixo:

```bash
docker compose exec app php artisan cache:clear
```

## Vai codar front-end?

Acesse a [documentação específica](./resources/README.md).

## Agentes de IA (Laravel Boost)

O `AGENTS.md` e as skills em `.claude/skills` e `.github/skills` são gerados pelo Laravel Boost já com os comandos `docker compose exec app ...`. Os arquivos que controlam isso são versionados:

- `config/boost.php`: define o prefixo dos comandos em `executable_paths` e exclui a seção padrão do Sail;
- `.ai/guidelines/serversideup.blade.php`: seção do ambiente Docker no `AGENTS.md`;
- `boost.json`: precisa manter `"sail": true`, porque é essa flag que liga o prefixo dos comandos.

Para regenerar as instruções, use o `boost:update`. Ele também roda no `composer update`.

```bash
docker compose exec app php artisan boost:update
```

Não rode o `boost:install`. Ele grava `"sail": false` no `boost.json` e reescreve a configuração do MCP. Se rodar sem querer:

1. volte `"sail": true` no `boost.json`;
2. volte o comando do MCP para `docker compose exec -T app php artisan boost:mcp` no `.mcp.json`, no `.ai/mcp/mcp.json` e no `opencode.json`;
3. rode o `boost:update` de novo.

Depois de atualizar o Boost, confira se nada voltou a apontar para o Sail. O comando abaixo não deve retornar nada:

```bash
grep -rn "vendor/bin/sail" AGENTS.md .claude/skills .github/skills
```

O MCP do Boost roda dentro do container, então os serviços precisam estar no ar (`docker compose up -d --wait`).

## Migrando do Sail

Para um projeto que já rodava com o Laravel Sail:

1. Pare os containers antigos, já com o novo `compose.yaml`. O `--remove-orphans` remove o antigo serviço `selenium`. Os volumes do MySQL e do Redis são mantidos.

    ```bash
    docker compose down --remove-orphans
    ```

2. No `.env`, remova `WWWUSER`, `WWWGROUP` e `SAIL_XDEBUG_*`. Adicione `USER_ID`, `GROUP_ID`, `XDEBUG_MODE` e `XDEBUG_CONFIG` como no `.env.example`.
3. Suba o ambiente e atualize as dependências:

    ```bash
    docker compose up -d --build --wait
    docker compose exec app composer install
    docker compose exec app npm install
    docker compose exec app npx playwright install chromium
    ```

A imagem antiga `sail-8.4/app` é compartilhada por todos os projetos que ainda usam o Sail nessa máquina. Só remova (`docker image rm sail-8.4/app`) se nenhum outro projeto precisar dela.

## Conheça nossa família

- [Área Administrativa](https://github.com/agenciafmd/admix)
- [Banners](https://github.com/agenciafmd/admix-banners)
- [Email](https://github.com/agenciafmd/admix-postal)
- [e mais](https://github.com/agenciafmd?utf8=%E2%9C%93&q=admix-&type=&language=)

## Requisitos do projeto

- Versão do PHP: **^8.4**
- Versão do Laravel: **12**
- Versão do Node: **24+**

## Licença

Nossos pacotes são abertos, [MIT](https://opensource.org/licenses/MIT) para os
mais chegados.
