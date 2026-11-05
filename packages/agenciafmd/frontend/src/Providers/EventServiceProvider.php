<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Providers;

use Agenciafmd\Frontend\Listeners\PageCacheEventSubscriber;
use Filament\Tables\Table;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Override;

final class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        //
    ];

    protected $subscribe = [
        PageCacheEventSubscriber::class,
    ];

    #[Override]
    public function boot(): void
    {
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
