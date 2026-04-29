<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import { Input } from '@/components/ui/input'
import type { ICategoryUpdate } from '@/types/category';

/**
 * PROPS
 */
const props = defineProps<{
    formData?: Partial<ICategoryUpdate>
    onChange?: (data: Partial<ICategoryUpdate>) => void
}>()

/**
 * STATE
 */
const form = ref<Partial<ICategoryUpdate>>({
    name: '',
    slug: '',
})


/**
 * INIT STATE FROM PROPS (SAFE)
 */
onMounted(() => {
    if (!props.formData) {
return
}

    form.value = {
        ...form.value,
        ...props.formData,
    }
})

/**
 * SYNC TO PARENT (SAFE + CLONED)
 */
watch(
    form,
    (val) => {
        props.onChange?.({ ...val })
    },
    { deep: true }
)

</script>

<template>
    <div class="space-y-3">

        <!-- NAME -->
        <div>
            <label class="text-sm font-medium">Category Name</label>
            <Input v-model="form.name" />
        </div>

        <!-- SLUG -->
        <div>
            <label class="text-sm font-medium">Slug</label>
            <Input v-model="form.slug" />
        </div>

    </div>
</template>