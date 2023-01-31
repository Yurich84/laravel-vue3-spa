<template>
    <div>
        <h1>{{ $t('auth.register.title') }}</h1>
        <register-form
            :loading="loading"
            :errors="errors"
            @submit="onSubmit"
        />
    </div>
</template>

<script setup>
import {useAuth} from '@websanova/vue-auth'
import {useErrors} from '@/includes/composable/errors'
import RegisterForm from './RegisterForm.vue'

const {t} = useI18n()
const errors = useErrors()
const auth = useAuth()
const loading = ref(false)

function onSubmit(signUpFormData) {
    loading.value = true
    auth
        .register({
            data: signUpFormData,
        })
        .then(response => {
            ElMessage.success(response.data?.status || t('auth.register.success'))
        }, error => {
            if (error.response?.status === 422) errors.record(error.response.data.errors)
            else console.error(error)
        })
        .finally(() => loading.value = false)
}
</script>
