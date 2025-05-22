<script setup lang="ts">
import { Copy } from 'lucide-vue-next';
import { toast } from 'vue-sonner';
import { Button } from './ui/button';

const props = defineProps<{
    value: string;
    label: string;
}>();
const copy = async () => {
    try {
        await navigator.clipboard.writeText(props.value);
        toast.success('Success', {
            description: 'Secret Copied to Clipboard',
            style: { borderColor: 'green', color: 'green' },
        });
    } catch (e) {
        console.error('Failed to copy', e);
    }
};
</script>
<template>
    <Button variant="ghost" size="icon" @click="copy()" class="cursor-pointer"><Copy /></Button>
</template>
