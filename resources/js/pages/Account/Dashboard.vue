<script setup lang="ts">
import AccountLayout from '@/layouts/AccountLayout.vue';
import type { SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps<{
    orderCount: number;
}>();

const page = usePage<SharedData>();
const user = computed(() => page.props.auth.user);

const links = [
    { label: 'Pesanan saya', description: 'Lihat riwayat dan status pesanan.', href: '/akun/pesanan' },
    { label: 'Profil', description: 'Perbarui nama, email, dan nomor telepon.', href: '/akun/profil' },
    { label: 'Alamat', description: 'Kelola alamat pengiriman utama.', href: '/akun/alamat' },
];

const styles = {
    title: 'text-2xl font-semibold',
    subtitle: 'mt-2 text-sm text-muted-foreground',
    grid: 'mt-6 grid gap-4 md:grid-cols-3',
    card: 'rounded-xl border border-border bg-card p-5 hover:border-coral',
    cardTitle: 'text-base font-semibold',
    cardText: 'mt-1 text-sm text-muted-foreground',
};
</script>

<template>
    <Head title="Akun" />

    <AccountLayout>
        <h1 :class="styles.title">Halo, {{ user?.name }}</h1>
        <p :class="styles.subtitle">Anda memiliki {{ orderCount }} pesanan di toko ini.</p>

        <div :class="styles.grid">
            <Link v-for="item in links" :key="item.href" :href="item.href" :class="styles.card">
                <h2 :class="styles.cardTitle">{{ item.label }}</h2>
                <p :class="styles.cardText">{{ item.description }}</p>
            </Link>
        </div>
    </AccountLayout>
</template>
