<p align="center"><a href="https://fmd.ag/?utm_source=github" target="_blank"><img src="https://raw.githubusercontent.com/agenciafmd/starter/v11/public/vendor/admix-ui/images/fmd.svg" width="250" alt="Agência F&MD Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/dt/agenciafmd/filament-starter" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/agenciafmd/filament-starter"><img src="https://img.shields.io/packagist/l/agenciafmd/filament-starter" alt="License"></a>
</p>

## O que é?

Este é o esqueleto de desenvolvimento dos nossos sites e apps.

## Requisitos

Estamos usando o [Laravel Sail](https://laravel.com/docs/11.x/sail) para desenvolvimento.

Veja mais na nossa documentação:

https://agenciafmd.github.io/docs/sail/

## Criando o projeto

Para começar, crie o projeto com o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer create-project agenciafmd/filament-starter:dev-master --ignore-platform-reqs nome-do-projeto
```

> O `v12.x-dev` no comando, irá garantir que a versão 11 do Laravel será usada.


## Instalando o projeto

Quando clonamos o projeto, o Laravel Sail já está configurado. Para instalar as dependências, basta rodar o comando:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
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

## Banco não encontrado?

Por padrão, agora usamos o SQLite, então você pode criar o banco com o comando:

```bash
touch database/database.sqlite
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

## Vai codar front-end?

Acesse a [documentação específica](./resources/README.md).

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
