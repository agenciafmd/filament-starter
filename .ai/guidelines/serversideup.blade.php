@php
/** @var \Laravel\Boost\Install\GuidelineAssist $assist */
@endphp
# Docker (serversideup/php)

- This project runs in Docker with the `serversideup/php` image (NGINX + PHP-FPM). The application container is the `app` service in `compose.yaml`; the image is built from the project's `Dockerfile`.
- There is no wrapper script and no Laravel Sail. You MUST run every PHP, Artisan, Composer, Node and `vendor/bin` command inside the `app` container with `docker compose exec app`. Examples:
    - Artisan: `{{ $assist->artisanCommand('migrate') }}`
    - Composer: `{{ $assist->composerCommand('install') }}`
    - Node: `{{ $assist->nodePackageManagerCommand('run dev') }}`
    - Vendor binaries: `{{ $assist->binCommand('pest') }}`
- Start the services with `docker compose up -d --wait` and stop them with `docker compose stop`. After changing the `Dockerfile`, rebuild with `docker compose up -d --build --wait`.
- The `Dockerfile` has two targets: `development` (used by `compose.yaml`, with Node, the Playwright dependencies and xdebug) and `production` (the default target). Each target starts from the `serversideup/php` image on its own, so keep the PHP extension list of both in sync (`production` has the same list minus xdebug). Never add Node, npm, xdebug, `require-dev` packages or frontend build steps to the `production` target: the production image serves the frontend assets committed in `public/`.
- Inside the container the web server listens on port 8080; on the host it is exposed on `APP_PORT`.
- Regenerate the AI guidelines and skills with `{{ $assist->artisanCommand('boost:update') }}`. Do not run `boost:install`: it resets `"sail": true` in `boost.json`, which this project uses as the Docker command prefix, and rewrites the MCP configuration.
