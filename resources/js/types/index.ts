export * from './auth';

import type { Auth } from './auth';

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    auth: Auth;
    flash: {
        success: string | null;
        error: string | null;
    };
    [key: string]: unknown;
};

export type Note = {
    id: number;
    title: string;
    content: string;
    created_at: string;
    updated_at: string;
};

export type BreadcrumbItem = {
    title: string;
    href: string;
};

