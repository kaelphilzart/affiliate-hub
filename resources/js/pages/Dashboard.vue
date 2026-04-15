<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import { Package, Folder, MousePointerClick } from 'lucide-vue-next'
import { ArrowRight } from 'lucide-vue-next'

defineProps<{
    totalProducts: number
    totalCategories: number
    totalAudienceClick: number
    latestProducts: any[]
    latestCategories: any[]
    hasMoreCategories: boolean
    hasMoreProducts: boolean
}>()

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: '/dashboard',
            },
        ],
    },
})
</script>

<template>

    <Head title="Dashboard" />

    <div class="flex flex-col gap-6 p-4">

        <!-- ================= KPI CARDS ================= -->
        <div class="grid gap-4 md:grid-cols-3">

            <!-- PRODUCTS -->
            <div class="rounded-xl border p-4 bg-white shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Products</p>
                        <p class="text-2xl font-bold">{{ totalProducts }}</p>
                    </div>
                    <Package class="w-6 h-6 text-gray-500" />
                </div>
            </div>

            <!-- CATEGORIES -->
            <div class="rounded-xl border p-4 bg-white shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Categories</p>
                        <p class="text-2xl font-bold">{{ totalCategories }}</p>
                    </div>
                    <Folder class="w-6 h-6 text-gray-500" />
                </div>
            </div>

            <!-- AUDIENCE -->
            <div class="rounded-xl border p-4 bg-white shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Clicks</p>
                        <p class="text-2xl font-bold">{{ totalAudienceClick }}</p>
                    </div>
                    <MousePointerClick class="w-6 h-6 text-gray-500" />
                </div>
            </div>

        </div>

        <!-- ================= CONTENT GRID ================= -->
        <div class="grid gap-4 md:grid-cols-2">

            <!-- LATEST PRODUCTS -->
            <div class="rounded-xl border bg-white p-4">
                <h2 class="mb-3 text-sm font-semibold">Latest Products</h2>

                <div class="space-y-2">
                    <div v-for="p in latestProducts" :key="p.id"
                        class="flex items-center justify-between rounded-md border px-3 py-2">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">
                                {{ p.name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ p.category?.name }}
                            </p>
                        </div>

                        <span class="text-xs text-gray-400">
                            {{ p.type }}
                        </span>
                    </div>
                </div>
                 <!-- VIEW ALL -->
                <div v-if="hasMoreCategories" class="mt-3 flex justify-end">
                    <Link href="/products" class="flex items-center gap-1 text-xs text-blue-600 hover:underline">
                        View all
                        <ArrowRight class="w-3 h-3" />
                    </Link>
                </div>
            </div>

            <!-- LATEST CATEGORIES -->
            <div class="rounded-xl border bg-white p-4">
                <h2 class="mb-3 text-sm font-semibold">Latest Categories</h2>

                <div class="space-y-2">
                    <div v-for="c in latestCategories" :key="c.id"
                        class="flex items-center justify-between rounded-md border px-3 py-2">
                        <p class="text-sm font-medium">
                            {{ c.name }}
                        </p>

                        <span class="text-xs text-gray-400">
                            new
                        </span>
                    </div>
                </div>
                <!-- VIEW ALL -->
                <div v-if="hasMoreCategories" class="mt-3 flex justify-end">
                    <Link href="/categories" class="flex items-center gap-1 text-xs text-blue-600 hover:underline">
                        View all
                        <ArrowRight class="w-3 h-3" />
                    </Link>
                </div>
            </div>

        </div>

    </div>
</template>