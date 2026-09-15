import '../css/app.css';
import '@fontsource/lilita-one/latin-400.css';

import { createApp, createSSRApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePage } from './resolvePage';

createInertiaApp({
    resolve: resolvePage,
    setup({ el, App, props, plugin }) {
        const createVueApp = el.hasChildNodes() ? createSSRApp : createApp;
        createVueApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
    progress: { color: '#A52821' },
});
