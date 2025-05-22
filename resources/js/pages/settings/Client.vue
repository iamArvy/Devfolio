<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import CopyButton from '@/components/CopyButton.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Eye, EyeClosed } from 'lucide-vue-next';
import { ref } from 'vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/client',
    },
];

defineProps<{
    client: {
        id: string;
        secret: string;
    };
}>();

const generateClient = () => router.post(route('settings.client.create'));
const refreshClient = () => router.post(route('settings.client.refresh'));
const deleteClient = () => router.delete(route('settings.client.destroy'));
const show = ref<boolean>(false);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall
                    title="Client Settings"
                    description="Use your Client ID and Secret to integrate with the API. Make sure to store them securely in your environment variables."
                />
            </div>
            <div v-if="client !== null" class="space-y-4">
                <div class="flex space-x-3">
                    <Label>Client ID: </Label>
                    <div class="flex space-x-1 p-1">
                        <input readonly :value="client.id" class="w-fit bg-transparent outline-none" />
                        <CopyButton :value="client.id" label="ID" />
                    </div>
                </div>
                <div class="flex space-x-3">
                    <Label>Client Secret:</Label>
                    <div class="flex space-x-1 p-1">
                        <input :type="show ? 'text' : 'password'" readonly :value="client.secret" class="w-fit bg-transparent outline-none" />
                        <Button @click="show = !show" variant="ghost" size="icon">
                            <Eye v-if="show" />
                            <EyeClosed v-else />
                        </Button>
                        <CopyButton :value="client.secret" label="Secret" />
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <Button @click="refreshClient()">Refresh Secret</Button>
                    <Button @click="deleteClient()" variant="destructive">Delete Client</Button>
                </div>
            </div>
            <div v-else>
                <Button size="sm" @click="generateClient()">Generate Client</Button>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
