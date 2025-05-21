<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Sheet from '@/components/Sheet.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Stack } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
    isUpdate?: boolean;
    item?: Stack;
}>();
const form = useForm({
    name: props.isUpdate && props.item ? props.item.name : '',
    icon: props.isUpdate && props.item ? props.item.icon : '',
    link: props.isUpdate && props.item ? props.item.link : '',
});

const submit = () =>
    props.isUpdate
        ? form.patch(route('stacks.update', { stack: props.item?.id }), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          })
        : form.post(route('stacks.store'), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          });
</script>
<template>
    <Sheet>
        <template #trigger>
            <span v-if="isUpdate" class="cursor-pointer hover:underline">{{ props.item?.name }}</span>
            <Button v-else>Add new</Button>
        </template>
        <template #title>
            {{ isUpdate ? props.item?.name : 'Add new' }}
        </template>
        <template #content>
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-2 p-2">
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="icon">Icon</Label>
                    <Input id="icon" v-model="form.icon" autocomplete />
                    <InputError :message="form.errors.icon" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="link">Link</Label>
                    <Input type="url" v-model="form.link" autocomplete />
                    <InputError :message="form.errors.link" />
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
