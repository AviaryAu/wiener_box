<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowUpRight, Check, Minus, Plus } from '@lucide/vue';
import { money, type Product } from '../types';
import ProductGallery from '../components/ProductGallery.vue';
const props = defineProps<{ product: Product }>();
const form = useForm({ product_id: props.product.id, quantity: 1 });
function add() {
    form.post('/cart', { preserveScroll: true });
}
</script>
<template>
    <div class="container section">
        <nav class="breadcrumbs" aria-label="Breadcrumb">
            <Link href="/">Home</Link><span aria-hidden="true">/</span>
            <Link href="/shop">Sausage boxes & packs</Link><span aria-hidden="true">/</span>
            <span aria-current="page">{{ product.name }}</span>
        </nav>
        <div class="product-detail">
            <ProductGallery
                :key="product.slug"
                :slug="product.slug"
                :name="product.name"
                :colour="product.colour"
            />
            <div class="detail-copy">
                <p class="eyebrow">{{ product.eyebrow }}</p>
                <h1>{{ product.name }}.</h1>
                <p class="detail-price">
                    {{ money(product.price) }}
                    <small>{{
                        product.cadence === 'monthly'
                            ? '/ month'
                            : '/ ' + (product.category === 'pack' ? 'pack' : 'box')
                    }}</small>
                </p>
                <p class="small-note">
                    Preview price in AUD + estimated $12 delivery{{
                        product.cadence === 'monthly' ? ' each month' : ''
                    }}.
                </p>
                <p class="detail-description">{{ product.story }}</p>
                <ul class="check-list">
                    <li v-for="highlight in product.highlights" :key="highlight">
                        <Check :size="18" />{{ highlight }}
                    </li>
                </ul>
                <form @submit.prevent="add" class="add-to-cart">
                    <div class="quantity-control">
                        <button
                            type="button"
                            aria-label="Decrease quantity"
                            :disabled="form.quantity <= 1"
                            @click="form.quantity--"
                        >
                            <Minus :size="17" /></button
                        ><input
                            v-model.number="form.quantity"
                            type="number"
                            min="1"
                            max="12"
                            aria-label="Quantity"
                        /><button
                            type="button"
                            aria-label="Increase quantity"
                            :disabled="form.quantity >= 12"
                            @click="form.quantity++"
                        >
                            <Plus :size="17" />
                        </button>
                    </div>
                    <button class="button primary" :disabled="form.processing || product.price === null">
                        {{ form.processing ? 'Adding…' : 'Add to your box' }}<ArrowUpRight :size="20" />
                    </button>
                </form>
                <p v-if="form.errors.quantity || form.errors.product_id" class="field-error" role="alert">
                    {{ form.errors.quantity || form.errors.product_id }}
                </p>
                <p class="preview-callout">
                    Just exploring? So are we. This builds a preview cart. Orders aren’t open, and no payment
                    or subscription starts.
                </p>
                <details class="product-disclosure" open>
                    <summary>What’s in the box?<Plus :size="17" /></summary>
                    <ul>
                        <li v-for="content in product.contents" :key="content">{{ content }}</li>
                    </ul>
                    <p>
                        Final contents, pack weights, ingredients, allergens and storage instructions will be
                        published before this product goes on sale.
                    </p>
                </details>
                <details class="product-disclosure">
                    <summary>Delivery & subscriptions<Plus :size="17" /></summary>
                    <p>
                        We’re planning chilled delivery in Sydney. Recurring delivery, skip, pause and
                        cancellation terms will be confirmed before subscriptions open.
                    </p>
                    <Link href="/delivery" class="text-link"
                        >Check your postcode <ArrowUpRight :size="16"
                    /></Link>
                </details>
            </div>
        </div>
    </div>
</template>
