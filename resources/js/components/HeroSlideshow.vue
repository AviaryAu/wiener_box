<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, ArrowRight, ArrowUpRight, Pause, Play, Sparkles } from '@lucide/vue';
import ProductImage from './ProductImage.vue';

const slides = ['The good stuff', 'The Big Wiener Club', 'Recipes & good ideas'];
const slideDuration = 8000;
const activeSlide = ref(0);
const slideshow = ref<HTMLElement>();
const markers = ref<HTMLElement>();
const isPaused = ref(true);
const isHovered = ref(false);
const isVisible = ref(false);
const isPageHidden = ref(false);
const isRotating = computed(
    () => !isPaused.value && !isHovered.value && isVisible.value && !isPageHidden.value,
);
let rotationTimer: ReturnType<typeof setInterval> | undefined;
let visibilityObserver: IntersectionObserver | undefined;
let motionPreference: MediaQueryList | undefined;
let touchStart: { x: number; y: number } | null = null;

function selectSlide(index: number) {
    isPaused.value = true;
    activeSlide.value = (index + slides.length) % slides.length;
}

async function handleKeydown(event: KeyboardEvent) {
    if (event.altKey || event.ctrlKey || event.metaKey) return;
    const destinations: Record<string, number> = {
        ArrowLeft: activeSlide.value - 1,
        ArrowRight: activeSlide.value + 1,
        Home: 0,
        End: slides.length - 1,
    };
    if (!Object.hasOwn(destinations, event.key)) return;
    event.preventDefault();
    selectSlide(destinations[event.key]);
    if (markers.value?.contains(event.target as Node)) {
        await nextTick();
        markers.value.querySelector<HTMLButtonElement>('[aria-pressed="true"]')?.focus();
    }
}

function pauseOnFocus(event: FocusEvent) {
    if (!(event.target as HTMLElement).closest('.hero-playback')) isPaused.value = true;
}

function startSwipe(event: TouchEvent) {
    touchStart =
        event.touches.length === 1 ? { x: event.touches[0].clientX, y: event.touches[0].clientY } : null;
}

function endSwipe(event: TouchEvent) {
    if (!touchStart || !event.changedTouches.length) return;
    const dx = event.changedTouches[0].clientX - touchStart.x;
    const dy = event.changedTouches[0].clientY - touchStart.y;
    touchStart = null;
    if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy) * 1.3) {
        selectSlide(activeSlide.value + (dx < 0 ? 1 : -1));
    }
}

function updatePageVisibility() {
    isPageHidden.value = document.hidden;
}

function updateMotionPreference() {
    if (motionPreference?.matches) isPaused.value = true;
}

watch(isRotating, (rotating) => {
    clearInterval(rotationTimer);
    if (rotating) {
        rotationTimer = setInterval(() => {
            activeSlide.value = (activeSlide.value + 1) % slides.length;
        }, slideDuration);
    }
});

onMounted(() => {
    motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
    isPaused.value = motionPreference.matches;
    motionPreference.addEventListener('change', updateMotionPreference);
    updatePageVisibility();
    document.addEventListener('visibilitychange', updatePageVisibility);
    visibilityObserver = new IntersectionObserver(
        ([entry]) => {
            isVisible.value = entry.isIntersecting;
        },
        { threshold: 0.15 },
    );
    if (slideshow.value) visibilityObserver.observe(slideshow.value);
});

onBeforeUnmount(() => {
    clearInterval(rotationTimer);
    visibilityObserver?.disconnect();
    motionPreference?.removeEventListener('change', updateMotionPreference);
    document.removeEventListener('visibilitychange', updatePageVisibility);
});
</script>

