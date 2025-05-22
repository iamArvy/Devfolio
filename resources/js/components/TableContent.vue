<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Cell } from '@/types/table';
import { Link } from '@inertiajs/vue3';
defineProps<{
    cell: Cell;
}>();
</script>
<template>
    <template v-if="cell.type === 'text'">
        <span :class="cell.action ? 'hover:underline' : ''" @click="cell.action">{{ cell.label }}</span>
    </template>
    <template v-if="cell.type === 'checkbox'">
        <input type="checkbox" class="form-checkbox" :checked="cell.checked" @change="cell.onChange" />
    </template>
    <template v-if="cell.type === 'link'">
        <Link v-if="cell.href" :href="cell.href">{{ cell.label }}</Link>
    </template>
    <template v-if="cell.type === 'image'">
        <img v-if="cell.src" :src="cell.src" :alt="cell.label" />
    </template>
    <template v-if="cell.type === 'button'">
        <Button @click="cell.action" :variant="cell.variant ? cell.variant : 'default'">{{ cell.label }}</Button>
    </template>
    <template v-else-if="cell.type === 'component'">
        <component :is="cell.component" v-bind="cell.props" />
    </template>
</template>
