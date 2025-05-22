import { Component, DefineComponent } from 'vue';

interface BaseCell {
    type: 'checkbox' | 'link' | 'image' | 'button' | 'component' | 'text';
    class?: string;
}

interface TextCell extends BaseCell {
    type: 'text';
    label: string;
    action?: () => void;
}

interface ButtonCell extends BaseCell {
    type: 'button';
    label: string;
    variant?: 'link' | 'default' | 'destructive' | 'outline' | 'secondary' | 'ghost';
    action?: () => void;
}

interface ComponentCell extends BaseCell {
    type: 'component';
    component: DefineComponent<any, any, any> | Component;
    props?: Record<string, any>;
}

interface LinkCell extends BaseCell {
    type: 'link';
    label: string;
    href: string;
}

interface ImageCell extends BaseCell {
    type: 'image';
    src: string;
    label?: string;
}

interface CheckboxCell extends BaseCell {
    type: 'checkbox';
    checked?: boolean;
    onChange?: (event: Event) => void;
    label?: string;
}

export type Cell = TextCell | ButtonCell | ComponentCell | LinkCell | ImageCell | CheckboxCell;