<template>
    <section
        ref="slideshow"
        class="hero hero-slideshow container"
        aria-roledescription="carousel"
        aria-label="A taste of Wiener Box"
        @pointerenter="isHovered = $event.pointerType === 'mouse'"
        @pointerleave="isHovered = false"
        @focusin="pauseOnFocus"
        @keydown="handleKeydown"
    >
        <div
            class="hero-stage"
            :aria-live="isRotating ? 'off' : 'polite'"
            @touchstart.passive="startSwipe"
            @touchend.passive="endSwipe"
            @touchcancel="touchStart = null"
        >
            <div
                id="hero-slide-1"
                class="hero-slide"
                :class="{ 'is-active': activeSlide === 0 }"
                role="group"
                aria-roledescription="slide"
                :aria-label="`1 of ${slides.length}: The good stuff`"
                :aria-hidden="activeSlide !== 0"
                :inert="activeSlide !== 0"
            >
                <div class="hero-copy">
                    <p class="eyebrow">
                        <span class="tiny-star" aria-hidden="true">✳</span> SERIOUS SAUSAGE. SILLY NAME.
                    </p>
                    <h1>THE BEST<br />OF THE<br /><span class="brand-underline">WURST.</span></h1>
                    <p class="hero-description">
                        German-style sausages. A box of good times. <br />A very good reason to fire up the
                        barbie.
                    </p>
                    <div class="hero-buttons">
                        <a href="#boxes" class="button primary">Find your box <ArrowUpRight :size="21" /></a>
                        <Link href="/shop?category=gift" class="text-link"
                            >Give a little wurst <ArrowRight :size="18"
                        /></Link>
                    </div>
                    <div class="hero-footnote">
                        <span class="status-dot"></span>Coming to Sydney · Join the launch list
                    </div>
                </div>
                <div class="hero-art">
                    <span class="brand-rays" aria-hidden="true"></span>
                    <div class="hero-photo">
                        <div class="hero-sticker">
                            100%<span>GOOD<br />TIMES</span><Sparkles :size="18" />
                        </div>
                        <ProductImage
                            slug="the-regular"
                            name="The Big Wiener Club"
                            sizes="(max-width: 600px) 100vw, 50vw"
                            loading="eager"
                            fetchpriority="high"
                        />
                    </div>
                    <img
                        class="hero-mascot"
                        src="/images/wiener-mascot-leaning.webp"
                        srcset="
                            /images/wiener-mascot-leaning-360.webp 360w,
                            /images/wiener-mascot-leaning.webp     720w
                        "
                        sizes="(max-width: 600px) 68vw, 42vw"
                        width="720"
                        height="913"
                        alt=""
                        aria-hidden="true"
                        decoding="async"
                        draggable="false"
                    />
                </div>
            </div>
            <div
                id="hero-slide-2"
                class="hero-slide hero-club-slide"
                :class="{ 'is-active': activeSlide === 1 }"
                role="group"
                aria-roledescription="slide"
                :aria-label="`2 of ${slides.length}: The Big Wiener Club`"
                :aria-hidden="activeSlide !== 1"
                :inert="activeSlide !== 1"
            >
                <div class="hero-copy">
                    <p class="eyebrow">
                        <span class="tiny-star" aria-hidden="true">✳</span> VERY IMPORTANT SAUSAGE PEOPLE.
                    </p>
                    <h2 class="hero-club-title">
                        <span class="hero-club-intro">JOIN THE</span>BIG WIENER<br /><span
                            class="hero-club-accent brand-underline"
                            >CLUB.</span
                        >
                    </h2>
                    <p class="hero-description">
                        A regular delivery of very good sausages. <br />A deeply unserious thing to put in
                        your bio.
                    </p>
                    <div class="hero-buttons">
                        <a href="#launch-list" class="button primary"
                            >Get on the list <ArrowUpRight :size="21"
                        /></a>
                        <Link href="/products/the-regular" class="text-link"
                            >Inspect the package <ArrowRight :size="18"
                        /></Link>
                    </div>
                    <div class="hero-footnote">
                        <span class="status-dot"></span>Club coming soon · Big Wiener energy encouraged
                    </div>
                </div>
                <div class="hero-club-art">
                    <img
                        src="/images/big-wiener-club-illustrated.webp"
                        srcset="
                            /images/big-wiener-club-illustrated-480.webp  480w,
                            /images/big-wiener-club-illustrated-800.webp  800w,
                            /images/big-wiener-club-illustrated.webp     1200w
                        "
                        sizes="(max-width: 600px) 100vw, 55vw"
                        width="1200"
                        height="1200"
                        alt="Our sausage mascot holding an illustrated yellow Big Wiener Club membership card beside a closed Wiener Box and a fan of sausage packs."
                        decoding="async"
                        fetchpriority="low"
                        draggable="false"
                    />
                    <p class="hero-club-caption">BIG PERKS. QUESTIONABLE BRAGGING RIGHTS.</p>
                </div>
            </div>
            <div
                id="hero-slide-3"
                class="hero-slide hero-recipe-slide"
                :class="{ 'is-active': activeSlide === 2 }"
                role="group"
                aria-roledescription="slide"
                :aria-label="`3 of ${slides.length}: Recipes & good ideas`"
                :aria-hidden="activeSlide !== 2"
                :inert="activeSlide !== 2"
            >
                <div class="hero-copy">
                    <p class="eyebrow">
                        <span class="tiny-star" aria-hidden="true">✳</span> GOOD FOOD. QUESTIONABLE DISGUISE.
                    </p>
                    <h2 class="hero-recipe-title" aria-label="Wiener, Wiener, Chicken Dinner">
                        WIENER,<br />WIENER,<br /><span>CHICKEN<br />DINNER.</span>
                    </h2>
                    <p class="hero-description">
                        Chicken sausages. Golden potatoes. A very good dinner. <br />Our mascot has dressed
                        for the occasion.
                    </p>
                    <div class="hero-buttons">
                        <Link href="/recipes" class="button primary"
                            >Get cooking <ArrowUpRight :size="21"
                        /></Link>
                    </div>
                    <div class="hero-footnote">
                        <span class="status-dot"></span>Costume optional. Appetite essential.
                    </div>
                </div>
                <div class="hero-club-art">
                    <img
                        src="/images/wiener-chicken-sausage-dinner-framed.webp"
                        srcset="
                            /images/wiener-chicken-sausage-dinner-framed-480.webp  480w,
                            /images/wiener-chicken-sausage-dinner-framed-800.webp  800w,
                            /images/wiener-chicken-sausage-dinner-framed.webp     1200w
                        "
                        sizes="(max-width: 600px) 100vw, 55vw"
                        width="1200"
                        height="1200"
                        alt="Our sausage mascot in a chicken costume presenting a realistic chicken sausage tray bake with golden potatoes and lemon."
                        decoding="async"
                        fetchpriority="low"
                        draggable="false"
                    />
                    <p class="hero-club-caption">ALL FLAVOUR. A LITTLE FOWL PLAY.</p>
                </div>
            </div>
        </div>
        <div class="hero-controls">
            <div ref="markers" class="hero-milestones" role="group" aria-label="Choose a banner">
                <button
                    v-for="(slide, index) in slides"
                    :key="slide"
                    type="button"
                    class="hero-milestone"
                    :aria-label="`Show slide ${index + 1}: ${slide}`"
                    :aria-controls="`hero-slide-${index + 1}`"
                    :aria-pressed="activeSlide === index"
                    @click="selectSlide(index)"
                >
                    <span class="hero-milestone-track" aria-hidden="true">
                        <span
                            v-if="activeSlide === index && isRotating"
                            :key="activeSlide"
                            class="hero-milestone-progress"
                            :style="{ animationDuration: `${slideDuration}ms` }"
                        ></span>
                    </span>
                    <span class="hero-milestone-label"
                        ><span class="hero-milestone-number">0{{ index + 1 }}</span
                        >{{ slide }}</span
                    >
                </button>
            </div>
            <div class="hero-navigation" role="group" aria-label="Slideshow controls">
                <button
                    type="button"
                    class="hero-playback"
                    :aria-label="isPaused ? 'Play slideshow' : 'Pause slideshow'"
                    @click="isPaused = !isPaused"
                >
                    <Play v-if="isPaused" :size="16" /><Pause v-else :size="16" />
                </button>
                <span class="hero-slide-count" aria-hidden="true"
                    >{{ String(activeSlide + 1).padStart(2, '0') }} /
                    {{ String(slides.length).padStart(2, '0') }}</span
                >
                <button type="button" aria-label="Previous slide" @click="selectSlide(activeSlide - 1)">
                    <ArrowLeft :size="19" />
                </button>
                <button type="button" aria-label="Next slide" @click="selectSlide(activeSlide + 1)">
                    <ArrowRight :size="19" />
                </button>
            </div>
        </div>
    </section>
