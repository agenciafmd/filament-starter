<?php

declare(strict_types=1);

use Agenciafmd\Leads\LeadsPlugin;
use Agenciafmd\Postal\PostalPlugin;
use Filament\Support\Colors\Color;

return [
    'schedule' => [
        'minutes' => sprintf('%02d', abs(crc32((string) env('APP_NAME', 'FMD'))) % 60),
    ],
    'timestamp' => [
        'format' => env('ADMIX_TIMESTAMP_FORMAT', 'd/m/Y H:i:s'),
    ],
    'auto_login' => env('ADMIX_AUTO_LOGIN', true),
    'plugins' => [
        LeadsPlugin::class,
        PostalPlugin::class,
    ],
    'colors' => [
        'primary' => Color::Slate,
    ],
    'font' => 'Ubuntu Sans',
];
