<p align="center"><a href="https://fmd.ag/?utm_source=github" target="_blank"><img src="https://raw.githubusercontent.com/agenciafmd/starter/v11/public/vendor/admix-ui/images/fmd.svg" width="250" alt="Agência F&MD Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/dt/agenciafmd/filament-starter" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/l/agenciafmd/filament-starter" alt="License"></a>
</p>

## O que é?

Este é o esqueleto de desenvolvimento dos nossos sites e apps.

## Requisitos

Usamos Docker com as imagens [serversideup/php](https://serversideup.net/open-source/docker-php/docs/getting-started) na variante FrankenPHP (Caddy + PHP), tanto no desenvolvimento quanto na imagem de produção. Você precisa do Docker com o Docker Compose 2.24 ou mais novo (`docker compose`).

Não é preciso PHP nem Node no host. Todos os comandos PHP, Artisan, Composer e Node rodam dentro do container `app`, com `docker compose exec app ...`.

## Criando o projeto

Para começar, crie o projeto com o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -e COMPOSER_HOME=/tmp/composer \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    serversideup/php:8.5-cli-alpine \
    composer create-project agenciafmd/filament-starter:v2.x-dev --ignore-platform-reqs nome-do-projeto
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
    serversideup/php:8.5-cli-alpine \
    composer install --ignore-platform-reqs
```
```bash
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

# reconstruir a imagem depois de mudar o .docker/runtime/8.5/Dockerfile
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

## Fila e agendamento

O `docker compose up` também sobe dois serviços com a mesma imagem do `app`:

- `queue`: processa a fila nas filas `high`, `default` e `low`. No desenvolvimento roda o `queue:listen`, que carrega o código atual a cada job, então não é preciso reiniciar o serviço depois de alterar um job. Em produção roda o `queue:work`.
- `scheduler`: roda o `schedule:work`, que executa as tarefas agendadas (as rotinas do admix, como `audit:prune`, `model:prune` e `auth:clear-resets`). Confira a lista com `docker compose exec app php artisan schedule:list`.

A fila só é processada pelo serviço `queue` quando o `QUEUE_CONNECTION` é `database` (o padrão) ou `redis`. Com `sync`, os jobs rodam na hora, dentro da requisição.

O admix também sabe agendar um `queue:work` pelo scheduler, para hospedagens sem worker dedicado. A imagem desliga esse agendamento com `ADMIX_QUEUE_ENABLED=false`, para não haver dois workers na mesma fila.

```bash
# logs do worker e do scheduler
docker compose logs -f queue scheduler

# reiniciar o scheduler depois de mudar um agendamento
docker compose restart scheduler
```

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

## Imagem de produção

O `.docker/runtime/8.5/Dockerfile` tem três estágios:

- `base`: o que é comum aos dois targets, com as extensões do PHP, o locale `pt_BR.UTF-8` e o fuso `America/Sao_Paulo`.
- `development`: parte do `base` e é usado pelo `compose.yaml`, com Node, xdebug e as dependências do Playwright. O código entra por bind mount.
- `production`: parte do `base`, sem Node, npm, xdebug, pacotes de dev nem Composer. O código e o `vendor/` (instalado com `--no-dev`) ficam dentro da imagem. É o target padrão: um `docker build` sem `--target` gera a imagem de produção.

Os assets do frontend **não** são compilados no build. A imagem usa os arquivos commitados em `public/build`, `public/css/critical` e `public/filament-admix`. Antes de gerar a imagem, rode no ambiente de desenvolvimento e commite o resultado:

```bash
docker compose exec app npm run build
docker compose exec app npm run build:filament
```

Gere a imagem a partir de um clone limpo do repositório. O contexto do build é a pasta, não o Git, então arquivos fora do Git (como pacotes locais em `packages/`) também entrariam na imagem.

```bash
docker build -f .docker/runtime/8.5/Dockerfile --target production -t nome-do-projeto:producao .
```

### Testando a imagem de produção localmente

O `compose.production.yaml` troca os serviços `app`, `queue` e `scheduler` pela imagem de produção, sem bind mount, e reaproveita o MySQL e o Redis do ambiente de desenvolvimento. O Mailpit fica de fora, num profile que não é ativado: em produção, o envio de e-mail usa o SMTP definido no `.env`. O MySQL e o Valkey não publicam portas no host: o Docker passa por cima do firewall do servidor, e eles ficariam acessíveis pela internet. A aplicação os acessa pela rede interna do Docker; para abrir o banco no servidor, use `docker compose exec mysql mysql -u root -p`. A configuração vem do `.env` quando o container sobe, com `APP_ENV=production` e `APP_DEBUG=false`. O `.env` nunca é copiado para a imagem.

```bash
docker compose -f compose.yaml -f compose.production.yaml up -d --build --wait
```

As imagens de produção ganham a tag `production` (`<projeto>-app:production`, `<projeto>-queue:production` e `<projeto>-scheduler:production`), e as de desenvolvimento, a tag `local` (`<projeto>-app:local` etc.). Assim, uma stack não sobrescreve a imagem da outra.

Enquanto a produção estiver no ar, o `docker compose exec app ...` roda no container de produção, que não tem Node nem Composer. Para voltar ao desenvolvimento:

```bash
docker compose up -d --wait
```

### Configuração em runtime

Na imagem de produção, toda a configuração vem de variáveis de ambiente (`APP_KEY`, banco, cache etc.). Ao subir, o container `app` cria o link do `storage`, roda as migrações (`php artisan migrate --force`) e roda o `php artisan optimize`, que gera os caches de config, rotas, views, eventos e do Filament. Os containers `queue` e `scheduler` sobem com `AUTORUN_ENABLED=false`, para que só o `app` rode as migrações. Ao parar, o `queue` tem 70 segundos (`stop_grace_period`) para terminar o job em andamento, um pouco mais que o `--timeout=60` do worker.

A homologação usa a mesma imagem de produção, com o `compose.production.yaml`. As migrações rodam ao subir, mas o `optimize` e os caches não. Defina no `.env` da homologação, que o `compose.production.yaml` repassa ao container:

```env
AUTORUN_LARAVEL_OPTIMIZE=false
AUTORUN_LARAVEL_CONFIG_CACHE=false
AUTORUN_LARAVEL_ROUTE_CACHE=false
AUTORUN_LARAVEL_VIEW_CACHE=false
AUTORUN_LARAVEL_EVENT_CACHE=false
```

Só o `AUTORUN_LARAVEL_OPTIMIZE=false` não basta: sem os outros, a imagem gera os caches de config, rotas, views e eventos um a um.

No desenvolvimento local o `AUTORUN_ENABLED` fica desligado, então nada roda automaticamente.

Os uploads ficam no volume `storage-app`, montado em `storage/app` no `app`, no `queue` e no `scheduler`, e sobrevivem à recriação dos containers. O restante do `storage/` (caches e views compiladas) é efêmero.

Os logs do Laravel vão para o stderr (`LOG_CHANNEL=stderr`) e aparecem no `docker compose logs`. O Docker guarda até 3 arquivos de 10 MB por serviço, para os logs não encherem o disco do servidor.

## FrankenPHP

Os dois targets usam a variante `frankenphp` da serversideup no modo clássico: cada requisição carrega o Laravel do zero, como no PHP-FPM. O Caddy responde em HTTP na porta 8080. Com `SSL_MODE=full` ou `SSL_MODE=mixed`, ele também responde em HTTPS na porta 8443, com HTTP/2 e HTTP/3 (veja a [configuração de SSL da serversideup](https://serversideup.net/open-source/docker-php/docs/deployment-and-production/configuring-ssl)). No desenvolvimento, o `compose.yaml` usa `SSL_MODE=off`.

O PHP dessa imagem roda em threads (ZTS), então toda extensão nova precisa ser thread-safe.

Para migrar para o [Laravel Octane](https://laravel.com/docs/octane), o código precisa estar pronto para o modo worker, sem estado que passe de uma requisição para outra. Depois:

1. instale o `laravel/octane` e rode `php artisan octane:install --server=frankenphp`;
2. versione o `public/frankenphp-worker.php` (o instalador o coloca no `.gitignore`);
3. troque o comando do container por `php artisan octane:start --server=frankenphp --port=8080 --caddyfile=/etc/frankenphp/Caddyfile`. No desenvolvimento, acrescente `--watch` para o worker recarregar quando o código mudar (precisa do pacote `chokidar` no npm).

## PHP e Caddy

Os dois arquivos ficam em `.docker/runtime/8.5/` e são copiados no estágio `base` do Dockerfile, então valem para o desenvolvimento e para a produção. Qualquer mudança neles exige rebuild:

```bash
docker compose up -d --build --wait
```

### php.ini

O `php.ini` é copiado como `/usr/local/etc/php/conf.d/zzz-app.ini` e lido depois dos arquivos da imagem. Use-o só para diretivas que a serversideup não expõe como variável de ambiente.

Para as diretivas comuns, prefira as [variáveis da serversideup](https://serversideup.net/open-source/docker-php/docs/reference/environment-variable-specification), que podem mudar por ambiente sem rebuild: no `.env` do servidor (o `compose.production.yaml` repassa ao container) ou no `environment` do `compose.yaml`.

| Variável | Diretiva | Padrão |
|---|---|---|
| `PHP_MEMORY_LIMIT` | `memory_limit` | 256M |
| `PHP_UPLOAD_MAX_FILE_SIZE` | `upload_max_filesize` | 100M |
| `PHP_POST_MAX_SIZE` | `post_max_size` | 100M |
| `PHP_MAX_EXECUTION_TIME` | `max_execution_time` | 0 |
| `PHP_MAX_INPUT_VARS` | `max_input_vars` | 1000 |

Para conferir o valor em uso:

```bash
docker compose exec app php -i | grep memory_limit
```

### app.caddyfile

O `app.caddyfile` é copiado para `/etc/frankenphp/caddyfile-server.d/` e importado dentro do bloco do site, como o `server { }` do nginx. O Caddyfile padrão da imagem (`/etc/frankenphp/Caddyfile`, dentro do container) já faz:

- compressão zstd, br e gzip;
- `X-Frame-Options`, `X-Content-Type-Options` e `Referrer-Policy`, e remove `Server` e `X-Powered-By`;
- cache de 1 ano para css, js, imagens e fontes;
- redirect de `/index.php/caminho` para `/caminho`.

O `app.caddyfile` acrescenta:

- **page cache**: serve o HTML gerado pelo `silber/page-cache` (usado pelo `laravel-turbo`) sem passar pelo PHP, só em `GET` e `HEAD`;
- **index.php**: redireciona qualquer `index.php` (`/index.php`, `/blog/index.php`) para o caminho sem ele;
- **PDF**: cache de 1 ano, como os outros estáticos;
- **cabeçalhos de segurança**, só com `APP_ENV=production` no container (produção e homologação), para não bloquear o Vite no desenvolvimento: `Content-Security-Policy`, `Strict-Transport-Security` e `Permissions-Policy`. Com os cabeçalhos da imagem, são os seis que o [securityheaders.com](https://securityheaders.com) avalia.

A CSP é montada a partir das variáveis do bloco `vars`, uma por diretiva (`csp_script`, `csp_style`, `csp_font` etc.). Para liberar um domínio, acrescente-o na variável certa. Os domínios variam por projeto, então revise as variáveis em cada cliente.

O `'unsafe-eval'` no `csp_script` é necessário: sem ele, o Alpine do Livewire e do Filament não funciona. Por causa dele e do `'unsafe-inline'`, o securityheaders.com dá nota A, e não A+.

O `Permissions-Policy` usa `(self)`, que já é o padrão dos navegadores, então não muda o comportamento do site. Para bloquear um recurso que o projeto não usa, troque por `()`, por exemplo `camera=()`.

Para conferir os cabeçalhos com a stack de produção no ar (troque `8081` pela porta do `APP_PORT`):

```bash
curl -sI http://localhost:8081/ | grep -iE "content-security|strict-transport|permissions-policy"
```

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

1. Pare os containers antigos, já com o novo `compose.yaml`. O `--remove-orphans` remove o antigo serviço `selenium`. Os volumes antigos do MySQL e do Redis não são apagados.

    ```bash
    docker compose down --remove-orphans
    ```

2. No `.env`, remova `WWWUSER`, `WWWGROUP` e `SAIL_XDEBUG_*`. Adicione `USER_ID`, `GROUP_ID`, `XDEBUG_MODE` e `XDEBUG_CONFIG` como no `.env.example`.
3. Copie os dados do MySQL para o volume novo, como em [Volumes do MySQL e do Valkey](#volumes-do-mysql-e-do-valkey).
4. Suba o ambiente e atualize as dependências:

    ```bash
    docker compose up -d --build --wait
    docker compose exec app composer install
    docker compose exec app npm install
    docker compose exec app npx playwright install chromium
    ```

A imagem antiga `sail-8.4/app` é compartilhada por todos os projetos que ainda usam o Sail nessa máquina. Só remova (`docker image rm sail-8.4/app`) se nenhum outro projeto precisar dela.

## Volumes do MySQL e do Valkey

Os dados ficam nos volumes `mysql-data` e `valkey-data`. O serviço de cache continua se chamando `redis` (`REDIS_HOST=redis`), mas usa a imagem do [Valkey](https://valkey.io), compatível com o driver `redis` do Laravel.

Projetos criados antes dessa mudança usavam `sail-mysql` e `sail-redis`. Se o seu projeto ainda tem o volume do MySQL, copie os dados **antes** de subir o ambiente. Se o `docker compose up` rodar antes da cópia, o MySQL é inicializado vazio no volume novo. Os dados do Redis não são copiados: são só cache, e o Valkey não lê o formato gravado pelo Redis 8.

```bash
# veja o prefixo dos volumes antigos (normalmente o nome da pasta do projeto)
docker volume ls --filter name=sail-

PROJETO=nome-do-projeto

docker compose down
docker compose create mysql
docker run --rm -v ${PROJETO}_sail-mysql:/from:ro -v ${PROJETO}_mysql-data:/to --entrypoint sh valkey/valkey:8-alpine -c 'cp -a /from/. /to/'
docker compose up -d --wait
```

O `docker compose create` cria o volume novo sem iniciar o MySQL. A cópia preserva dono e permissões dos arquivos, e os volumes antigos não são alterados.

Se o ambiente já subiu com os volumes novos vazios, rode `docker compose down`, remova o volume novo (`docker volume rm ${PROJETO}_mysql-data`) e repita os comandos acima.

Depois de conferir que os dados estão lá, remova os volumes antigos:

```bash
docker volume rm ${PROJETO}_sail-mysql ${PROJETO}_sail-redis
```

O volume `redis-data`, usado antes da troca para o Valkey, também pode ser removido: `docker volume rm ${PROJETO}_redis-data`.

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
