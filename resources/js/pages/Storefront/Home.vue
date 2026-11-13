<script setup lang="ts">
import StorefrontLayout from '@/layouts/StorefrontLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const advantages = [
    {
        title: 'File desain aman',
        description: 'Unggah file desain langsung ke penyimpanan aman, maksimal 600 MB per file.',
    },
    {
        title: 'Ongkir transparan',
        description: 'Tarif pengiriman dihitung dari berat cetakan dan tujuan Anda.',
    },
    {
        title: 'Pesanan terlacak',
        description: 'Pantau status produksi sampai pesanan diterima di tangan Anda.',
    },
];

const styles = {
    hero: 'grid gap-8 rounded-2xl bg-ink px-6 py-12 text-paper md:grid-cols-2 md:px-10',
    heroTitle: 'text-3xl font-semibold leading-tight md:text-4xl',
    heroText: 'mt-4 max-w-prose text-base text-paper/80',
    cta: 'mt-8 inline-flex items-center rounded-md bg-coral px-5 py-3 text-sm font-semibold text-ink hover:bg-coral/90',
    sectionTitle: 'mt-12 text-xl font-semibold',
    grid: 'mt-6 grid gap-4 md:grid-cols-3',
    card: 'rounded-xl border border-border bg-card p-6',
    cardTitle: 'text-base font-semibold',
    cardText: 'mt-2 text-sm text-muted-foreground',
};
</script>

<template>
    <Head title="Beranda" />

    <StorefrontLayout>
        <section :class="styles.hero">
            <div>
                <h1 :class="styles.heroTitle">Cetak cepat, hasil rapi, pesanan terpantau.</h1>
                <p :class="styles.heroText">
                    Pilih produk cetak, unggah desain, dan pantau proses produksi sampai pesanan dikirim.
                </p>
                <Link href="/register" :class="styles.cta">Buat akun</Link>
            </div>
        </section>

        <h2 :class="styles.sectionTitle">Kenapa memesan di sini</h2>
        <div :class="styles.grid">
            <article v-for="item in advantages" :key="item.title" :class="styles.card">
                <h3 :class="styles.cardTitle">{{ item.title }}</h3>
                <p :class="styles.cardText">{{ item.description }}</p>
            </article>
        </div>
    </StorefrontLayout>
</template>
