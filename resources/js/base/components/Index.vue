<template>
    <section id="index">
        <div class="title mb-4">
            {{ title }}
        </div>
        <div class="links">
            <a href="https://github.com/Yurich84/laravel-vue-spa-skeleton">
                github.com/Yurich84/laravel-vue3-spa
            </a>
        </div>
    </section>
</template>

<script setup>
const title = window.config.appName
</script>

<style lang="scss" scoped>
    .title {
        font-size: 64px;
    }
</style>
