<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { cn } from '@/lib/utils'

type Column<T> = {
    key: string
    label: string
    render?: (row: T) => any
}

const props = defineProps<{
    data: any[]
    columns: Column<any>[]

    modelValue?: number // OPTIONAL (controlled)
    perPage?: number
    searchableKey?: string

    class?: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', val: number): void
}>()

/* ================= INTERNAL STATE (uncontrolled mode) ================= */
const internalPage = ref(1)

/* ================= SMART PAGE (controlled + uncontrolled) ================= */
const page = computed({
    get: () => props.modelValue ?? internalPage.value,
    set: (val: number) => {
        internalPage.value = val
        emit('update:modelValue', val)
    },
})

const search = ref('')

const perPage = computed(() => props.perPage ?? 10)

/* ================= FILTER ================= */
const filteredData = computed(() => {
    if (!search.value || !props.searchableKey) return props.data

    return props.data.filter((item) =>
        String(item?.[props.searchableKey ?? ''] ?? '')
            .toLowerCase()
            .includes(search.value.toLowerCase()),
    )
})

/* ================= PAGINATION ================= */
const totalPages = computed(() =>
    Math.ceil(filteredData.value.length / perPage.value),
)

const paginatedData = computed(() => {
    const start = (page.value - 1) * perPage.value
    return filteredData.value.slice(start, start + perPage.value)
})

/* ================= SAFE PAGE GUARD ================= */
watch(filteredData, () => {
    if (page.value > totalPages.value && totalPages.value > 0) {
        page.value = 1
    }
})
</script>

<template>
    <div :class="cn('w-full space-y-3', props.class)">

        <!-- HEADER -->
        <div class="flex items-center justify-between">

            <input v-if="searchableKey" v-model="search" placeholder="Search..."
                class="h-9 w-64 rounded-md border px-3 text-sm" />

            <div class="text-sm text-gray-500">
                Total: {{ filteredData.length }} data
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto rounded-md border">
            <table class="w-full text-sm">

                <thead class="bg-primary text-primary-foreground">
                    <tr>
                        <th v-for="col in columns" :key="col.key" class="px-4 py-2 text-left font-medium">
                            {{ col.label }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(row, i) in paginatedData" :key="row.id ?? i" class="border-t">
                        <td v-for="col in columns" :key="col.key" class="px-4 py-2">
                            <slot :name="col.key" :row="row"  :index="(page - 1) * perPage + i">
                                {{ col.render ? col.render(row) : row[col.key] }}
                            </slot>
                        </td>
                    </tr>

                    <tr v-if="!paginatedData.length">
                        <td :colspan="columns.length" class="py-6 text-center text-gray-500">
                            No data found
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

        <!-- PAGINATION -->
        <div class="flex items-center justify-between text-sm">

            <div>
                Page {{ page }} / {{ totalPages || 1 }}
            </div>

            <div class="flex gap-2">
                <button class="rounded border px-3 py-1 disabled:opacity-50" :disabled="page <= 1" @click="page--">
                    Prev
                </button>

                <button class="rounded border px-3 py-1 disabled:opacity-50" :disabled="page >= totalPages"
                    @click="page++">
                    Next
                </button>
            </div>
        </div>

    </div>
</template>