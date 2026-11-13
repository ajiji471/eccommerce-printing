<?php

use App\Integrations\Gmail\FakeGmailClient;
use App\Integrations\Gmail\GmailClient;
use App\Integrations\Gmail\GmailQuotaExceededException;
use App\Integrations\Gmail\GmailService;

it('mengirim email melalui fake tanpa jaringan', function () {
    config(['gmail.fake' => true, 'gmail.daily_quota' => 10]);

    app(GmailService::class)->send('pembeli@example.com', 'Verifikasi', '<p>Halo</p>', 'MSVA Grafika');

    $client = app(GmailClient::class);

    expect($client)->toBeInstanceOf(FakeGmailClient::class)
        ->and($client->sent())->toHaveCount(1)
        ->and($client->sent()[0]['to'])->toBe('pembeli@example.com')
        ->and($client->sent()[0]['from_name'])->toBe('MSVA Grafika');
});

it('menolak pengiriman ketika kuota harian habis', function () {
    config(['gmail.fake' => true, 'gmail.daily_quota' => 1]);

    $service = app(GmailService::class);

    $service->send('pertama@example.com', 'Satu', '<p>Satu</p>');

    expect(fn () => $service->send('kedua@example.com', 'Dua', '<p>Dua</p>'))
        ->toThrow(GmailQuotaExceededException::class);
});
