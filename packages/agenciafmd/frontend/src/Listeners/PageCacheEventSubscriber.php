<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Listeners;

use Agenciafmd\Articles\Models\Article;
use Agenciafmd\Banners\Models\Banner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelSettings\Events\SettingsSaved;

use function Illuminate\Support\defer;

/**
 * Mantém o cache estático do `silber/page-cache` (middleware `turbo`) em dia:
 * apaga a página afetada assim que o model é salvo, excluído ou restaurado e,
 * depois que a resposta é enviada, faz uma requisição para gerar o cache de novo.
 *
 * Os models e handlers ficam no `subscribe()` e devem ser ajustados em cada projeto.
 */
final class PageCacheEventSubscriber
{
    /**
     * Nome do arquivo que o `silber/page-cache` usa para a home.
     */
    private const string HOME_SLUG = 'pc__index__pc';

    /**
     * Tempo máximo (em segundos) da requisição que gera o cache de novo.
     */
    private const int WARM_UP_TIMEOUT = 5;

    /**
     * @return array<string, list<string>>
     */
    public function subscribe(): array
    {
        /* seeders, imports e filas não limpam o cache; rode `page-cache:clear` depois deles */
        if (app()->runningInConsole()) {
            return [];
        }

        return [
            ...$this->events(Banner::class, ['homeHandler']),
            ...$this->events(Article::class, ['homeHandler', 'modelUrlHandler']),
            /* settings do admix (GTM, Analytics, scripts) aparecem em todas as páginas */
            SettingsSaved::class => ['clearAll'],
        ];
    }

    public function homeHandler(): void
    {
        $this->forget(self::HOME_SLUG);

        $this->warmUp(url('/'));
    }

    public function clearAll(): void
    {
        rescue(static fn (): int => Artisan::call('page-cache:clear'));

        /* já que apagamos tudo, vamos recuperar pelo menos a home */
        $this->warmUp(url('/'));
    }

    /**
     * Limpa uma página específica (path ou URL absoluta) e gera o cache de novo.
     * Use dentro de um handler do projeto, ex.:
     * `public function contactHandler(): void { $this->urlHandler('/contato'); }`.
     */
    public function urlHandler(string $url): void
    {
        $url = url($url);

        $this->forget($this->slugFromUrl($url));

        $this->warmUp($url);
    }

    /**
     * Limpa a página do model (atributo `url`) e, se o endereço mudou
     * (ex.: troca de slug), também a página do endereço antigo.
     *
     * Na reordenação o evento traz a nova ordem (lista de chaves) no lugar do model;
     * a ordem não muda a página de detalhe, então não há o que limpar.
     *
     * @param  Model|list<int|string>  $model
     */
    public function modelUrlHandler(Model|array $model): void
    {
        if (! $model instanceof Model) {
            return;
        }

        $url = $this->modelUrl($model);
        $previousUrl = $this->modelUrl((clone $model)->setRawAttributes($model->getRawOriginal()));

        foreach (array_unique(array_filter([$url, $previousUrl])) as $pageUrl) {
            $this->forget($this->slugFromUrl($pageUrl));
        }

        $this->warmUp($url);
    }

    /**
     * URL da página do model (atributo `url`); `null` quando o model não tem uma.
     */
    private function modelUrl(Model $model): ?string
    {
        $url = $model->getAttribute('url');

        return is_string($url) && $url !== '' ? $url : null;
    }

    /**
     * O `reordered` é disparado pelo `EventServiceProvider` após a reordenação das tabelas do Filament.
     *
     * @param  class-string<Model>  $model
     * @param  list<string>  $handlers
     * @return array<string, list<string>>
     */
    private function events(string $model, array $handlers): array
    {
        return collect(['saved', 'deleted', 'restored', 'reordered'])
            ->mapWithKeys(static fn (string $event): array => ["eloquent.{$event}: {$model}" => $handlers])
            ->all();
    }

    private function forget(string $slug): void
    {
        rescue(static fn (): int => Artisan::call('page-cache:clear', [
            'slug' => $slug,
        ]));
    }

    /**
     * Converte a URL no slug usado pelo `page-cache:clear`. Usa só o path,
     * pois o host do `route()` pode ser diferente do `APP_URL` (ex.: www).
     * A home vira `pc__index__pc`; um slug vazio apagaria o cache inteiro.
     */
    private function slugFromUrl(string $url): string
    {
        $path = mb_trim((string) parse_url($url, PHP_URL_PATH), '/');

        return $path === '' ? self::HOME_SLUG : $path;
    }

    /**
     * Executada depois da resposta (o admin não espera) e uma única vez por URL,
     * mesmo em ações em massa. Falhas são ignoradas: o próximo visitante gera o cache.
     */
    private function warmUp(?string $url): void
    {
        if (blank($url)) {
            return;
        }

        defer(
            static fn (): mixed => rescue(
                static fn (): mixed => Http::timeout(self::WARM_UP_TIMEOUT)->get($url),
                report: false,
            ),
            "page-cache:warm-up:{$url}",
        );
    }
}
