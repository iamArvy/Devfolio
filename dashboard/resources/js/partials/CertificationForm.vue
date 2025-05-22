<script setup lang="ts">
import { Label } from '@/components/ui/label';
// import TipTap from "@/Components/TipTap.vue";
import { useForm } from '@inertiajs/vue3';
// import { ref } from 'vue';
// import { ImageInput, Sheet } from "@/partials";
import Sheet from '@/components/Sheet.vue';
import { Input } from '@/components/ui/input';
// import { route } from "@/utils";
// import { Categories } from "@/types";
// import { Post } from "@/types/blog/post";
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { TagsInput, TagsInputInput, TagsInputItem, TagsInputItemDelete, TagsInputItemText } from '@/components/ui/tags-input';
import { Certification } from '@/types';

const props = defineProps<{
    isUpdate?: boolean;
    item?: Certification;
}>();
const form = useForm({
    name: props.isUpdate && props.item ? props.item.name : '',
    location: props.isUpdate && props.item ? props.item.location : '',
    highlights: props.isUpdate && props.item ? props.item.highlights : [],
    date_acquired: props.isUpdate && props.item ? props.item.date_acquired : '',
    // media: null,
    link: props.isUpdate && props.item ? props.item.link : '',
});

// const photoPreview = props.isUpdate ? props.certification?.media : ref(null);

const submit = () =>
    props.isUpdate
        ? form.patch(route('certifications.update', { certification: props.item?.id }), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          })
        : form.post(route('certifications.store'), {
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
                <!-- <div class="flex flex-col gap-2 p-2">
                    <Label for="image">Image</Label>
                    <ImageInput v-model="form.image" :preview="photoPreview" id="image" />
                    <InputError :message="form.errors.title" />
                </div> -->
                <div class="flex flex-col gap-2 p-2">
                    <Label for="title">Name</Label>
                    <Input id="title" v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="category">Location</Label>
                    <Input v-model="form.location" autocomplete />
                    <InputError :message="form.errors.location" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="content">Date Acquired</Label>
                    <Input type="month" v-model="form.date_acquired" autocomplete class="w-fit" />
                    <InputError :message="form.errors.date_acquired" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="link">Link</Label>
                    <Input type="url" v-model="form.link" autocomplete />
                    <InputError :message="form.errors.link" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="highlights">Highlights</Label>
                    <TagsInput v-model="form.highlights">
                        <TagsInputItem v-for="item in form.highlights" :key="item" :value="item">
                            <TagsInputItemText />
                            <TagsInputItemDelete />
                        </TagsInputItem>

                        <TagsInputInput placeholder="I worked on various...." />
                    </TagsInput>
                    <InputError :message="form.errors.highlights" />
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
