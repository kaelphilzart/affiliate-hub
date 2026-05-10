<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Input from '@/components/ui/input/Input.vue'
import type { ICategory } from '@/types/category'
import type { IProduct } from '@/types/product'


const props = defineProps<{
    canRegister: boolean
    products: IProduct[]
    categories: ICategory[]
}>()

/**
 * SEARCH STATE
 */
const search = ref('')
const selectedCategory = ref<string | null>(null)

/**
 * FILTERED PRODUCTS (NO DEBOUNCE - SIMPLE & CLEAN)
 */
const filteredProducts = computed(() => {
    let result = props.products

    if (search.value) {
        const q = search.value.toLowerCase()

        result = result.filter((p) =>
            p.name?.toLowerCase().includes(q) ||
            p.category?.name?.toLowerCase().includes(q) ||
            p.link?.toLowerCase().includes(q)
        )
    }

    if (selectedCategory.value) {
        result = result.filter((p) => p.category.id === selectedCategory.value)
    }

    return result
})
</script>

<template>

    <Head title="Home" />

    <div class="min-h-screen bg-white dark:bg-black text-black dark:text-white flex justify-center">

        <div class="w-full max-w-md">
            <!-- WRAPPER SEMUA PAGE HERO + SEARCH -->
            <div class="relative">

                <!-- GLOBAL BACKGROUND (dipakai bareng) -->
                <img src="/images/bg-green-pastel.png" class="absolute inset-0 w-full h-full object-cover z-0" />

                <!-- OVERLAY GLOBAL -->
                <div class="absolute inset-0 bg-black/20 z-0"></div>

                <!-- CONTENT ALL -->
                <div class="relative z-10">

                    <!-- SEARCH (IKUT BACKGROUND) -->
                    <div class="sticky top-0 px-4 py-3 z-50">
                        <Input v-model="search" type="text" placeholder="Search link, name, category..." class="
                    w-full
                    bg-white/70
                    dark:bg-black/40
                    backdrop-blur-md
                    border-none
                    shadow-md
                " />
                    </div>

                    <!-- HERO -->
                    <section class="px-5 py-4 text-white">

                        <div class="flex items-start gap-3">

                            <img src="https://images.unsplash.com/photo-1602492665157-639323eadd31?q=80&w=774&auto=format&fit=crop"
                                class="w-20 h-20 rounded-full object-cover shrink-0 border-2 border-white" />

                            <div class="flex-1">
                                <h1 class="text-xl font-bold leading-tight">
                                    Dea Store
                                </h1>

                                <p class="text-xs opacity-90 leading-relaxed mt-2">
                                    Cari produk, klik, dan langsung belanja. Semoga happy shopping 🫶🏻
                                </p>
                            </div>

                        </div>

                        <div v-if="$page.props.auth.user" class="mt-3">
                            <Link href="/dashboard"
                                class="inline-flex px-3 py-1.5 text-xs rounded-full bg-white text-black">
                                Dashboard
                            </Link>
                        </div>

                    </section>

                </div>
            </div>
            <!-- CATEGORY -->
            <section class="mt-3 px-4">
                <div class="flex gap-2 overflow-x-auto no-scrollbar pb-2">
                    <!-- ALL -->
                    <Button @click="selectedCategory = null" :class="[
                        'cursor-pointer shrink-0 px-3 py-1 rounded-full text-xs border bg-white text-black',
                        selectedCategory === null ? 'bg-primary text-balck text-white' : ''
                    ]">
                        All
                    </Button>

                    <!-- CATEGORY -->
                    <Button v-for="c in categories" :key="c.id" @click="selectedCategory = c.id" :class="[
                        'cursor-pointer shrink-0 px-3 py-1 rounded-full text-xs border bg-white text-black',
                        selectedCategory === c.id ? 'bg-primary text-white' : ''
                    ]">
                        {{ c.name }}
                    </Button>

                </div>
            </section>

            <!-- PRODUCTS -->
            <section class="px-4 mt-5 pb-10">

                <div class="grid grid-cols-2 gap-3">

                    <a v-for="p in filteredProducts" :key="p.id" :href="`/r/${p.id}`" target="_blank" class="block">

                        <Card class="overflow-hidden p-0 gap-0 rounded-none cursor-pointer hover:shadow-md transition bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800">

                            <img :src="p.image_url" class="aspect-square w-auto mx-4 object-cover block" />

                            <CardContent class="p-2 pt-1 space-y-0.5">
                                <p class="text-sm leading-tight overflow-hidden mt-2 ml-2" style="
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    line-clamp: 2;
                ">
                                    {{ p.name }}
                                </p>
                            </CardContent>

                        </Card>

                    </a>

                </div>

                <!-- EMPTY STATE -->
                <div v-if="filteredProducts.length === 0" class="text-center text-sm text-gray-400 mt-10">
                    No products found
                </div>

            </section>
        </div>
    </div>
</template>