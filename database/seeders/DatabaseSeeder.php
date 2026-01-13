<?php

declare(strict_types=1);

namespace Database\Seeders;

use Agenciafmd\Admix\Models\User;
use Agenciafmd\Articles\Database\Seeders\ArticleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)
            ->create();

        User::factory()
            ->create([
                'name' => 'Irineu Junior',
                'email' => 'irineu@fmd.ag',
            ]);

        $this->call([
            ArticleSeeder::class,
        ]);
    }
}
