FROM serversideup/php:8.4-fpm-nginx-v5.1.1

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
