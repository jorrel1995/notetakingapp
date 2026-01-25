<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-neutral-950">
        <nav class="border-b border-gray-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center">
                            <Link href="/notes" class="text-xl font-bold text-gray-900 dark:text-white">
                                NoteApp
                            </Link>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <Link
                                href="/notes"
                                class="inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Notes
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <header v-if="breadcrumbs && breadcrumbs.length > 0" class="bg-white shadow-sm dark:bg-neutral-900">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-4">
                        <li v-for="(item, index) in breadcrumbs" :key="index">
                            <div class="flex items-center">
                                <svg
                                    v-if="index > 0"
                                    class="h-5 w-5 flex-shrink-0 text-gray-300 dark:text-gray-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    aria-hidden="true"
                                >
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                                <Link
                                    :href="item.href"
                                    class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                    :class="{ 'ml-0': index === 0 }"
                                >
                                    {{ item.title }}
                                </Link>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </header>

        <main class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>
