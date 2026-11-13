# ADR-0002: Klien Integrasi Gmail dan RajaOngkir Tanpa SDK

Status: diterima
Tanggal: 13 November 2026

## Konteks

Plan 001 menyebut `google/apiclient` dan `nicxonsolutions/rajaongkir`. Instalasi paket tambahan tertahan oleh masalah jaringan saat pengembangan lokal, dan paket RajaOngkir belum dipastikan mendukung PHP 8.4/Laravel 12.

## Keputusan

- `GmailClient` dan `RajaOngkirClient` didefinisikan sebagai interface domain.
- Implementasi produksi memakai `Illuminate\Support\Facades\Http` dengan OAuth refresh token (Gmail) dan header `key` (RajaOngkir).
- Implementasi `FakeGmailClient` dan `FakeRajaOngkir` dipakai pada test dan lingkungan lokal.
- Timeout, retry, cache, kuota, dan pencatatan kegagalan ditangani di lapisan klien.

## Konsekuensi

- Tidak ada ketergantungan SDK tambahan pada F0; kebutuhan SDK dapat ditinjau ulang ketika endpoint nyata diuji di staging.
- Bentuk respons mengikuti API RajaOngkir Starter (`rajaongkir.results`) dan akan diverifikasi dengan panggilan nyata pada F0-10 di staging.
- Gmail memakai endpoint `users/me/messages/send` dengan pesan MIME yang di-encode base64url.
