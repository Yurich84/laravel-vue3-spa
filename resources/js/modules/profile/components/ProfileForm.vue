<template>
    <el-form
        ref="profileFormRef"
        :model="form"
        :rules="rules"
        label-position="left"
        label-width="120px"
        @submit.prevent="onSubmit"
    >
        <el-form-item
            prop="name"
            :label="$t('profile.name')"
            class="form-group"
            :error="$t(errors.get('name'))"
        >
            <el-input
                v-model="form.name"
                name="name"
                type="name"
            />
        </el-form-item>
        <el-form-item
            prop="email"
            :label="$t('profile.email')"
            class="form-group"
            :error="$t(errors.get('email'))"
        >
            <el-input
                v-model="form.email"
                name="email"
                type="email"
            />
        </el-form-item>
        <el-form-item class="w-100">
            <el-button
                class="w-100"
                type="success"
                :loading="loading"
                @click.prevent="onSubmit"
            >
                {{ $t('global.save') }}
            </el-button>
        </el-form-item>
    </el-form>
</template>

<script setup>
import {ref} from 'vue'
import {useI18n} from 'vue-i18n'
import {useAuth} from '@websanova/vue-auth'
import {useErrors} from '@/includes/composable/errors'
import settingApi from '../profileApi'
import {ElMessage} from 'element-plus'

const {t} = useI18n()
const emit = defineEmits()
const auth = useAuth()
const errors = useErrors()

const loading = ref(false)
const profileFormRef = ref()
const form = ref({
    name: auth.user().name,
    email: auth.user().email,
})
const rules = ref({
    name: [
        {required:true, message: t('form.rules.required', { 'fieldName': t('profile.name')}), trigger: 'blur'}
    ],
    email: [
        { required:true, message: t('form.rules.required', { 'fieldName': t('profile.email')}), trigger: 'blur'},
        { type: 'email', message: t('form.rules.email'), trigger: ['blur', 'change'] }
    ],
})

function onSubmit(e) {
    profileFormRef.value.validate((valid) => {
        if (valid) {
            loading.value = true
            errors.clear()

            settingApi.update(form.value).then(response => {
                ElMessage({
                    message: response.data.message,
                    type: response.data.type
                })
                if(response.data.type === 'success') {
                    auth.user().name = form.value.name
                    auth.user().email = form.value.email
                    emit('saved')
                }
            }).catch((error) => {
                if (error.response.data.errors) errors.record(error.response.data.errors)
            }).finally(() => loading.value = false)
        }
    })
}

</script>
