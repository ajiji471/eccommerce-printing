<script setup lang="ts">
import FormField from '@/components/app/FormField.vue';
import AccountLayout from '@/layouts/AccountLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

interface ActiveSession {
    id: string;
    ip_address: string | null;
    user_agent: string | null;
    last_activity: string;
    is_current: boolean;
}

defineProps<{
    sessions: ActiveSession[];
}>();

const form = useForm({
    password: '',
});

const logoutOthers = () => {
    form.post('/akun/perangkat/logout-lain', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const formatActivity = (value: string) => new Date(value).toLocaleString('id-ID');

const styles = {
    title: 'text-2xl font-semibold',
    subtitle: 'mt-2 text-sm text-muted-foreground',
    list: 'mt-6 divide-y divide-border rounded-xl border border-border bg-card',
    row: 'flex flex-col gap-1 p-4',
    meta: 'text-sm text-muted-foreground',
    badge: 'inline-flex w-fit rounded-full bg-muted px-2 py-0.5 text-xs font-medium text-foreground',
    form: 'mt-6 max-w-md space-y-4',
    input: 'w-full rounded-md border border-input bg-background px-3 py-2 text-sm',
    button: 'rounded-md bg-coral px-4 py-2 text-sm font-semibold text-white hover:opacity-90 disabled:opacity-50',
};
</script>

<template>
    <Head title="Perangkat aktif" />

    <AccountLayout>
        <h1 :class="styles.title">Perangkat aktif</h1>
        <p :class="styles.subtitle">Daftar sesi yang sedang masuk dengan akun Anda.</p>

        <ul :class="styles.list">
            <li v-for="session in sessions" :key="session.id" :class="styles.row">
                <p class="text-sm font-medium">{{ session.user_agent ?? 'Perangkat tidak dikenal' }}</p>
                <p :class="styles.meta">
                    IP {{ session.ip_address ?? '-' }} &middot; Aktivitas terakhir {{ formatActivity(session.last_activity) }}
                </p>
                <span v-if="session.is_current" :class="styles.badge">Perangkat ini</span>
            </li>
        </ul>

        <form :class="styles.form" @submit.prevent="logoutOthers">
            <FormField label="Kata sandi saat ini" for="password" :error="form.errors.password" required>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    autocomplete="current-password"
                    :class="styles.input"
                />
            </FormField>

            <button type="submit" :class="styles.button" :disabled="form.processing">Keluarkan perangkat lain</button>
        </form>
    </AccountLayout>
</template>
