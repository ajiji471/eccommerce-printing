import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User | null;
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

export interface Tenant {
    id: number;
    slug: string;
    display_name: string;
    brand_name: string;
    logo_url: string | null;
    accent_color: string | null;
    footer: string | null;
    plan: 'free' | 'plan' | null;
    own_branding: boolean;
    ppn_percent: string | null;
    active_couriers: string[];
}

export interface Flash {
    success: string | null;
    error: string | null;
}

export interface SharedData {
    name: string;
    locale: string;
    auth: Auth;
    tenant: Tenant | null;
    flash: Flash;
    ziggy: {
        location: string;
        url: string;
        port: null | number;
        defaults: Record<string, unknown>;
        routes: Record<string, string>;
    };
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    phone: string | null;
    avatar?: string;
    email_verified: boolean;
    email_verified_at?: string | null;
    is_super_admin: boolean;
    is_admin: boolean;
    created_at?: string;
    updated_at?: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
