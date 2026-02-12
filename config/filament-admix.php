<?php

declare(strict_types=1);

use Agenciafmd\Articles\ArticlesPlugin;
use Agenciafmd\Banners\BannersPlugin;
use Agenciafmd\Postal\PostalPlugin;
use Agenciafmd\Redirects\RedirectsPlugin;

return [
    'schedule' => [
        'minutes' => mb_substr(base_convert((string) env('APP_NAME'), 36, 5), 0, 2),
    ],
    'timestamp' => [
        'format' => env('ADMIX_TIMESTAMP_FORMAT', 'd/m/Y H:i:s'),
    ],
    'plugins' => [
        ArticlesPlugin::class,
        BannersPlugin::class,
        PostalPlugin::class,
        RedirectsPlugin::class,
    ],
];
