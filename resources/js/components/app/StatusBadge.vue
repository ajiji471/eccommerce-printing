<script setup lang="ts">
import type { OrderStatus } from '@/lib/status';
import { statusMap } from '@/lib/status';
import { computed } from 'vue';

const props = defineProps<{
    status: OrderStatus | string;
}>();

const base = 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium';

const current = computed(() => {
    if (props.status in statusMap) {
        return statusMap[props.status as OrderStatus];
    }

    return { label: props.status, tone: 'bg-muted text-muted-foreground' };
});
</script>

<template>
    <span :class="[base, current.tone]">{{ current.label }}</span>
</template>
