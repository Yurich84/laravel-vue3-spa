<template>
    <div>
        <template v-if="success">
            <div
                class="alert alert-success"
                role="alert"
            >
                {{ success }}
            </div>

            <router-link
                :to="{ name: 'Login' }"
                class="btn btn-primary"
            >
                {{ $t('auth.login.title') }}
            </router-link>
        </template>
        <template v-else>
            <div
                class="alert alert-danger"
                role="alert"
            >
                {{ error || $t('auth.verification.failed') }}
            </div>

            <router-link
                :to="{ name: 'Verification resend' }"
                class="small float-right"
            >
                {{ $t('auth.verification.resend_link') }}
            </router-link>
        </template>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import authApi from '../authApi'
import {useRoute} from 'vue-router'

const route = useRoute()

const error = ref('')
const success = ref('')

verifyEmail()

function verifyEmail() {
    const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')

    authApi.verify(route.params.user, qs(route.query)).then(res => {
        success.value = res.data.status
    }).catch(error => {
        error.value = error.response.data.status
    })
}
</script>
