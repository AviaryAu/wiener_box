<script setup lang="ts">
import { computed } from 'vue';
import { mascotArtwork } from '../mascotArtwork';

const props = withDefaults(defineProps<{ pose: keyof typeof mascotArtwork; sizes?: string }>(), {
    sizes: '180px',
});
const artwork = computed(() => mascotArtwork[props.pose]);
</script>
<template>
    <img
        class="section-mascot"
        :data-pose="pose"
        :src="artwork.src"
        :srcset="artwork.srcset"
        :sizes="sizes"
        :width="artwork.width"
        :height="artwork.height"
        :style="{ maskImage: `url(${artwork.mask})`, WebkitMaskImage: `url(${artwork.mask})` }"
        alt=""
        aria-hidden="true"
        loading="lazy"
        decoding="async"
        draggable="false"
    />
</template>
