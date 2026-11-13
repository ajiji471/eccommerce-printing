<script setup lang="ts">
import BrandName from '@/components/app/BrandName.vue';
import { Head, Link } from '@inertiajs/vue3';

const features = [
    'Satu platform untuk banyak usaha percetakan',
    'Katalog, pesanan, pembayaran, dan laporan terpisah per toko',
    'Paket FREE dan PLAN dengan batas yang jelas',
];

const styles = {
    page: 'flex min-h-screen flex-col bg-background',
    header: 'border-b border-border bg-card',
    bar: 'mx-auto flex h-16 w-full max-w-5xl items-center justify-between px-4',
    main: 'mx-auto flex w-full max-w-5xl flex-1 flex-col justify-center px-4 py-16',
    title: 'text-3xl font-semibold md:text-4xl',
    text: 'mt-4 max-w-prose text-base text-muted-foreground',
    list: 'mt-8 flex flex-col gap-3 text-sm',
    item: 'rounded-lg border border-border bg-card px-4 py-3',
    actions: 'mt-10 flex gap-3',
    primary: 'rounded-md bg-ink px-5 py-3 text-sm font-semibold text-paper hover:bg-ink/90',
    secondary: 'rounded-md border border-border px-5 py-3 text-sm font-semibold hover:bg-muted',
};
</script>

<template>
    <Head title="Platform" />

    <div :class="styles.page">
        <header :class="styles.header">
            <div :class="styles.bar">
                <BrandName />
                <Link href="/login" :class="styles.primary">Masuk</Link>
            </div>
        </header>

        <main :class="styles.main">
            <h1 :class="styles.title">Platform e-commerce jasa percetakan multi-tenant.</h1>
            <p :class="styles.text">
                Setiap usaha percetakan mendapat ruang kerja sendiri: katalog, harga, pesanan, dan laporan terpisah.
            </p>

            <ul :class="styles.list">
                <li v-for="feature in features" :key="feature" :class="styles.item">{{ feature }}</li>
            </ul>

            <div :class="styles.actions">
                <Link href="/register" :class="styles.primary">Daftar akun</Link>
                <Link href="/login" :class="styles.secondary">Masuk ke akun</Link>
            </div>
        </main>
    </div>
</template>
