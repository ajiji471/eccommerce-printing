<script setup lang="ts">
import { useMoney } from '@/composables/useMoney';
import { computed } from 'vue';

const props = defineProps<{
    amount: number | null | undefined;
}>();

const { format } = useMoney();

const display = computed(() => format(props.amount));
</script>

<template>
    <span class="tabular-nums">{{ display }}</span>
</template>
