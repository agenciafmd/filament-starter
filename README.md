<p align="center"><a href="https://fmd.ag/?utm_source=github" target="_blank"><img src="https://raw.githubusercontent.com/agenciafmd/starter/v11/public/vendor/admix-ui/images/fmd.svg" width="250" alt="Agência F&MD Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/dt/agenciafmd/filament-starter" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/l/agenciafmd/filament-starter" alt="License"></a>
</p>

## O que é?

Este é o esqueleto de desenvolvimento dos nossos sites e apps.

## Requisitos

Estamos usando o [Laravel Sail](https://laravel.com/docs/13.x/sail) para desenvolvimento.

Veja mais na nossa documentação:

https://agenciafmd.github.io/docs/sail/

## Criando o projeto

Para começar, crie o projeto com o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer:2 \
    composer create-project agenciafmd/filament-starter:dev-master --ignore-platform-reqs --no-scripts nome-do-projeto
```

> Usamos a imagem oficial `composer:2` porque ela já vem com o PHP 8.5, exigido pelo projeto e pelos pacotes da agência. As imagens `laravelsail/phpXX-composer` param no PHP 8.4 e quebram no `package:discover`. O `--ignore-platform-reqs` dispensa as extensões que só existem no container do Sail, e o `--no-scripts` evita que o `create-project` tente subir o Sail de dentro do container do Composer; os passos abaixo fazem o que esses scripts fariam.

Em seguida, prepare o projeto:

```bash
cd nome-do-projeto
cp .env.example .env
sail up -d
sail artisan key:generate
sail artisan migrate
```

## Instalando o projeto

Quando clonamos o projeto, o Laravel Sail já está configurado. Para instalar as dependências, basta rodar o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer:2 \
    composer install --ignore-platform-reqs
```

> A imagem oficial `composer:2` já vem com PHP 8.5, então os scripts do Composer rodam normalmente. O `--ignore-platform-reqs` dispensa as extensões que só existem no container do Sail.

Depois, crie o `.env` e suba os containers:

```bash
cp .env.example .env
sail up -d
```

## Gerando a chave da aplicação

Após clonar o projeto ou configurar o ambiente pela primeira vez, é necessário gerar a chave de criptografia da aplicação.

```bash
sail artisan key:generate
```

## Alimentando o projeto

Alimente o projeto com dados fictícios usando o comando:

```bash
sail artisan migrate:fresh --seed
```

Com o banco alimentado, instale as dependências do front-end e gere os assets:

```bash
sail npm ci
sail npm run build
sail npm run build:filament
```

## Banco não encontrado?

Por padrão, usamos o MySQL do Sail (configurado no `.env.example`). O banco é criado quando o container sobe, então garanta que o ambiente está rodando antes das migrations:

```bash
sail up -d
```

## Imagens quebradas?

Linke corretamente o `storage` para o public:

```bash
sail artisan storage:link
```

## SVGs não carregando?

Limpe o cache com o comando abaixo:

```bash
sail artisan cache:clear
```

## Alterei no admix e o site não mudou?

As páginas com a middleware `turbo` são gravadas em `public/page-cache` e servidas direto pelo servidor web. O `PageCacheEventSubscriber` do pacote `frontend` limpa as páginas quando um model é salvo, excluído, restaurado ou reordenado no admix — ajuste os models monitorados no `subscribe()` dele ao criar novos recursos ([ver mais](./packages/agenciafmd/frontend/README.md#limpeza-do-cache-estático-pagecacheeventsubscriber)).

Alterações feitas pelo console (seeders, imports, filas) não limpam o cache. Nesse caso, rode:

```bash
sail artisan page-cache:clear
```

## Onde configuro o GTM, o Analytics, o Search Console, o Pixel da Meta e os scripts?

No admix, menu **Configurações** (somente administradores), pelo pacote [`filament-settings`](./packages/agenciafmd/filament-settings/README.md). O `GOOGLE_TAGMANAGER` e o `GOOGLE_SITE_VERIFICATION` do `.env` não são mais usados.

## Vai codar front-end?

Acesse a [documentação específica](./resources/README.md).

## Conheça nossa família

- [Área Administrativa](https://github.com/agenciafmd/admix)
- [Banners](https://github.com/agenciafmd/admix-banners)
- [Email](https://github.com/agenciafmd/admix-postal)
- [e mais](https://github.com/agenciafmd?utf8=%E2%9C%93&q=admix-&type=&language=)

## Requisitos do projeto

- Versão do PHP: **^8.5**
- Versão do Laravel: **13**
- Versão do Node: **24+**

## Licença

Nossos pacotes são abertos, [MIT](https://opensource.org/licenses/MIT) para os
mais chegados.
