<?php

declare(strict_types=1);

return [

    'api_key' => env('RAJAONGKIR_API_KEY'),
    'base_url' => env('RAJAONGKIR_BASE_URL', 'https://api.rajaongkir.com/starter'),
    'timeout' => (int) env('RAJAONGKIR_TIMEOUT', 5),
    'fake' => (bool) env('RAJAONGKIR_FAKE', false),

    'cache' => [
        'region' => 60 * 60 * 24 * 7,
        'cost' => 60 * 10,
    ],

];
