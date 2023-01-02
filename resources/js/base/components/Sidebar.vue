<template>
    <aside>
        <el-menu
            :default-active="$route.path"
            class="el-menu-vertical-demo"
            router
            :collapse="isCollapsed"
        >
            <template v-for="(item, index) in admin_routes">
                <el-menu-item
                    v-if="!item.children && !item.hidden"
                    :key="index"
                    :route="item"
                    :index="item.path"
                >
                    <i :class="item.icon || 'fa fa-th-large'" />
                    <span>{{ $t(item.name.toString()) }}</span>
                </el-menu-item>
                <el-sub-menu
                    v-if="item.children && !item.hidden"
                    :key="index"
                    :index="index+''"
                >
                    <template #title>
                        <i :class="item.icon || 'fa fa-th-large'" />
                        <span>{{ item.name }}</span>
                    </template>
                    <template v-for="child in item.children">
                        <el-menu-item
                            v-if="!child.hidden"
                            :key="child.path"
                            :route="child"
                            :index="child.path"
                        >
                            <i :class="item.icon || 'fa fa-th-large'" />
                            <span>{{ child.name }}</span>
                        </el-menu-item>
                    </template>
                </el-sub-menu>
            </template>
        </el-menu>
    </aside>
</template>

<script setup>
import {computed} from 'vue'
import {useRouter} from 'vue-router'
import {storeToRefs} from 'pinia'
import {useBaseStore} from '@/base/baseStore'

const router = useRouter()

const { isCollapsed } = storeToRefs(useBaseStore())

const admin_routes = computed(() => router.options.routes[0].children[0].children)
</script>

<style lang="scss" scoped>
aside {
    .el-menu {
        height: calc(100vh - 60px);
    }

    .collapsed {
        width: 60px;

        .item {
            position: relative;
        }

        .submenu {
            position: absolute;
            top: 0;
            left: 60px;
            z-index: 99999;
            height: auto;
            display: none;
        }

    }
}

.menu-collapsed {
    flex: 0 0 60px;
    width: 60px;
}

.menu-expanded {
    flex: 0 0 230px;
    width: 230px;
}

.el-menu-vertical-demo {
    li.el-menu-item {
        span {
            margin-left: 10px;
        }
    }
    .el-sub-menu {
        &__title {
            span {
                margin-left: 10px;
            }
        }
    }
}
</style>
