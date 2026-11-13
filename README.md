# MSVA Web

Platform e-commerce percetakan multi-tenant (Laravel 12, Inertia v2, Vue 3, TypeScript, shadcn-vue).

[![CI](https://github.com/ajiji471/eccommerce-printing/actions/workflows/ci.yml/badge.svg)](https://github.com/ajiji471/eccommerce-printing/actions/workflows/ci.yml)

## Persyaratan

- PHP 8.4 dengan ekstensi `mbstring`, `pdo_mysql`, `intl`, `gd`, `zip`, `exif`
- Composer 2
- Node.js 22 dan npm
- MariaDB 10.6+ (lokal boleh lebih baru), database `msva_web` dan `msva_test` dengan collation `utf8mb4_unicode_ci`

## Instalasi lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate --seed
```

Isi kredensial admin pada `.env` sebelum menjalankan seeder:

- `SUPER_ADMIN_EMAIL`, `SUPER_ADMIN_PASSWORD` untuk super-admin platform
- `MSVA_ADMIN_EMAIL`, `MSVA_ADMIN_PASSWORD` untuk admin tenant `msva`
- `DEMO_ADMIN_EMAIL`, `DEMO_ADMIN_PASSWORD` untuk admin tenant `demo`

Tanpa nilai tersebut seeder melewati pembuatan admin dan menampilkan peringatan.

## Host lokal

| Host | Fungsi |
| --- | --- |
| `msva.platform.test` | Storefront tenant MSVA Grafika |
| `demo.platform.test` | Storefront tenant demo (paket FREE) |
| `platform.test` | Landing platform dan panel super-admin |

Tambahkan pemetaan host ke `127.0.0.1` pada file hosts sistem.

## Perintah kualitas

```bash
composer test          # config:clear + Pest (MariaDB msva_test)
./vendor/bin/pint --test
./vendor/bin/phpstan analyse
npm run lint:check
npm run typecheck
npm run build
```

## Antrean dan penjadwal

Antrean memakai tabel `jobs` dan dijalankan lewat cron:

```bash
php artisan queue:work --stop-when-empty --max-time=55
php artisan schedule:run
```

Email keluar memakai Gmail API melalui `GmailClient`. Selama kredensial belum diisi, gunakan `GMAIL_FAKE=true` pada lingkungan pengembangan.

## Struktur singkat

- `app/Domain/Tenancy` — konteks tenant, scope global, layanan batas paket
- `app/Integrations` — klien Gmail dan RajaOngkir beserta fake untuk test
- `app/Http/Middleware/ResolveTenant.php` — resolusi tenant dari host
- `resources/js/layouts` — layout Storefront, Admin, Platform, Account
- `.github/workflows/ci.yml` — pipeline kualitas dan artefak rilis

## Lisensi

Perangkat lunak milik MSVA Grafika. Seluruh hak dilindungi.
