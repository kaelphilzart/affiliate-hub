<script setup lang="ts">
import { ref, watch, onMounted, computed } from 'vue'
import { ICreateProduct } from '@/types/product'
import { ICategory } from '@/types/category'
import { Input } from '@/components/ui/input'
import { ListViewSelect } from '@/components/ui/custom-components'

const props = defineProps<{
    formData?: Partial<ICreateProduct>
    onChange?: (data: Partial<ICreateProduct>) => void
    categories: ICategory[]
}>()

const STORAGE_KEY = 'add_product_form'

/* ================= FORM STATE ================= */
const form = ref<Partial<ICreateProduct>>({
    name: '',
    category_id: undefined,
    link: '',
    image: null,
    type: '',
})

/* ================= INIT ================= */
onMounted(() => {
    const saved = localStorage.getItem(STORAGE_KEY)

    if (saved) {
        try {
            form.value = {
                ...form.value,
                ...JSON.parse(saved),
            }
        } catch {}
    }

    if (props.formData) {
        form.value = {
            ...form.value,
            ...props.formData,
        }
    }
})

/* ================= SYNC ================= */
watch(
    form,
    (val) => {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(val))
        props.onChange?.(val)
    },
    { deep: true }
)

/* ================= CATEGORY ================= */
const categoryItems = computed(() =>
    props.categories.map((c) => ({
        label: c.name,
        value: c.id,
    }))
)

/* ================= TYPES ================= */
const types = [
    { label: 'Shopee', value: 'SHOPEE' },
    { label: 'TikTok', value: 'TIKTOK' },
    { label: 'Tokopedia', value: 'TOKOPEDIA' },
]

/* ================= IMAGE ================= */
const preview = ref<string | null>(null)

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement
    const file = target.files?.[0]

    if (!file) return

    form.value.image = file

    if (preview.value) {
        URL.revokeObjectURL(preview.value)
    }

    preview.value = URL.createObjectURL(file)
}
</script>

<template>
    <div class="space-y-5">

        <!-- NAME -->
        <div class="space-y-1">
            <label class="text-xs font-medium text-gray-600 dark:text-gray-300">
                Product Name
            </label>
            <Input
                v-model="form.name"
                placeholder="Enter product name"
                class="dark:bg-gray-900 dark:border-gray-700"
            />
        </div>

        <!-- CATEGORY -->
        <div class="space-y-1">
            <label class="text-xs font-medium text-gray-600 dark:text-gray-300">
                Category
            </label>

            <ListViewSelect
                v-model="form.category_id"
                :items="categoryItems"
                placeholder="Pilih kategori"
            />
        </div>

        <!-- LINK -->
        <div class="space-y-1">
            <label class="text-xs font-medium text-gray-600 dark:text-gray-300">
                Link
            </label>
            <Input
                v-model="form.link"
                placeholder="https://example.com"
                class="dark:bg-gray-900 dark:border-gray-700"
            />
        </div>

        <!-- IMAGE -->
        <div class="space-y-2">
            <label class="text-xs font-medium text-gray-600 dark:text-gray-300">
                Image
            </label>

            <Input
                type="file"
                accept="image/*"
                @change="handleFileChange"
                class="dark:bg-gray-900 dark:border-gray-700"
            />

            <div v-if="preview" class="mt-2">
                <img
                    :src="preview"
                    class="h-28 w-28 rounded-lg object-cover border dark:border-gray-700"
                />
                <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">
                    Preview image
                </p>
            </div>
        </div>

        <!-- TYPE -->
        <div class="space-y-1">
            <label class="text-xs font-medium text-gray-600 dark:text-gray-300">
                Platform
            </label>

            <ListViewSelect
                v-model="form.type"
                :items="types"
                placeholder="Pilih platform"
            />
        </div>

    </div>
</template>