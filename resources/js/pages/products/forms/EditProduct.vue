<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import ListViewSelect from '@/components/ui/custom-components/ListViewSelect.vue'
import { Input } from '@/components/ui/input'
import type { IUpdateProduct } from '@/types/product'

/**
 * PROPS
 */
const props = defineProps<{
  formData?: Partial<IUpdateProduct>
  onChange?: (data: Partial<IUpdateProduct>) => void
}>()

/**
 * STATE
 */
const form = ref<Partial<IUpdateProduct>>({
  name: '',
  link: '',
  image: null,
  type: '',
})

const preview = ref<string | null>(null)

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

  // pakai image_url
  if ((props.formData as any).image_url) {
    preview.value = (props.formData as any).image_url
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

/**
 * FILE HANDLER
 */
const handleFileChange = (e: Event) => {
  const target = e.target as HTMLInputElement
  const file = target.files?.[0]

  if (!file) {
    return
  }

  form.value.image = file

  // cleanup previous preview
  if (preview.value && preview.value.startsWith('blob:')) {
    URL.revokeObjectURL(preview.value)
  }

  preview.value = URL.createObjectURL(file)
}

/**
 * OPTIONS
 */
const types = [
  { label: 'Shopee', value: 'SHOPEE' },
  { label: 'TikTok', value: 'TIKTOK' },
  { label: 'Tokopedia', value: 'TOKOPEDIA' },
]
</script>

<template>
  <div class="space-y-3">

    <!-- NAME -->
    <div>
      <label class="text-sm font-medium">Product Name</label>
      <Input v-model="form.name" />
    </div>

    <!-- LINK -->
    <div>
      <label class="text-sm font-medium">Link</label>
      <Input v-model="form.link" />
    </div>

    <!-- IMAGE -->
    <div>
      <label class="text-sm font-medium">Image</label>

      <Input type="file" accept="image/*" @change="handleFileChange" />

      <div v-if="preview" class="mt-3">
        <img :src="preview" class="h-32 w-32 rounded-lg object-cover border" />
      </div>
    </div>

    <!-- TYPE -->
    <div>
      <ListViewSelect v-model="form.type" :items="types" />
    </div>

  </div>
</template>