<script setup lang="ts">
import BrandName from '@/components/app/BrandName.vue';
import { Link } from '@inertiajs/vue3';

const navItems = [
    { label: 'Ringkasan', href: '/platform' },
    { label: 'Tenant', href: '/platform/tenants' },
    { label: 'Paket', href: '/platform/plans' },
    { label: 'Audit', href: '/platform/audit' },
];

const styles = {
    shell: 'flex min-h-screen flex-col bg-background',
    header: 'border-b border-border bg-ink text-paper',
    bar: 'mx-auto flex h-16 w-full max-w-6xl items-center justify-between gap-4 px-4',
    nav: 'flex items-center gap-1',
    navLink: 'rounded-md px-3 py-2 text-sm font-medium text-paper/80 hover:bg-white/10 hover:text-paper',
    main: 'mx-auto w-full max-w-6xl px-4 py-8',
};
</script>

<template>
    <div :class="styles.shell">
        <header :class="styles.header">
            <div :class="styles.bar">
                <div class="flex items-center gap-3">
                    <BrandName />
                    <span class="rounded bg-white/10 px-2 py-0.5 text-xs">Platform</span>
                </div>

                <nav :class="styles.nav" aria-label="Navigasi platform">
                    <Link v-for="item in navItems" :key="item.href" :href="item.href" :class="styles.navLink">
                        {{ item.label }}
                    </Link>
                    <Link href="/logout" method="post" as="button" :class="styles.navLink">Keluar</Link>
                </nav>
            </div>
        </header>

        <main :class="styles.main">
            <slot />
        </main>
    </div>
</template>
