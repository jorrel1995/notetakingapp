<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const props = defineProps({
    note: {
        type: Object,
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Notes',
        href: '/notes',
    },
    {
        title: props.note.title,
        href: `/notes/${props.note.id}`,
    },
];

const formatDate = (dateString: string) => {
    if (!dateString) return '';
    const date = new Date(dateString);
    const offset = date.getTimezoneOffset() * 60000;
    return (new Date(date.getTime() - offset)).toISOString().slice(0, 16);
};

const editNote = () => {
    useForm().get(`/notes/${props.note.id}/edit`);
}

const deleteNote = () => {
    useForm().delete(`/notes/${props.note.id}`);
}

const backToNotes = () => {
    useForm().get('/notes');
}

</script>

<template>
    <Head title="View Note" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6">
            <div class="mx-auto w-full max-w-2xl">
                <div
                    class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-neutral-800 dark:bg-neutral-900"
                >
                    <div class="mb-6 text-center">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            View Note
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            View the details of your note.
                        </p>
                    <div class="flex gap-4 justify-center">
                    <div>
                        <button
                            type="button"
                            @click="editNote"
                            class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 disabled:opacity-50 sm:w-auto dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800"
                        >
                            <span>Edit Note</span>
                        </button>
                    </div>
                    <div>
                        <button
                            type="button"
                            @click="deleteNote"
                            class="inline-flex w-full justify-center rounded-lg bg-red-600 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 disabled:opacity-50 sm:w-auto dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800"
                        >
                            <span>Delete Note</span>
                        </button>
                    </div>  
                    <div>
                        <button
                            type="button"
                            @click="backToNotes"
                            class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 disabled:opacity-50 sm:w-auto dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800"
                        >
                            <span>Back to Notes</span>
                        </button>
                    </div>
                    </div>
                    </div>


                    <form class="space-y-6">
                        <div>
                            <label
                                for="title"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200"
                                >Title</label
                            >
                            <input
                                type="text"
                                id="title"
                                :value="note.title"
                                readonly
                                disabled
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-white dark:placeholder-neutral-400 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="Enter note title..."
                            />
                        </div>

                        <div>
                            <label
                                for="content"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200"
                                >Content</label
                            >
                            <textarea
                                id="content"
                                :value="note.content"
                                rows="6"
                                readonly
                                disabled
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-white dark:placeholder-neutral-400 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="Write your thoughts here..."
                            ></textarea>
                        </div>

                        <div>
                            <label
                                for="created_at"
                                class="mb-2 block text-sm font-medium text-gray-900 dark:text-gray-200"
                                >Created At</label
                            >
                            <input
                                type="datetime-local"
                                id="created_at"
                                :value="formatDate(note.created_at)"
                                readonly
                                disabled
                                class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-800 dark:text-white dark:placeholder-neutral-400 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                            />                            
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>