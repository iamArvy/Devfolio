<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Profile, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    profile: Profile;
}>();

const title = 'Profile';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: title,
        href: '/profile',
    },
];

const form = useForm({
    fullname: props.profile ? props.profile.fullname : '',
    job_description: props.profile ? props.profile.job_description : '',
    bio: props.profile ? props.profile.bio : '',
    phone: props.profile ? props.profile.phone : '',
    email: props.profile ? props.profile.email : '',
    location: props.profile ? props.profile.location : '',
});

const submit = () =>
    props.profile
        ? form.patch(route('profile.update', { profile: props.profile.id }), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          })
        : form.post(route('profile.store'), {
              onSuccess: () => form.reset,
              preserveScroll: true,
          });
</script>

<template>
    <Head :title="title" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form @submit.prevent="submit" class="grid grid-cols-2">
                <!-- <div class="flex flex-col gap-2 p-2">
                    <Label for="image">Image</Label>
                    <ImageInput v-model="form.image" :preview="photoPreview" id="image" />
                    <InputError :message="form.errors.title" />
                </div> -->
                <div class="col-span-2 flex flex-col gap-2 p-2">
                    <Label for="fullname">Full Name</Label>
                    <Input id="title" v-model="form.fullname" placeholder="e.g John Doe Evangelion or John D. Evangelion" />
                    <InputError :message="form.errors.fullname" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="job_description">Job Description</Label>
                    <Input v-model="form.job_description" autocomplete placeholder="e.g Web Developer" />
                    <InputError :message="form.errors.job_description" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="location">Location</Label>
                    <Input v-model="form.location" autocomplete placeholder="e,g Lagos, Nigeria" />
                    <InputError :message="form.errors.location" />
                </div>
                <div class="col-span-2 flex flex-col gap-2 p-2">
                    <Label for="bio">Bio</Label>
                    <Textarea type="month" v-model="form.bio" class="w-full" />
                    <InputError :message="form.errors.bio" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="phone">Phone Number</Label>
                    <Input v-model="form.phone" autocomplete placeholder="+2348012345678" />
                    <InputError :message="form.errors.phone" />
                </div>
                <div class="flex flex-col gap-2 p-2">
                    <Label for="email">Email</Label>
                    <Input v-model="form.email" autocomplete type="email" placeholder="example@example.com" />
                    <InputError :message="form.errors.phone" />
                </div>
                <div class="col-span-2 flex flex-row justify-end gap-2 p-2">
                    <Button type="button" @click="form.reset()">Reset</Button>
                    <Button type="submit">Submit</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
