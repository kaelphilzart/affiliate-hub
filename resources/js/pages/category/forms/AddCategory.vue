<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import { ICategoryCreate } from '@/types/category';
import { Input } from '@/components/ui/input'

const props = defineProps<{
    formData?: Partial<ICategoryCreate>
    onChange?: (data: Partial<ICategoryCreate>) => void
}>()

const STORAGE_KEY = 'add_category_form'

/**
 * LOCAL STATE (source of truth)
 */
const form = ref<Partial<ICategoryCreate>>({
    name: '',
    slug: '',
})

/**
 * INIT from parent OR draft
 */
onMounted(() => {
    const saved = localStorage.getItem(STORAGE_KEY)

    if (saved) {
        try {
            form.value = {
                ...form.value,
                ...JSON.parse(saved),
            }
        } catch { }
    }

    if (props.formData) {
        form.value = {
            ...form.value,
            ...props.formData,
        }
    }
})

/**
 * AUTO SAVE DRAFT + SYNC TO PARENT
 */
watch(
    form,
    (val) => {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(val))
        props.onChange?.(val)
    },
    { deep: true }
)

</script>
<template>
    <div class="space-y-3">

        <!-- NAME -->
        <div>
            <label class="text-sm font-medium">Category Name</label>
            <Input v-model="form.name" placeholder="Enter category name" />
        </div>

        <div>
            <label class="text-sm font-medium">Slug</label>
            <Input v-model="form.slug" placeholder="Enter category slug" />
        </div>
    </div>
</template>