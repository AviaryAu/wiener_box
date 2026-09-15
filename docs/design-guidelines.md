# Wiener Box design guidelines

Version 1.0 · 15 September 2026

## Purpose and implementation

This is the design reference for the storefront, customer journeys, marketing and business admin. The approved territory is **Serious sausage. Silly name.** Use generous layouts, expressive typography, original cartoon illustrations and plain, dependable shopping controls.

The implementation source of truth is `resources/css/tokens.css`. Shared Vue components live in `resources/js/components`. Change a token or shared component before introducing a page-specific variation. The brand concept is in `brand/wiener-box-concept.png`; it provides art direction, not exact production colour or font measurements.

## 1. Typography

| Role | Family / weight | Size and leading | Rule |
|---|---|---|---|
| Wordmark | Lilita One, 400 | 28–40 px / 0.85 | Stacked WIENER / BOX; use approved lockup when available |
| Hero | Lilita One, 400 | Fluid 64–112 px / 0.9 | Maximum three short lines; uppercase optional |
| Page heading | Lilita One, 400 | Fluid 44–72 px / 1 | One H1 per page |
| Section heading | Lilita One, 400 | Fluid 36–56 px / 1.05 | Short and direct |
| Product title | Lilita One, 400 | 28–36 px / 1.1 | Preserve readable product names |
| Body | DM Sans, 400 / 500 | 16–18 px / 1.65 | 60–70 characters maximum line length |
| Button/navigation | DM Sans, 700 | 12–16 px / 1.2 | Sentence case, clear action |
| Eyebrow/caption | DM Sans, 700 | 9–12 px / 1.4 | Uppercase, 0.12 em tracking |
| Compact card copy | DM Sans, 400 / 500 | 13–14 px / 1.7 | Supporting product summaries; keep important conditions readable |
| Price/data | DM Sans, 700 | 20–32 px / 1.1 | Tabular numerals, never cartoon lettering for dense data |
| Admin body | DM Sans, 400 / 600 | 14–16 px / 1.5 | Compact, calm and task-focused |

