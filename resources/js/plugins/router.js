import { createRouter, createWebHistory } from 'vue-router'
import {routes} from '@/base/routes'

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return new Promise((resolve) => {
            if (to.hash) {
                resolve({ selector: to.hash })
            } else if (savedPosition) {
                resolve(savedPosition)
            } else {
                resolve({x: 0, y: 0})
            }
        })
    }
})

export default (app) => {
    app.router = router

    app.use(router)
}

