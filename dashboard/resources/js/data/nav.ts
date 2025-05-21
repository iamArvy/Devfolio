import { NavItem } from '@/types';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';

export const mainNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: '/profile',
        icon: LayoutGrid,
    },
    {
        title: 'Certifications',
        href: '/certifications',
        icon: LayoutGrid,
    },
    {
        title: 'Experiences',
        href: '/experiences',
        icon: LayoutGrid,
    },
    {
        title: 'Projects',
        href: '/projects',
        icon: LayoutGrid,
    },
    {
        title: 'Stacks',
        href: '/stacks',
        icon: LayoutGrid,
    },
    {
        title: 'Socials',
        href: '/socials',
        icon: LayoutGrid,
    },
];

export const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
