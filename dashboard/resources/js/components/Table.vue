<script setup lang=ts>
import type { Cell } from '.';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
  } from '@/components/ui/table'
    import TableContent from './TableContent.vue';
    defineProps <{
        headers: Cell[],
        body: Cell[][],
    }>()
</script>

<template>
    <Table>
        <TableHeader>
        <TableRow>
            <TableHead v-for="(cell, index ) in headers" :key="index" :class="cell.class ?? null">
                <TableContent :cell="cell" />
            </TableHead>
        </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="(item, index) in body" :key="index">
                <TableCell v-for="(cell, index) in item" :key="index" :class="cell.class ?? null">
                    <TableContent :cell="cell" />
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>
</template>
