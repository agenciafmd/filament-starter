# Desenvolvimento: código via bind mount, Node, Playwright e xdebug
FROM serversideup/php:8.4-fpm-nginx-v5.1.1 AS development

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG NODE_VERSION=24

ENV XDEBUG_MODE=off

USER root

RUN install-php-extensions intl imagick bcmath sockets xdebug

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
# É o target padrão do `docker build`.
FROM serversideup/php:8.4-fpm-nginx-v5.1.1 AS production

ENV HEALTHCHECK_PATH=/up \
    PHP_OPCACHE_ENABLE=1 \
    AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_MIGRATION=false

USER root

# Mesmas extensões do development, sem o xdebug
RUN install-php-extensions intl imagick bcmath sockets

USER www-data

WORKDIR /var/www/html

COPY --chown=www-data:www-data composer.json composer.lock ./
COPY --chown=www-data:www-data packages/ packages/

RUN composer install --no-dev --no-scripts --no-autoloader --no-cache --prefer-dist --no-interaction

COPY --chown=www-data:www-data . .

RUN composer dump-autoload --no-dev --optimize --no-cache

USER root

RUN rm -f /usr/bin/composer

USER www-data
