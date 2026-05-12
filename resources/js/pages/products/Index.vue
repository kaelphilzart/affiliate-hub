<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { Trash2, Edit2 } from 'lucide-vue-next'
import { computed, ref } from 'vue'
import { toast } from 'vue-sonner'
import { Button } from '@/components/ui/button/'
import { Card, CardContent } from '@/components/ui/card'
import { ModalForm } from '@/components/ui/custom-components'
import { Input } from '@/components/ui/input'
import type { ICategory } from '@/types/category'
import type { IProduct, ICreateProduct, IUpdateProduct } from '@/types/product'

import AddProduct from './forms/AddProduct.vue'
import EditProduct from './forms/EditProduct.vue'

/* ================= PROPS ================= */
const props = defineProps<{
    products: IProduct[]
    categories: ICategory[]
}>()

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Products',
            },
        ],
    },
})

/* ================= SEARCH ================= */
const search = ref('')

const filteredProducts = computed(() => {
    if (!search.value) {
        return props.products
    }

    return props.products.filter((p) =>
        p.name.toLowerCase().includes(search.value.toLowerCase()) ||
        p.category?.name?.toLowerCase().includes(search.value.toLowerCase()) ||
        p.type?.toLowerCase().includes(search.value.toLowerCase())
    )
})

const totalProducts = computed(() => filteredProducts.value.length)

/* ================= MODAL ================= */
const isOpenAddForm = ref(false)
const isOpenEditForm = ref(false)

/* ================= FORM ================= */
const addProductData = ref<Partial<ICreateProduct>>({
    name: '',
    category_id: '',
    link: '',
    image: null,
    type: '',
})

const originalEditData = ref<IUpdateProduct | null>(null)
const editProductData = ref<Partial<IUpdateProduct>>({})

/* ================= CREATE ================= */
const handleSubmit = () => {
    router.post('/products', addProductData.value, {
        preserveScroll: true,
        onSuccess: () => {
            isOpenAddForm.value = false

            addProductData.value = {
                name: '',
                category_id: '',
                link: '',
                image: null,
                type: '',
            }

            toast.success('Product created successfully')
        },
        onError: (errors) => {
            console.log(errors)

            const firstError = Object.values(errors)?.[0]

            let message = 'Failed to create product'

            if (Array.isArray(firstError)) {
                message = firstError[0]
            } else if (typeof firstError === 'string') {
                message = firstError
            }

            if (
                message.includes('failed to upload') ||
                message.includes('Failed to upload')
            ) {
                message = 'Image maximum size is 2 MB'
            }

            toast.error(message)
        },
    })
}

/* ================= EDIT ================= */
const handleOpenEdit = (product: IProduct) => {
    const mapped: IUpdateProduct = {
        id: product.id,
        name: product.name,
        category_id: product.category?.id ?? '',
        link: product.link,
        type: product.type,
        image: product.image,
        image_url: product.image_url,
    }

    originalEditData.value = mapped
    editProductData.value = { ...mapped }

    isOpenEditForm.value = true
}

/* ================= UPDATE ================= */
const handleUpdate = () => {
    if (!originalEditData.value) {
        return
    }

    router.put(`/products/${originalEditData.value.id}`, editProductData.value, {
        preserveScroll: true,
        onSuccess: () => {
            isOpenEditForm.value = false
            originalEditData.value = null
            editProductData.value = {}

            toast.success('Product updated successfully')
        },
        onError: (errors) => {
            const firstError = Object.values(errors)?.[0]

            toast.error(
                Array.isArray(firstError)
                    ? firstError[0]
                    : 'Failed to update product',
            )
        },
    })
}

/* ================= DELETE ================= */
const handleDelete = (product: IProduct) => {
    router.delete(`/products/${product.id}`, {
        preserveScroll: true,
        onSuccess: () => toast.success('Product deleted'),
        onError: () => toast.error('Failed to delete product'),
    })
}
</script>

<template>

    <Head title="Products" />

    <div class="p-4">
        <div class="flex items-center justify-between gap-3">
            <!-- SEARCH -->
            <Input v-model="search" type="text" placeholder="Search product / category / type..."
                class="w-72 rounded-md border px-3 py-2 text-sm" />
            <Button variant="default" @click="isOpenAddForm = true">
                + Add
            </Button>
        </div>
        <div class="text-sm text-muted-foreground mt-2">
            Total: {{ totalProducts }}
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 py-4">

            <Card v-for="p in filteredProducts" :key="p.id"
                class="overflow-hidden rounded-xl border bg-white dark:bg-gray-900 dark:border-gray-800 p-0 transition hover:-translate-y-1 hover:shadow-xl">

                <!-- IMAGE -->
                <a :href="`/r/${p.id}`" target="_blank">
                    <div class="aspect-square w-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                        <img :src="p.image_url"
                            class="h-full w-full object-cover transition duration-300 hover:scale-105" />
                    </div>
                </a>

                <CardContent class="p-3 space-y-2">

                    <!-- TOP INFO -->
                    <div class="flex justify-between items-center mb-1">

                        <!-- clicks -->
                        <div class="flex items-center gap-1 text-[11px] text-gray-500 dark:text-gray-400">

                            <!-- cursor click icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 3l7 17 2-7 7-2L8 3z" />
                            </svg>

                            <span class="font-medium">
                                {{ p.clicks ?? 0 }}
                            </span>

                        </div>

                        <!-- category -->
                        <span
                            class="text-[10px] px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 truncate max-w-20">
                            {{ p.category?.name }}
                        </span>

                    </div>

                    <!-- NAME -->
                    <p class="text-sm font-medium leading-tight line-clamp-2 text-gray-900 dark:text-white">
                        {{ p.name }}
                    </p>

                    <!-- ACTION ROW -->
                    <div class="flex items-center justify-between pt-1">

                        <!-- BUTTONS -->
                        <div class="flex gap-1">

                            <Button size="icon" variant="secondary" class="dark:bg-gray-800 dark:text-white"
                                @click="handleOpenEdit(p)">
                                <Edit2 class="w-4 h-4" />
                            </Button>

                            <Button size="icon" variant="destructive" @click="handleDelete(p)">
                                <Trash2 class="w-4 h-4" />
                            </Button>

                        </div>

                        <!-- TYPE LOGO -->
                        <div class="flex items-center">
                            <img v-if="p.type === 'TIKTOK'" src="/logos/tiktok-logo.png"
                                class="h-10 w-10 object-contain" />

                            <img v-else-if="p.type === 'SHOPEE'" src="/logos/shopee-logo.png"
                                class="h-8 w-8 object-contain" />
                        </div>

                    </div>

                </CardContent>

            </Card>

        </div>
    </div>

    <!-- MODAL -->
    <ModalForm :open="isOpenAddForm" title="Tambah Product" :onClose="() => (isOpenAddForm = false)"
        :onSubmit="handleSubmit">
        <AddProduct :formData="addProductData" :onChange="(data) => (addProductData = data)" :categories="categories" />
    </ModalForm>

    <ModalForm :open="isOpenEditForm" title="Edit Product" :onClose="() => (isOpenEditForm = false)"
        :onSubmit="handleUpdate">
        <EditProduct :formData="editProductData" :onChange="(data) => (editProductData = data)" />
    </ModalForm>
</template>