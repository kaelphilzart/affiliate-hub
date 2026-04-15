<script setup lang="ts">
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import { ICategory, ICategoryCreate, ICategoryUpdate } from '@/types/category';
import { ModalForm } from '@/components/ui/custom-components';
import { DataTable } from '@/components/ui/custom-components';
import { Button } from '@/components/ui/button';
import { toast } from 'vue-sonner'

import AddCategory from './forms/AddCategory.vue';
import EditCategory from './forms/EditCategory.vue';

defineProps<{
    categories: ICategory[]
}>()

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Categories',
            },
        ],
    },
})

const columns = [
    {
        key: 'no',
        label: 'No',
    },
    {
        key: 'name',
        label: 'Name',
    },
    {
        key: 'slug',
        label: 'Slug',
    },
     {
        key: 'action',
        label: 'Action',
    },

]
//* ================== FORM STATE ================== *//
const isOpenAddForm = ref(false)
const isOpenEditForm = ref(false)


/**
 * DRAFT FORM STATE (INI YANG DIPAKE)
 */
const getChangedFields = <T extends Record<string, any>>(newData: T, oldData: T) => {
    const changed: Partial<T> = {};
    for (const key in newData) {
        if (newData[key] !== oldData[key]) {
            changed[key] = newData[key];
        }
    }
    return changed;
};

const cleanPayload = (obj: Record<string, any>) =>
    Object.fromEntries(
        Object.entries(obj).filter(
            ([_, v]) => v !== '' && v !== null && v !== undefined
        )
    )


const addCategoryData = ref<Partial<ICategoryCreate>>({
    name: '',
    slug: '',
})
const originalEditData = ref<ICategoryUpdate | null>(null)
const editCategoryData = ref<Partial<ICategoryUpdate>>({})

/**
 * HANDLE 
 */
/* ================= CREATE ================= */
const handleSubmit = () => {
    router.post('/categories', addCategoryData.value, {
        preserveScroll: true,
        onSuccess: () => {
            isOpenAddForm.value = false

            addCategoryData.value = {
                name: '',
                slug: '',
            }
            toast.success('Category created successfully')
        },
        onError: (errors) => {
            const firstError = Object.values(errors)?.[0]

            toast.error(
                Array.isArray(firstError)
                    ? firstError[0]
                    : 'Failed to create category',
            )
        },
    })
}

const handleOpenEDit = (category: ICategory) => {
    const mapped: ICategoryUpdate = {
        id: category.id,
        name: category.name,
        slug: category.slug,
    }

    originalEditData.value = mapped
    editCategoryData.value = { ...mapped }

    isOpenEditForm.value = true
}

/* ================= UPDATE ================= */
const handleUpdate = () => {
    if (!originalEditData.value) return

    router.put(
        `/categories/${originalEditData.value.id}`,
        cleanPayload(
            getChangedFields(editCategoryData.value, originalEditData.value),
        ),
        {
            preserveScroll: true,

            onSuccess: () => {
                isOpenEditForm.value = false
                originalEditData.value = null
                editCategoryData.value = {}

                toast.success('Category updated successfully')
            },

            onError: (errors) => {
                const firstError = Object.values(errors)?.[0]

                toast.error(
                    Array.isArray(firstError)
                        ? firstError[0]
                        : 'Failed to update category',
                )
            },
        },
    )
}
/* ================= DELETE ================= */
const handleDelete = (category: ICategory) => {
    router.delete(`/categories/${category.id}`, {
        preserveScroll: true,

        onSuccess: () => {
            toast.success('Category deleted successfully')
        },

        onError: () => {
            toast.error('Failed to delete category')
        },
    })
}

</script>

<template>

    <Head title="Categories" />
    <div class="p-4">
        <Button variant="default" @click="isOpenAddForm = true" class="my-4">
            + Add
        </Button>
        <!-- TABLE -->
        <DataTable :data="categories" :columns="columns" searchable-key="name">
            <!-- 🔥 NO COLUMN -->
            <template #no="{ row, index }">
                {{ index + 1 }}
            </template>

            <!-- 🔥 ACTION COLUMN -->
            <template #action="{ row }">
                <div class="flex gap-2">

                    <Button variant="default" @click="handleOpenEDit(row)">
                        Edit
                    </Button>

                    <Button variant="destructive" @click="handleDelete(row)">
                        Delete
                    </Button>

                </div>
            </template>
        </DataTable>

    </div>
    <ModalForm :open="isOpenAddForm" title="Tambah Category" :onClose="() => (isOpenAddForm = false)"
        :onSubmit="handleSubmit">
        <AddCategory :formData="addCategoryData" :onChange="(data) => (addCategoryData = data)" />
    </ModalForm>

    <ModalForm :open="isOpenEditForm" title="Edit Category" :onClose="() => (isOpenEditForm = false)"
        :onSubmit="handleUpdate">
        <EditCategory :formData="editCategoryData" :onChange="(data) => (editCategoryData = data)" />
    </ModalForm>
</template>