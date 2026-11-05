<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Tests\Feature\Providers;

use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Event;
use Livewire\Component;
use Tests\TestCase;

pest()->extend(TestCase::class);

it('dispatches the reordered event of the table model with the new order', function (): void {
    Event::fake(['eloquent.reordered: ' . User::class]);
    $livewire = new class extends Component implements HasActions, HasSchemas, HasTable
    {
        use InteractsWithActions;
        use InteractsWithSchemas;
        use InteractsWithTable;
    };
    $table = Table::make($livewire)->query(User::query());

    $table->callAfterReordering(['3', '1', '2']);

    Event::assertDispatched(
        'eloquent.reordered: ' . User::class,
        static fn (string $event, array $payload): bool => $payload === [['3', '1', '2']],
    );
});
