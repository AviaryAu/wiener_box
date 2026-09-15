<script setup lang="ts">
import { computed } from 'vue';
import { productBadge } from '../productBadges';

const props = defineProps<{ slug: string }>();
const badge = computed(() => productBadge(props.slug));
const outline = computed(() => {
    if (!badge.value) return '';
    const { points, innerRadius } = badge.value;
    return Array.from({ length: points * 2 }, (_, index) => {
        const angle = (index * Math.PI) / points - Math.PI / 2;
        const radius = index % 2 ? innerRadius : 94 + (index % 3);
        return `${(100 + Math.cos(angle) * radius).toFixed(2)},${(100 + Math.sin(angle) * radius).toFixed(2)}`;
    }).join(' ');
});
</script>
<template>
    <span
        v-if="badge"
        class="product-badge"
        :class="`product-badge--${badge.variant}`"
        :style="{ '--badge-rotation': `${badge.rotation}deg` }"
        role="img"
        aria-label="Award winning sausages · German Butchery range"
    >
        <svg viewBox="0 0 208 208" aria-hidden="true" focusable="false">
            <polygon class="badge-shadow" :points="outline" transform="translate(4 5)" />
            <polygon class="badge-burst" :points="outline" />
            <path
                class="badge-centre"
                d="M100 29C141 28 173 60 173 100C174 140 141 171 101 172C61 172 28 141 29 101C27 61 60 30 100 29Z"
            />
            <g class="badge-sparkles" stroke-linecap="round" stroke-linejoin="round">
                <path d="M100 38L103 46L111 49L103 52L100 60L97 52L89 49L97 46Z" />
                <path d="M76 47L73 43M124 47L127 43" fill="none" />
            </g>
            <g class="badge-lettering" text-anchor="middle">
                <text class="badge-award" x="100" y="83">AWARD</text>
                <text class="badge-winning" x="100" y="111">WINNING</text>
                <text class="badge-sausages" x="100" y="134">SAUSAGES</text>
            </g>
            <g class="badge-flourish" stroke-linecap="round" stroke-linejoin="round">
                <path
                    v-if="badge.variant === 'ink'"
                    d="M100 158C78 145 94 136 100 145C107 136 122 145 100 158Z"
                />
                <path
                    v-else
                    d="M86 146C94 153 105 153 113 145C117 141 122 148 117 153C106 165 90 162 82 153C78 149 82 142 86 146Z"
                />
                <path d="M70 148L65 145M70 154L64 155M130 148L135 145M130 154L136 155" fill="none" />
            </g>
        </svg>
    </span>
</template>
