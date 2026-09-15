<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight, Clock, UsersRound } from '@lucide/vue';
import RecipeImage from './RecipeImage.vue';
import type { Recipe } from '../types';

defineProps<{ recipe: Recipe }>();
</script>

<template>
    <article class="recipe-card">
        <Link :href="recipe.url" class="recipe-card-image" :aria-label="`Cook ${recipe.title}`">
            <RecipeImage :recipe="recipe" />
            <span class="recipe-category">{{ recipe.category }}</span>
            <span class="recipe-card-arrow" aria-hidden="true"><ArrowUpRight :size="22" /></span>
        </Link>
        <div class="recipe-meta">
            <span><Clock :size="15" />{{ recipe.totalMinutes }} min</span
            ><span><UsersRound :size="15" />Serves {{ recipe.servings }}</span>
        </div>
        <h3>
            <Link :href="recipe.url">{{ recipe.title }}</Link>
        </h3>
        <p>{{ recipe.description }}</p>
    </article>
</template>
