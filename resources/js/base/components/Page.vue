<template>
    <router-view
        :key="$route.fullPath"
        v-slot="{ Component }"
    >
        <transition
            name="fade"
            mode="out-in"
        >
            <component :is="Component" />
        </transition>
    </router-view>
</template>
