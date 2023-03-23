import Profile from './components/Profile.vue'
import ChangePassword from './components/ChangePassword.vue'

export const routes = [
    {
        path: 'change-password',
        name: 'profile.change_password',
        component: ChangePassword,
        hidden: true,
    },
    {
        path: 'profile',
        name: 'profile.edit',
        component: Profile,
        hidden: true,
    },
]
