<?php

declare(strict_types=1);

return [

    'super_admin' => [
        'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
        'email' => env('SUPER_ADMIN_EMAIL'),
        'password' => env('SUPER_ADMIN_PASSWORD'),
    ],

    'msva' => [
        'admin_name' => env('MSVA_ADMIN_NAME', 'Admin MSVA'),
        'admin_email' => env('MSVA_ADMIN_EMAIL'),
        'admin_password' => env('MSVA_ADMIN_PASSWORD'),
    ],

    'demo' => [
        'admin_name' => env('DEMO_ADMIN_NAME', 'Admin Demo'),
        'admin_email' => env('DEMO_ADMIN_EMAIL'),
        'admin_password' => env('DEMO_ADMIN_PASSWORD'),
    ],

];
