<script setup lang="ts">
import PlatformLayout from '@/layouts/PlatformLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    stats: {
        tenants: number;
        activeTenants: number;
        suspendedTenants: number;
    };
}>();

const styles = {
    title: 'text-2xl font-semibold',
    subtitle: 'mt-2 text-sm text-muted-foreground',
    grid: 'mt-6 grid gap-4 sm:grid-cols-3',
    card: 'rounded-xl border border-border bg-card p-5',
    cardLabel: 'text-sm text-muted-foreground',
    cardValue: 'mt-2 text-2xl font-semibold',
};
</script>

<template>
    <Head title="Platform" />

    <PlatformLayout>
        <h1 :class="styles.title">Ringkasan platform</h1>
        <p :class="styles.subtitle">Pantau jumlah tenant dan statusnya.</p>

        <div :class="styles.grid">
            <div :class="styles.card">
                <p :class="styles.cardLabel">Total tenant</p>
                <p :class="styles.cardValue">{{ stats.tenants }}</p>
            </div>
            <div :class="styles.card">
                <p :class="styles.cardLabel">Tenant aktif</p>
                <p :class="styles.cardValue">{{ stats.activeTenants }}</p>
            </div>
            <div :class="styles.card">
                <p :class="styles.cardLabel">Tenant ditangguhkan</p>
                <p :class="styles.cardValue">{{ stats.suspendedTenants }}</p>
            </div>
        </div>
    </PlatformLayout>
</template>
