require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { i18nVue } from 'laravel-vue-i18n';
import Toast from 'vue-toastification';
import composer from '../../composer.json';

const isLaravel9 = composer.require["laravel/framework"].startsWith("^9.")
    ? true
    : false;

const appName =
    window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(i18nVue, {
                // TODO: Use a real solution.
                resolve: (lang) => {
                    if (isLaravel9) {
                        try {
                            return import(`../../lang/${lang}.json`);
                        } catch (error) {}
                    } else {
                        try {
                            return import(`../lang/${lang}.json`);
                        } catch (error) {}
                    }
                },
            })
            .use(Toast, {
                hideProgressBar: true,
                closeOnClick: false,
                closeButton: false,
                icon: false,
                timeout: 5000,
                transition: 'Vue-Toastification__fade',
            })
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#9333EA' });
