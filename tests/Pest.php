<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Sleep;
use Illuminate\Support\Str;
use Tests\TestCase;

pest()->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->beforeEach(function (): void {
        Str::createRandomStringsNormally();
        Str::createUuidsNormally();
        Http::preventStrayRequests();
        Process::preventStrayProcesses();
        Sleep::fake();

        $this->freezeTime();
    })
    ->in('Browser', 'Feature', 'Unit');

pest()->tia()
    ->defaultBranch('master');

/*
 * Os testes de packages/agenciafmd/* só rodam quando o pacote está instalado no composer do projeto;
 * os clones locais que não estão instalados têm os testes pulados.
 */
foreach (glob(__DIR__ . '/../packages/agenciafmd/*/tests', GLOB_ONLYDIR) ?: [] as $packageTestsPath) {
    $packageName = basename(dirname($packageTestsPath));

    if (InstalledVersions::isInstalled("agenciafmd/{$packageName}")) {
        continue;
    }

    pest()->beforeEach(function () use ($packageName): void {
        $this->markTestSkipped("agenciafmd/{$packageName} não está instalado no projeto.");
    })->in("../packages/agenciafmd/{$packageName}/tests");
}

expect()->extend('toBeOne', fn () => $this->toBe(1));

function something(): void
{
    // ..
}
