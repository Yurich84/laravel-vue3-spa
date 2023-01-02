<template>
    <div>
        <h1>{{ $t('auth.login.title') }}</h1>
        <login-form
            :errors="errors"
            :loading="loading"
            @submit="onSubmit"
        />
    </div>
</template>

<script setup>
import LoginForm from './LoginForm.vue'
import {ref} from 'vue'
import {useAuth} from '@websanova/vue-auth'
import {useErrors} from '@/includes/composable/errors'

const errors = useErrors()
const auth = useAuth()
const loading = ref(false)

function onSubmit(loginData) {
    loading.value = true

    auth
        .login({
            data: loginData,
            remember: loginData.remember
        })
        .then(null, error => {
            if (error.response?.status === 422) errors.record(error.response.data.errors)
            else console.error(error)
        })
        .finally(() => loading.value = false)
}

</script>
