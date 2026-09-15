<script setup lang="ts">
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ArrowUpRight, Minus, Plus, Trash2, ShoppingBag } from '@lucide/vue';
import { money, type SharedProps } from '../types';
import ProductImage from '../components/ProductImage.vue';
const page = usePage<SharedProps>();
const cart = computed(() => page.props.cart);
const busy = ref(false);
function update(id: number, quantity: number) {
    busy.value = true;
    router.patch(`/cart/${id}`, { quantity }, { preserveScroll: true, onFinish: () => (busy.value = false) });
}
function remove(id: number) {
    busy.value = true;
    router.delete(`/cart/${id}`, { preserveScroll: true, onFinish: () => (busy.value = false) });
}
const groups = computed(() =>
    [
        { title: 'Your regular thing', lines: cart.value.lines.filter((l) => l.cadence === 'monthly') },
        { title: 'Just this once', lines: cart.value.lines.filter((l) => l.cadence !== 'monthly') },
    ].filter((g) => g.lines.length),
);
</script>
<template>
    <div class="container section cart-page">
        <p class="eyebrow">GOOD CHOICES, ALL ROUND.</p>
        <h1>Your box of good times.</h1>
        <div v-if="!cart.lines.length" class="empty-state">
            <ShoppingBag :size="48" />
            <h2>A little empty. A lot of potential.</h2>
            <p>Let’s find you something worth firing up the grill for.</p>
            <Link href="/shop" class="button primary">Explore the line-up <ArrowUpRight :size="20" /></Link>
        </div>
        <div v-else class="cart-layout">
            <div>
                <section v-for="group in groups" :key="group.title" class="cart-group">
                    <h2>{{ group.title }}</h2>
                    <article v-for="line in group.lines" :key="line.id" class="cart-line">
                        <div class="cart-thumb" :class="line.colour">
                            <ProductImage :slug="line.slug" :name="line.name" sizes="110px" decorative />
                        </div>
                        <div class="cart-line-info">
                            <Link v-if="line.slug" :href="`/products/${line.slug}`" class="cart-item-name">{{
                                line.name
                            }}</Link
                            ><span v-else>{{ line.name }}</span>
                            <p>
                                {{ money(line.unitPrice) }}
                                {{ line.cadence === 'monthly' ? '/ month' : 'each' }}
                            </p>
                            <p v-if="!line.available" class="field-error">
                                This item is no longer available.
                            </p>
                            <button class="remove-button" :disabled="busy" @click="remove(line.id)">
                                <Trash2 :size="13" />Remove
                            </button>
                        </div>
                        <div class="cart-line-controls">
                            <div class="quantity-control">
                                <button
                                    :disabled="busy || line.quantity <= 1"
                                    :aria-label="`Decrease ${line.name} quantity`"
                                    @click="update(line.id, line.quantity - 1)"
                                >
                                    <Minus :size="16" /></button
                                ><span>{{ line.quantity }}</span
                                ><button
                                    :disabled="busy || line.quantity >= 12"
                                    :aria-label="`Increase ${line.name} quantity`"
                                    @click="update(line.id, line.quantity + 1)"
                                >
                                    <Plus :size="16" />
                                </button>
                            </div>
                            <strong>{{ money(line.total) }}</strong>
                        </div>
                    </article>
                </section>
                <p v-if="page.props.errors.quantity" class="field-error" role="alert">
                    {{ page.props.errors.quantity }}
                </p>
                <Link href="/shop" class="text-link"
                    >A little something else? <ArrowUpRight :size="18"
                /></Link>
            </div>
            <aside class="cart-summary">
                <p class="eyebrow">YOUR PREVIEW BOX</p>
                <h2>Looking delicious.</h2>
                <div class="summary-row">
                    <span>Products</span><strong>{{ money(cart.subtotal) }}</strong>
                </div>
                <div class="summary-row">
                    <span>Delivery estimate</span><strong>{{ money(cart.deliveryEstimate) }}</strong>
                </div>
                <div class="summary-row total">
                    <span>Estimated first delivery</span
                    ><strong>{{ money(cart.subtotal + cart.deliveryEstimate) }}</strong>
                </div>
                <p class="small-note">
                    AUD · Proposed prices. Monthly items would renew with delivery charged each cycle. Final
                    pricing and terms will be shown before purchase.
                </p>
                <div class="preview-callout">
                    <strong>We’re still warming up.</strong>
                    <p>
                        Your cart is saved for this visit. Join the launch list to hear when orders open.
                        Nothing is being charged.
                    </p>
                </div>
                <Link href="/#launch-list" class="button primary"
                    >Tell me when it’s ready <ArrowUpRight :size="19" /></Link
                ><Link href="/delivery" class="text-link"
                    >Check your postcode <ArrowUpRight :size="17"
                /></Link>
            </aside>
        </div>
    </div>
</template>
