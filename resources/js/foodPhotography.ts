export interface FoodPhoto {
    label: string;
    kind: 'serving' | 'box';
    src: string;
    srcset: string;
    alt: string;
    width: number;
    height: number;
    reference?: { name: string; url: string };
}

function photo(
    name: string,
    alt: string,
    options: { landscape?: boolean; reference?: FoodPhoto['reference'] } = {},
): FoodPhoto {
    const path = `/images/food/${name}-reference`;
    const width = options.landscape ? 1440 : 1200;
    return {
        label: options.landscape ? 'Serving idea' : 'On the plate',
        kind: 'serving',
        src: `${path}.webp`,
        srcset: `${path}-480.webp 480w, ${path}-800.webp 800w, ${path}.webp ${width}w`,
        alt,
        width,
        height: options.landscape ? 960 : 1200,
        reference: options.reference,
    };
}

const productPhotos: Record<string, FoodPhoto> = {
    'classic-wieners': photo(
        'classic-wieners',
        'Classic wiener sausages on a cream plate with mustard and cornichons — generated serving suggestion',
        {
            reference: {
                name: 'Continental Frankfurter',
                url: 'https://www.german-butchery.com.au/products/sausages/frankfurterpork',
            },
        },
    ),
    bratwurst: photo(
        'bratwurst',
        'Lightly browned German bratwurst with mustard and sauerkraut — generated serving suggestion',
        {
            reference: {
                name: 'German Bratwurst',
                url: 'https://www.german-butchery.com.au/products/sausages/thueringerbratwurst',
            },
        },
    ),
    'cheese-kransky': photo(
        'cheese-kransky',
        'Smoked cheese kransky, sliced to show the cheese filling — generated serving suggestion',
        {
            reference: {
                name: 'Cheese Kransky',
                url: 'https://www.german-butchery.com.au/products/sausages/kranskycheese',
            },
        },
    ),
};

export const sausageSpread = photo(
    'sausage-spread',
    'A sharing platter of German-style sausages with mustard, pickles and bread — generated serving suggestion',
    { landscape: true },
);

function studioPhoto(
    name: string,
    label: string,
    alt: string,
    kind: FoodPhoto['kind'] = 'serving',
    reference?: FoodPhoto['reference'],
): FoodPhoto {
    const path = `/images/products/${name}`;
    return {
        label,
        kind,
        alt,
        reference,
        src: `${path}.webp`,
        srcset: `${path}-480.webp 480w, ${path}-800.webp 800w, ${path}.webp 1200w`,
        width: 1200,
        height: 1200,
    };
}

export const defaultProductPhoto = studioPhoto(
    'regular-open-box',
    'Open box',
    'An open mustard Wiener Box showing individually sealed packs of assorted sausages — generated box preview',
    'box',
);

const boxContents = [
    { ...productPhotos['classic-wieners'], label: 'Wieners' },
    { ...productPhotos.bratwurst, label: 'Bratwurst' },
    { ...productPhotos['cheese-kransky'], label: 'Cheese Kransky' },
    sausageSpread,
];

const galleries: Record<string, readonly FoodPhoto[]> = {
    'the-regular': [defaultProductPhoto, ...boxContents],
    'the-fling': [
        studioPhoto(
            'fling-open-box',
            'Open box',
            'An open Wiener Box on a sage tabletop with mixed sausage packs visible inside — generated box preview',
            'box',
        ),
        ...boxContents,
    ],
    'the-big-gesture': [
        studioPhoto(
            'gift-open-box',
            'Open gift box',
            'An open Wiener Box gift carton with sealed sausage packs, a red ribbon and a gift card — generated box preview',
            'box',
        ),
        ...boxContents,
    ],
    'classic-wieners': [
        productPhotos['classic-wieners'],
        studioPhoto(
            'wieners-close-up',
            'A closer look',
            'A close view of lightly smoked wieners with one cut to show the fine filling — generated serving suggestion',
            'serving',
            productPhotos['classic-wieners'].reference,
        ),
    ],
    bratwurst: [
        productPhotos.bratwurst,
        studioPhoto(
            'bratwurst-close-up',
            'A closer look',
            'A close view of pale golden German bratwurst with a cut section — generated serving suggestion',
            'serving',
            productPhotos.bratwurst.reference,
        ),
    ],
    'cheese-kransky': [
        productPhotos['cheese-kransky'],
        studioPhoto(
            'kransky-close-up',
            'A closer look',
            'A close view of smoked cheese kransky with pale cheese pieces in the sliced filling — generated serving suggestion',
            'serving',
            productPhotos['cheese-kransky'].reference,
        ),
    ],
};

export function productGallery(slug: string | null): readonly FoodPhoto[] {
    return slug && Object.hasOwn(galleries, slug) ? galleries[slug] : [];
}

export function productPhoto(slug: string | null): FoodPhoto | undefined {
    return productGallery(slug)[0];
}

export function photoCaption(photo: FoodPhoto): string {
    return photo.kind === 'box'
        ? 'AI-generated box preview. Final selection, quantities and packaging may differ.'
        : 'AI-generated serving suggestion. Final products and pack sizes may differ; accompaniments are not included.';
}
