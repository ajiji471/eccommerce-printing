<script setup lang="ts">
import BrandName from '@/components/app/BrandName.vue';
import type { SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage<SharedData>();

const navItems = [
    { label: 'Ringkasan', href: '/akun' },
    { label: 'Perangkat', href: '/akun/perangkat' },
];

const styles = {
    shell: 'flex min-h-screen flex-col bg-background',
    header: 'border-b border-border bg-card',
    bar: 'mx-auto flex h-16 w-full max-w-5xl items-center justify-between gap-4 px-4',
    nav: 'hidden items-center gap-1 sm:flex',
    navLink: 'rounded-md px-3 py-2 text-sm font-medium text-muted-foreground hover:bg-muted hover:text-foreground',
    main: 'mx-auto w-full max-w-5xl flex-1 px-4 py-8',
};

const user = computed(() => page.props.auth.user);
</script>

<template>
    <div :class="styles.shell">
        <header :class="styles.header">
            <div :class="styles.bar">
                <Link href="/"><BrandName /></Link>

                <nav :class="styles.nav" aria-label="Navigasi akun">
                    <Link v-for="item in navItems" :key="item.href" :href="item.href" :class="styles.navLink">
                        {{ item.label }}
                    </Link>
                </nav>

                <div class="flex items-center gap-3 text-sm">
                    <span class="font-medium">{{ user?.name }}</span>
                    <Link href="/logout" method="post" as="button" class="text-muted-foreground hover:text-foreground">
                        Keluar
                    </Link>
                </div>
            </div>
        </header>

        <main :class="styles.main">
            <slot />
        </main>
    </div>
</template>
