<template>
    <el-header class="header">
        <div
            class="logo"
            :class="isCollapsed ? 'logo-collapse-width' : 'logo-width'"
        >
            {{ isCollapsed ? '' : $config.appName }}
        </div>
        <div class="tools">
            <div @click.prevent="toggleCollapse">
                <i class="fa fa-align-justify" />
            </div>
        </div>
        <div class="userinfo">
            <span>{{ sysUserName }}</span>
            <el-dropdown trigger="click">
                <span class="el-dropdown-link userinfo-inner">
                    <img :src="sysUserAvatar">
                </span>
                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item @click="$router.push({name: 'profile.edit'})">
                            Edit profile
                        </el-dropdown-item>
                        <el-dropdown-item @click="$router.push({name: 'profile.change_password'})">
                            Change password
                        </el-dropdown-item>
                        <el-dropdown-item
                            divided
                            @click="logout"
                        >
                            Log Out
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
        </div>
    </el-header>
</template>

<script setup>
import {computed} from 'vue'
import {ElMessageBox} from 'element-plus'
import {useAuth} from '@websanova/vue-auth'
import bus from '@/includes/Event'
import { useI18n } from 'vue-i18n'
import {storeToRefs} from 'pinia'
import {useBaseStore} from '@/base/baseStore'

const {t} = useI18n()
const auth = useAuth()

const sysUserName = computed(() => auth.user()?.name || '')
const sysUserAvatar = computed(() => auth.user()?.avatar || '')

const { isCollapsed } = storeToRefs(useBaseStore())
const { toggleCollapse } = useBaseStore()

function logout() {
    ElMessageBox.confirm(t('auth.logout_confirm.text'), t('auth.logout_confirm.title'), {
        confirmButtonText: t('auth.logout_confirm.button_ok'),
        cancelButtonText: t('auth.logout_confirm.button_cancel'),
    }).then(async () => {
        bus.$emit('logout')
        await auth.logout()
    })
}
</script>
