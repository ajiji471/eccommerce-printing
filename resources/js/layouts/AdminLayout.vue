<script setup lang="ts">
import BrandName from '@/components/app/BrandName.vue';
import type { SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<SharedData>();

const navItems = [
    { label: 'Dashboard', href: '/admin' },
    { label: 'Produk', href: '/admin/produk' },
    { label: 'Kategori', href: '/admin/kategori' },
    { label: 'Stok', href: '/admin/stok' },
    { label: 'Pesanan', href: '/admin/pesanan' },
    { label: 'Pembayaran', href: '/admin/pembayaran' },
    { label: 'Laporan', href: '/admin/laporan' },
    { label: 'Pengaturan', href: '/admin/pengaturan/toko' },
];

const styles = {
    shell: 'flex min-h-screen bg-background',
    sidebar: 'hidden w-60 shrink-0 flex-col border-r border-border bg-card md:flex',
    sidebarBrand: 'flex h-16 items-center border-b border-border px-4',
    nav: 'flex flex-col gap-1 p-3',
    navLink: 'rounded-md px-3 py-2 text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground',
    content: 'flex min-w-0 flex-1 flex-col',
    topbar: 'flex h-16 items-center justify-between border-b border-border bg-card px-4',
    main: 'flex-1 px-4 py-6',
};

const user = computed(() => page.props.auth.user);
</script>

<template>
    <div :class="styles.shell">
        <aside :class="styles.sidebar">
            <div :class="styles.sidebarBrand">
                <BrandName />
            </div>
            <nav :class="styles.nav" aria-label="Navigasi admin">
                <Link v-for="item in navItems" :key="item.href" :href="item.href" :class="styles.navLink">
                    {{ item.label }}
                </Link>
            </nav>
        </aside>

        <div :class="styles.content">
            <header :class="styles.topbar">
                <p class="text-sm text-muted-foreground">Panel Admin</p>
                <div class="flex items-center gap-3 text-sm">
                    <span class="font-medium">{{ user?.name }}</span>
                    <Link href="/logout" method="post" as="button" class="text-muted-foreground hover:text-foreground">
                        Keluar
                    </Link>
                </div>
            </header>

            <main :class="styles.main">
                <slot />
            </main>
        </div>
    </div>
</template>
