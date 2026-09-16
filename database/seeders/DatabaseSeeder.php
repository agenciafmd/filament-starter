<?php

declare(strict_types=1);

namespace Database\Seeders;

use Agenciafmd\Admix\Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        /* remove files from storage/public/fake */
        File::cleanDirectory(storage_path('app/public/fake'));

        Schema::disableForeignKeyConstraints();

        $this->call([
            //            ArticleSeeder::class,
        ]);

        UserFactory::new()
            ->create([
                'name' => 'Irineu Junior',
                'email' => 'irineu@fmd.ag',
            ]);

        Schema::enableForeignKeyConstraints();
    }
}