Self-host fonts through Fontsource packages. Load Latin subsets, use `font-display: swap`, and retain the supplied SIL Open Font License files. Fallbacks: `Impact, sans-serif` for display and `Arial, sans-serif` for body. Do not add a third family or fake bold to Lilita One. [Lilita One source](https://github.com/google/fonts/tree/main/ofl/lilitaone), [DM Sans source](https://github.com/google/fonts/tree/main/ofl/dmsans)

## 2. Colour tokens

| Token | Value | Purpose |
|---|---|---|
| `--color-ink` | `#181714` | Main type, key buttons, outlines, footer |
| `--color-mustard` | `#FFCF24` | Primary brand field and highlights |
| `--color-red` | `#E43C2F` | Large display accents and illustration |
| `--color-cream` | `#FFF5DD` | Main page background |
| `--color-paper` | `#FFFCF4` | Form and card reading surfaces |
| `--color-red-dark` | `#A52821` | Accessible red text and error accents |
| `--color-muted` | `#686154` | Secondary text on light surfaces |
| `--color-line` | `#D9CFB9` | Quiet dividers |
| `--color-peach` | `#F8C6AF` | Gift illustration field |
| `--color-sage` | `#DCE3BC` | Shop/recipe illustration field |
| `--color-success` | `#34563B` | Confirmed success text |

German flag colours establish the identity. Cream should occupy most reading surfaces; peach and sage are supporting illustration backgrounds, not replacement brand colours. Avoid gradients, glass effects, blue SaaS styling and excessive saturated panels.

### Accessible pairings

Calculated contrast ratios: ink/cream **16.52:1**, ink/mustard **12.12:1**, cream/dark red **6.62:1**. Ink/brand red is only **4.26:1**, and cream/brand red is **3.88:1**: reserve these for large display text and decoration, not normal body text or small button labels. Use ink buttons with cream labels, or dark-red buttons with cream labels.

Errors and success always include words or an icon with accessible text. A red border alone is insufficient. Focus rings use a high-contrast ink outline with a cream offset.

## 3. Layout and spacing

- Maximum content width: 1280 px. Desktop gutters: 48–64 px; tablet: 32 px; mobile: 20 px.
- Spacing scale: 4, 8, 12, 16, 24, 32, 48, 64, 96 px. Use tokens, not arbitrary near-duplicates.
- Hero: two columns from 900 px, stacked on smaller screens. Keep the product proposition and primary action ahead of the illustration in document order.
- Product grid: three columns on wide screens, two from 640 px, one below 640 px.
- Breakpoints: 640 px, 900 px, 1200 px. Do not use device-specific model names.
- Section padding: 72–96 px desktop, 48–64 px mobile. Allow content to define height.
- Avoid horizontal overflow at 320 px. Sticky navigation must not obscure anchor headings or focus.

## 4. Shapes and texture

Use rounded rectangles with purpose: 12 px controls, 20 px cards, 28 px major illustration panels. Pill shapes belong to compact labels and filter controls. Use 2 px ink outlines for expressive cards; quieter 1 px borders for forms and admin tables.

Hard offset shadows, usually `4px 4px 0 var(--color-ink)`, may emphasise a CTA or selected card. Avoid soft floating shadows everywhere. Small decorative rotations may be up to 8 degrees; do not rotate interactive controls, prices or paragraph text.

Paper grain is subtle and belongs in artwork. Keep text and form surfaces clean. No background gradients or blurry glows.

## 5. Shared components

### Header and navigation

Use the stacked wordmark at left, primary links in the centre and account/cart at right. A short upper strip can communicate launch or delivery status. Collapse navigation behind a labelled toggle on mobile. Show a real cart quantity and keep all icon buttons at least 44 × 44 px.

### Buttons

- Primary: ink background, cream text, clear focus, optional small arrow.
- Secondary: cream background, ink border and text.
- Compact controls: 44 px minimum target. Main CTAs: 52–56 px tall.
- Hover: subtle translation or background change. Loading: disable repeated submission, maintain width and show action text.
- Label the consequence: “Add to box”, “Check postcode”, “Join the launch list”. Reserve “Checkout” for a working, correctly configured payment journey.

### Product cards

Product photograph, small type/category label, title, concise proposition, price and cadence, then action. Show “per month” and delivery treatment beside subscription prices. Do not fabricate review counts, savings, inventory scarcity, weights or servings.

Cart rows use the same title/price format, labelled quantity controls and an explicit remove action. Recalculate totals on the server. Separate recurring and one-off lines.

### Forms and dialogs

Visible labels, 16 px minimum input text, specific inline errors, autocomplete hints and a persistent submission result. Never use placeholders as the only label. Preserve entered data after validation errors. Avoid essential interactions that depend on hover.

Dialogs must trap focus, close with Escape, restore focus and prevent background scrolling. Prefer an ordinary page when a modal adds no value. Native disclosure elements work well for FAQs.

### Admin

Use DM Sans, restrained mustard accents, semantic statuses and clear data hierarchy. Display real database values; empty states explain the next task. Staff actions require authentication and explicit permissions. Do not apply storefront jokes to money, expiry, billing errors or incident handling.

## 6. Imagery and iconography

The Happy Link mascot has a curved orange-brown body, expressive eyes, cream gloves, black limbs and red oversized shoes. Preserve its silhouette and facial proportions. Keep safe space around hands and feet. Do not stretch illustrations or place busy artwork behind text.

Keep original PNG artwork and web-friendly optimised copies. Preserve alpha when an illustration needs transparency. Photographs render at their natural colours without blend modes or decorative rotation. Include intrinsic image dimensions. Give informative images useful alt text; decorative stars and repeated mascots have empty alt text.

Shopping surfaces use realistic open-box photography showing sealed sausage packs inside. The hero, subscription and gift listings, product galleries and cart use the matching photograph for each offer. Keep the original cartoon packaging in the brand archive; new carton photography carries the playful wordmark and printed mascot.

The homepage hero pairs that photograph with the Happy Link mascot leaning across its lower-left frame edge. Keep the mascot separate from the product photo, with its glove overlapping the frame and its face, wave and shoes fully visible. Reserve space to the left and below the photo so the character stays clear of the headline, actions, box contents and preview caption at every screen size. Use the same composition on mobile. The decorative character uses empty alt text and cannot intercept clicks. The current cream-matte artwork is clipped to its contour in CSS; keep that contour paired with `wiener-mascot-leaning.webp` when resizing or replacing the asset.

### Food photography

Pair the mascot and branded packaging with appetising, photorealistic food imagery. Use bright daylight from the upper left, natural casing and grill texture, cream ceramics, mustard tabletops and small red linen accents. Keep individual sausages recognisable: slender smooth wieners, golden grilled bratwurst and smoked kransky with visible cheese pockets. Avoid dark rustic backgrounds, exaggerated cheese pulls, plastic-looking surfaces and text baked into photographs.

Individual sausage listings use square food images consistently across cards, detail pages and cart thumbnails. Subscription and gift cards use their own open-box photograph. Box galleries combine that view with sausage and serving inspiration; individual sausage galleries have plated and close-up views. Preserve the open box, visible contents and food when cropping, use intrinsic dimensions and responsive WebP sizes, and load below-the-fold images lazily. Do not apply the mascot's rotation or blend mode to photography.

The current food and box images are AI-generated previews, not photographs of supplier stock. Use a box-preview caption for open cartons and a serving-suggestion caption for plated food. Label this beside food imagery, keep confirmed contents separate, and do not imply that garnishes, sides, quantities or packaging shown are included. Before opening sales, replace these concepts with approved photos of the actual products. The reusable asset mapping is `resources/js/foodPhotography.ts`; original PNGs and generation prompts are retained under `brand/photography` and `brand/image-prompts.md`.

Use German Butchery's actual product photos and descriptions as the sausage reference. Our Classic Wieners correspond to its [Continental Frankfurter](https://www.german-butchery.com.au/products/sausages/frankfurterpork); Bratwurst references [German Bratwurst](https://www.german-butchery.com.au/products/sausages/thueringerbratwurst); Cheese Kransky references its [Cheese Kransky](https://www.german-butchery.com.au/products/sausages/kranskycheese). Preserve the lighter frankfurter casing, slender pale bratwurst and natural smoked kransky texture visible in those images. Keep our own tabletop, props, composition and brand palette. Supplier screenshots are reference inputs only; do not publish the website UI, awards or logos as our artwork. Gallery views of individual sausages link to their specific product reference.

### Product galleries

Every launch product has selectable thumbnails: five views for boxes and two for individual sausages. Use the ordered data in `resources/js/foodPhotography.ts` and the shared `ProductGallery.vue` component. The first image is also the listing and cart image. New originals live under `brand/photography`; 480, 800 and 1200 px WebP copies live under `public/images/products`.

Provide previous/next buttons, a visible image count and pressed states on thumbnails. Support arrow keys, Home/End and horizontal swipes; do not autoplay. Open the larger view in a native modal dialog with contained keyboard focus, Escape and a visible close button. Restore focus and page scrolling on close or navigation. Preserve the complete image in the main gallery and enlarged view, and show a useful message if an image fails to load.

Use one consistent outline icon family (Lucide), with 1.8–2 px strokes. Standard sizes: 16, 20 and 24 px. Icons accompany labels unless the function has an accessible name.

## 7. Voice and shopping clarity

Warm, direct and a little cheeky. One joke per section. Examples: “The best of the wurst”, “Make it a regular thing”, “Good times come in links”.

Keep factual moments plain: ingredients, allergens, temperature, recurring charges, cancellation, late delivery and refunds. Never call an unconfirmed supplier relationship a partnership. Use “German-style” where that accurately describes the offer.

Prelaunch screens say that orders are not open. Distinguish preview prices from verified retail offers. Technical setup details belong in the admin and implementation notes.

## 8. Motion and accessibility

Use 150–220 ms transitions for opacity, background and small transforms. Avoid continuous mascot movement, autoplay carousels or animated purchasing pressure. Respect `prefers-reduced-motion` by removing decorative motion and smooth scrolling.

Use semantic landmarks, one H1, a skip link, visible focus and keyboard-accessible controls. Announce cart and form updates with a polite live region. Verify layouts at 320, 390, 768 and 1440 px, keyboard navigation and 200% text zoom.

## 9. Review before merging

1. Fonts and colours use shared tokens; no new family or unexplained hex code.
2. Mobile layout, focus, labels and contrast remain usable.
3. Price, subscription cadence, delivery cost and availability are honest and consistent.
4. Artwork does not misrepresent final product contents or supplier permission.
5. Forms, links, cart actions and empty/error states actually work.
6. Admin data is real and sensitive actions are protected.
7. Update this guide and shared components together when changing the system.
