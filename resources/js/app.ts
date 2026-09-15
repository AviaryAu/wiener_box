import '../css/app.css';
import '@fontsource/lilita-one/latin-400.css';

import { createApp, h, type DefineComponent, type Component } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import StoreLayout from './components/StoreLayout.vue';

createInertiaApp({
    title: (title) => `${title} · Wiener Box`,
    resolve: async (name) => {
        const page = (await resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        )) as { default: DefineComponent & { layout?: Component } };
        page.default.layout ??= StoreLayout;
        return page.default;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: { color: '#A52821' },
});
