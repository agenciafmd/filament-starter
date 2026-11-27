@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp
# Docker (serversideup/php)

- This project runs in Docker with the `serversideup/php` image, FrankenPHP variant (Caddy + PHP, classic mode), in both the `development` and `production` targets. The application container is the `app` service in `compose.yaml`; the image is built from `.docker/runtime/8.5/Dockerfile`, with the project root as the build context.
- There is no wrapper script and no Laravel Sail. You MUST run every PHP, Artisan, Composer, Node and `vendor/bin` command inside the `app` container with `docker compose exec app`. Examples:
    - Artisan: `{{ $assist->artisanCommand('migrate') }}`
    - Composer: `{{ $assist->composerCommand('install') }}`
    - Node: `{{ $assist->nodePackageManagerCommand('run dev') }}`
    - Vendor binaries: `{{ $assist->binCommand('pest') }}`
- Start the services with `docker compose up -d --wait` and stop them with `docker compose stop`. After changing the Dockerfile, rebuild with `docker compose up -d --build --wait`.
- The Dockerfile is multi-stage: `base` (the `serversideup/php` image, the PHP extensions, the `pt_BR.UTF-8` locale and the `America/Sao_Paulo` timezone), `development` (built from `base` and used by `compose.yaml`, adding xdebug, Node, the Playwright dependencies and the `www-data` UID/GID of the host) and `production` (built from `base`, the last stage and the default target). Put anything both targets need in `base`, so the image tag and the PHP extension list stay in one place. The FrankenPHP PHP is thread-safe (ZTS), so any new extension must be thread-safe too. Never add Node, npm, xdebug, `require-dev` packages or frontend build steps to the `production` target: the production image serves the frontend assets committed in `public/`.
- Inside the container the web server listens on port 8080; on the host it is exposed on `APP_PORT`.
- Regenerate the AI guidelines and skills with `{{ $assist->artisanCommand('boost:update') }}`. Do not run `boost:install`: it resets `"sail": true` in `boost.json`, which this project uses as the Docker command prefix, and rewrites the MCP configuration.
