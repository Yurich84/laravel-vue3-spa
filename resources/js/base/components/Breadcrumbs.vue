<template>
    <el-breadcrumb
        separator="/"
        class="breadcrumb-inner"
    >
        <el-breadcrumb-item
            v-for="item in breadcrumbs"
            :key="item.path"
        >
            {{ $t(item.name || 'Home') }}
        </el-breadcrumb-item>
    </el-breadcrumb>
</template>

<script setup>
const route = useRoute()

const breadcrumbs = computed(() => {
    const routes = route.matched
    routes.shift()

    return routes
})
</script>
