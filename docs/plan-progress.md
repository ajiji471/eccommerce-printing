# Progres Plan

Diperbarui: 13 November 2026

## Status F0 Fondasi

| Tiket | Status | Catatan |
| --- | --- | --- |
| F0-01 Inisialisasi proyek | Selesai | Laravel 12 + Inertia v2 + Vue 3 + shadcn-vue, PHP 8.4, Pest, Pint, Larastan level 6 |
| F0-02 CI/CD | Selesai | `.github/workflows/ci.yml` memakai MariaDB 10.6 dan job `build-release` |
| F0-03 Frontend shell | Selesai | Token ink/coral/paper, layout Storefront/Admin/Platform/Account, komponen app |
| F0-04 Skema inti + tenancy | Selesai | Tabel F0, enum, `TenantContext`, `TenantScope`, `BelongsToTenant`, cast `encrypted` |
| F0-05 Seeder | Selesai | Plan, tenant MSVA/demo, super-admin dari `.env`; idempoten dan diuji |
| F0-06 Resolusi tenant | Selesai | Custom domain, subdomain ketat, landing platform, 404, 503, peran tenant |
| F0-07 Autentikasi | Selesai | Login/register/reset/verifikasi/konfirmasi sandi, redirect per peran, throttle, sesi database, perangkat aktif |
| F0-08 Spike Google Drive | Tertunda | Menunggu kredensial Google Workspace dan akses Shared Drive |
| F0-09 Gmail API + queue email | Selesai (fake) | `GmailClient` + fake, transport kustom, job `emails`/`emails-critical`, kuota harian, `failed_emails` |
| F0-10 RajaOngkir client | Selesai (fake) | Klien HTTP tipis + fake, cache wilayah/tarif, timeout dan retry |
| F0-11 Infrastruktur lintas-modul | Selesai | Channel log, `AuditLogger`, `/up`, halaman error Indonesia, scheduler, helper Pest |
| F0-12 Staging cPanel | Tertunda | Menunggu akses cPanel dan subdomain staging |
| F0-13 Gerbang akhir F0 | Sebagian | Verifikasi lokal lulus (lihat tabel di bawah); gerbang staging menunggu F0-12 |

## Verifikasi lokal 13 November 2026

| Pemeriksaan | Hasil |
| --- | --- |
| `vendor/bin/pint --test` | 118 file lulus |
| `vendor/bin/phpstan analyse` (level 6) | Tidak ada error |
| `vendor/bin/pest` | 51 lulus, 146 asersi |
| `npm run lint:check` dan `npm run typecheck` | Bersih |
| `npm run build` | Sukses, aset di `public/build` |
| `php artisan migrate --seed` (dua kali berturut) | Idempoten: plan `free`/`plan`, tenant `msva`/`demo`, tanpa duplikasi |
| Smoke test `php artisan serve` | `/up` 200, home tenant 200, landing platform 200, host tak dikenal 404 |

Blocker yang tetap terbuka: F0-08 menunggu kredensial Google Workspace dan akses Shared Drive, F0-12 menunggu akses cPanel dan subdomain staging.

## Pekerjaan aktif berikutnya

F1 Katalog menunggu konfirmasi plan-main §2.2 poin 4-6 (PPN, akun Google, kuota Drive) dan penyelesaian F0-08/F0-12.

## Deviasi yang dicatat

- Starter kit resmi Laravel Vue v1.0.2 (Laravel 12, Inertia v2) dipakai sebagai dasar; lihat ADR-0003.
- Klien Gmail dan RajaOngkir ditulis sebagai klien HTTP tipis tanpa paket SDK; lihat ADR-0002.
- MariaDB lokal 11.8.3, sedangkan CI dan target produksi memakai 10.6 dengan collation `utf8mb4_unicode_ci`.
