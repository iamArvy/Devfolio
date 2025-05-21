import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Client {
    id: string;
    secret: string;
    created_at: string;
    updated_at: string;
}

export interface Profile {
    id: number;
    fullname: string;
    job_description: string;
    bio: string;
    phone: string;
    email: string;
    location: string;
    user_id: string;
    created_at: string;
    updated_at: string;
}

export interface Experience {
    id: number;
    role: string;
    location: string;
    highlights?: string[];
    start_date?: string;
    end_date?: string;
    active?: boolean;
    user_id: string;
    created_at: string;
    updated_at: string;
}

export interface Social {
    id: number;
    name: string;
    value: string;
    icon?: string;
    link?: string;
    user_id: string;
    created_at: string;
    updated_at: string;
}

export interface Certification {
    id: number;
    name: string;
    location: string;
    highlights?: string[];
    date_acquired?: string;
    media?: string;
    link?: string;
    user_id: string;
    created_at: string;
    updated_at: string;
}

export interface Stack {
    id: number;
    name: string;
    link?: string;
    icon?: string;
    user_id: number;
    created_at: string;
    updated_at: string;
}

export interface Project {
    id: number;
    name: string;
    description?: string;
    link?: string;
    repository?: string;
    tags?: string[];
    user_id: number;
    created_at: string;
    updated_at: string;
}
export type BreadcrumbItemType = BreadcrumbItem;

export type Paginated<T> = {
    current_page: number;
    data: T;
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    next_page_url: string;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
};

export interface Flash {
    success: string;
    error: string;
    message: string;
}
