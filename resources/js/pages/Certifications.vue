<script setup lang="ts">
import EmptyPage from '@/components/EmptyPage.vue';
import Table from '@/components/Table.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import CertificationForm from '@/partials/CertificationForm.vue';
import { Certification, Paginated, type BreadcrumbItem } from '@/types';
import { Cell } from '@/types/table';
import { Head, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
    certifications: Paginated<Certification[]>;
    // categories: Categories
    // filters: PostFilters
}>();

const title = 'Certifications';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: title,
        href: '/certifications',
    },
];

const headers: Cell[] = [
    {
        type: 'text',
        label: 'Name',
    },
    {
        type: 'text',
        label: 'Location',
    },
    {
        type: 'text',
        label: 'Date Acquired',
    },
    {
        type: 'text',
        label: 'Link',
    },
    {
        type: 'text',
        label: 'Delete',
    },
];
const body = computed<Cell[][]>(() => {
    return props.certifications.data.map((item) => [
        // {
        //     type: 'checkbox',
        //     checked: isSelected(order.id),
        //     onChange: (event: Event) => toggleOrderSelection(order.id, event),
        //     label: 'order-checkbox'
        // },
        // {
        //     type: 'component',
        //     component: Form,
        //     props: {
        //         isUpdate: true,
        //         post: post,
        //         categories: props.categories
        //     }
        // },
        {
            type: 'component',
            component: CertificationForm,
            props: {
                isUpdate: true,
                item,
            },
        },
        {
            type: 'text',
            label: item.location,
        },
        {
            type: 'text',
            label: new Date(item.date_acquired + '-01').toLocaleString('en-US', { month: 'long', year: 'numeric' }) ?? '',
        },
        {
            type: 'link',
            label: item.link ?? '',
            href: item.link ?? '',
        },
        {
            type: 'button',
            label: 'Delete',
            variant: 'destructive',
            action: () => router.delete(route('certifications.destroy', item.id)),
        },
    ]);
});
</script>

<template>
    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #page-actions>
            <CertificationForm>
                <Button class="cursor-pointer">Add New</Button>
            </CertificationForm>
        </template>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4" v-if="certifications.data.length > 0">
            <Table :headers="headers" :body="body"></Table>
            <!-- <Pagination :paginated="posts" :filters="filters" /> -->
        </div>
        <EmptyPage v-else>
            <CertificationForm>
                <Button class="cursor-pointer">Create Certification</Button>
            </CertificationForm>
        </EmptyPage>
    </AppLayout>
</template>
