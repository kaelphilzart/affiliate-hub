<script setup lang="ts">
import {
  DropdownMenu,
  DropdownMenuTrigger,
  DropdownMenuContent,
  DropdownMenuItem,
} from '@/components/ui/dropdown-menu'

interface ListViewItem {
  label: string
  value: string
}

const props = defineProps<{
  modelValue: string | undefined | null
  items: ListViewItem[]
  placeholder?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | undefined): void
}>()

/* ================= SELECTED LABEL ================= */
const selectedLabel = (value?: string | null) => {
  return props.items.find((i) => i.value === value)?.label
}
</script>

<template>
  <DropdownMenu>

    <!-- TRIGGER -->
    <DropdownMenuTrigger as-child>
      <button
        class="
          w-full
          flex items-center justify-between
          px-3 py-2
          text-sm text-left
          rounded-md
          border border-gray-300 dark:border-gray-700
          bg-white dark:bg-gray-900
          text-gray-900 dark:text-white
          hover:border-gray-400 dark:hover:border-gray-600
          transition
        "
      >
        <span class="truncate">
          {{ selectedLabel(modelValue) || placeholder || 'Select...' }}
        </span>

        <span class="text-xs text-gray-400">▼</span>
      </button>
    </DropdownMenuTrigger>

    <!-- CONTENT -->
    <DropdownMenuContent
      class="
        w-(--reka-dropdown-menu-trigger-width)
        min-w-(--reka-dropdown-menu-trigger-width)
        p-1
        rounded-md
        border border-gray-200 dark:border-gray-800
        bg-white dark:bg-gray-900
        shadow-lg
      "
    >

      <DropdownMenuItem
        v-for="item in items"
        :key="item.value"
        class="
          cursor-pointer
          px-2 py-2
          text-sm
          rounded-md
          text-gray-700 dark:text-gray-200
          hover:bg-gray-100 dark:hover:bg-gray-800
          transition
        "
        @click="emit('update:modelValue', item.value)"
      >
        <span class="w-full truncate">
          {{ item.label }}
        </span>
      </DropdownMenuItem>

    </DropdownMenuContent>

  </DropdownMenu>
</template>