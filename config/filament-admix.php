<?php

declare(strict_types=1);

use Agenciafmd\Articles\ArticlesPlugin;
use Agenciafmd\Banners\BannersPlugin;
use Agenciafmd\BigNumbers\BigNumbersPlugin;
use Agenciafmd\Faqs\FaqsPlugin;
use Agenciafmd\HttpLogs\HttpLogsPlugin;
use Agenciafmd\Leads\LeadsPlugin;
use Agenciafmd\Partners\PartnersPlugin;
use Agenciafmd\Postal\PostalPlugin;
use Agenciafmd\Redirects\RedirectsPlugin;
use Agenciafmd\Testimonials\TestimonialsPlugin;
use Filament\Support\Colors\Color;
use Illuminate\Support\Str;

return [
    'schedule' => [
        'minutes' => sprintf('%02d', abs(crc32(env('APP_NAME', 'FMD'))) % 60),
    ],
    'timestamp' => [
        'format' => env('ADMIX_TIMESTAMP_FORMAT', 'd/m/Y H:i:s'),
    ],
    'plugins' => [
        ArticlesPlugin::class,
        BannersPlugin::class,
        BigNumbersPlugin::class,
        HttpLogsPlugin::class,
        LeadsPlugin::class,
        PartnersPlugin::class,
        PostalPlugin::class,
        RedirectsPlugin::class,
        TestimonialsPlugin::class,
        FaqsPlugin::class,
    ],
    'colors' => [
        'primary' => Color::Slate,
    ],
    'font' => 'Ubuntu Sans',
];
