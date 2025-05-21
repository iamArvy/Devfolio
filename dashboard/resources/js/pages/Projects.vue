<script setup lang="ts">
import EmptyPage from '@/components/EmptyPage.vue';
import Table from '@/components/Table.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ProjectForm from '@/partials/ProjectForm.vue';
import { Paginated, Project, type BreadcrumbItem } from '@/types';
import { Cell } from '@/types/table';
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    items: Paginated<Project[]>;
    // categories: Categories
    // filters: PostFilters
}>();

const title = 'Projects';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: title,
        href: '/projects',
    },
];

const headers: Cell[] = [
    {
        type: 'text',
        label: 'Name',
    },
    {
        type: 'text',
        label: 'Repository',
    },
    {
        type: 'text',
        label: 'Link',
    },
    {
        type: 'text',
        label: 'Tags',
    },
    {
        type: 'text',
        label: 'Delete',
    },
];
const body = computed<Cell[][]>(() => {
    return props.items.data.map((item) => [
        // {
        //     type: 'checkbox',
        //     checked: isSelected(order.id),
        //     onChange: (event: Event) => toggleOrderSelection(order.id, event),
        //     label: 'order-checkbox'
        // },
        {
            type: 'component',
            component: ProjectForm,
            props: {
                isUpdate: true,
                item: item,
            },
        },
        {
            type: 'text',
            label: item.repository ?? '',
        },
        {
            type: 'text',
            label: item.link ?? '',
        },
        {
            type: 'text',
            label: item.tags?.join(', ') ?? '',
        },
        {
            type: 'button',
            label: 'Delete',
            variant: 'destructive',
            action: () => router.delete(route('projects.destroy', item.id)),
        },
    ]);
});
</script>

<template>
    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #page-actions>
            <ProjectForm />
        </template>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4" v-if="items.data.length > 0">
            <Table :headers="headers" :body="body"></Table>
            <!-- <Pagination :paginated="items" :filters="filters" /> -->
        </div>
        <EmptyPage v-else>
            <ProjectForm />
        </EmptyPage>
    </AppLayout>
</template>
