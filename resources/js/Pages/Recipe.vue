<script setup lang="ts">
import { ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, ArrowUpRight, Clock, UsersRound } from '@lucide/vue';
import RecipeImage from '../components/RecipeImage.vue';
import type { Recipe } from '../types';

const props = defineProps<{ recipe: Recipe }>();
const checkedIngredients = ref<number[]>([]);
watch(
    () => props.recipe.id,
    () => {
        checkedIngredients.value = [];
    },
);
</script>

<template>
    <article class="recipe-page container section">
        <Link href="/recipes" class="text-link recipe-back"><ArrowLeft :size="17" />All recipes</Link>
        <header class="recipe-detail-header">
            <div>
                <p class="eyebrow">FROM THE WIENER BOX KITCHEN</p>
                <span class="recipe-category">{{ recipe.category }}</span>
                <h1>{{ recipe.title }}.</h1>
                <p class="page-intro">{{ recipe.description }}</p>
                <div class="recipe-meta">
                    <span><Clock :size="18" />{{ recipe.totalMinutes }} min total</span
                    ><span><UsersRound :size="18" />Serves {{ recipe.servings }}</span>
                </div>
                <p class="recipe-timing">
                    {{ recipe.prepMinutes }} min prep ·
                    {{ recipe.cookMinutes ? `${recipe.cookMinutes} min cooking` : 'No cooking needed' }}
                </p>
                <a href="#recipe-method" class="button primary">Let’s make it <ArrowUpRight :size="21" /></a>
            </div>
            <RecipeImage
                :recipe="recipe"
                loading="eager"
                fetchpriority="high"
                sizes="(max-width: 700px) 100vw, 55vw"
            />
        </header>
        <div class="recipe-instructions">
            <aside class="recipe-ingredients" aria-labelledby="recipe-ingredients-heading">
                <p class="eyebrow">THE SHOPPING LIST</p>
                <h2 id="recipe-ingredients-heading">The good stuff.</h2>
                <p>For {{ recipe.servings }} · Tick things off as you go.</p>
                <ul>
                    <li v-for="(ingredient, index) in recipe.ingredients" :key="ingredient">
                        <label :class="{ 'is-checked': checkedIngredients.includes(index) }"
                            ><input v-model="checkedIngredients" type="checkbox" :value="index" /><span>{{
                                ingredient
                            }}</span></label
                        >
                    </li>
                </ul>
            </aside>
            <section id="recipe-method" class="recipe-method" aria-labelledby="recipe-method-heading">
                <p class="eyebrow">A LITTLE METHOD TO THE MUSTARD</p>
                <h2 id="recipe-method-heading">Here’s the plan.</h2>
                <ol>
                    <li v-for="(step, index) in recipe.method" :key="step">
                        <span class="recipe-step-number" aria-hidden="true">{{
                            String(index + 1).padStart(2, '0')
                        }}</span>
                        <p>{{ step }}</p>
                    </li>
                </ol>
                <div class="recipe-tip">
                    <span aria-hidden="true">✳</span>
                    <div>
                        <h3>A little extra flavour.</h3>
                        <p>{{ recipe.tip }}</p>
                    </div>
                </div>
                <a
                    v-if="recipe.category === 'Sausages'"
                    class="recipe-cooking-guide"
                    href="https://www.foodstandards.gov.au/consumer/prevention-of-foodborne-illness/food-safety-basics"
                    target="_blank"
                    rel="noopener noreferrer"
                    >Cooking temperatures: Food Standards Australia New Zealand
                    <ArrowUpRight :size="13" /><span class="recipe-link-note">(opens in a new tab)</span></a
                >
            </section>
        </div>
        <div class="recipe-bottom-note">
            <span aria-hidden="true">✳</span>
            <p>Room for a little something on the side?</p>
            <Link href="/recipes" class="text-link">More recipes <ArrowUpRight :size="19" /></Link>
        </div>
    </article>
</template>
