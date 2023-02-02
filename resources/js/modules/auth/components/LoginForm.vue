<template>
    <el-form
        ref="loginFormRef"
        :model="form"
        :rules="rules"
        hide-required-asterisk
        label-width="120px"
        @keyup.enter="onSubmit"
    >
        <el-form-item
            prop="email"
            :label="$t('auth.login.email_label')"
            :error="$t(errors.get('email'))"
            class="form-group"
        >
            <el-input
                v-model="form.email"
                name="email"
                type="text"
            />
        </el-form-item>
        <el-form-item
            prop="password"
            :label="$t('auth.login.password_label')"
            :error="$t(errors.get('password'))"
            class="form-group"
        >
            <el-input
                v-model="form.password"
                name="password"
                type="password"
                show-password
            />
        </el-form-item>
        <el-form-item class="w-100">
            <el-button
                :loading="loading"
                class="w-100"
                @click="onSubmit"
            >
                {{ $t('auth.login.submit_button') }}
            </el-button>
        </el-form-item>
    </el-form>
</template>

<script setup>
import {ref} from 'vue'
import {useI18n} from 'vue-i18n'

const {t} = useI18n()

const emit = defineEmits()

const props = defineProps({
    errors: {
        type: Object,
        default: null
    },
    loading: {
        type: Boolean,
        default: false
    }
})

const loginFormRef = ref()

const form = ref({
    email: '',
    password: '',
    device_name: window.config.deviceName
})

const rules = ref({
    email:      [{ required:true, message: t('global.form.rules.required', { 'fieldName': t('auth.login.email_label')}), trigger: 'blur' }],
    password:   [{ required:true, message: t('global.form.rules.required', { 'fieldName': t('auth.login.password_label')}), trigger: 'blur' }],
})

function onSubmit(e) {
    loginFormRef.value.validate((valid) => {
        if (valid) emit('submit', form.value)
    })
}
</script>
