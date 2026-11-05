<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Providers;

use Agenciafmd\Frontend\Listeners\PageCacheEventSubscriber;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::subscribe(PageCacheEventSubscriber::class);

        $this->bootReorderEvents();
    }

    /**
     * A reordenação do Filament grava a nova ordem com um `update` via query,
     * que não dispara eventos do Eloquent. Aqui disparamos o evento
     * `eloquent.reordered: {Model}` com a nova ordem (lista de chaves).
     *
     * Uma tabela que definir o próprio `afterReordering()` substitui este callback.
     */
    private function bootReorderEvents(): void
    {
        if (! class_exists(Table::class)) {
            return;
        }

        Table::configureUsing(static function (Table $table): void {
            $table->afterReordering(static function (array $order) use ($table): void {
                $model = $table->getModel();

                if ($model === null) {
                    return;
                }

                event("eloquent.reordered: {$model}", [$order]);
            });
        });
    }
}
