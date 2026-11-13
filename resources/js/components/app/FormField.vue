<script setup lang="ts">
defineProps<{
    label: string;
    for?: string;
    error?: string;
    required?: boolean;
}>();

const fieldClass = 'flex flex-col gap-2';
const labelClass = 'text-sm font-medium text-foreground';
const errorClass = 'text-sm text-destructive';
</script>

<template>
    <div :class="fieldClass">
        <label :for="$props.for" :class="labelClass">
            {{ label }}
            <span v-if="required" class="text-coral" aria-hidden="true">*</span>
        </label>
        <slot />
        <p v-if="error" :id="$props.for ? `${$props.for}-error` : undefined" :class="errorClass" role="alert">
            {{ error }}
        </p>
    </div>
</template>
