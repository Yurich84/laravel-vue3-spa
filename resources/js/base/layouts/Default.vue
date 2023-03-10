<template>
    <navbar />
    <el-container class="home-container">
        <sidebar />
        <el-container>
            <el-main>
                <breadcrumbs />
                <el-card shadow="always">
                    <h1 class="title text-center">
                        {{ $t($route.name.toString()) }}
                    </h1>
                    <child />
                </el-card>
            </el-main>
            <el-footer>&nbsp;</el-footer>
        </el-container>
    </el-container>
</template>

<script setup>
import Navbar from '@/base/components/Navbar.vue'
import Sidebar from '@/base/components/Sidebar.vue'
import Breadcrumbs from '@/base/components/Breadcrumbs.vue'
import Child from '@/base/components/Child.vue'
</script>

<style lang="scss">
.el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 230px;
    min-height: 400px;
}

.el-breadcrumb {
    padding-bottom: 20px;
}

.title {
    margin-bottom: 20px;
}
</style>
