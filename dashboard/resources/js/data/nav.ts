import { NavItem } from '@/types';
import { BadgeCheck, BookOpen, Briefcase, Folder, FolderKanban, Layers, Share2, User } from 'lucide-vue-next';

export const mainNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: '/profile',
        icon: User,
    },
    {
        title: 'Certifications',
        href: '/certifications',
        icon: BadgeCheck,
    },
    {
        title: 'Experiences',
        href: '/experiences',
        icon: Briefcase,
    },
    {
        title: 'Projects',
        href: '/projects',
        icon: FolderKanban,
    },
    {
        title: 'Stacks',
        href: '/stacks',
        icon: Layers,
    },
    {
        title: 'Socials',
        href: '/socials',
        icon: Share2,
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
