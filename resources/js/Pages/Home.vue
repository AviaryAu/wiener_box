<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight } from '@lucide/vue';
import ProductCard from '../components/ProductCard.vue';
import ProductImage from '../components/ProductImage.vue';
import WaitlistForm from '../components/WaitlistForm.vue';
import FoodShowcase from '../components/FoodShowcase.vue';
import MascotArtwork from '../components/MascotArtwork.vue';
import HeroSlideshow from '../components/HeroSlideshow.vue';
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
        'We’ll publish supplier-confirmed ingredients, allergens, pack sizes and storage instructions for every product before it goes on sale. Final selections, pack sizes and packaging will be confirmed before orders open.',
    ],
];
</script>
<template>
    <div>
        <HeroSlideshow />
        <div class="brand-ribbon" aria-hidden="true">
            <span>GOOD TIMES COME IN LINKS</span><span>✳</span><span>BIG FLAVOUR. LITTLE FUSS.</span
            ><span>✳</span><span>GOOD TIMES COME IN LINKS</span><span>✳</span>
        </div>
        <FoodShowcase />
        <section id="boxes" class="section container">
            <div class="section-heading boxes-heading">
                <div>
                    <p class="eyebrow">THERE’S A BOX FOR THAT.</p>
                    <h2>Pick your kind of <span class="brand-underline">good time.</span></h2>
                    <p>German-style sausage boxes, monthly discoveries and gifts, coming to Sydney.</p>
                </div>
                <MascotArtwork pose="choose" emphasis sizes="(max-width: 600px) 110px, 160px" />
                <Link href="/shop" class="text-link"
                    >Explore the whole line-up <ArrowUpRight :size="20"
                /></Link>
            </div>
            <div class="product-grid">
                <ProductCard v-for="product in products" :key="product.id" :product="product" />
            </div>
            <p class="preview-note">
                A taste of what’s coming. Preview prices + estimated $12 delivery. Final contents and
                availability to be confirmed.
            </p>
        </section>
        <section id="box-to-bbq" class="how-section watermark-panel watermark-bbq">
            <div class="container">
                <div class="section-heading how-heading">
                    <div>
                        <p class="eyebrow">FROM OUR BOX TO YOUR BBQ.</p>
                        <h2><span class="brand-underline">Good food.</span> Zero song and dance.</h2>
                    </div>
                    <MascotArtwork pose="deliver" emphasis sizes="(max-width: 600px) 120px, 180px" />
                </div>
                <div class="steps-grid">
                    <article>
                        <div class="step-illustration">
                            <span class="step-number">01</span>
                            <MascotArtwork
                                pose="step-box"
                                sizes="(max-width: 639px) 200px, (max-width: 899px) 170px, 220px"
                            />
                        </div>
                        <span class="step-pun">Love at first bite.</span>
                        <h3>Pick a box.</h3>
                        <p>Make it a regular thing, try a one-off, or send someone a delicious surprise.</p>
                    </article>
                    <article>
                        <div class="step-illustration">
                            <span class="step-number">02</span>
                            <MascotArtwork
                                pose="step-truck"
                                sizes="(max-width: 639px) 200px, (max-width: 899px) 170px, 220px"
                            />
                        </div>
                        <span class="step-pun">We’re on a roll.</span>
                        <h3>We’ll bring the goods.</h3>
                        <p>
                            Chilled delivery is planned for our Sydney launch. Check your postcode for
                            updates.
                        </p>
                    </article>
                    <article>
                        <div class="step-illustration">
                            <span class="step-number">03</span>
                            <MascotArtwork
                                pose="step-bbq"
                                sizes="(max-width: 639px) 200px, (max-width: 899px) 170px, 220px"
                            />
                        </div>
                        <span class="step-pun">Licence to grill.</span>
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
                    <div class="gift-actions">
                        <Link href="/products/the-big-gesture" class="button primary"
                            >Meet Nice Package <ArrowUpRight :size="21"
                        /></Link>
                        <MascotArtwork pose="gift" sizes="(max-width: 600px) 110px, 160px" />
                    </div>
                </div>
                <div class="gift-art">
                    <span class="gift-doodle" aria-hidden="true">WITH<br />LOVE,<br />WURST.</span
                    ><ProductImage
                        slug="the-big-gesture"
                        name="Nice Package"
                        sizes="(max-width: 600px) 100vw, 50vw"
                    />
                </div>
            </div>
        </section>
        <section class="section container faq-section">
            <div class="faq-intro">
                <p class="eyebrow">A FEW BURNING QUESTIONS.</p>
                <h2>The need<br /><span class="brand-underline">to know.</span></h2>
                <Link href="/how-it-works" class="text-link"
                    >Get the full lowdown <ArrowUpRight :size="20"
                /></Link>
                <MascotArtwork pose="curious" emphasis sizes="(max-width: 600px) 120px, 180px" />
            </div>
            <div class="faq-list">
                <details v-for="[question, answer] in faqs" :key="question">
                    <summary>{{ question }}<span>+</span></summary>
                    <p>{{ answer }}</p>
                </details>
            </div>
        </section>
        <section id="launch-list" class="launch-section watermark-panel watermark-box">
            <div class="container launch-grid">
                <div>
                    <p class="eyebrow">THE GRILL IS WARMING UP.</p>
                    <h2>First in line.<br />First to the wurst.</h2>
                    <div class="launch-copy-footer">
                        <p>
                            We’re getting our ducks (well, sausages) in a row. Leave your details for Sydney
                            launch news.
                        </p>
                        <MascotArtwork pose="announce" sizes="(max-width: 600px) 120px, 160px" />
                    </div>
                </div>
                <WaitlistForm />
            </div>
        </section>
    </div>
</template>
