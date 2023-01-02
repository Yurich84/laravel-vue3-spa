import Login from './components/Login.vue'
import Register from './components/Register.vue'
import VerifyEmail from './components/VerifyEmail.vue'
import ResendVerification from './components/ResendVerification.vue'
import Child from '@/base/components/Child.vue'

export const routes = [
    {
        path: '/email',
        name: 'Auth',
        component: Child,
        meta: {
            layout: 'Welcome',
            auth: true
        },
        hidden: true,
        children: [
            {
                path: '/login',
                component: Login,
                name: 'Login',
                meta: {
                    auth: false,
                },
            },
            {
                path: '/register',
                component: Register,
                name: 'Register',
                meta: {
                    auth: false,
                },
            },
            {
                path: 'verify/:user',
                component: VerifyEmail,
                name: 'Verification email'
            },
            {
                path: 'resend/verification',
                component: ResendVerification,
                name: 'Verification resend'
            }
        ]
    }
]
