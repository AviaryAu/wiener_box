<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Package, Repeat2, ArrowUpRight, LogOut } from '@lucide/vue';
import { money, type SharedProps } from '../types';
const page = usePage<SharedProps>();
defineProps<{ orders: { reference: string; status: string; total: number; placedAt: string }[] }>();
</script>
<template>
    <div class="container section account-page">
        <Head title="Your account" />
        <div class="section-heading">
            <div>
                <p class="eyebrow">YOUR CORNER OF THE WURST.</p>
                <h1>Hello, {{ page.props.auth.user?.name.split(' ')[0] }}.</h1>
                <p>{{ page.props.auth.user?.email }}</p>
            </div>
            <Link href="/logout" method="post" as="button" class="button secondary"
                >Sign out <LogOut :size="18"
            /></Link>
        </div>
        <div class="account-panels">
            <section class="account-panel">
                <Package :size="27" />
                <h2>Your orders</h2>
                <div v-if="orders.length" class="orders-list">
                    <article v-for="order in orders" :key="order.reference">
                        <div>
                            <strong>{{ order.reference }}</strong>
                            <p>{{ order.placedAt }} · {{ order.status }}</p>
                        </div>
                        <strong>{{ money(order.total) }}</strong>
                    </article>
                </div>
                <div v-else>
                    <p>No orders yet. We’ll show your order history here once the shop opens.</p>
                    <Link href="/shop" class="text-link"
                        >Explore the launch line-up <ArrowUpRight :size="19"
                    /></Link>
                </div>
            </section>
            <section class="account-panel">
                <Repeat2 :size="27" />
                <h2>Your regular thing</h2>
                <p>
                    Subscriptions haven’t opened yet. Building a preview cart doesn’t start a subscription or
                    charge your card.
                </p>
                <Link href="/products/the-regular" class="text-link"
                    >Meet The Big Wiener Club <ArrowUpRight :size="19"
                /></Link>
            </section>
        </div>
    </div>
</template>
