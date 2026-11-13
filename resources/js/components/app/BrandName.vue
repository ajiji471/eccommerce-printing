<script setup lang="ts">
import type { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    fallback?: string;
}>();

const page = usePage<SharedData>();

const brandName = computed<string>(() => {
    const tenant = page.props.tenant;

    if (tenant?.brand_name) {
        return tenant.brand_name;
    }

    return props.fallback ?? page.props.name;
});
</script>

<template>
    <span class="font-semibold tracking-tight text-ink">{{ brandName }}</span>
</template>
