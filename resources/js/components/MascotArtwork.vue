<script setup lang="ts">
import { computed } from 'vue';
import { mascotArtwork } from '../mascotArtwork';

const props = withDefaults(
    defineProps<{ pose: keyof typeof mascotArtwork; sizes?: string; emphasis?: boolean }>(),
    { sizes: '180px', emphasis: false },
);
const artwork = computed(() => mascotArtwork[props.pose]);
</script>
<template>
    <span
        class="section-mascot"
        :class="{ 'mascot-emphasis': emphasis }"
        :data-pose="pose"
        aria-hidden="true"
    >
        <img
            :src="artwork.src"
            :srcset="artwork.srcset"
            :sizes="sizes"
            :width="artwork.width"
            :height="artwork.height"
            :style="{ maskImage: `url(${artwork.mask})`, WebkitMaskImage: `url(${artwork.mask})` }"
            alt=""
            loading="lazy"
            decoding="async"
            draggable="false"
        />
    </span>
</template>
