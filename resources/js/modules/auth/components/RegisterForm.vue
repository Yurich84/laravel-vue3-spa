<template>
    <el-form
        ref="registerFormRef"
        :model="form"
        :rules="rules"
        label-width="140px"
        @keyup.enter="onSubmit"
    >
        <el-form-item
            prop="name"
            :label="$t('auth.register.name_label')"
            class="form-group"
            :error="$t(errors.get('name'))"
        >
            <el-input
                v-model="form.name"
                name="name"
                type="test"
            />
        </el-form-item>
        <el-form-item
            prop="email"
            :label="$t('auth.register.email_label')"
            class="form-group"
            :error="$t(errors.get('email'))"
        >
            <el-input
                v-model="form.email"
                name="email"
                type="email"
            />
        </el-form-item>
        <el-form-item
            prop="password"
            :label="$t('auth.register.password_label')"
            class="form-group"
            :error="$t(errors.get('password'))"
        >
            <el-input
                v-model="form.password"
                name="password"
                show-password
            />
        </el-form-item>
        <el-form-item
            prop="password_confirmation"
            :label="$t('auth.register.password_confirmation_label')"
            class="form-group"
        >
            <el-input
                v-model="form.password_confirmation"
                name="password_confirmation"
                show-password
            />
        </el-form-item>
        <el-form-item class="w-100">
            <el-button
                class="w-100"
                :loading="loading"
                @click.prevent="onSubmit"
            >
                {{ $t('auth.register.submit_button') }}
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

const registerFormRef = ref()

const form = ref({
    email: '',
    password: '',
    password_confirmation: ''
})

const rules = ref({
    email: [
        { required:true, message: t('global.form.rules.required', { 'fieldName': t('auth.register.email_label')}), trigger: 'blur'},
        { type: 'email', message: t('global.form.rules.email'), trigger: 'blur' }
    ],
    name: [
        { required:true, message: t('global.form.rules.required', { 'fieldName': t('auth.register.name_label')}), trigger: 'blur'},
        { trigger: 'blur', min: 3, max: 255, message: t('global.form.rules.max', {
            'fieldName': t('auth.register.name'),
            'attribute': 255,
        })}
    ],
    password: [
        { required:true, message: t('global.form.rules.required', { 'fieldName': t('auth.register.password_label')}), trigger: 'blur'},
        { trigger: 'blur', min: 8, max: 12, message: t('global.form.rules.max', {
            'fieldName': t('auth.register.password_label'),
            'attribute': 8,
        })}
    ],
    password_confirmation : [
        { required: true, message: t('global.form.rules.required', {'fieldName': t('auth.register.password_confirmation_label')})},
        { validator: checkPassIdentical, trigger: 'blur' }
    ]
})


function onSubmit(e) {
    registerFormRef.value.validate((valid) => {
        if (valid) emit('submit', form.value)
    })
}

function checkPassIdentical(rule, value, callback) {
    if (!value) {
        return callback(new Error(t('global.form.rules.required', {'fieldName': t('auth.register.password_label')})))
    }

    if (value !== form.value.password) {
        callback(new Error(t('global.form.rules.password_repeat.different')))
    } else {
        callback()
    }
}
</script>
