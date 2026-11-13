<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Tenancy\TenantContext;
use App\Integrations\Gmail\FakeGmailClient;
use App\Integrations\Gmail\GmailClient;
use App\Integrations\Gmail\HttpGmailClient;
use App\Integrations\RajaOngkir\FakeRajaOngkir;
use App\Integrations\RajaOngkir\HttpRajaOngkirClient;
use App\Integrations\RajaOngkir\RajaOngkirClient;
use App\Mail\GmailTransport;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TenantContext::class);

        $this->app->singleton(GmailClient::class, function (): GmailClient {
            if (config('gmail.fake') || $this->app->environment('testing')) {
                return new FakeGmailClient;
            }

            return new HttpGmailClient;
        });

        $this->app->singleton(RajaOngkirClient::class, function (): RajaOngkirClient {
            if (config('rajaongkir.fake') || $this->app->environment('testing')) {
                return new FakeRajaOngkir;
            }

            return new HttpRajaOngkirClient;
        });
    }

    public function boot(): void
    {
        Mail::extend('gmail', fn (): GmailTransport => new GmailTransport);

        Event::listen(NotificationSending::class, function (NotificationSending $event): void {
            if ($event->notification instanceof VerifyEmail || $event->notification instanceof ResetPassword) {
                GmailTransport::markNextAsCritical();
            }
        });

        Event::listen(DiagnosingHealth::class, function (): void {
            DB::connection()->select('select 1');

            Cache::put('health:probe', 'ok', 10);

            if (Cache::get('health:probe') !== 'ok') {
                throw new RuntimeException('Cache tidak merespons.');
            }

            if (! Schema::hasTable('jobs')) {
                throw new RuntimeException('Tabel antrean belum tersedia.');
            }
        });
    }
}
