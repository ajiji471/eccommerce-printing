# ADR-0003: Starter Kit Resmi Laravel Vue v1.0.2

Status: diterima
Tanggal: 13 November 2026

## Konteks

Plan 001 meminta Laravel 12 dengan Inertia v2 dan shadcn-vue. Percobaan `laravel new --vue` pada versi terbaru memasang Laravel 13, Inertia v3, serta paket tambahan yang tidak ada pada rencana.

## Keputusan

Repositori dibangun dari `laravel/vue-starter-kit` tag `v1.0.2` yang memakai Laravel 12, Inertia v2, Vue 3, TypeScript, Tailwind 3, dan shadcn-vue. Versi yang terpasang diaudit dan dicatat pada `composer.lock` serta `package-lock.json`.

## Konsekuensi

- Stack sesuai plan-main dan seluruh tiket F0 dibangun di atas kerangka ini.
- Halaman contoh starter yang tidak dipakai dihapus; layout aplikasi memakai komponen yang sudah ada.
- Peningkatan ke Laravel 13 dilakukan pada plan terpisah setelah F0 stabil.
