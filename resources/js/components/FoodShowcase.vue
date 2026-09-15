<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight } from '@lucide/vue';
import { sausageSpread } from '../foodPhotography';
</script>
<template>
    <section class="food-showcase-section container" aria-labelledby="food-showcase-title">
        <div class="food-showcase">
            <figure class="food-showcase-photo">
                <img
                    :src="sausageSpread.src"
                    :srcset="sausageSpread.srcset"
                    sizes="(max-width: 760px) 100vw, 60vw"
                    :alt="sausageSpread.alt"
                    :width="sausageSpread.width"
                    :height="sausageSpread.height"
                    loading="lazy"
                    decoding="async"
                />
                <figcaption>AI-generated serving suggestion</figcaption>
            </figure>
            <div class="food-showcase-copy">
                <p class="eyebrow">A LITTLE SIZZLE. A LOT TO LOVE.</p>
                <h2 id="food-showcase-title">Go on.<br />Have a proper<br /><span>sausage.</span></h2>
                <p>
                    Classic wieners. Golden bratwurst. A little cheesy kransky. Meet the line-up for your next
                    very good cook-up.
                </p>
                <Link href="/shop?category=pack" class="button primary"
                    >Meet the sausages <ArrowUpRight :size="20"
                /></Link>
                <p class="food-serving-note">
                    Serving inspiration. Final products and pack sizes to be confirmed.
                </p>
            </div>
        </div>
    </section>
</template>
