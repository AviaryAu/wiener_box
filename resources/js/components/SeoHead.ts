import { Head, usePage } from '@inertiajs/vue3';
import { defineComponent, h } from 'vue';
import type { SharedProps } from '../types';

export default defineComponent({
    name: 'SeoHead',
    setup() {
        const page = usePage<SharedProps>();

        return () => {
            const seo = page.props.seo;
            const tags = seo.meta.map((meta) =>
                h('meta', {
                    'head-key': meta.key,
                    [meta.attribute]: meta.name,
                    content: meta.content,
                }),
            );

            if (seo.canonical) {
                tags.push(h('link', { 'head-key': 'canonical', rel: 'canonical', href: seo.canonical }));
            }

            if (seo.structuredData) {
                tags.push(
                    h(
                        'script',
                        { 'head-key': 'structured-data', type: 'application/ld+json' },
                        seo.structuredData,
                    ),
                );
            }

            return h(Head, { title: seo.title }, () => tags);
        };
    },
});
