<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowUpRight, ShoppingBag, UserRound, Menu, X, ArrowRight } from '@lucide/vue';
import type { SharedProps } from '../types';
import SeoHead from './SeoHead';
const page = usePage<SharedProps>();
const menuOpen = ref(false);
const cartQuantity = computed(() => page.props.cart.quantity);
watch(
    () => page.url,
    () => {
        menuOpen.value = false;
    },
);
const links = [
    { label: 'Our boxes', href: '/#boxes' },
    { label: 'Shop sausages', href: '/shop?category=pack' },
    { label: 'Gifting', href: '/shop?category=gift' },
    { label: 'How it works', href: '/how-it-works' },
    { label: 'Recipes', href: '/recipes' },
];
</script>

<template>
    <div class="site-shell">
        <SeoHead />
        <a class="skip-link" href="#main">Skip to content</a>
        <div class="announcement">
            <span>GERMAN ROOTS. GOOD TIMES.</span
            ><Link href="/delivery">A little wurst is coming to Sydney <ArrowUpRight :size="13" /></Link>
        </div>
        <header class="site-header container">
            <Link href="/" class="wordmark" aria-label="Wiener Box home">
                <img src="/images/wiener-box-logo.svg" width="470" height="315" alt="" />
            </Link>
            <nav aria-label="Main navigation" class="desktop-nav">
                <Link v-for="link in links" :key="link.href" :href="link.href">{{ link.label }}</Link>
            </nav>
            <div class="header-actions">
                <Link
                    :href="page.props.auth.user ? '/account' : '/login'"
                    class="icon-button account-link"
                    aria-label="Your account"
                    ><UserRound :size="21"
                /></Link>
                <Link href="/cart" class="cart-button" :aria-label="`Your box, ${cartQuantity} items`"
                    ><ShoppingBag :size="20" /><span>Your box</span><b>{{ cartQuantity }}</b></Link
                >
                <button
                    class="icon-button menu-toggle"
                    :aria-expanded="menuOpen"
                    aria-controls="mobile-nav"
                    aria-label="Toggle navigation"
                    @click="menuOpen = !menuOpen"
                >
                    <X v-if="menuOpen" /><Menu v-else />
                </button>
            </div>
        </header>
        <nav v-if="menuOpen" id="mobile-nav" class="mobile-nav" aria-label="Mobile navigation">
            <Link v-for="link in links" :key="link.href" :href="link.href"
                >{{ link.label }}<ArrowRight :size="20" /></Link
            ><Link href="/account">My account<ArrowRight :size="20" /></Link>
        </nav>
        <div v-if="page.props.flash.message" :key="page.props.flash.message" class="toast" role="status">
            {{ page.props.flash.message }}
            <Link href="/cart" v-if="page.props.flash.message.startsWith('Added')">View your box →</Link>
        </div>
        <main id="main" class="watermark-panel" :data-page="page.component" tabindex="-1">
            <slot />
        </main>
        <footer class="site-footer">
            <div class="container footer-grid">
                <div>
                    <Link href="/" class="wordmark footer-wordmark" aria-label="Wiener Box home">
                        <img src="/images/wiener-box-logo.svg" width="470" height="315" alt="" />
                    </Link>
                    <p>Serious sausage.<br />Silly name.</p>
                    <span class="footer-tag">GOOD TIMES COME IN LINKS.</span>
                </div>
                <div>
                    <h3>Get the good stuff</h3>
                    <Link href="/#boxes">Explore our boxes</Link><Link href="/shop">Shop all sausages</Link
                    ><Link href="/shop?category=gift">Send a little happiness</Link
                    ><Link href="/recipes">Recipes & good ideas</Link>
                </div>
                <div>
                    <h3>The useful stuff</h3>
                    <Link href="/how-it-works">How it works</Link
                    ><Link href="/delivery">Check your postcode</Link
                    ><Link href="/account">Account & orders</Link><Link href="/privacy">Privacy</Link>
                </div>
                <div>
                    <h3>Still warming up.</h3>
                    <p>We’re getting ready for our first Sydney delivery. Be first to hear.</p>
                    <Link href="/#launch-list" class="footer-cta"
                        >Join the launch list <ArrowUpRight :size="18"
                    /></Link>
                </div>
            </div>
            <div class="container footer-bottom">
                <span>© {{ new Date().getFullYear() }} Wiener Box</span
                ><span>Prelaunch preview · All prices in AUD · Orders aren’t open yet</span
                ><span>Made for a good feed. ✳</span>
            </div>
        </footer>
    </div>
</template>
