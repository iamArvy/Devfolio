<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Sheet from '@/components/Sheet.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Experience } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    isUpdate?: boolean;
    item?: Experience;
}>();
const form = useForm({
    role: props.isUpdate && props.item ? props.item.role : '',
    location: props.isUpdate && props.item ? props.item.location : '',
    // highlights: props.isUpdate && props.item ? props.item.highlights : [],
    start_date: props.isUpdate && props.item ? props.item.start_date : '',
    end_date: props.isUpdate && props.item ? props.item.end_date : '',
    active: props.isUpdate && props.item ? props.item.active : undefined,
});

const submit = () =>
    props.isUpdate
        ? form.patch(route('experiences.update', { experience: props.item?.id }), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          })
        : form.post(route('experiences.store'), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          });
</script>
<template>
    <Sheet>
        <template #trigger>
            <span v-if="isUpdate" class="cursor-pointer hover:underline">{{ props.item?.role }}</span>
            <Button v-else>Add new</Button>
        </template>
        <template #title>
            {{ isUpdate ? props.item?.role : 'Add new' }}
        </template>
        <template #content>
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-2 p-2">
                    <Label for="role">Role</Label>
                    <Input id="role" v-model="form.role" autocomplete="job-role" />
                    <InputError :message="form.errors.role" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="location">Location</Label>
                    <Input id="role" v-model="form.location" autocomplete="location" />
                    <InputError :message="form.errors.location" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="start-date">Start Date</Label>
                    <Input type="month" v-model="form.start_date" class="w-fit" />
                    <InputError :message="form.errors.start_date" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="end-date">End Date</Label>
                    <Input type="month" v-model="form.end_date" class="w-fit" />
                    <InputError :message="form.errors.end_date" />
                </div>
            </form>
        </template>
        <template #footer>
            <div class="flex w-full justify-end space-x-2">
                <Button @click="form.reset()">Reset</Button>
                <Button @click="submit()">Save</Button>
            </div>
        </template>
    </Sheet>
</template>

<style scoped></style>
