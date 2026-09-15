<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight, Clock, UsersRound } from '@lucide/vue';
import RecipeImage from '../components/RecipeImage.vue';
import RecipeCard from '../components/RecipeCard.vue';
import type { Recipe } from '../types';

const props = defineProps<{ recipes: Recipe[] }>();
const category = ref('All recipes');
const categories = computed(() => [
    'All recipes',
    ...['Sausages', 'Sides', 'Sauces'].filter((name) =>
        props.recipes.some((recipe) => recipe.category === name),
    ),
]);
const featuredRecipe = computed(() => props.recipes.find((recipe) => recipe.featured));
const filteredRecipes = computed(() =>
    props.recipes.filter((recipe) =>
        category.value === 'All recipes'
            ? recipe.id !== featuredRecipe.value?.id
            : recipe.category === category.value,
    ),
);
</script>

<template>
    <div class="recipes-page container section">
        <header class="recipes-intro">
            <div>
                <p class="eyebrow">GOOD THINGS ON THE SIDE. AND IN THE MIDDLE.</p>
                <h1>Make a meal<br /><span class="brand-underline">of it.</span></h1>
            </div>
            <p class="page-intro">
                A little sauce. A proper side. Something sizzling.<br />Easy recipes for your next very good
                feed, with a healthy helping of German inspiration.
            </p>
        </header>
        <section
            v-if="featuredRecipe && category === 'All recipes'"
            class="recipe-feature"
            aria-label="Recipe of the moment"
        >
            <Link :href="featuredRecipe.url" :aria-label="`Cook ${featuredRecipe.title}`"
                ><RecipeImage
                    :recipe="featuredRecipe"
                    loading="eager"
                    fetchpriority="high"
                    sizes="(max-width: 700px) 100vw, 55vw"
            /></Link>
            <div class="recipe-feature-copy">
                <p class="eyebrow">RECIPE OF THE MOMENT</p>
                <span class="recipe-category">{{ featuredRecipe.category }}</span>
                <h2>{{ featuredRecipe.title }}.</h2>
                <p>{{ featuredRecipe.description }}</p>
                <div class="recipe-meta">
                    <span><Clock :size="17" />{{ featuredRecipe.totalMinutes }} min</span
                    ><span><UsersRound :size="17" />Serves {{ featuredRecipe.servings }}</span>
                </div>
                <Link :href="featuredRecipe.url" class="button primary"
                    >Get cooking <ArrowUpRight :size="21"
                /></Link>
            </div>
        </section>
        <section class="recipe-collection" aria-labelledby="recipe-collection-heading">
            <div class="recipe-collection-heading">
                <h2 id="recipe-collection-heading">
                    {{
                        category === 'All recipes'
                            ? 'The rest of the good stuff.'
                            : category + ' worth making.'
                    }}
                </h2>
                <p>{{ recipes.length }} recipes. Plenty of good combinations.</p>
            </div>
            <div class="recipe-filters" role="group" aria-label="Filter recipes">
                <button
                    v-for="name in categories"
                    :key="name"
                    type="button"
                    :aria-pressed="category === name"
                    @click="category = name"
                >
                    {{ name }}
                </button>
            </div>
            <p class="recipe-result-count" aria-live="polite">
                {{ filteredRecipes.length }} {{ filteredRecipes.length === 1 ? 'recipe' : 'recipes'
                }}{{ category === 'All recipes' && featuredRecipe ? ' to keep you cooking' : ' to try' }}
            </p>
            <div v-if="filteredRecipes.length" class="recipe-grid">
                <RecipeCard v-for="recipe in filteredRecipes" :key="recipe.id" :recipe="recipe" />
            </div>
            <div v-else class="recipe-empty">
                <h3>The kitchen is warming up.</h3>
                <p>Fresh ideas are on their way. Check back for something delicious.</p>
            </div>
        </section>
        <div class="recipe-bottom-note">
            <span aria-hidden="true">✳</span>
            <p>Great sausages deserve great company. Mix a sauce, pick a side, make it yours.</p>
            <Link href="/shop" class="text-link">Meet the sausages <ArrowUpRight :size="19" /></Link>
        </div>
    </div>
</template>
