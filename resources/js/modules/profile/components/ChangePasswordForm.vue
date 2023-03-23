<template>
    <div class="page-section max-width-600-tablet-desktop">
        <el-form
            ref="formRef"
            :model="form"
            :rules="rules"
            label-width="140px"
            @submit.prevent="passwordChange"
        >
            <el-form-item
                :label="$t('profile.old_password')"
                prop="old_password"
                :error="errors.get('old_password')"
            >
                <el-input
                    v-model="form.old_password"
                    type="password"
                    show-password
                />
            </el-form-item>
            <el-form-item
                :label="$t('profile.new_password')"
                prop="password"
                :error="errors.get('password')"
            >
                <el-input
                    v-model="form.password"
                    type="password"
                    show-password
                />
            </el-form-item>
            <el-form-item
                :label="$t('profile.confirm_password')"
                prop="password_confirmation"
                :error="errors.get('password_confirmation')"
            >
                <el-input
                    v-model="form.password_confirmation"
                    type="password"
                    show-password
                />
            </el-form-item>
        </el-form>
        <div>
            <el-button
                @click="cancel"
            >
                Cancel
            </el-button>
            <el-button
                type="success"
                @click.prevent="passwordChange"
            >
                Save Password
            </el-button>
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue'
import {useRoute, useRouter} from 'vue-router'
import {ElMessage} from 'element-plus'
import profileApi from '@/modules/profile/profileApi'
import {useErrors} from '@/includes/composable/errors'

const emit = defineEmits()
const router = useRouter()
const route = useRoute()
const errors = useErrors()

const formRef = ref()

const form = ref({
    password_confirmation: '',
    password: '',
    old_password: '',
})

const rules = {
    password: [{ required: true, trigger: 'change' }],
    password_confirmation: [{ required: true, validator: checkPassIdentical, trigger: 'blur' },],
}

function passwordChange() {
    errors.clear()
    profileApi.changePassword(form.value).then(response => {
        ElMessage.success('Password changed successfully!')
        emit('saved')
        clearForm()
    }).catch(error => {
        if (error.response.data.errors) {
            errors.record(error.response.data.errors)
        }
    })
}

function checkPassIdentical(rule, value, callback) {
    if (!value) {
        return callback(new Error(
            'Password confirmation is required'
        ))
    }

    if (value !== form.value.password) {
        callback(new Error('Mismatch password'))
    } else {
        callback()
    }
}

function cancel() {
    clearForm()
    emit('cancel')
}

function clearForm() {
    errors.clear()
    if (formRef.value) formRef.value.resetFields()
}

</script>
