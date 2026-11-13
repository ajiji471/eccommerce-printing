<?php

use App\Integrations\RajaOngkir\FakeRajaOngkir;
use App\Integrations\RajaOngkir\RajaOngkirClient;

it('memakai fake RajaOngkir pada lingkungan test', function () {
    config(['rajaongkir.fake' => true]);

    $client = app(RajaOngkirClient::class);

    expect($client)->toBeInstanceOf(FakeRajaOngkir::class);
});

it('mengembalikan tarif dari fake', function () {
    config(['rajaongkir.fake' => true]);

    $costs = app(RajaOngkirClient::class)->cost('3471', '3471', 1000, 'jne');

    expect($costs)->toBeArray()
        ->and($costs[0]['code'])->toBe('jne')
        ->and($costs[0]['costs'][0]['cost'][0]['value'])->toBe(18000);
});

it('mengembalikan daftar provinsi dari fake', function () {
    config(['rajaongkir.fake' => true]);

    $provinces = app(RajaOngkirClient::class)->provinces();

    expect($provinces)->not->toBeEmpty()
        ->and($provinces[0])->toHaveKeys(['province_id', 'province']);
});
