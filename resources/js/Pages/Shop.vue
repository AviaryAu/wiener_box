<script setup lang="ts">
import { computed, ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Search } from '@lucide/vue';
import ProductCard from '../components/ProductCard.vue';
import type { Product } from '../types';
const props = defineProps<{ products: Product[] }>();
const page = usePage();
const category = ref(new URLSearchParams(page.url.split('?')[1]).get('category') ?? 'all');
const search = ref('');
const filters = [
    { value: 'all', label: 'The whole line-up' },
    { value: 'subscription', label: 'Subscriptions' },
    { value: 'box', label: 'One-off boxes' },
    { value: 'gift', label: 'Gifts' },
    { value: 'pack', label: 'Individual packs' },
];
const filtered = computed(() =>
    props.products.filter(
        (p) =>
            (category.value === 'all' || p.category === category.value) &&
            p.name.toLowerCase().includes(search.value.toLowerCase()),
    ),
);
</script>
<template>
    <div class="container section shop-page">
        <Head title="Shop the line-up" />
        <p class="eyebrow">LET’S FIND YOUR FLAVOUR.</p>
        <h1>The whole lovely lot.</h1>
        <p class="page-intro">
            Regular favourites. One-off flings. Gifts worth opening.<br />Meet the Wiener Box launch line-up.
        </p>
        <div class="shop-tools">
            <div class="filter-list" aria-label="Product categories">
                <button
                    v-for="filter in filters"
                    :key="filter.value"
                    class="filter"
                    :class="{ active: category === filter.value }"
                    :aria-pressed="category === filter.value"
                    @click="category = filter.value"
                >
                    {{ filter.label }}
                </button>
            </div>
            <label class="search-field"
                ><Search :size="18" /><input
                    v-model="search"
                    aria-label="Search products"
                    placeholder="Find your favourite"
            /></label>
        </div>
        <p class="result-count" role="status">
            {{ filtered.length }} good {{ filtered.length === 1 ? 'thing' : 'things' }} to discover
        </p>
        <div v-if="filtered.length" class="product-grid">
            <ProductCard v-for="product in filtered" :key="product.id" :product="product" />
        </div>
        <div v-else class="empty-state">
            <h2>No wurst found.</h2>
            <p>Try another search or category.</p>
            <button
                class="button secondary"
                @click="
                    search = '';
                    category = 'all';
                "
            >
                Show the whole line-up
            </button>
        </div>
        <p class="preview-note">
            Prelaunch preview · Prices and pack sizes are provisional. Delivery estimate $12. Final
            ingredients, allergens and availability will be confirmed before sales open. Food images are
            AI-generated serving suggestions; accompaniments are not included.
        </p>
    </div>
</template>
