<script setup lang="ts">
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import { SidebarInset, SidebarProvider } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

import { SharedData } from '@/types';
import { usePage } from '@inertiajs/vue3';

const isOpen = usePage<SharedData>().props.sidebarOpen;
</script>

<template>
    <SidebarProvider :default-open="isOpen">
        <AppSidebar />
        <SidebarInset>
            <AppSidebarHeader :breadcrumbs="breadcrumbs">
                <template #page-actions>
                    <slot name="page-actions"></slot>
                </template>
            </AppSidebarHeader>
            <slot />
        </SidebarInset>
    </SidebarProvider>
</template>
