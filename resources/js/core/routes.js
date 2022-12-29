import Index        from './components/Index.vue'
import NotFound     from './components/NotFound.vue'
import Welcome      from './components/Welcome.vue'
import Home         from './components/Home.vue'
import auth         from '../modules/auth/routes_auth'

const autoImportModules = import.meta.glob('../modules/*/routes.js', { import: 'routes' })

let moduleRoutes = []

for (const path in autoImportModules) {
    const routes = await autoImportModules[path]()
    moduleRoutes = moduleRoutes.concat(routes)
}

export const routes = [
    {
        path: '/admin',
        component: Home,
        meta: {auth: true},
        children: [
            ...moduleRoutes,
        ]
    },
    {
        path: '/',
        component: Welcome,
        children: [
            {
                path: '/',
                component: Index,
                name: 'index',
            },
            ...auth,
            {
                path: '*',
                component: NotFound,
                name: 'not_found'
            }
        ]
    },
]

