// import { createApp, h } from 'vue/dist/vue.esm-bundler.js'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { InertiaProgress } from '@inertiajs/progress'
import VueTheMask from 'vue-the-mask'

import Layout from './Layouts/Layout.vue'

InertiaProgress.init()

createInertiaApp({
    resolve: name => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        )
        page.then((module) => {
            module.default.layout = module.default.layout || Layout
        })
        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .mixin({ methods: { route } })
            .use(plugin)
            .use(VueTheMask)
            .mount(el)
    },
})



