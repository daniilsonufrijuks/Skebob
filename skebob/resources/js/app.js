import '../css/app.css';
import './bootstrap';

import {createInertiaApp, router} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRouter, createWebHistory } from 'vue-router'
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import 'font-awesome/css/font-awesome.css';
import store from "@/Cart/cart.js";
import i18n from './i18n.js';

// const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    // title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ).then((module) => {
            // Apply DefaultLayout if the page doesn’t specify one
            const page = module.default;
            page.layout = page.layout || DefaultLayout;
            return page;
        }),
    setup({el, App, props, plugin}) {
        const vueApp = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(store)
            .use(i18n); // ✅ Register i18n globally

        vueApp.mount(el);
        return vueApp;
        // return createApp({render: () => h(App, props)})
        //     .use(plugin)
        //     .use(ZiggyVue)
        //     //.use(router)
        //     .use(store)
        //     .use(i18n)
        //     .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}).then(() => {
    console.log('Inertia.js app is set up with Vue Router.');
    console.log('Inertia.js app with i18n is ready 🎉');
});

// Ensure persisted locale on reload
const savedLang = localStorage.getItem('lang');
if (savedLang) i18n.global.locale.value = savedLang;

