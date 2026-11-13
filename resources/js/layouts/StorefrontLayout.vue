<script setup lang="ts">
import BrandName from '@/components/app/BrandName.vue';
import type { SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<SharedData>();

const navItems = [
    { label: 'Beranda', href: '/' },
    { label: 'Katalog', href: '/produk' },
    { label: 'Pesanan Saya', href: '/akun/pesanan' },
];

const styles = {
    header: 'border-b border-border bg-card',
    bar: 'mx-auto flex h-16 w-full max-w-6xl items-center justify-between gap-4 px-4',
    nav: 'hidden items-center gap-1 md:flex',
    navLink: 'rounded-md px-3 py-2 text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground',
    action: 'rounded-md bg-ink px-4 py-2 text-sm font-medium text-paper hover:bg-ink/90',
    main: 'mx-auto w-full max-w-6xl px-4 py-8',
    footer: 'mt-12 border-t border-border bg-ink text-paper',
    footerInner: 'mx-auto w-full max-w-6xl px-4 py-6 text-sm',
};

const user = computed(() => page.props.auth.user);
const tenant = computed(() => page.props.tenant);
</script>

<template>
    <div class="flex min-h-screen flex-col bg-background">
        <header :class="styles.header">
            <div :class="styles.bar">
                <Link href="/" class="flex items-center gap-2">
                    <BrandName />
                </Link>

                <nav :class="styles.nav" aria-label="Navigasi utama">
                    <Link v-for="item in navItems" :key="item.href" :href="item.href" :class="styles.navLink">
                        {{ item.label }}
                    </Link>
                </nav>

                <div class="flex items-center gap-2">
                    <Link v-if="!user" href="/login" :class="styles.action">Masuk</Link>
                    <Link v-else href="/akun" :class="styles.action">{{ user.name }}</Link>
                </div>
            </div>
        </header>

        <main :class="styles.main">
            <slot />
        </main>

        <footer :class="styles.footer">
            <div :class="styles.footerInner">
                {{ tenant?.footer ?? 'Layanan cetak cepat dan rapi untuk kebutuhan bisnis Anda.' }}
            </div>
        </footer>
    </div>
</template>
