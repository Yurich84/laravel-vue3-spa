import { createApp } from 'vue'
import App from './core/App.vue'
import ElementPlus from 'element-plus'
import i18n from './bootstrap/i18n'
import dayjs from './bootstrap/day'
import router from './bootstrap/router'
import auth from './bootstrap/auth'
import './bootstrap/day'
import VueAxios from 'vue-axios'
import axios from './bootstrap/axios-interceptor'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'

const app = createApp(App)

for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
    app.component(key, component)
}

app.use(router)
app.use(VueAxios, axios)
app.use(auth)
app.use(i18n)
app.use(ElementPlus, {i18n: (key, value) => i18n.t(key, value)})

app.config.globalProperties.$config = window.config
app.config.globalProperties.$dayjs = dayjs

app.mount('#app')

export default app
