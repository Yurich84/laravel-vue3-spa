<template>
    <div>
        <h1>{{ $t('auth.verification.resend_title') }}</h1>
        <el-form
            ref="resendForm"
            :model="form"
            :rules="rules"
            label-position="left"
            label-width="120px"
            @submit.prevent="resend"
        >
            <el-form-item
                prop="email"
                :label="$t('setting.profile.email')"
                class="form-group"
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
                    @click.prevent="resend"
                >
                    {{ $t('auth.verification.resend_button') }}
                </el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script setup>
import authApi from '../authApi'
import {ref} from 'vue'
import {useI18n} from 'vue-i18n'
import {ElMessage} from 'element-plus'

const {t} = useI18n()

const form = ref({})

const rules = ref({
    email: [
        { required: true, message: t('form.rules.required', {'fieldName': t('setting.profile.email')}), trigger: 'blur' },
        { type: 'email', message: t('form.rules.email'), trigger: ['blur', 'change'] }
    ],
})

function resend() {
    authApi.resend(form.value).then(response => {
        ElMessage({
            message: response.data.message,
            type: response.data.type
        })
    })
}
</script>
