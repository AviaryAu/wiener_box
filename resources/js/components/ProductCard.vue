<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight, Package } from '@lucide/vue';
import { money, type Product } from '../types';
import { productPhoto } from '../foodPhotography';
import ProductImage from './ProductImage.vue';
import ProductBadge from './ProductBadge.vue';
import { productBadge } from '../productBadges';
defineProps<{ product: Product }>();
</script>
<template>
    <article class="product-card">
        <Link
            :href="`/products/${product.slug}`"
            class="product-art"
            :class="[
                product.colour,
                {
                    'has-food-photo': productPhoto(product.slug),
                    'has-box-photo': productPhoto(product.slug)?.kind === 'box',
                },
            ]"
            :aria-label="`Explore ${product.name}`"
        >
            <ProductBadge v-if="productBadge(product.slug)" :slug="product.slug" />
            <span v-else class="product-label">{{
                product.category === 'subscription'
                    ? 'THE MAIN EVENT'
                    : product.category === 'gift'
                      ? 'GIFT-READY GOODNESS'
                      : product.category === 'pack'
                        ? 'MEET THE LINE-UP'
                        : 'NO STRINGS ATTACHED'
            }}</span>
            <ProductImage
                v-if="product.category !== 'pack' || productPhoto(product.slug)"
                :slug="product.slug"
                :name="product.name"
            />
            <div v-else class="pack-art">
                <Package :size="64" :stroke-width="1.4" /><strong>{{ product.name }}</strong
                ><span>GERMAN-STYLE · PACK PREVIEW</span>
            </div>
            <span class="round-arrow"><ArrowUpRight :size="23" /></span>
        </Link>
        <div class="product-info">
            <p class="eyebrow">{{ product.eyebrow }}</p>
            <div class="product-title-row">
                <h3>
                    <Link :href="`/products/${product.slug}`">{{ product.name }}</Link>
                </h3>
                <span class="card-price"
                    >{{ money(product.price)
                    }}<small>{{
                        product.cadence === 'monthly'
                            ? '/ month'
                            : product.category === 'pack'
                              ? '/ pack'
                              : '/ box'
                    }}</small></span
                >
            </div>
            <p>{{ product.story }}</p>
            <Link :href="`/products/${product.slug}`" class="text-link"
                >{{
                    product.category === 'gift'
                        ? 'Make someone’s day'
                        : product.category === 'pack'
                          ? 'Meet your sausage'
                          : 'Meet your box'
                }}
                <ArrowUpRight :size="18"
            /></Link>
        </div>
    </article>
</template>
