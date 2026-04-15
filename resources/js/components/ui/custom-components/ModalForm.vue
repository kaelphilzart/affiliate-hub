<script setup lang="ts">
import { BaseModal } from '.';
import { Button } from '../button';

const props = defineProps<{
  open: boolean
  title: string
  onClose: () => void
  onSubmit: () => void
}>()
</script>

<template>
  <BaseModal
    :open="open"
    :title="title"
    @update:open="(val) => !val && onClose()"
  >

    <!-- CONTENT -->
    <div class="p-1 sm:p-2">
      <slot />
    </div>

    <!-- FOOTER -->
    <template #footer>
      <div class="flex flex-col sm:flex-row sm:justify-end gap-2 sm:gap-3 border-t border-gray-200 dark:border-gray-800 pt-3">

        <Button
          variant="ghost"
          class="w-full sm:w-auto px-4 py-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
          @click="onClose"
        >
          Batal
        </Button>

        <Button
          class="w-full sm:w-auto px-4 py-2 rounded-md bg-primary text-white hover:opacity-90 transition"
          @click="onSubmit"
        >
          Simpan
        </Button>

      </div>
    </template>

  </BaseModal>
</template>