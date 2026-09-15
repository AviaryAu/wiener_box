<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight, PackageCheck, Truck, Utensils } from '@lucide/vue';
</script>
<template>
    <div class="container section">
        <div class="narrow-intro">
            <p class="eyebrow">A LITTLE METHOD TO THE MUSTARD.</p>
            <h1>A good feed.<br />A <span class="brand-underline">simple idea.</span></h1>
            <p class="page-intro">
                Wiener Box is a German-style sausage service in the making. A regular delivery of new
                favourites, with one-off boxes, gifts and individual packs for every other occasion.
            </p>
        </div>
        <div class="steps-grid standalone-steps">
            <article>
                <PackageCheck :size="36" />
                <h2>1. Find your box.</h2>
                <p>
                    The Big Wiener Club is our proposed monthly discovery box. The Wurst Fling is a one-off.
                    Nice Package is for someone you like a lot. You can also build your own selection of
                    packs.
                </p>
            </article>
            <article>
                <Truck :size="36" />
                <h2>2. Check your patch.</h2>
                <p>
                    We’re planning chilled Sydney delivery first. The current estimate is $12 per delivery.
                    Dates, cut-offs and coverage will be confirmed before orders open.
                </p>
                <Link href="/delivery" class="text-link"
                    >Check your postcode <ArrowUpRight :size="18"
                /></Link>
            </article>
            <article>
                <Utensils :size="36" />
                <h2>3. Make good times.</h2>
                <p>
                    Fire up the BBQ, rustle up a weeknight dinner or give a very edible gift. Exact contents,
                    storage advice and product information will accompany the final range.
                </p>
            </article>
        </div>
        <div class="info-banner">
            <div>
                <p class="eyebrow">WHERE WE’RE AT</p>
                <h2>Still warming up.</h2>
                <p>
                    You’re exploring a prelaunch preview. No payments are taken. Supplier arrangements,
                    delivery partners, subscription terms and product details are being finalised.
                </p>
            </div>
            <Link href="/#launch-list" class="button primary"
                >Join the launch list <ArrowUpRight :size="21"
            /></Link>
        </div>
    </div>
</template>
