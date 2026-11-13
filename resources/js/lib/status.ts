export type OrderStatus =
    | 'menunggu_pembayaran'
    | 'menunggu_verifikasi'
    | 'diproses'
    | 'produksi'
    | 'siap'
    | 'dikirim'
    | 'selesai'
    | 'dibatalkan'
    | 'dikembalikan';

export const statusMap: Record<OrderStatus, { label: string; tone: string }> = {
    menunggu_pembayaran: { label: 'Menunggu Pembayaran', tone: 'bg-amber-100 text-amber-900' },
    menunggu_verifikasi: { label: 'Menunggu Verifikasi', tone: 'bg-sky-100 text-sky-900' },
    diproses: { label: 'Diproses', tone: 'bg-indigo-100 text-indigo-900' },
    produksi: { label: 'Produksi', tone: 'bg-violet-100 text-violet-900' },
    siap: { label: 'Siap', tone: 'bg-teal-100 text-teal-900' },
    dikirim: { label: 'Dikirim', tone: 'bg-cyan-100 text-cyan-900' },
    selesai: { label: 'Selesai', tone: 'bg-emerald-100 text-emerald-900' },
    dibatalkan: { label: 'Dibatalkan', tone: 'bg-red-100 text-red-900' },
    dikembalikan: { label: 'Dikembalikan', tone: 'bg-orange-100 text-orange-900' },
};
