<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue';
import { ArrowLeft, ArrowRight, ArrowUpRight, ImageOff, Package, X, ZoomIn } from '@lucide/vue';
import { photoCaption, productGallery } from '../foodPhotography';
import ProductBadge from './ProductBadge.vue';
import { productBadge, supplierAwardsUrl } from '../productBadges';

const props = defineProps<{ slug: string; name: string; colour: string }>();
const photos = computed(() => productGallery(props.slug));
const selected = ref(0);
const active = computed(() => photos.value[selected.value] ?? photos.value[0]);
const imageFailed = ref(false);
const viewer = ref<HTMLDialogElement>();
const opener = ref<HTMLButtonElement>();
const thumbnails = ref<HTMLDivElement>();
const viewerOpen = ref(false);
let savedOverflow: string | null = null;
let unmounting = false;
let touchStart: { x: number; y: number } | null = null;

function select(index: number) {
    if (!photos.value.length) return;
    selected.value = (index + photos.value.length) % photos.value.length;
}

async function onKeydown(event: KeyboardEvent) {
    if (event.altKey || event.ctrlKey || event.metaKey) return;
    if (event.key === 'Tab' && viewer.value?.open) {
        const controls = viewer.value.querySelectorAll<HTMLButtonElement>('button:not(:disabled)');
        const first = controls[0];
        const last = controls[controls.length - 1];
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last?.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first?.focus();
        }
        return;
    }
    const changes: Record<string, number> = {
        ArrowLeft: selected.value - 1,
        ArrowRight: selected.value + 1,
        Home: 0,
        End: photos.value.length - 1,
    };
    if (!Object.hasOwn(changes, event.key)) return;
    event.preventDefault();
    select(changes[event.key]);
    if (thumbnails.value?.contains(event.target as Node)) {
        await nextTick();
        thumbnails.value.querySelector<HTMLButtonElement>('[aria-pressed="true"]')?.focus();
    }
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
        event.preventDefault();
        select(selected.value + (dx < 0 ? 1 : -1));
    }
}

function unlockPage() {
    if (savedOverflow !== null) {
        document.body.style.overflow = savedOverflow;
        savedOverflow = null;
    }
}

async function openViewer() {
    if (!viewer.value || viewerOpen.value) return;
    viewerOpen.value = true;
    await nextTick();
    if (!viewer.value || !viewerOpen.value) return;
    viewer.value.showModal();
    savedOverflow = document.body.style.overflow;
    document.body.style.overflow = 'hidden';
    viewer.value.querySelector<HTMLButtonElement>('.gallery-close')?.focus();
}

function closeViewer() {
    viewer.value?.close();
    viewerOpen.value = false;
    unlockPage();
}

function onClose() {
    viewerOpen.value = false;
    unlockPage();
    if (!unmounting) opener.value?.focus({ preventScroll: true });
}

