<template>
    <div class="app">
        <router-view
            :key="$route.meta.layout || 'Default'"
            v-slot="{ Component }"
        >
            <div
                v-if="!$auth.ready()"
                class="loading-screen"
            >
                <div class="loading-text">
                    <p>Loading ...</p>
                </div>
            </div>
            <component
                :is="Component"
                v-if="$auth.ready()"
            />
        </router-view>
    </div>
</template>
