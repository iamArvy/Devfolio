<script setup lang="ts">
import EmptyPage from '@/components/EmptyPage.vue';
import Table from '@/components/Table.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ExperienceForm from '@/partials/ExperienceForm.vue';
import { Experience, Paginated, type BreadcrumbItem } from '@/types';
import { Cell } from '@/types/table';
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    items: Paginated<Experience[]>;
    // categories: Categories
    // filters: PostFilters
}>();

const title = 'Experiences';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: title,
        href: '/experiences',
    },
];

const headers: Cell[] = [
    {
        type: 'text',
        label: 'Role',
    },
    {
        type: 'text',
        label: 'Location',
    },
    {
        type: 'text',
        label: 'Start Date',
    },
    {
        type: 'text',
        label: 'End Date',
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
            component: ExperienceForm,
            props: {
                isUpdate: true,
                item: item,
            },
        },
        {
            type: 'text',
            label: item.location,
        },
        {
            type: 'text',
            label: new Date(item.start_date + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }) ?? '',
        },
        {
            type: 'text',
            label: new Date(item.end_date + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }) ?? '',
        },
        {
            type: 'button',
            label: 'Delete',
            variant: 'destructive',
            action: () => router.delete(route('experiences.destroy', item.id)),
        },
    ]);
});
</script>

<template>
    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #page-actions>
            <ExperienceForm />
        </template>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4" v-if="items.data.length > 0">
            <Table :headers="headers" :body="body"></Table>
            <!-- <Pagination :paginated="items" :filters="filters" /> -->
        </div>
        <EmptyPage v-else>
            <ExperienceForm />
        </EmptyPage>
    </AppLayout>
</template>
