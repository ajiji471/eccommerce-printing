# ADR-0001: Strategi Unggah Google Drive

Status: ditunda
Tanggal: 13 November 2026

## Konteks

Spike F0-08 membutuhkan kredensial Google Workspace (service account dengan Shared Drive atau OAuth refresh token) serta folder uji untuk membandingkan dua strategi unggah langsung dari browser:

- A: service account + Shared Drive.
- B: OAuth refresh token akun platform dengan scope `drive.file`.

## Kondisi Saat Ini

Kredensial belum tersedia. Lingkungan lokal memakai `FILESYSTEM_DISK=local` dan tidak ada klien Drive yang diimplementasikan pada F0.

## Langkah yang Dibutuhkan

1. Sediakan kredensial dan folder uji sesuai pertanyaan terbuka plan 001 nomor 4.
2. Implementasikan `DriveClient` dengan `createResumableSession`, `getFileMetadata`, `delete`, dan `streamDownload`.
3. Uji unggahan 600 MB, jeda-lanjut, dan CORS dari subdomain serta custom domain.
4. Isi hasil pengukuran pada ADR ini dan ubah status menjadi diterima.

Sampai ADR ini diterima, fitur unggah file produksi tidak diaktifkan.
