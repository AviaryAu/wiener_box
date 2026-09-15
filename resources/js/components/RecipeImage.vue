<script setup lang="ts">
import { computed } from 'vue';
import type { Recipe } from '../types';

const props = withDefaults(
    defineProps<{
        recipe: Pick<Recipe, 'image' | 'imageAlt'>;
        sizes?: string;
        loading?: 'lazy' | 'eager';
    }>(),
    {
        sizes: '(max-width: 600px) 100vw, (max-width: 900px) 50vw, 420px',
        loading: 'lazy',
    },
);
const imageBase = computed(() => props.recipe.image.replace(/\.webp$/, ''));
</script>

<template>
    <img
        class="recipe-photo"
        :src="recipe.image"
        :srcset="`${imageBase}-480.webp 480w, ${imageBase}-800.webp 800w, ${recipe.image} 1200w`"
        :alt="recipe.imageAlt"
        :sizes="sizes"
        :loading="loading"
        width="1200"
        height="1200"
        decoding="async"
    />
</template>
