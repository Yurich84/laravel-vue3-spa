import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './base/App.vue'
import ElementPlus from 'element-plus'
import i18n from './plugins/i18n'
import $dayjs from './plugins/day'
import * as _ from 'lodash'
import $filters from './includes/filters'
import $bus from './includes/Event'
import router from './plugins/router'
import auth from './plugins/auth'
import './plugins/day'
import VueAxios from 'vue-axios'
import axios from './plugins/axios-interceptor'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'

const app = createApp(App)

for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
    app.component(key, component)
}

window._ = _

app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)
app.use(auth)
app.use(i18n)
app.use(ElementPlus, {i18n: (key, value) => i18n.t(key, value)})

app.config.globalProperties.$config = window.config
app.config.globalProperties.$filters = $filters
app.config.globalProperties.$dayjs = $dayjs
app.config.globalProperties.$bus = $bus

app.mount('#app')

export default app