watch(
    () => active.value?.src,
    () => {
        imageFailed.value = false;
    },
);
watch(
    () => props.slug,
    () => {
        selected.value = 0;
        closeViewer();
    },
);
onBeforeUnmount(() => {
    unmounting = true;
    closeViewer();
});
</script>
<template>
    <section class="product-gallery" :aria-label="`${name} photos`" @keydown="onKeydown">
        <template v-if="active">
            <div
                class="gallery-stage detail-art has-food-photo"
                :class="colour"
                @touchstart.passive="startSwipe"
                @touchend="endSwipe"
                @touchcancel="touchStart = null"
            >
                <button
                    ref="opener"
                    class="gallery-image-button"
                    type="button"
                    :aria-label="`Enlarge ${active.label.toLowerCase()} photo`"
                    :disabled="imageFailed"
                    @click="openViewer"
                >
                    <img
                        v-show="!imageFailed"
                        :key="active.src"
                        class="food-photo gallery-main-photo"
                        :src="active.src"
                        :srcset="active.srcset"
                        sizes="(max-width: 600px) 100vw, 55vw"
                        :alt="active.alt"
                        :width="active.width"
                        :height="active.height"
                        loading="eager"
                        decoding="async"
                        @error="imageFailed = true"
                    />
                    <span v-if="!imageFailed" class="gallery-enlarge"><ZoomIn :size="18" />View larger</span>
                </button>
                <ProductBadge :slug="slug" />
                <div v-if="imageFailed" class="gallery-image-error" role="status">
                    <ImageOff :size="30" />
                    <p>This photo couldn’t load. Try another view.</p>
                </div>
            </div>
            <div class="gallery-toolbar">
                <p class="gallery-position" aria-live="polite" aria-atomic="true">
                    <strong>{{ active.label }}</strong
                    ><span>{{ selected + 1 }} / {{ photos.length }}</span>
                </p>
                <div v-if="photos.length > 1" class="gallery-arrows">
                    <button type="button" aria-label="Previous photo" @click="select(selected - 1)">
                        <ArrowLeft :size="19" />
                    </button>
                    <button type="button" aria-label="Next photo" @click="select(selected + 1)">
                        <ArrowRight :size="19" />
                    </button>
                </div>
            </div>
            <div
                v-if="photos.length > 1"
                ref="thumbnails"
                class="gallery-thumbnails"
                role="group"
                aria-label="Choose a photo"
            >
                <button
                    v-for="(photo, index) in photos"
                    :key="photo.src"
                    type="button"
                    :aria-label="`Show photo ${index + 1}: ${photo.label}`"
                    :aria-pressed="index === selected"
                    @click="select(index)"
                >
                    <img
                        :src="photo.src"
                        :srcset="photo.srcset"
                        sizes="96px"
                        alt=""
                        :width="photo.width"
                        :height="photo.height"
                        loading="lazy"
                    />
                    <span>{{ photo.label }}</span>
                </button>
            </div>
            <p class="photo-caption">{{ photoCaption(active) }}</p>
            <p v-if="productBadge(slug)" class="product-award-reference">
                Award-winning sausages from German Butchery.
                <a
                    :href="supplierAwardsUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="View German Butchery supplier awards (opens in a new tab)"
                    >View supplier awards <ArrowUpRight :size="13" aria-hidden="true" />
                </a>
            </p>
            <p v-if="active.reference" class="photo-reference">
                Product reference:
                <a
                    :href="active.reference.url"
                    :aria-label="`${active.reference.name} · German Butchery (opens in a new tab)`"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    {{ active.reference.name }} · German Butchery
                    <ArrowUpRight :size="12" aria-hidden="true" />
                </a>
            </p>
            <dialog
                ref="viewer"
                class="gallery-dialog"
                :aria-label="`${name} photo viewer`"
                @cancel.prevent="closeViewer"
                @close="onClose"
                @click="$event.target === viewer && closeViewer()"
            >
                <div v-if="viewerOpen" class="gallery-dialog-panel">
                    <header class="gallery-dialog-header">
                        <h2>{{ name }}</h2>
                        <button
                            type="button"
                            class="gallery-close"
                            aria-label="Close photo viewer"
                            autofocus
                            @click="closeViewer"
                        >
                            <X :size="24" />
                        </button>
                    </header>
                    <div
                        class="gallery-dialog-image"
                        @touchstart.passive="startSwipe"
                        @touchend="endSwipe"
                        @touchcancel="touchStart = null"
                    >
                        <img
                            :src="active.src"
                            :alt="active.alt"
                            :width="active.width"
                            :height="active.height"
                        />
                    </div>
                    <div class="gallery-toolbar">
                        <p class="gallery-position" aria-live="polite" aria-atomic="true">
                            <strong>{{ active.label }}</strong
                            ><span>{{ selected + 1 }} / {{ photos.length }}</span>
                        </p>
                        <div v-if="photos.length > 1" class="gallery-arrows">
                            <button type="button" aria-label="Previous photo" @click="select(selected - 1)">
                                <ArrowLeft :size="19" />
                            </button>
                            <button type="button" aria-label="Next photo" @click="select(selected + 1)">
                                <ArrowRight :size="19" />
                            </button>
                        </div>
                    </div>
                    <p class="photo-caption">{{ photoCaption(active) }}</p>
                </div>
            </dialog>
        </template>
        <div v-else class="detail-art" :class="colour">
            <div class="pack-art">
                <Package :size="80" /><strong>{{ name }}</strong
                ><span>PRODUCT PHOTOGRAPHY COMING SOON</span>
            </div>
        </div>
    </section>
</template>