</template>

<style scoped>
.hero.hero-slideshow {
    display: block;
    padding-bottom: 26px;
}
.hero-stage {
    display: grid;
}
.hero-slide {
    grid-area: 1 / 1;
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1.08fr);
    align-items: center;
    gap: 20px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition:
        opacity 400ms ease,
        visibility 400ms;
}
.hero-slide.is-active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}
.hero-club-title {
    font-size: clamp(60px, 6.4vw, 89px);
    line-height: 0.94;
    letter-spacing: -0.035em;
}
.hero-club-intro {
    display: block;
    font-size: 0.36em;
    letter-spacing: 0.015em;
    margin-bottom: 14px;
}
.hero-club-accent {
    color: var(--color-red);
}
.hero-recipe-title {
    font-size: clamp(52px, 5.8vw, 80px);
    line-height: 0.9;
    letter-spacing: -0.035em;
}
.hero-recipe-title > span {
    color: var(--color-red);
}
.hero-club-art {
    position: relative;
    align-self: center;
}
.hero-club-art img {
    width: 100%;
    border-radius: var(--radius-panel);
}
.hero-club-caption {
    margin-top: 13px;
    text-align: center;
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 0.13em;
}
.hero-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    margin-top: 36px;
}
.hero-milestones {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
    width: min(100%, 800px);
}
.hero-milestone {
    display: flex;
    flex-direction: column;
    border: 0;
    padding: 10px 0;
    background: transparent;
    text-align: left;
    color: var(--color-muted);
}
.hero-milestone-track {
    width: 100%;
    display: block;
    position: relative;
    height: 3px;
    background: var(--color-line);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 12px;
}
.hero-milestone[aria-pressed='true'] {
    color: var(--color-ink);
}
.hero-milestone[aria-pressed='true'] .hero-milestone-track {
    background: var(--color-red);
}
.hero-milestone[aria-pressed='true'] .hero-milestone-track:has(.hero-milestone-progress) {
    background: var(--color-line);
}
.hero-milestone-progress {
    position: absolute;
    inset: 0;
    background: var(--color-red);
    transform-origin: left;
    animation: milestone-progress linear both;
}
.hero-milestone-label {
    display: flex;
    gap: 12px;
    font-size: 12px;
    font-weight: 800;
}
.hero-milestone-number {
    font-weight: 500;
    color: var(--color-muted);
}
.hero-navigation {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.hero-navigation button {
    display: grid;
    place-items: center;
    width: 44px;
    height: 44px;
    border: 1px solid var(--color-ink);
    border-radius: 50%;
    background: transparent;
    transition: background 150ms;
}
.hero-navigation button:hover {
    background: var(--color-mustard);
}
.hero-navigation .hero-playback {
    border-color: transparent;
}
.hero-slide-count {
    padding-inline: 4px 12px;
    font-size: 10px;
    font-weight: 700;
    font-variant-numeric: tabular-nums;
}
@keyframes milestone-progress {
    from {
        transform: scaleX(0);
    }
    to {
        transform: scaleX(1);
    }
}
@media (min-width: 601px) and (max-width: 899px) {
    .hero-club-title {
        font-size: 64px;
    }
    .hero-controls {
        gap: 20px;
    }
    .hero-milestones {
        gap: 16px;
    }
    .hero-slide-count {
        display: none;
    }
}
@media (max-width: 600px) {
    .hero-slide {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: 1fr auto;
        gap: 28px;
    }
    .hero-club-title {
        font-size: clamp(64px, 16vw, 88px);
    }
    .hero-recipe-title {
        font-size: clamp(55px, 15vw, 78px);
    }
    .hero-art {
        aspect-ratio: 1;
        align-items: center;
    }
    .hero-art > .hero-mascot {
        bottom: -3%;
    }
    .hero-club-art {
        width: 100%;
        max-width: 410px;
        margin-inline: auto;
    }
    .hero-club-caption {
        font-size: 8px;
        letter-spacing: 0.07em;
    }
    .hero-controls {
        margin-top: 26px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .hero-milestones {
        gap: 12px;
    }
    .hero-milestone-label {
        flex-direction: column;
        gap: 7px;
        font-size: 10px;
    }
    .hero-navigation {
        margin-left: auto;
    }
}
@media (prefers-reduced-motion: reduce) {
    .hero-slide,
    .hero-navigation button {
        transition: none;
    }
    .hero-milestone-progress {
        animation: none;
    }
}
</style>
