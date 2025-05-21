<script setup lang="ts">
import Sonner from '@/components/Sonner.vue';
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <Sonner />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #page-actions>
            <slot name="page-actions"></slot>
        </template>

        <slot />
    </AppLayout>
</template>
