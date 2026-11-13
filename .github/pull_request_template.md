## Ringkasan
<!-- Apa dan mengapa. Rujuk tugas/AC plan-main (mis. F2 – CheckoutService). -->

## Checklist
- [ ] Test unit/feature baru; test isolasi tenant untuk model/endpoint baru
- [ ] `/verify` hijau (Pint, Larastan, test, lint, typecheck, build)
- [ ] Tidak ada float untuk uang; harga/stok/ongkir dihitung ulang di server
- [ ] Perubahan status pesanan lewat `OrderStateMachine`
- [ ] Batas paket ditegakkan di server bila relevan
- [ ] Kredensial terenkripsi, tidak di log
- [ ] Migrasi baru (bukan edit migrasi lama), reversible atau ada catatan
- [ ] `public/build` diperbarui bila ada perubahan frontend
- [ ] `docs/plan-progress.md` diperbarui
