import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { Component, DefineComponent } from 'vue';
import StoreLayout from './components/StoreLayout.vue';

export async function resolvePage(name: string) {
    const page = (await resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue'),
    )) as { default: DefineComponent & { layout?: Component } };
    page.default.layout ??= StoreLayout;
    return page.default;
}
