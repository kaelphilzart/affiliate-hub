<script setup lang="ts">
import {
  Dialog,
  DialogTrigger,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter,
  DialogClose,
  DialogOverlay,
} from '@/components/ui/dialog'

const props = defineProps<{
  title?: string
  description?: string
  open?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:open', value: boolean): void
}>()
</script>

<template>
  <Dialog :open="open" @update:open="(val) => emit('update:open', val)">

    <!-- TRIGGER -->
    <DialogTrigger as-child>
      <slot name="trigger" />
    </DialogTrigger>

    <!-- OVERLAY -->
    <DialogOverlay class="fixed inset-0 bg-black/60" />

    <!-- CONTENT -->
    <DialogContent
      class="
        w-[95vw]
        sm:w-full sm:max-w-lg
        max-h-[90vh]
        overflow-y-auto
        rounded-2xl
        bg-white dark:bg-gray-900
        shadow-xl
        border border-gray-200 dark:border-gray-800
        p-4 sm:p-6
      "
    >

      <!-- HEADER -->
      <DialogHeader class="space-y-1">
        <DialogTitle class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
          {{ title }}
        </DialogTitle>

        <DialogDescription
          v-if="description"
          class="text-xs sm:text-sm text-gray-500 dark:text-gray-400"
        >
          {{ description }}
        </DialogDescription>
      </DialogHeader>

      <!-- BODY -->
      <div class="py-3 sm:py-4">
        <slot />
      </div>

      <!-- FOOTER -->
      <DialogFooter
        class="
          flex flex-col sm:flex-row
          gap-2 sm:gap-3
          justify-end
          border-t border-gray-200 dark:border-gray-800
          pt-3
        "
      >
        <slot name="footer">
          <DialogClose as-child>
            <button
              class="
                w-full sm:w-auto
                px-4 py-2 text-sm
                rounded-md
                bg-gray-100 dark:bg-gray-800
                text-gray-700 dark:text-gray-200
                hover:bg-gray-200 dark:hover:bg-gray-700
                transition
              "
            >
              Cancel
            </button>
          </DialogClose>
        </slot>
      </DialogFooter>

    </DialogContent>
  </Dialog>
</template>