<template>
    <el-form
        :model="filters"
        @submit.prevent
    >
        <el-form-item class="mr-0 float-right">
            <el-input
                v-model="filters.search"
                style="width: 200px"
                placeholder="Search"
                clearable
            />
        </el-form-item>
    </el-form>
</template>

<script setup>
import { useModelWrapper } from '@/includes/composable/modelWrapper'

const emit = defineEmits()

const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },
})

const filters = useModelWrapper(props, emit, 'modelValue')

function clearSearch() {
    filters.search = ''
}
</script>
