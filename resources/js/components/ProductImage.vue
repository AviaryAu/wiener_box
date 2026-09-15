<script setup lang="ts">
import { computed } from 'vue';
import { defaultProductPhoto, productPhoto } from '../foodPhotography';
const props = withDefaults(
    defineProps<{
        slug: string | null;
        name: string;
        sizes?: string;
        loading?: 'lazy' | 'eager';
        decorative?: boolean;
    }>(),
    {
        sizes: '(max-width: 600px) 100vw, (max-width: 900px) 50vw, 420px',
        loading: 'lazy',
        decorative: false,
    },
);
const photo = computed(() => productPhoto(props.slug) ?? defaultProductPhoto);
</script>
<template>
    <img
        :src="photo.src"
        :srcset="photo.srcset"
        :sizes="sizes"
        :alt="decorative ? '' : photo.alt"
        :width="photo.width"
        :height="photo.height"
        class="food-photo"
        :loading="loading"
        decoding="async"
    />
</template>
