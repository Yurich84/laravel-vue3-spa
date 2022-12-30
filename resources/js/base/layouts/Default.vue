<template>
    <header-default />
    <el-container class="home-container">
        <div class="container">
            <child />
        </div>
    </el-container>
</template>

<script setup>
import Child from '@/base/components/Child.vue'
import HeaderDefault from '@/base/components/Navbar.vue'
</script>
