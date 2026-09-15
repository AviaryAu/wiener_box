export const productBadges = {
    'the-regular': { variant: 'mustard', points: 14, innerRadius: 79, rotation: -10 },
    'the-fling': { variant: 'red', points: 12, innerRadius: 77, rotation: 9 },
    'the-big-gesture': { variant: 'ink', points: 16, innerRadius: 82, rotation: -7 },
} as const;

export function productBadge(slug: string) {
    return Object.hasOwn(productBadges, slug) ? productBadges[slug as keyof typeof productBadges] : null;
}

export const supplierAwardsUrl = 'https://www.german-butchery.com.au/awards';
