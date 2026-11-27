# syntax=docker/dockerfile:1

# Base: o que é comum ao desenvolvimento e à produção
FROM serversideup/php:8.5-frankenphp AS base

ENV AUTORUN_LARAVEL_MIGRATION=true \
    AUTORUN_LARAVEL_STORAGE_LINK=true \
    LANG=pt_BR.UTF-8 \
    LANGUAGE=pt_BR:pt \
    LC_ALL=pt_BR.UTF-8 \
    TZ=America/Sao_Paulo \
    PHP_DATE_TIMEZONE=America/Sao_Paulo \
    HEALTHCHECK_PATH=/up \
    ADMIX_QUEUE_ENABLED=false

USER root

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
    && echo ${TZ} > /etc/timezone

RUN apt-get update \
    && apt-get install -y --no-install-recommends locales \
    && sed -i 's/^# *pt_BR.UTF-8 UTF-8/pt_BR.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Binários usados pelo spatie/image-optimizer na otimização das imagens enviadas
RUN apt-get update \
    && apt-get install -y --no-install-recommends jpegoptim optipng pngquant gifsicle webp libavif-bin \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions intl imagick bcmath sockets

COPY .docker/runtime/8.5/php.ini /usr/local/etc/php/conf.d/zzz-app.ini
COPY .docker/runtime/8.5/app.caddyfile /etc/frankenphp/caddyfile-server.d/app.caddyfile

USER www-data

# Desenvolvimento: código via bind mount, Node, Playwright e xdebug
FROM base AS development

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG NODE_VERSION=24

ENV XDEBUG_MODE=off \
    XDEBUG_CONFIG="client_host=host.docker.internal" \
    PLAYWRIGHT_BROWSERS_PATH=0 \
    PUPPETEER_CACHE_DIR=/var/www/html/node_modules/.cache/puppeteer \
    CRITICAL_URL=http://localhost:8080

USER root

RUN install-php-extensions xdebug

RUN apt-get update \
    && apt-get install -y --no-install-recommends ca-certificates curl gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_${NODE_VERSION}.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && npx -y playwright install-deps chromium \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /root/.npm

RUN docker-php-serversideup-set-id www-data ${USER_ID}:${GROUP_ID} \
    && docker-php-serversideup-set-file-permissions --owner ${USER_ID}:${GROUP_ID}

USER www-data

# Produção: código e dependências dentro da imagem, sem Node, xdebug, pacotes de dev nem Composer.
# É o último estágio, então é o target padrão do `docker build`.
FROM base AS production

ENV PHP_OPCACHE_ENABLE=1 \
    AUTORUN_ENABLED=true

WORKDIR /var/www/html

COPY --chown=www-data:www-data composer.json composer.lock ./
COPY --chown=www-data:www-data packages/ packages/

RUN --mount=type=cache,target=/composer/cache,uid=33,gid=33 \
    composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction

COPY --chown=www-data:www-data . .

RUN composer dump-autoload --no-dev --optimize --no-cache

USER root

RUN rm -f /usr/bin/composer

USER www-data
