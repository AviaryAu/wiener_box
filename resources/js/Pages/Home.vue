<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowUpRight, ArrowRight, PackageCheck, Truck, Utensils, Sparkles } from '@lucide/vue';
import ProductCard from '../components/ProductCard.vue';
import ProductImage from '../components/ProductImage.vue';
import WaitlistForm from '../components/WaitlistForm.vue';
import FoodShowcase from '../components/FoodShowcase.vue';
import type { Product } from '../types';
defineProps<{ products: Product[] }>();
const faqs = [
    [
        'So, what’s a Wiener Box?',
        'A box of German-style sausage goodness, built around a monthly discovery subscription. We’re also planning one-off boxes, gifts and individual packs. The range and final contents are being confirmed before launch.',
    ],
    [
        'Where will you deliver?',
        'We’re starting with a proposed Sydney delivery area. Check your postcode and join the launch list to help us plan our first routes. Chilled delivery coverage and dates will be confirmed before orders open.',
    ],
    [
        'Am I signing up for a subscription now?',
        'No. This is a preview. You can explore the range and build a sample cart, but no payment is taken and no subscription is started. We’ll show all renewal, delivery and cancellation terms before launch.',
    ],
    [
        'What about ingredients and allergens?',
        'We’ll publish supplier-confirmed ingredients, allergens, pack sizes and storage instructions for every product before it goes on sale. Food and box images are AI-generated previews. Final selections, pack sizes and packaging will be confirmed before orders open.',
    ],
];
</script>
<template>
    <div>
        <Head title="Serious sausage. Silly name."
            ><meta
                name="description"
                content="Meet Wiener Box. German-style sausage subscriptions, generous gifts and good times, coming to Sydney."
        /></Head>
        <section class="hero container">
            <div class="hero-copy">
                <p class="eyebrow"><span class="tiny-star">✳</span> SERIOUS SAUSAGE. SILLY NAME.</p>
                <h1>THE BEST<br />OF THE<br /><span>WURST.</span></h1>
                <p class="hero-description">
                    German-style sausages. A box of good times. <br />A very good reason to fire up the
                    barbie.
                </p>
                <div class="hero-buttons">
                    <a href="#boxes" class="button primary">Find your box <ArrowUpRight :size="21" /></a
                    ><Link href="/shop?category=gift" class="text-link"
                        >Give a little wurst <ArrowRight :size="18"
                    /></Link>
                </div>
                <div class="hero-footnote">
                    <span class="status-dot"></span>Coming to Sydney · Join the launch list
                </div>
            </div>
            <div class="hero-art">
                <div class="hero-photo">
                    <div class="hero-sticker">
                        100%<span>GOOD<br />TIMES</span><Sparkles :size="18" />
                    </div>
                    <ProductImage
                        slug="the-regular"
                        name="The Regular"
                        sizes="(max-width: 600px) 100vw, 50vw"
                        loading="eager"
                        fetchpriority="high"
                    />
                    <span class="hero-caption">AI-GENERATED BOX PREVIEW</span>
                </div>
                <img
                    class="hero-mascot"
                    src="/images/wiener-mascot-leaning.webp"
                    srcset="
                        /images/wiener-mascot-leaning-360.webp 360w,
                        /images/wiener-mascot-leaning.webp     720w
                    "
                    sizes="(max-width: 600px) 80vw, 50vw"
                    width="720"
                    height="913"
                    alt=""
                    aria-hidden="true"
                    decoding="async"
                    draggable="false"
                />
            </div>
        </section>
        <div class="brand-ribbon" aria-hidden="true">
            <span>GOOD TIMES COME IN LINKS</span><span>✳</span><span>BIG FLAVOUR. LITTLE FUSS.</span
            ><span>✳</span><span>GOOD TIMES COME IN LINKS</span><span>✳</span>
        </div>
        <FoodShowcase />
        <section id="boxes" class="section container">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">THERE’S A BOX FOR THAT.</p>
                    <h2>Pick your kind of good time.</h2>
                </div>
                <Link href="/shop" class="text-link"
                    >Explore the whole line-up <ArrowUpRight :size="20"
                /></Link>
            </div>
            <div class="product-grid">
                <ProductCard v-for="product in products" :key="product.id" :product="product" />
            </div>
            <p class="preview-note">
                A taste of what’s coming. Preview prices + estimated $12 delivery. Final contents and
                availability to be confirmed. Images show generated box and contents previews.
            </p>
        </section>
        <section class="how-section">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">FROM OUR BOX TO YOUR BBQ.</p>
                        <h2>Good food. Zero song and dance.</h2>
                    </div>
                    <span class="handwritten-star" aria-hidden="true">✳</span>
                </div>
                <div class="steps-grid">
                    <article>
                        <div class="step-icon"><PackageCheck :size="32" /><span>01</span></div>
                        <h3>Pick a box.</h3>
                        <p>Make it a regular thing, try a one-off, or send someone a delicious surprise.</p>
                    </article>
                    <article>
                        <div class="step-icon"><Truck :size="32" /><span>02</span></div>
                        <h3>We’ll bring the goods.</h3>
                        <p>
                            Chilled delivery is planned for our Sydney launch. Check your postcode for
                            updates.
                        </p>
                    </article>
                    <article>
                        <div class="step-icon"><Utensils :size="32" /><span>03</span></div>
                        <h3>Make a meal of it.</h3>
                        <p>Gather your favourite people. Add mustard. Let the good times roll.</p>
                    </article>
                </div>
            </div>
        </section>
        <section class="gift-section container">
            <div class="gift-panel">
                <div>
                    <p class="eyebrow">FOR YOUR FAVOURITE SAUSAGE.</p>
                    <h2>Say it with<br />sausages.</h2>
                    <p>
                        Birthdays. Thank-yous. “I saw this and thought of you.”<br />Some gifts just hit a
                        little differently.
                    </p>
                    <Link href="/products/the-big-gesture" class="button primary"
                        >Meet The Big Gesture <ArrowUpRight :size="21"
                    /></Link>
                </div>
                <div class="gift-art">
                    <span class="gift-doodle" aria-hidden="true">WITH<br />LOVE,<br />WURST.</span
                    ><ProductImage
                        slug="the-big-gesture"
                        name="The Big Gesture"
                        sizes="(max-width: 600px) 100vw, 50vw"
                    />
                    <p class="photo-caption">AI-generated box preview</p>
                </div>
            </div>
        </section>
        <section class="section container faq-section">
            <div>
                <p class="eyebrow">A FEW BURNING QUESTIONS.</p>
                <h2>The need<br />to know.</h2>
                <Link href="/how-it-works" class="text-link"
                    >Get the full lowdown <ArrowUpRight :size="20"
                /></Link>
            </div>
            <div class="faq-list">
                <details v-for="[question, answer] in faqs" :key="question">
                    <summary>{{ question }}<span>+</span></summary>
                    <p>{{ answer }}</p>
                </details>
            </div>
        </section>
        <section id="launch-list" class="launch-section">
            <div class="container launch-grid">
                <div>
                    <p class="eyebrow">THE GRILL IS WARMING UP.</p>
                    <h2>First in line.<br />First to the wurst.</h2>
                    <p>
                        We’re getting our ducks (well, sausages) in a row.<br />Leave your details for Sydney
                        launch news.
                    </p>
                    <span class="launch-star" aria-hidden="true">✳</span>
                </div>
                <WaitlistForm />
            </div>
        </section>
    </div>
</template>
