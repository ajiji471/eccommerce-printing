<script setup lang="ts">
import MoneyText from '@/components/app/MoneyText.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    stats: {
        newOrders: number;
        awaitingVerification: number;
        revenueThisMonth: number;
        lowStock: number;
    };
}>();

const styles = {
    title: 'text-2xl font-semibold',
    subtitle: 'mt-2 text-sm text-muted-foreground',
    grid: 'mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4',
    card: 'rounded-xl border border-border bg-card p-5',
    cardLabel: 'text-sm text-muted-foreground',
    cardValue: 'mt-2 text-2xl font-semibold',
};
</script>

<template>
    <Head title="Dashboard Admin" />

    <AdminLayout>
        <h1 :class="styles.title">Dashboard</h1>
        <p :class="styles.subtitle">Ringkasan operasional toko hari ini.</p>

        <div :class="styles.grid">
            <div :class="styles.card">
                <p :class="styles.cardLabel">Pesanan baru</p>
                <p :class="styles.cardValue">{{ stats.newOrders }}</p>
            </div>
            <div :class="styles.card">
                <p :class="styles.cardLabel">Menunggu verifikasi</p>
                <p :class="styles.cardValue">{{ stats.awaitingVerification }}</p>
            </div>
            <div :class="styles.card">
                <p :class="styles.cardLabel">Pendapatan bulan ini</p>
                <p :class="styles.cardValue"><MoneyText :amount="stats.revenueThisMonth" /></p>
            </div>
            <div :class="styles.card">
                <p :class="styles.cardLabel">Stok menipis</p>
                <p :class="styles.cardValue">{{ stats.lowStock }}</p>
            </div>
        </div>
    </AdminLayout>
</template>
