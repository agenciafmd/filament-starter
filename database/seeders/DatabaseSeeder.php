<?php

declare(strict_types=1);

namespace Database\Seeders;

use Agenciafmd\Admix\Models\User;
//use Agenciafmd\Articles\Database\Seeders\ArticleSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        /* remove files from storage/public/fake */
        @rmdir(public_path('storage/fake'));

        Schema::disableForeignKeyConstraints();

        User::factory(100)
            ->create();

        User::factory()
            ->create([
                'name' => 'Irineu Junior',
                'email' => 'irineu@fmd.ag',
            ]);

        $this->call([
//            ArticleSeeder::class,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
