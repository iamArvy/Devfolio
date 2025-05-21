<script setup lang="ts">
import { Sheet, SheetContent, SheetFooter, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
</script>

<template>
    <Sheet>
        <SheetTrigger as-child>
            <slot name="trigger" />
        </SheetTrigger>
        <SheetContent side="right" class="flex flex-col px-2 max-md:w-full">
            <SheetHeader>
                <SheetTitle>
                    <slot name="title" />
                </SheetTitle>
            </SheetHeader>
            <div class="flex flex-grow flex-col overflow-y-auto">
                <slot name="content" />
            </div>
            <SheetFooter>
                <slot name="footer" />
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
