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
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Project } from '@/types';

const props = defineProps<{
    isUpdate?: boolean;
    item?: Project;
}>();
const form = useForm({
    name: props.isUpdate && props.item ? props.item.name : '',
    description: props.isUpdate && props.item ? props.item.description : '',
    tags: props.isUpdate && props.item ? props.item.tags : [],
    link: props.isUpdate && props.item ? props.item.link : '',
    repository: props.isUpdate && props.item ? props.item.repository : '',
});

const submit = () =>
    props.isUpdate
        ? form.patch(route('projects.update', { project: props.item?.id }), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          })
        : form.post(route('projects.store'), {
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
                    <Label for="role">Name</Label>
                    <Input id="role" v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="description">Description</Label>
                    <Textarea id="role" v-model="form.description" autocomplete />
                    <InputError :message="form.errors.description" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="link">Link</Label>
                    <Input type="url" v-model="form.link" autocomplete />
                    <InputError :message="form.errors.link" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="repository">Repository</Label>
                    <Input type="url" v-model="form.repository" autocomplete />
                    <InputError :message="form.errors.repository" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="repository">Tags</Label>
                    <TagsInput v-model="form.tags">
                        <TagsInputItem v-for="item in form.tags" :key="item" :value="item">
                            <TagsInputItemText />
                            <TagsInputItemDelete />
                        </TagsInputItem>

                        <TagsInputInput placeholder="Website..." />
                    </TagsInput>
                    <InputError :message="form.errors.tags" />
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
