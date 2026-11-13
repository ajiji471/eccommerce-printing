<?php

use App\Jobs\SendEmailJob;
use App\Models\FailedEmail;

it('mencatat email yang gagal permanen ke tabel failed_emails', function () {
    $job = new SendEmailJob(
        to: 'pembeli@example.com',
        subject: 'Verifikasi',
        html: '<p>Halo</p>',
    );

    $job->failed(new RuntimeException('Koneksi Gmail terputus'));

    $record = FailedEmail::query()->firstOrFail();

    expect($record->to)->toBe('pembeli@example.com')
        ->and($record->subject)->toBe('Verifikasi')
        ->and($record->error)->toContain('Koneksi Gmail terputus');
});
