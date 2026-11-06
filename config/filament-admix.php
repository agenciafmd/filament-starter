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
    /*
     * Lets administrators access the panel as another user (users with a role only).
     */
    'impersonate' => env('ADMIX_IMPERSONATE', true),
    /*
     * Organizations (multi-tenant): each user only sees the organizations they belong to.
     * Administrators (users without a role) access every organization.
     */
    'tenancy' => [
        'enabled' => env('ADMIX_TENANCY', false),
        /*
         * Organization slugs that cannot be used, because the slug also names the subdomain of the organization.
         */
        'reserved_slugs' => [
            'admin',
            'admix',
            'api',
            'app',
            'ftp',
            'mail',
            'pop',
            'pop3',
            'smtp',
            'www',
        ],
    ],
    /*
     * Host of the panel (ex.: app.landingflow.com.br). Empty, the panel answers on every host.
     */
    'domain' => env('ADMIX_DOMAIN'),
    'plugins' => [
        LeadsPlugin::class,
        PostalPlugin::class,
    ],
    'colors' => [
        'primary' => Color::Slate,
    ],
    'font' => 'Ubuntu Sans',
];
