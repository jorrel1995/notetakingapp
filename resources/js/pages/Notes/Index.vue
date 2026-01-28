<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { watch } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type Note } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';

interface PaginatedResponse<T> {
    data: T[];
    links: any[]; // Simplified for now
    meta?: any;
    current_page: number;
    // ... add other pagination fields as needed
}

const props = defineProps<{
    notes: PaginatedResponse<Note>;
    search?: string;
    perPage?: number;
    flash?: {
        success?: string;
        error?: string;
    };
}>();


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Notes',
        href: '/notes',
    },
];

const perPage = ref(props.perPage || 10);
const search = ref(props.search || '');

let searchTimeout: ReturnType<typeof setTimeout>;

watch(search, (value) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(
            '/notes',
            { search: value, perPage: perPage.value },
            { preserveState: true, replace: true }
        );
    }, 300);
});

watch(perPage, (value) => {
    router.get(
        '/notes',
        { search: search.value, perPage: value },
        { preserveState: true, replace: true }
        );
});
</script>

<template>
    <Head title="Notes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
        <button>
            <Link href="/notes/create" class="text-blue-500 hover:underline">Create Note</Link>
        </button>
        </button>
        
        <div v-if="$page.props.flash.success" class="mb-4 rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-800 dark:text-green-100" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ $page.props.flash.success }}</p>
        </div>
        <div v-if="$page.props.flash.error" class="mb-4 rounded-lg bg-red-100 p-4 text-red-700 dark:bg-red-800 dark:text-red-100" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ $page.props.flash.error }}</p>
        </div>

        <div class="flex gap-4 mb-4">
            <input type="text" v-model="search" placeholder="Search notes..." class="border p-2 rounded" />
            <select v-model="perPage" class="border p-2 rounded">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-4"
        >
                <h1 class="text-2xl font-bold mb-4">Notes</h1>
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-left text-sm" v-if="notes.data.length > 0">
                        <thead>
                            <tr class="border-b dark:border-sidebar-border text-sidebar-foreground/70">
                                <th class="pb-2 font-semibold">Title</th>
                                <th class="pb-2 font-semibold">Content</th>
                                <th class="pb-2 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-sidebar-border">
                            <tr v-for="note in notes.data" :key="note.id">
                                <td class="py-3 font-medium">{{ note.title }}</td>
                                <td class="py-3">{{ String(note.content).substring(0, 50) }}...</td>
                                <td class="py-3 text-right">
                                    <button class="mr-2 text-blue-500 hover:underline" @click="router.get(`/notes/${note.id}`)">View</button>
                                    <button
                                        class="mr-2 text-blue-500 hover:underline"
                                        @click="router.get(`/notes/${note.id}/edit`)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        class="text-red-500 hover:underline"
                                        @click="router.delete(`/notes/${note.id}`)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="notes && notes.data.length > 0">
                                <td colspan="3" class="py-3 text-center">
                                    <Pagination :links="notes.links" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-else class="py-3 text-center text-sm text-gray-500">
                        No notes found.
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
