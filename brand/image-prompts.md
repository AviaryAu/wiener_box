# Concept artwork prompts

Tool: built-in image-generation tool. Generated 15 September 2026.

Final selected asset: `brand/wiener-box-concept.png`.

## Initial generation

Use case: logo-brand
Asset type: original brand concept board for a playful Australian German-sausage subscription business.
Primary request: explore an original "WIENER BOX" sausage mascot and wordmark in a bright vintage rubber-hose cartoon style. The user reference evokes 1930s cartoons with thick black outlines, expressive eyes, cream gloves, oversized shoes, hand-drawn lettering, flat bright colours and lightly distressed print texture. Create your own sausage character and distinct typography.
Subject: a smiling curved frankfurter character, little linked sausage ends, confident jaunty walking pose, waving a cream gloved hand, black rubber-hose limbs, red shoes, mustard yellow accent. Friendly and cheeky, appetising and suitable for families. Clearly a sausage.
Composition: polished landscape design exploration board on warm cream paper. Left two-thirds a large hero lockup with the mascot beside bold hand-lettered stacked text "WIENER BOX". Right third two smaller alternate mascot marks, one peeking out of a branded delivery box and one circular badge. Bottom a short neat strip of three colour swatches black, red, mustard yellow. Spacious professional composition.
Colour palette: near black #181714, mustard gold #FFCF24, red #E43C2F, warm cream #FFF5DD, toasted sausage brown as small character colour.
Text (verbatim): main "WIENER BOX"; small tagline "SERIOUS SAUSAGE. SILLY NAME."; optional tiny heading "BRAND EXPLORATION".
Constraints: distinctive original sausage mascot. No existing game characters, cup heads, straws, franchise logos, copied poses or copied wordmark. No photographic meat, no 3D, no gradients, no flags used as text, no mock website. This is concept artwork, not a finished vector logo.

## Targeted revision

Edit this brand exploration board. Preserve the exact three original sausage mascot drawings, WIENER BOX wordmarks, compositions and correct slogan. Replace the entire dark blurred glowing vignette background with solid warm cream #FFF5DD. Remove all background gradients, glows, cast shadows and dark airbrush effects. Make the flat mustard-yellow #FFCF24 and red #E43C2F vivid. All small headings, swatch labels and tagline must be dark ink and legible against the cream background. Keep vintage linework and slight paper texture. The finished image should be bright, cheerful, crisp, flat and graphic, like a professionally printed cartoon brand sheet on cream paper. Do not change lettering spelling or mascot design.

The generated board is a raster concept. Typography, exact brand hex values, print colours and small-size marks should follow the brand specification during vector refinement.

## Implementation assets — 15 September 2026

Created with the built-in image generation tool using `wiener-box-concept.png` as the visual reference:

- Hero: an original cheerful rubber-hose sausage mascot waving and leaning on a closed mustard delivery carton labelled WIENER BOX; cream gloves, black limbs, red shoes; no actual food contents. The first background contained a checkerboard, so a follow-up changed only that background to warm cream #FFF5DD, preserving the pose and character.
- Packaging: one closed mustard carton in a three-quarter view, red WIENER BOX lettering, black tape and a small printed sausage character; actual alpha transparency; no food-content claims.

Selected originals are retained as `public/images/hero.png` and `public/images/box.png`. The website serves resized WebP copies at quality 88 (1100 px hero, 1000 px carton). These are packaging concepts and mascot art, not photographs of saleable supplier products.

## Spelling correction — 15 September 2026

Mode: built-in image generation, targeted text edits. The confirmed brand is **Wiener Box**, with I before E. All logo lockups, the hero carton and the packaging illustration were corrected while preserving the existing character and visual direction.

Final saved assets:

- `brand/wiener-box-concept.png`
- `public/images/hero.png` → `public/images/wiener-hero.webp`
- `public/images/box.png` → `public/images/wiener-box.webp` (alpha transparency preserved)

The website uses new asset URLs so cached images cannot retain the old spelling.

### Final prompt set

#### Hero

Use case: text-localization. Edit this existing hero illustration. Correct ONLY the misspelled lettering on the yellow carton from WEINER BOX to WIENER BOX. Exact required text: WIENER on the first line, BOX on the second. Spell the first line W-I-E-N-E-R (I before E). Preserve the mascot identity, facial expression, waving pose, cream gloves, red shoes, box shape and perspective, red letter style, black outlines, colours, dimensions and flat warm cream background #FFF5DD. Do not redesign or add any elements. Return the corrected complete illustration.

#### Box

Use case: text-localization. Edit this existing yellow packaging illustration. Correct ONLY the misspelled front word from WEINER to WIENER. Exact label must read WIENER BOX. Spell WIENER W-I-E-N-E-R, I comes before E. Preserve the red lettering style with heavy black outline, box dimensions and three-quarter perspective, tape, textures, printed mascot, colours and composition. Preserve an actually transparent background with alpha, not a drawn checkerboard or solid dark backdrop. No redesign, no new objects. Return the complete corrected carton illustration.

#### Board

Use case: text-localization. Edit this existing original brand exploration board. Correct ALL THREE occurrences of the misspelling WEINER to WIENER: the main large central yellow logo, the upper-right carton logo, and the curved black text on the bottom-right yellow circular badge. Exact brand everywhere: WIENER BOX, with WIENER spelled W-I-E-N-E-R (I before E). Keep all mascot characters, their identities, poses, shapes, style, colours, layout and dimensions exactly as in the image. Preserve all other text verbatim, including SERIOUS SAUSAGE. SILLY NAME., colour swatches, and BRAND EXPLORATION. Only correct the brand spelling; do not redesign.

#### Packaging transparency correction

Use case: background-extraction. Edit target: attached corrected WIENER BOX packaging illustration. Remove the entire gray-and-white checkerboard background. Deliver a genuinely transparent PNG with an alpha channel: all pixels outside the carton must have alpha zero, not a drawn checkerboard and not a colored backdrop. Preserve the existing carton exactly: its mustard panels, black outlines, black tape, red lettering spelled WIENER BOX (W-I-E-N-E-R, I before E), small sausage drawing on the right, size, position, perspective, and printed texture. Change only the background to real transparency. No added shadows or new text.

## Food photography — 15 September 2026

Mode: built-in image generation, `photorealistic-natural`. Four original photorealistic serving concepts supplement the mascot and packaging.

### Final saved assets

| Subject | Original PNG | Website WebP | Placement |
| --- | --- | --- | --- |
| Classic wieners | `brand/photography/classic-wieners.png` | `public/images/food/classic-wieners.webp` | Individual product card, detail page and cart |
| Bratwurst | `brand/photography/bratwurst.png` | `public/images/food/bratwurst.webp` | Individual product card, detail page and cart |
| Cheese kransky | `brand/photography/cheese-kransky.png` | `public/images/food/cheese-kransky.webp` | Individual product card, detail page and cart |
| Sharing platter | `brand/photography/sausage-spread.png` | `public/images/food/sausage-spread.webp` | Homepage food feature and box detail pages |

WebP quality is 86. Square originals are 1254 × 1254 px and serve at 1200, 800 and 480 px wide. The landscape original is 1536 × 1024 px and serves at 1440, 800 and 480 px wide. Each image has `-800.webp` and `-480.webp` variants selected through `srcset`.

Visual research: the supplier's [continental sausage range](https://www.german-butchery.com.au/products/sausages) and [cheese kransky description](https://www.german-butchery.com.au/products/sausages/kranskycheese) informed the distinctions between smooth wieners, bratwurst and coarse smoked kransky with cheese. No supplier photography was copied; generated quantities and accompaniments are not contents claims.

### Generation prompts

#### classic-wieners

Use case: photorealistic-natural. Asset type: premium ecommerce food photography for Wiener Box, a playful German-style sausage brand. This must look like a beautifully shot actual food photograph, not an illustration, CGI, plastic prop or cartoon. Bright direct daylight from upper left, soft-edged directional shadows, natural food texture, appetising restrained sheen, editorial food styling. Colour direction: warm cream #FFF5DD, mustard yellow #FFCF24, small classic red #E43C2F accents. No lettering, logos, packaging, people, hands, watermarks, flags, raw meat or cutlery touching food. Only the specified sausages and simple serving accompaniments. Photographic serving concept, not branded supplier photography. Square composition, 1536x1536. Near-overhead close food still life on a saturated mustard yellow tabletop. A round warm cream ceramic plate holds four slender long gently curved lightly smoked pork wiener frankfurters, natural reddish golden orange smooth skins, lightly warmed and intact, not heavily grilled or scored. A tiny cream ramekin of mustard, two crisp green cornichons, and a cropped red cotton napkin provide subtle supporting accents. The four wieners are the clear focal point filling the plate; the full plate fits inside the frame with generous outer space. Lively modern independent food brand aesthetic, clean uncluttered scene, sharp real textures.

#### bratwurst

Use case: photorealistic-natural. Asset type: premium ecommerce food photography for Wiener Box, a playful German-style sausage brand. This must look like a beautifully shot actual food photograph, not an illustration, CGI, plastic prop or cartoon. Bright direct daylight from upper left, soft-edged directional shadows, natural food texture, appetising restrained sheen, editorial food styling. Colour direction: warm cream #FFF5DD, mustard yellow #FFCF24, small classic red #E43C2F accents. No lettering, logos, packaging, people, hands, watermarks, flags, raw meat or cutlery touching food. Only the specified sausages and simple serving accompaniments. Photographic serving concept, not branded supplier photography. Square composition, 1536x1536. Near-overhead close food still life on a warm cream tabletop. A round cream ceramic plate holds three plump German bratwurst with pale golden brown natural casing, browned caramelised patches, fine seasoning speckles and subtle authentic grill marks. One little mustard ramekin, a modest forkless mound of sauerkraut on the plate and a red cotton napkin cropped into one corner. The three intact bratwurst are the clear focal point filling the plate; the full plate fits inside the frame with generous outer space. Golden, juicy, properly cooked, not blackened or burnt. Lively modern independent food brand aesthetic, clean uncluttered scene, sharp real textures.

#### cheese-kransky

Use case: photorealistic-natural. Asset type: premium ecommerce food photography for Wiener Box, a playful German-style sausage brand. This must look like a beautifully shot actual food photograph, not an illustration, CGI, plastic prop or cartoon. Bright direct daylight from upper left, soft-edged directional shadows, natural food texture, appetising restrained sheen, editorial food styling. Colour direction: warm cream #FFF5DD, mustard yellow #FFCF24, small classic red #E43C2F accents. No lettering, logos, packaging, people, hands, watermarks, flags, raw meat or cutlery touching food. Only the specified sausages and simple serving accompaniments. Photographic serving concept, not branded supplier photography. Square composition, 1536x1536. Near-overhead close food still life on a warm cream tabletop. A round mustard yellow ceramic plate holds two whole substantial reddish brown smoked cheese kransky sausages and one cut kransky with two thick cut pieces in front. Show credible coarse cooked sausage cross sections with small irregular pale golden cheese pockets embedded throughout; no exaggerated stretchy cheese, no cheese poured on top. Natural browned skins with restrained grill marks. A small red dish of mustard and two cornichons sit at the edge of the plate. The kransky are the clear focal point filling the plate; full plate fits inside frame with generous outer space. Lively modern independent food brand aesthetic, clean uncluttered scene, sharp real textures.

#### sausage-spread

Use case: photorealistic-natural. Asset type: premium ecommerce food photography for Wiener Box, a playful German-style sausage brand. This must look like a beautifully shot actual food photograph, not an illustration, CGI, plastic prop or cartoon. Bright direct daylight from upper left, soft-edged directional shadows, natural food texture, appetising restrained sheen, editorial food styling. Colour direction: warm cream #FFF5DD, mustard yellow #FFCF24, small classic red #E43C2F accents. No lettering, logos, packaging, people, hands, watermarks, flags, raw meat or cutlery touching food. Only the specified sausages and simple serving accompaniments. Photographic serving concept, not branded supplier photography. Landscape 1536x1024 composition. Generous German-style sausage sharing spread shot near-overhead at a slight angle on a warm cream table. A large off-white oval platter is the hero, filled with a natural loose arrangement of golden grilled bratwurst, slender reddish orange wiener frankfurters and thicker smoked cheese kransky, one kransky sliced to show a believable coarse filling and small pale cheese pockets. Every sausage has distinct correct natural ends and shape; no entangled merged shapes. Supporting small bowls of mustard and sauerkraut, a few cornichons, two crusty rolls partially cropped at one edge. A red and cream gingham cloth enters from one side and a mustard yellow small side plate sits near an edge. Food fills the image invitingly while full oval platter remains within central safe area for responsive crops. Summer lunch, lively Australian backyard hospitality, tasteful art direction, natural saturated colours, no rustic dark wood, no labels.

## Revision using the supplier website — 15 September 2026

Mode: built-in image generation, targeted edits with actual supplier-page screenshots as visual reference inputs. The previous images used general product descriptions; this revision also uses the visible sausage photos on the individual product pages. Our lighting, plates, accompaniments and brand palette remain original.

### Product references

| Wiener Box listing | German Butchery reference | Website retail format | Visual direction |
| --- | --- | --- | --- |
| Classic Wieners | [Continental Frankfurter](https://www.german-butchery.com.au/products/sausages/frankfurterpork) | 5 sausages | Light peach-tan smooth casing; slender curved form |
| Bratwurst | [German Bratwurst](https://www.german-butchery.com.au/products/sausages/thueringerbratwurst) | 3 sausages | Pale ivory-beige casing, fine seasoning; elongated curved links |
| Cheese Kransky | [Cheese Kransky](https://www.german-butchery.com.au/products/sausages/kranskycheese) | 3 sausages | Warm smoked casing; coarse pale filling with irregular cheese pieces |

References inspected in a browser on 15 September 2026. The listed retail formats describe the supplier website, not confirmed Wiener Box contents. Generated images remain serving suggestions: illustrated quantities, browning and accompaniments do not establish pack specifications. In particular, the revised wiener scene contains four visible sausages despite the requested five; it is not used as a pack-count illustration. Individual detail pages now link to the exact source product.

### Current saved assets

| Subject | Original PNG | Website WebP |
| --- | --- | --- |
| Classic wieners | `brand/photography/classic-wieners-reference.png` | `public/images/food/classic-wieners-reference.webp` |
| Bratwurst | `brand/photography/bratwurst-reference.png` | `public/images/food/bratwurst-reference.webp` |
| Cheese kransky | `brand/photography/cheese-kransky-reference.png` | `public/images/food/cheese-kransky-reference.webp` |
| Sharing platter | `brand/photography/sausage-spread-reference.png` | `public/images/food/sausage-spread-reference.webp` |

New WebP URLs prevent cached first concepts from being shown. The 480 px and 800 px variants use the same stem followed by `-480.webp` or `-800.webp`. Earlier concepts remain available in the original filenames.

### Revision prompts and inputs

#### classic-wieners

Inputs: `brand/photography/classic-wieners.png`, `tmp/supplier-reference/frankfurter.png`.

Use case: precise-object-edit. Image 1 is our current generated food photograph and is the edit target. The remaining images are screenshots of German Butchery's actual product pages, supplied as visual references for the sausage appearance only. Use the product photo visible in each screenshot to guide sausage proportions, casing colour and filling texture. Keep our own cream/mustard/red food styling, camera angle and overall composition. Do not reproduce any website interface, text, logos, awards or background from the screenshots. No supplier marks or packaging. Deliver a realistic food photograph, not a screenshot, collage, drawing or CGI. These remain generated serving concepts. Reference: German Butchery Continental Frankfurter. Adjust our sausages to the reference's lighter peach-tan lightly smoked casing, smooth fine texture, long slender gently curved form and softly rounded natural ends. Replace the current dark-orange heavily glossy appearance with the realistic light tan-pink colour of the supplier reference. Show five wieners neatly arranged on the cream plate, matching the listed five-piece retail format. Gently warmed and ungrilled; no char marks. Preserve the mustard yellow table, red napkin, cream mustard bowl, cornichons and daylight. Keep all five sausages entirely within the frame. No lettering. Square image.

#### bratwurst

Inputs: `brand/photography/bratwurst.png`, `tmp/supplier-reference/bratwurst.png`.

Use case: precise-object-edit. Image 1 is our current generated food photograph and is the edit target. The remaining images are screenshots of German Butchery's actual product pages, supplied as visual references for the sausage appearance only. Use the product photo visible in each screenshot to guide sausage proportions, casing colour and filling texture. Keep our own cream/mustard/red food styling, camera angle and overall composition. Do not reproduce any website interface, text, logos, awards or background from the screenshots. No supplier marks or packaging. Deliver a realistic food photograph, not a screenshot, collage, drawing or CGI. These remain generated serving concepts. Reference: German Butchery German Bratwurst. Adjust our three sausages to the reference's slimmer elongated curved proportions, pale ivory-beige natural casing and very fine marjoram seasoning flecks. The current sausages are too thick and heavily browned. Make these three reference-shaped bratwurst only gently pan-golden in a few places, with most pale casing still clearly visible. No dark char stripes or large green herb pieces embedded in the skin. Preserve the cream plate, small mustard bowl, sauerkraut, red linen accent, camera angle and bright daylight. Each sausage has a believable natural taper and is fully inside the frame. No lettering. Square image.

#### cheese-kransky

Inputs: `brand/photography/cheese-kransky.png`, `tmp/supplier-reference/cheese-kransky.png`.

Use case: precise-object-edit. Image 1 is our current generated food photograph and is the edit target. The remaining images are screenshots of German Butchery's actual product pages, supplied as visual references for the sausage appearance only. Use the product photo visible in each screenshot to guide sausage proportions, casing colour and filling texture. Keep our own cream/mustard/red food styling, camera angle and overall composition. Do not reproduce any website interface, text, logos, awards or background from the screenshots. No supplier marks or packaging. Deliver a realistic food photograph, not a screenshot, collage, drawing or CGI. These remain generated serving concepts. Reference: German Butchery Cheese Kransky. Adjust the sausages to the reference's medium-width gently curved form, natural warm chestnut-tan smoked casing with fine flecks, and irregular pale cream cheese pieces distributed through a coarse pink-beige cooked filling. The current sausages are too thick, too dark and too oily. Show two whole kransky and the third cut with a couple of slices, all consistently thinner and less intensely charred. Very gentle surface browning only. Cheese stays embedded in the filling, no yellow molten chunks or cheese pull. Preserve the yellow plate, red mustard bowl, cornichons, cream tabletop and camera angle. No lettering. Square image.

#### sausage-spread

Inputs: `brand/photography/sausage-spread.png`, `tmp/supplier-reference/frankfurter.png`, `tmp/supplier-reference/bratwurst.png`, `tmp/supplier-reference/cheese-kransky.png`.

Use case: precise-object-edit. Image 1 is our current generated food photograph and is the edit target. The remaining images are screenshots of German Butchery's actual product pages, supplied as visual references for the sausage appearance only. Use the product photo visible in each screenshot to guide sausage proportions, casing colour and filling texture. Keep our own cream/mustard/red food styling, camera angle and overall composition. Do not reproduce any website interface, text, logos, awards or background from the screenshots. No supplier marks or packaging. Deliver a realistic food photograph, not a screenshot, collage, drawing or CGI. These remain generated serving concepts. In the sharing platter, correct the three sausage types to follow their respective supplier product photo references. Image 2: Continental Frankfurters should be slender, smooth and light peach-tan with rounded ends, not dark orange hot dogs. Image 3: German Bratwurst should be slimmer elongated pale ivory-beige links with subtle seasoning, gently golden in patches, not fat coarse darkly charred bangers. Image 4: Cheese Kransky should be medium-width warm chestnut-tan smoked links, natural subtle speckles, coarse pink-beige filling with scattered irregular pale cream cheese pieces. Keep the sausages appetising and prepared for serving, with restrained browning and natural sheen. Preserve the existing cream oval platter, mustard, sauerkraut, rolls, pickles, red gingham, yellow plate, bright daylight and landscape 3:2 composition. Change only the sausage appearance; do not introduce supplier branding, text or website UI.

## Product galleries and open-box photography — 15 September 2026

Mode: built-in image generation. Three new photorealistic open-carton scenes replace the illustrated carton on the homepage hero, box cards, gift feature, account illustration and cart. Clear sealed pouches show the sausage selection. Three additional close-up photographs give each individual sausage a second gallery view. All are generated concepts; selections, counts and packaging remain provisional.

The supplier screenshots from the preceding revision were used as sausage references for the boxes. The printed WIENER BOX wordmark and mascot reference comes from `public/images/box.png`. The previous supplier-referenced photographs guide the new sausage close-ups.

### Current gallery assets

| View | Original PNG | Web asset |
| --- | --- | --- |
| regular-open-box | `brand/photography/regular-open-box.png` | `public/images/products/regular-open-box.webp` |
| fling-open-box | `brand/photography/fling-open-box.png` | `public/images/products/fling-open-box.webp` |
| gift-open-box | `brand/photography/gift-open-box.png` | `public/images/products/gift-open-box.webp` |
| wieners-close-up | `brand/photography/wieners-close-up.png` | `public/images/products/wieners-close-up.webp` |
| bratwurst-close-up | `brand/photography/bratwurst-close-up.png` | `public/images/products/bratwurst-close-up.webp` |
| kransky-close-up | `brand/photography/kransky-close-up.png` | `public/images/products/kransky-close-up.webp` |

All six originals are 1254 × 1254 px. Website copies are WebP quality 86 at 1200, 800 and 480 px wide. Smaller filenames append `-800` or `-480` before `.webp`. Existing plated photos and the sharing spread remain in their earlier paths. Ordered galleries and primary product images are maintained together in `resources/js/foodPhotography.ts`.

### Generation prompts

#### regular-open-box

Inputs: `public/images/box.png`, `tmp/supplier-reference/frankfurter.png`, `tmp/supplier-reference/bratwurst.png`, `tmp/supplier-reference/cheese-kransky.png`.

Use case: product-mockup. Generate a NEW photorealistic ecommerce studio photograph of an OPEN Wiener Box sausage delivery carton showing its contents. Image 1 is ONLY a branding reference for mustard yellow packaging, red WIENER BOX lettering and small printed sausage mascot. Images 2-4 are supplier website screenshots used ONLY to reference the actual shapes, colours and textures of their sausages: light peach-tan slender Continental Frankfurters, pale ivory fine-ground German bratwurst, medium-width chestnut-tan cheese kransky. Photograph a real corrugated cardboard box with matte mustard printed outer walls and subtle black details, an open lid angled back, natural folds and inner insulation. The box itself must look entirely physical and photographic, not a drawing, cartoon or 3D render. The sausages are neatly arranged inside in separate clear vacuum-sealed retail pouches with realistic heat-sealed edges and minimal reflections so the actual sausage contents are easy to see. No loose sausages touching cardboard, no cooked dinner on top of a shipping box. Include a discreet chilled gel pack at the back. Print ONLY 'WIENER BOX' accurately on the front in the reference's playful red brand lettering; WIENER is W-I-E-N-E-R, I before E. No supplier logos, certifications, invented ingredients, other text or watermarks. High three-quarter camera angle, enough elevation to clearly see all contents and front branding. Whole open box fully inside the square frame with 10% breathing room. Bright natural upper-left daylight, subtle grounded shadow, appetising realistic food, warm cream/mustard/red colour palette. The Regular subscription box: warm cream seamless tabletop and background. Neat generous mixed selection of four visible sealed packs representing the three referenced sausage types, with a small cream recipe card tucked near the lid, blank on the visible side. Mustard box, lid and red lettering are the main brand elements. No table props, crockery or garnishes outside the carton. Square composition.

#### fling-open-box

Inputs: `public/images/box.png`, `tmp/supplier-reference/frankfurter.png`, `tmp/supplier-reference/bratwurst.png`, `tmp/supplier-reference/cheese-kransky.png`.

Use case: product-mockup. Generate a NEW photorealistic ecommerce studio photograph of an OPEN Wiener Box sausage delivery carton showing its contents. Image 1 is ONLY a branding reference for mustard yellow packaging, red WIENER BOX lettering and small printed sausage mascot. Images 2-4 are supplier website screenshots used ONLY to reference the actual shapes, colours and textures of their sausages: light peach-tan slender Continental Frankfurters, pale ivory fine-ground German bratwurst, medium-width chestnut-tan cheese kransky. Photograph a real corrugated cardboard box with matte mustard printed outer walls and subtle black details, an open lid angled back, natural folds and inner insulation. The box itself must look entirely physical and photographic, not a drawing, cartoon or 3D render. The sausages are neatly arranged inside in separate clear vacuum-sealed retail pouches with realistic heat-sealed edges and minimal reflections so the actual sausage contents are easy to see. No loose sausages touching cardboard, no cooked dinner on top of a shipping box. Include a discreet chilled gel pack at the back. Print ONLY 'WIENER BOX' accurately on the front in the reference's playful red brand lettering; WIENER is W-I-E-N-E-R, I before E. No supplier logos, certifications, invented ingredients, other text or watermarks. High three-quarter camera angle, enough elevation to clearly see all contents and front branding. Whole open box fully inside the square frame with 10% breathing room. Bright natural upper-left daylight, subtle grounded shadow, appetising realistic food, warm cream/mustard/red colour palette. The Fling one-off discovery box: soft pale sage tabletop, warm cream backdrop. A mustard carton containing a mixed selection of four visible sealed sausage packs representing the three referenced types. Angle the front slightly to the left while the open lid sits behind the contents. A small folded red paper insert adds brand colour inside one corner, with no text. No table props or garnishes outside the carton. Square composition.

#### gift-open-box

Inputs: `public/images/box.png`, `tmp/supplier-reference/frankfurter.png`, `tmp/supplier-reference/bratwurst.png`, `tmp/supplier-reference/cheese-kransky.png`.

Use case: product-mockup. Generate a NEW photorealistic ecommerce studio photograph of an OPEN Wiener Box sausage delivery carton showing its contents. Image 1 is ONLY a branding reference for mustard yellow packaging, red WIENER BOX lettering and small printed sausage mascot. Images 2-4 are supplier website screenshots used ONLY to reference the actual shapes, colours and textures of their sausages: light peach-tan slender Continental Frankfurters, pale ivory fine-ground German bratwurst, medium-width chestnut-tan cheese kransky. Photograph a real corrugated cardboard box with matte mustard printed outer walls and subtle black details, an open lid angled back, natural folds and inner insulation. The box itself must look entirely physical and photographic, not a drawing, cartoon or 3D render. The sausages are neatly arranged inside in separate clear vacuum-sealed retail pouches with realistic heat-sealed edges and minimal reflections so the actual sausage contents are easy to see. No loose sausages touching cardboard, no cooked dinner on top of a shipping box. Include a discreet chilled gel pack at the back. Print ONLY 'WIENER BOX' accurately on the front in the reference's playful red brand lettering; WIENER is W-I-E-N-E-R, I before E. No supplier logos, certifications, invented ingredients, other text or watermarks. High three-quarter camera angle, enough elevation to clearly see all contents and front branding. Whole open box fully inside the square frame with 10% breathing room. Bright natural upper-left daylight, subtle grounded shadow, appetising realistic food, warm cream/mustard/red colour palette. The Big Gesture gift box: soft peach tabletop with warm cream background. A generous mustard carton with six visible sealed sausage pouches representing the three referenced sausage types; keep the top row contents clearly recognisable. A real red grosgrain ribbon tied around the outside bottom of the open carton, with a small bow on one corner. A small blank cream gift card and matching envelope tucked upright near the open lid. Premium but playful, generous gift presentation. No flowers, jars, bottles, accessories or food outside the box. Square composition.

#### wieners-close-up

Inputs: `brand/photography/classic-wieners-reference.png`.

Use case: photorealistic-natural. Generate a SECOND gallery photograph of the same Continental Frankfurter style sausages in the supplied image, which is a product appearance and art direction reference. This is a different camera angle: close 30-degree tabletop view with shallow natural depth of field, not the reference's top-down view. Show three slender light peach-tan smooth gently curved wieners on a cream plate, one cut near its end with one slice showing a fine smooth pale pink cooked filling. Match the lightly smoked casing colour and proportions from the reference. A small mustard bowl recedes softly in the background. Mustard yellow tabletop, tiny cropped red linen accent. All sausages clearly recognisable, natural food sheen and skin texture, no harsh char, no dark-orange American hotdog colouring. Premium realistic food photograph, no text, logos, illustration or watermarks. Square composition, food kept inside central safe area.

#### bratwurst-close-up

Inputs: `brand/photography/bratwurst-reference.png`.

Use case: photorealistic-natural. Generate a SECOND gallery photograph of the German bratwurst in the supplied image, which is a product appearance and art direction reference. Different camera angle: intimate 30-degree tabletop view across a cream plate, shallow natural depth of field, not an overhead shot. Two slender long gently curved pale ivory bratwurst with fine marjoram speckles and restrained golden pan-browned patches; one neatly cut into two sections in the foreground, exposing a fine cooked pale beige interior. Match the reference casing, proportions and subtle browning, no giant coarse dark bangers, no pink raw meat. Small mustard bowl softly blurred behind, cream table and a red linen edge, bright warm upper-left daylight. Tactile appetising authentic food photograph. No text, logos, cartoon, or watermarks. Square frame with food fully inside the safe central area.

#### kransky-close-up

Inputs: `brand/photography/cheese-kransky-reference.png`.

Use case: photorealistic-natural. Generate a SECOND gallery photograph of the cheese kransky in the supplied image, which is the product appearance and styling reference. Different camera angle: low three-quarter tabletop food detail photograph, natural shallow depth of field. Warm chestnut-tan medium-width smoked kransky on a mustard ceramic plate, one whole link behind and one sliced in front to show coarse cooked pink-beige filling with irregular pale cream cheese pieces. Match the reference's sausage shapes and realistic cheese distribution. Modest surface browning, no black char, no stretching or poured cheese. A cropped red ramekin in the background and cream tabletop, upper-left natural sunlight, tactile real casing and cut surfaces. Appetising premium ecommerce photo, not an illustration or CGI. No text, logos, watermarks, or raw meat. Square frame, complete foreground slices inside the central safe area.

## Hero mascot overlay — 15 September 2026

Mode: built-in image generation, followed by responsive WebP optimisation and CSS composition.

Final saved assets:

- Original: `brand/wiener-mascot-leaning.png` (1114 × 1412).
- Web: `public/images/wiener-mascot-leaning.webp` (720 × 913) and `public/images/wiener-mascot-leaning-360.webp` (360 × 456), quality 90.
- Consumer: homepage hero in `resources/js/Pages/Home.vue`, with the corresponding contour and placement in `resources/css/app.css`.

Reference: the user's screenshot of the original waving mascot leaning on an illustrated carton (`codex-clipboard-459674c0-0d52-432f-9877-e81d616f302d.png`). The real open-box photograph remains a separate existing asset. The mascot's right glove overlaps its lower-left frame edge.

The two transparency attempts returned RGB images with baked-in checkerboards. Those variants were rejected. The selected revision has a cream matte; the PNG and WebP files do not contain alpha transparency. The hero now uses `public/images/wiener-mascot-outline.svg`, a vector display mask traced from the original outline, including the arm and leg openings. This replaces the coarse CSS polygon while leaving the source artwork unchanged.

### Extraction prompt

Use case: background-extraction.
Asset type: transparent mascot overlay for the Wiener Box website hero.
Input image 1 is the edit target and identity reference: the existing orange sausage mascot on the left, waving and leaning with its right-side glove on a carton.
Primary request: isolate JUST this exact full-body mascot on a genuinely transparent background with an alpha channel. Remove the entire box, all page background, all typography and cropped page fragments, and the surrounding stars and yellow accent marks. Keep the character's orange sausage body, face, curved silhouette, black rubber-hose limbs, cream gloves, red oversized shoes, bold black outline and subtle printed texture. Preserve its friendly expression and exact leaning pose: raised waving hand on viewer's left, bent elbow and relaxed cream glove extending to viewer's right and resting on an invisible ledge. The right glove must remain completely intact once the carton is removed. The complete character and both shoes must be inside the canvas with only a small transparent safety margin on every side. Portrait composition closely fitted around the character; no excessive empty space. Keep the existing simple small black grounding shadow beneath its shoes, with transparent surroundings. No new props, no box, no photo frame, no text, no watermarks, no checkerboard pattern baked into the image. The background must be transparent, not cream or white. Do not redesign the character.

### Alpha correction attempt (rejected)

Use case: background-extraction. Edit this mascot asset. The current grey checkerboard is baked into RGB pixels and is NOT transparency. Remove every checkerboard pixel and replace the background with true alpha transparency. Output an RGBA PNG with alpha 0 outside the character, including between the limbs, around the bent right arm and under the shoes. Preserve the exact mascot, edges, cream gloves, face, orange body, red shoes, black outlines and black ground shadow unchanged. No checkerboard, white, grey or cream background pixels. This is a cutout for compositing over website content. Keep the dimensions and pose. Do not add objects or words.

### Final selected revision prompt

Use case: precise-object-edit. Edit the supplied isolated Wiener Box sausage mascot. Replace ONLY the grey checkerboard background with a perfectly flat, uniform solid warm cream colour, exact sRGB hex #FFF5DD. Fill all space outside the character including holes between limbs and behind the bent right arm with this same solid cream. There must be NO transparency, NO checkerboard squares, no grain, gradient, texture, vignette, pattern or shadows in the background. Preserve the mascot's exact identity, facial expression, orange colour, black outlines, cream gloves, waving and leaning pose, bright red shoes and small black shoe shadow. Preserve original portrait framing and complete character. No carton, props, letters or extra marks. The background must be a single flat cream colour to blend seamlessly with a website canvas.

## Homepage section poses — 15 September 2026

Mode: built-in image generation, one call per pose using `brand/wiener-mascot-leaning.png` as the character identity reference. The hero itself was preserved.

Saved originals: `brand/mascots/{grill,choose,deliver,gift,curious,announce}.png` (1114 × 1412 each). Each pose has 360 × 456 and 720 × 913 WebP copies at quality 90 in `public/images/mascots`, and a matching `*-outline.svg` display mask. The original PNGs are unchanged. Masks remove the cream background and open spaces between the limbs for clean rendering on cream, yellow and photographic backgrounds.

The shared component is `resources/js/components/MascotArtwork.vue`; `resources/js/mascotArtwork.ts` stores the asset paths and intrinsic dimensions. These illustrations are decorative, lazy-loaded section companions. Parcel props illustrate delivery and gifting; product cards continue to use the existing food and open-box photos.

### Sausage showcase: grill

Original: `brand/mascots/grill.png`. Web: `public/images/mascots/grill-360.webp`, `public/images/mascots/grill-720.webp`. Mask: `public/images/mascots/grill-outline.svg`.

Use case: illustration-story.
Asset type: one full-body mascot illustration for a Wiener Box homepage section.
Input image 1 is the strict character identity and drawing-style reference, NOT a pose to repeat.
Draw the SAME original cheerful orange sausage mascot in the new pose specified below. Preserve its curved frankfurter silhouette with tied sausage ends, tall expressive cream-and-black eyes, friendly expressive eyebrows, black rubber-hose arms and legs, large cream gloves, vivid red oversized shoes, thick smooth black outlines, subtle orange print texture and small simple black shadow under its shoes. The character should be immediately recognisable as the same individual across all poses. No clothing that hides its sausage body; no new character.
Background: perfectly flat uniform solid warm cream #FFF5DD, including between limbs and around props. No gradient, scene, floor texture, white border, glow, sticker border or checkerboard. Every part of the character and prop should have a clear closed black outer outline. Use a single uncluttered isolated figure, complete feet and all accessories fully within the canvas with roughly 8% breathing room. Near-square or modest portrait framing, centred. No lettering, numbers, slogans, watermarks or extra symbols.
Style: warm, playful 1930s rubber-hose brand illustration matching the input, not 3D or realistic. Keep the original face proportions and vivid orange, cream, black, red and mustard palette.
New pose: The proud cook. Stand in a jaunty relaxed stance wearing a small cream chef's toque above the tied sausage tip. Hold a pair of short closed black barbecue tongs upright in one gloved hand, and give a confident thumbs-up with the other. Big friendly smile looking toward the viewer. The tongs are empty. No grill, flames, plate or food.

### Pick your box: choose

Original: `brand/mascots/choose.png`. Web: `public/images/mascots/choose-360.webp`, `public/images/mascots/choose-720.webp`. Mask: `public/images/mascots/choose-outline.svg`.

Use case: illustration-story.
Asset type: one full-body mascot illustration for a Wiener Box homepage section.
Input image 1 is the strict character identity and drawing-style reference, NOT a pose to repeat.
Draw the SAME original cheerful orange sausage mascot in the new pose specified below. Preserve its curved frankfurter silhouette with tied sausage ends, tall expressive cream-and-black eyes, friendly expressive eyebrows, black rubber-hose arms and legs, large cream gloves, vivid red oversized shoes, thick smooth black outlines, subtle orange print texture and small simple black shadow under its shoes. The character should be immediately recognisable as the same individual across all poses. No clothing that hides its sausage body; no new character.
Background: perfectly flat uniform solid warm cream #FFF5DD, including between limbs and around props. No gradient, scene, floor texture, white border, glow, sticker border or checkerboard. Every part of the character and prop should have a clear closed black outer outline. Use a single uncluttered isolated figure, complete feet and all accessories fully within the canvas with roughly 8% breathing room. Near-square or modest portrait framing, centred. No lettering, numbers, slogans, watermarks or extra symbols.
Style: warm, playful 1930s rubber-hose brand illustration matching the input, not 3D or realistic. Keep the original face proportions and vivid orange, cream, black, red and mustard palette.
New pose: The helpful host. Stand with feet apart and a slight friendly lean. One gloved arm extends out to the viewer's right with its index finger pointing diagonally down to introduce a product choice; the other arm is bent with palm up in a welcoming presenting gesture. Open-eyed cheerful smile, looking toward the pointing hand. No props or boxes.

### How it works: deliver

Original: `brand/mascots/deliver.png`. Web: `public/images/mascots/deliver-360.webp`, `public/images/mascots/deliver-720.webp`. Mask: `public/images/mascots/deliver-outline.svg`.

Use case: illustration-story.
Asset type: one full-body mascot illustration for a Wiener Box homepage section.
Input image 1 is the strict character identity and drawing-style reference, NOT a pose to repeat.
Draw the SAME original cheerful orange sausage mascot in the new pose specified below. Preserve its curved frankfurter silhouette with tied sausage ends, tall expressive cream-and-black eyes, friendly expressive eyebrows, black rubber-hose arms and legs, large cream gloves, vivid red oversized shoes, thick smooth black outlines, subtle orange print texture and small simple black shadow under its shoes. The character should be immediately recognisable as the same individual across all poses. No clothing that hides its sausage body; no new character.
Background: perfectly flat uniform solid warm cream #FFF5DD, including between limbs and around props. No gradient, scene, floor texture, white border, glow, sticker border or checkerboard. Every part of the character and prop should have a clear closed black outer outline. Use a single uncluttered isolated figure, complete feet and all accessories fully within the canvas with roughly 8% breathing room. Near-square or modest portrait framing, centred. No lettering, numbers, slogans, watermarks or extra symbols.
Style: warm, playful 1930s rubber-hose brand illustration matching the input, not 3D or realistic. Keep the original face proportions and vivid orange, cream, black, red and mustard palette.
New pose: The happy delivery. Walk briskly toward the viewer's right with one red shoe lifted in a jaunty stride, carrying a small plain mustard cardboard parcel securely in both cream-gloved hands near waist level. Keep the orange body, both eyes and happy face clearly visible above the parcel. The small parcel has black fold lines and a narrow red tape strip, absolutely no lettering. No truck, wheels, extra parcels or speed lines.

### Gifting: gift

Original: `brand/mascots/gift.png`. Web: `public/images/mascots/gift-360.webp`, `public/images/mascots/gift-720.webp`. Mask: `public/images/mascots/gift-outline.svg`.

Use case: illustration-story.
Asset type: one full-body mascot illustration for a Wiener Box homepage section.
Input image 1 is the strict character identity and drawing-style reference, NOT a pose to repeat.
Draw the SAME original cheerful orange sausage mascot in the new pose specified below. Preserve its curved frankfurter silhouette with tied sausage ends, tall expressive cream-and-black eyes, friendly expressive eyebrows, black rubber-hose arms and legs, large cream gloves, vivid red oversized shoes, thick smooth black outlines, subtle orange print texture and small simple black shadow under its shoes. The character should be immediately recognisable as the same individual across all poses. No clothing that hides its sausage body; no new character.
Background: perfectly flat uniform solid warm cream #FFF5DD, including between limbs and around props. No gradient, scene, floor texture, white border, glow, sticker border or checkerboard. Every part of the character and prop should have a clear closed black outer outline. Use a single uncluttered isolated figure, complete feet and all accessories fully within the canvas with roughly 8% breathing room. Near-square or modest portrait framing, centred. No lettering, numbers, slogans, watermarks or extra symbols.
Style: warm, playful 1930s rubber-hose brand illustration matching the input, not 3D or realistic. Keep the original face proportions and vivid orange, cream, black, red and mustard palette.
New pose: The generous friend. Stand with one knee slightly bent, head tilted fondly, hugging a small bright red square gift with a neat mustard-yellow ribbon and bow in both cream-gloved hands in front of the lower body. The gift sits low enough that the sausage body and smiling face stay fully visible. Warm delighted expression looking at the viewer. No heart symbols, lettering or extra presents.

### Frequently asked questions: curious

Original: `brand/mascots/curious.png`. Web: `public/images/mascots/curious-360.webp`, `public/images/mascots/curious-720.webp`. Mask: `public/images/mascots/curious-outline.svg`.

Use case: illustration-story.
Asset type: one full-body mascot illustration for a Wiener Box homepage section.
Input image 1 is the strict character identity and drawing-style reference, NOT a pose to repeat.
Draw the SAME original cheerful orange sausage mascot in the new pose specified below. Preserve its curved frankfurter silhouette with tied sausage ends, tall expressive cream-and-black eyes, friendly expressive eyebrows, black rubber-hose arms and legs, large cream gloves, vivid red oversized shoes, thick smooth black outlines, subtle orange print texture and small simple black shadow under its shoes. The character should be immediately recognisable as the same individual across all poses. No clothing that hides its sausage body; no new character.
Background: perfectly flat uniform solid warm cream #FFF5DD, including between limbs and around props. No gradient, scene, floor texture, white border, glow, sticker border or checkerboard. Every part of the character and prop should have a clear closed black outer outline. Use a single uncluttered isolated figure, complete feet and all accessories fully within the canvas with roughly 8% breathing room. Near-square or modest portrait framing, centred. No lettering, numbers, slogans, watermarks or extra symbols.
Style: warm, playful 1930s rubber-hose brand illustration matching the input, not 3D or realistic. Keep the original face proportions and vivid orange, cream, black, red and mustard palette.
New pose: The curious thinker. Stand with one gloved index finger resting under its chin, the other gloved hand on its hip, one eyebrow gently raised, eyes looking up toward the viewer's right, and a small friendly thoughtful smile. One red shoe turned slightly outward. Keep the face large and readable. No question mark, thought bubble or props.

### Launch signup: announce

Original: `brand/mascots/announce.png`. Web: `public/images/mascots/announce-360.webp`, `public/images/mascots/announce-720.webp`. Mask: `public/images/mascots/announce-outline.svg`.

Use case: illustration-story.
Asset type: one full-body mascot illustration for a Wiener Box homepage section.
Input image 1 is the strict character identity and drawing-style reference, NOT a pose to repeat.
Draw the SAME original cheerful orange sausage mascot in the new pose specified below. Preserve its curved frankfurter silhouette with tied sausage ends, tall expressive cream-and-black eyes, friendly expressive eyebrows, black rubber-hose arms and legs, large cream gloves, vivid red oversized shoes, thick smooth black outlines, subtle orange print texture and small simple black shadow under its shoes. The character should be immediately recognisable as the same individual across all poses. No clothing that hides its sausage body; no new character.
Background: perfectly flat uniform solid warm cream #FFF5DD, including between limbs and around props. No gradient, scene, floor texture, white border, glow, sticker border or checkerboard. Every part of the character and prop should have a clear closed black outer outline. Use a single uncluttered isolated figure, complete feet and all accessories fully within the canvas with roughly 8% breathing room. Near-square or modest portrait framing, centred. No lettering, numbers, slogans, watermarks or extra symbols.
Style: warm, playful 1930s rubber-hose brand illustration matching the input, not 3D or realistic. Keep the original face proportions and vivid orange, cream, black, red and mustard palette.
New pose: The excited announcer. A lively grounded stance with one red shoe pointed out, holding a small mustard-yellow and black handheld megaphone up near the side of its open smiling mouth in one gloved hand. The megaphone faces the viewer's right and does not obscure the eyes or face. The other hand is raised in a friendly welcoming wave. No sound lines, lettering, confetti or extra props.

## Box-to-BBQ illustrated steps — 15 September 2026

Mode: built-in `image_gen`, one generation per illustration. Reference: `brand/wiener-mascot-leaning.png` (original character and style). The hero and other section artwork remain unchanged. These square scenes replace the three homepage step icons.

Original outputs are 1254 × 1254 PNG files. The website uses lazy-loaded 360 and 720 px WebP derivatives, quality 90, through `MascotArtwork.vue`. The generated RGB originals remain unchanged; matching native SVG display masks remove the cream backdrop and preserve the full illustrations, small floating details and open spaces between limbs/props. Pun captions and step numbers are live HTML.

### Love at first bite.

Original: `brand/mascots/step-love.png`. Web: `public/images/mascots/step-love-360.webp`, `public/images/mascots/step-love-720.webp`. Display mask: `public/images/mascots/step-love-outline.svg`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a405-33ed-71a3-960f-eb2056dc353a/exec-a91d0e66-533a-4135-a652-5ce943d3fff0.png`.

Final prompt:

```text
Use case: illustration-story.
Asset type: a single original Wiener Box website how-it-works step illustration.
Input image 1: strict character identity and illustration-style reference, not a composition to repeat.
Create a new full-body scene using exactly this cheerful curved orange sausage mascot: tied sausage tips, expressive large cream eyes with black pie-cut pupils, black rubber-hose arms and legs, cream cartoon gloves, oversized bright red shoes. Match the bold thick slightly irregular black ink outlines, vintage animation proportions, simple flat mustard yellow/red/orange/cream palette, restrained worn print texture. Keep the character recognizable.
Canvas: square 1024 x 1024. Center the full mascot and its props as one compact vignette filling about 85% of the canvas, with clear margin around every edge. All important parts must be inside frame, no crop.
Background: perfectly flat solid warm cream #FFF5DD, no gradient, paper texture, checkerboard, frame or environment. All colored forms including hands and props have closed solid black outlines. A small black oval ground shadow is okay.
No letters, words, numerals, labels, logos or watermarks anywhere. Website captions will be added separately. Keep props simple and readable at 230px wide. No additional characters.
Scene: The sausage mascot has fallen in love with its perfect sausage box. It stands in a charming swooning pose, cradling and hugging a small open mustard-yellow cardboard delivery box against its chest with both cream gloves. Its face smiles delightedly down at the box. Two simple small red hearts float just above the box. Its red shoes touch the ground, one heel kicked up slightly. The open box has simple folded flaps and a few orange wrapped sausage links peeking out. An affectionate visual pun on choosing your perfect box. Keep the full cheerful face visible above the box.
```

### We’re on a roll.

Original: `brand/mascots/step-roll.png`. Web: `public/images/mascots/step-roll-360.webp`, `public/images/mascots/step-roll-720.webp`. Display mask: `public/images/mascots/step-roll-outline.svg`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a405-33ed-71a3-960f-eb2056dc353a/exec-c2d51613-677b-4468-90cc-328d5e2ffe18.png`.

Final prompt:

```text
Use case: illustration-story.
Asset type: a single original Wiener Box website how-it-works step illustration.
Input image 1: strict character identity and illustration-style reference, not a composition to repeat.
Create a new full-body scene using exactly this cheerful curved orange sausage mascot: tied sausage tips, expressive large cream eyes with black pie-cut pupils, black rubber-hose arms and legs, cream cartoon gloves, oversized bright red shoes. Match the bold thick slightly irregular black ink outlines, vintage animation proportions, simple flat mustard yellow/red/orange/cream palette, restrained worn print texture. Keep the character recognizable.
Canvas: square 1024 x 1024. Center the full mascot and its props as one compact vignette filling about 85% of the canvas, with clear margin around every edge. All important parts must be inside frame, no crop.
Background: perfectly flat solid warm cream #FFF5DD, no gradient, paper texture, checkerboard, frame or environment. All colored forms including hands and props have closed solid black outlines. A small black oval ground shadow is okay.
No letters, words, numerals, labels, logos or watermarks anywhere. Website captions will be added separately. Keep props simple and readable at 230px wide. No additional characters.
Scene: The sausage mascot is a cheerful speedy delivery skater: wearing four-wheel roller skates built into its signature oversized red shoes, leaning forward in an energetic skating pose, safely holding a small CLOSED mustard-yellow delivery parcel tucked against its body with one cream glove and waving with the other. A neat black tape stripe on the parcel, no text. Add two simple black speed streaks behind the skates. An obvious playful visual pun: this sausage delivery is ON A ROLL. Maintain the original face and body rather than transforming it into a vehicle.
```

### Licence to grill.

Original: `brand/mascots/step-grill.png`. Web: `public/images/mascots/step-grill-360.webp`, `public/images/mascots/step-grill-720.webp`. Display mask: `public/images/mascots/step-grill-outline.svg`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a405-33ed-71a3-960f-eb2056dc353a/exec-609e82d9-83bd-4722-bb5d-928ee2d13a3d.png`.

Final prompt:

```text
Use case: illustration-story.
Asset type: a single original Wiener Box website how-it-works step illustration.
Input image 1: strict character identity and illustration-style reference, not a composition to repeat.
Create a new full-body scene using exactly this cheerful curved orange sausage mascot: tied sausage tips, expressive large cream eyes with black pie-cut pupils, black rubber-hose arms and legs, cream cartoon gloves, oversized bright red shoes. Match the bold thick slightly irregular black ink outlines, vintage animation proportions, simple flat mustard yellow/red/orange/cream palette, restrained worn print texture. Keep the character recognizable.
Canvas: square 1024 x 1024. Center the full mascot and its props as one compact vignette filling about 85% of the canvas, with clear margin around every edge. All important parts must be inside frame, no crop.
Background: perfectly flat solid warm cream #FFF5DD, no gradient, paper texture, checkerboard, frame or environment. All colored forms including hands and props have closed solid black outlines. A small black oval ground shadow is okay.
No letters, words, numerals, labels, logos or watermarks anywhere. Website captions will be added separately. Keep props simple and readable at 230px wide. No additional characters.
Scene: The sausage mascot is a proudly overqualified backyard barbecue chef. It stands next to a small waist-high bright red round kettle barbecue on simple black legs, holding oversized barbecue tongs in one cream glove like a jaunty spy gadget pointed safely upwards, and resting its other gloved hand on its hip. Wear a puffy cream chef hat and a little mustard-yellow apron. Give it the recognizable delighted mischievous grin and original expressive eyes, no sunglasses. Two little sausage links and one simple curling black smoke line over the grill. A playful LICENCE TO GRILL scene. Keep the chef and red barbecue touching/overlapping slightly as a compact vignette.
```

## Box-to-BBQ object illustrations — 15 September 2026

Mode: built-in `image_gen`, one generation per object. Style reference: `brand/mascots/step-grill.png`, used only for its drawing treatment. These three object illustrations replaced the earlier column mascots. The delivery mascot beside the heading stays in place. The initial version had no characters, faces or visible sausages; the enhanced revisions below add sausage contents and truck branding.

Design research: [CHILL transport information](https://faq.chill.com.au/en/knowledge/transport-faqs-1) lists vans and trucks for deliveries; its [temperature-controlled transport overview](https://chill.com.au/wp-content/uploads/2021/09/How-can-we-help-you-rev-3.pdf) identifies refrigerated van/truck services. A compact refrigerated vehicle is our design choice for the planned local chilled-delivery step, not a claim about a contracted courier or vehicle. [Weber's Compact Kettle range](https://anz.weber.com/en-au/collections/compact-kettle) informed the recognisable round bowl, domed lid and wheeled stand for the barbecue illustration. The open insulated carton follows the existing box-and-chilled-delivery concept. No third-party logos or product branding were reproduced.

Original PNGs are 1254 × 1254. Website derivatives are 360 and 720 px WebP, quality 90. Original raster files are preserved; native SVG display masks remove the cream backdrop and preserve negative spaces. Assets reuse `MascotArtwork.vue` and `mascotArtwork.ts` as the shared illustration renderer. Earlier character scenes remain archived on disk.

### Pick a box: step-box

Original: `brand/mascots/step-box.png`. Web: `public/images/mascots/step-box-360.webp`, `public/images/mascots/step-box-720.webp`. Mask: `public/images/mascots/step-box-outline.svg`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a405-33ed-71a3-960f-eb2056dc353a/exec-06988403-7322-4fa6-94df-e96a55e3a82e.png`.

Final prompt:

```text
Use case: illustration-story.
Asset type: an original isolated object illustration for a Wiener Box website how-it-works column.
Input image 1 is a drawing STYLE reference only: match its thick slightly irregular black ink contours, playful rounded vintage cartoon forms, flat mustard yellow, vivid red, warm cream and near-black palette, restrained worn screen-print texture, bold simple highlights. Do NOT draw the sausage mascot or any character from the reference.
Make a single attractive OBJECT, not a character: absolutely no eyes, face, mouth, arms, gloves, human legs, shoes, people, animals, sausage characters or anthropomorphism. No visible sausages. No letters, logos, numbers, captions or watermark. Avoid realistic rendering, 3D or generic thin-line vector icon styling.
Square 1024x1024 canvas. Center the complete object with a generous approximately 10% empty margin around it. Full object entirely inside the canvas, recognizable at 240px wide. A small black ground shadow and a couple of simple black accent strokes are fine.
Background: perfectly flat uniform cream #FFF5DD, no gradient, no scene, no texture outside the object, no checkerboard or white border. Every object part has a solid closed black outer contour.
Subject: A cheerful chunky mustard-yellow insulated cardboard delivery carton in three-quarter view, with its top open and four folded flaps. Broad red packing-tape stripe across the front and side panels, cream protective liner visible inside. One plain cream rectangular gel ice pack peeks out of the liner, with a small simple black six-armed snowflake printed on it; no text. Otherwise minimal contents, no food visible. Slightly squashy hand-drawn proportions and bold black fold lines make this feel like a prop from a vintage cartoon. Two tiny mustard sparkle accents beside the carton. The carton is the star, filling about 75% of the canvas width and 75% height.
```

### Chilled delivery: step-truck

Original: `brand/mascots/step-truck.png`. Web: `public/images/mascots/step-truck-360.webp`, `public/images/mascots/step-truck-720.webp`. Mask: `public/images/mascots/step-truck-outline.svg`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a405-33ed-71a3-960f-eb2056dc353a/exec-521c57c9-8427-4d4e-b911-ef9892dc8d8f.png`.

Final prompt:

```text
Use case: illustration-story.
Asset type: an original isolated object illustration for a Wiener Box website how-it-works column.
Input image 1 is a drawing STYLE reference only: match its thick slightly irregular black ink contours, playful rounded vintage cartoon forms, flat mustard yellow, vivid red, warm cream and near-black palette, restrained worn screen-print texture, bold simple highlights. Do NOT draw the sausage mascot or any character from the reference.
Make a single attractive OBJECT, not a character: absolutely no eyes, face, mouth, arms, gloves, human legs, shoes, people, animals, sausage characters or anthropomorphism. No visible sausages. No letters, logos, numbers, captions or watermark. Avoid realistic rendering, 3D or generic thin-line vector icon styling.
Square 1024x1024 canvas. Center the complete object with a generous approximately 10% empty margin around it. Full object entirely inside the canvas, recognizable at 240px wide. A small black ground shadow and a couple of simple black accent strokes are fine.
Background: perfectly flat uniform cream #FFF5DD, no gradient, no scene, no texture outside the object, no checkerboard or white border. Every object part has a solid closed black outer contour.
Subject: A small friendly-looking but NON-anthropomorphic refrigerated local delivery van / compact box truck in three-quarter view, facing right. Mustard-yellow square insulated cargo body with rounded corners, a broad red horizontal stripe, a simple black six-armed snowflake symbol on the side, cream front cab, red wheel hubs, chunky black tyres, cream windows. A small cream refrigeration unit sits above the cab. No driver or passengers, no face-like grille or eyes. Exaggerated curved fenders and a slightly jaunty forward stance, two short black motion streaks behind it. Entire vehicle including both visible wheels fits the canvas, at about 85% width and 65% height. This is an original generic cartoon delivery vehicle, not any real vehicle or courier brand.
```

### Make a meal of it: step-bbq

Original: `brand/mascots/step-bbq.png`. Web: `public/images/mascots/step-bbq-360.webp`, `public/images/mascots/step-bbq-720.webp`. Mask: `public/images/mascots/step-bbq-outline.svg`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a405-33ed-71a3-960f-eb2056dc353a/exec-03331eb4-44fd-463e-8d62-c72f19486857.png`.

Final prompt:

```text
Use case: illustration-story.
Asset type: an original isolated object illustration for a Wiener Box website how-it-works column.
Input image 1 is a drawing STYLE reference only: match its thick slightly irregular black ink contours, playful rounded vintage cartoon forms, flat mustard yellow, vivid red, warm cream and near-black palette, restrained worn screen-print texture, bold simple highlights. Do NOT draw the sausage mascot or any character from the reference.
Make a single attractive OBJECT, not a character: absolutely no eyes, face, mouth, arms, gloves, human legs, shoes, people, animals, sausage characters or anthropomorphism. No visible sausages. No letters, logos, numbers, captions or watermark. Avoid realistic rendering, 3D or generic thin-line vector icon styling.
Square 1024x1024 canvas. Center the complete object with a generous approximately 10% empty margin around it. Full object entirely inside the canvas, recognizable at 240px wide. A small black ground shadow and a couple of simple black accent strokes are fine.
Background: perfectly flat uniform cream #FFF5DD, no gradient, no scene, no texture outside the object, no checkerboard or white border. Every object part has a solid closed black outer contour.
Subject: A bold bright-red round kettle charcoal barbecue in three-quarter view, on a sturdy black tripod stand with two small chunky wheels. Its domed red lid is hinged open at the back, showing an empty black-and-cream cooking grate. A pair of simple cream-and-black metal barbecue tongs rests diagonally on the rim. Cream lid handle and small black vent holes, two elegant curling black heat lines above the grill. No food or sausages anywhere. Match the red kettle prop in the reference's drawing style, but make the barbecue the sole subject and redraw it larger with a clearly open lid. Entire barbecue including lid, stand and wheels inside the canvas at about 75% width and 85% height.
```

## Enhanced Box-to-BBQ illustrations — 15 September 2026

Mode: built-in `image_gen`, targeted edits of the three existing column illustrations. These revisions fill the box and barbecue with sausages and replace the truck snowflake with the mascot and WIENER BOX branding.

The original PNGs remain at `brand/mascots/step-box.png`, `brand/mascots/step-truck.png` and `brand/mascots/step-bbq.png`. Website assets reuse the corresponding 360 px and 720 px WebP paths, at quality 90, with refreshed SVG display masks. The box and truck outputs contain an opaque checkerboard removed by their display masks; the barbecue has actual alpha transparency, which is preserved. The existing page composition and responsive image references consume these replacements.

### Final edit prompt set

#### step-box

Reference inputs: `public/images/mascots/step-box-720.webp`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a4b2-51b0-7b40-a1ac-d8d362c1b95d/exec-cb738d51-642b-4251-8884-c937092a2034.png`.

```text
Use case: precise-object-edit. Asset type: existing illustrated website step icon, square. Edit target: Image 1, the yellow open chilled-delivery box. Enhance this exact illustration by filling the visible box interior with a generous collection of plump reddish-orange German sausage links nestled in the cream insulated liner, alongside a smaller visible cold pack at the back. The sausages must be obvious and appetising at a 260px display size, with tied ends, bold black outlines and simple cream highlights. The sausages are food, no faces. Preserve the existing box geometry, viewpoint, open yellow flaps, red stripe and tape, heavy black outlines, restrained vintage print grain, cream highlights and golden accent marks. Retain the complete original object silhouette, scale, and square framing with a comfortable margin. Match the existing limited mustard-yellow, warm cream, tomato-red, orange and black palette and playful retro cartoon style. Change only the contents of the box. No added text or extra props. Isolate illustration on a genuinely transparent background; keep cream inside the liner and black grounded shadow intact.
```

#### step-truck

Reference inputs: `public/images/mascots/step-truck-720.webp`, `public/images/mascots/choose-720.webp`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a4b2-51b0-7b40-a1ac-d8d362c1b95d/exec-7f6968e5-e2f7-4645-be4e-ae6384525300.png`.

```text
Use case: compositing. Asset type: existing illustrated website delivery step icon, square. Image 1 is the edit target, the yellow-and-cream delivery truck. Image 2 is the exact sausage mascot identity and style reference to print as branding on the truck, not as a separate character. Replace the large black snowflake on the yellow side panel of the truck with a branded livery: a small smiling orange sausage mascot matching Image 2 (sausage body with tied ends, expressive cream eyes, black arms, white glove waving, red shoes), alongside a very legible large stacked black wordmark reading exactly "WIENER" on the first line and "BOX" on the second line. Spell WIENER as W-I-E-N-E-R. Use chunky friendly rounded uppercase lettering, with the logo and mascot fitting neatly within the yellow cargo panel above the red stripe. It should read as a deliberate printed truck brand. Remove the snowflake completely. Preserve the exact existing truck viewpoint and silhouette, yellow cargo body, cream cab, red horizontal stripe and wheel hubs, rooftop refrigeration unit, wheels, black shadow, motion marks and comfortable square framing. Match the heavy black outlines, limited warm palette and restrained vintage print grain. No added standalone characters, extra text, watermarks, scenery, or photographic elements. Isolate entire illustration on a genuinely transparent background, keeping cream cab and black grounded shadow intact.
```

#### step-bbq

Reference inputs: `public/images/mascots/step-bbq-720.webp`.

Built-in source: `/Users/stompy/.codex/generated_images/01a0a4b2-51b0-7b40-a1ac-d8d362c1b95d/exec-0f5fb94c-a51b-406c-a09c-24580560ed4e.png`.

```text
Use case: precise-object-edit. Asset type: existing illustrated website barbecue step icon, square. Edit target: Image 1, the open red kettle barbecue. Add four plump golden-orange and reddish-brown German sausages visibly resting on the black grill grate. Place them naturally across the grate in perspective, each with bold black outlines, 2-3 dark diagonal grill marks and simple creamy highlights, easily readable at a 260px display size. Food only, no faces. Keep the sausages inside the grill and clearly separated from the existing tongs. Preserve the exact existing red barbecue body, open lid, handle, wheels, legs, grill, right-side tongs, black curling heat wisps and grounded black shadow, object silhouette, square framing and margin. Match its warm red, golden-orange, cream and black retro cartoon palette, bold outlines and restrained vintage print grain. Change only the empty grill to have sausages cooking on it. No extra objects or text. Isolate illustration on a genuinely transparent background; keep cream details intact and transparency in open gaps between the legs.
```

## Big Wiener Club slideshow artwork — 15 September 2026

Mode: built-in image generation, `ads-marketing`. References: `brand/wiener-mascot-leaning.png` (mascot identity) and `brand/photography/regular-open-box.png` (products and packaging).

Final original: `brand/photography/big-wiener-club.png`. Website assets: `public/images/big-wiener-club.webp` (1200 px), `public/images/big-wiener-club-800.webp`, and `public/images/big-wiener-club-480.webp`, all WebP quality 88. Used in `resources/js/components/HeroSlideshow.vue`.

### Final prompt

Use case: ads-marketing.
Asset type: finished square campaign artwork for the right half of the Wiener Box homepage second hero slide, 1536 x 1536. This is a NEW composition using the two attached images as identity and product references.
Primary request: a funny, premium 'Big Wiener Club' campaign image combining the exact orange cartoon sausage mascot with a PHOTOREALISTIC oversized membership card and PHOTOREALISTIC open Wiener Box sausage product box.
Image 1 role: mascot identity reference. Preserve the orange sausage body, scalloped sausage tied ends, cream white gloves, black rubber-hose limbs, red shoes, heavy black outlines, cheeky smiling face and lightly distressed retro illustration style. Keep him 2D illustrated, not a plastic toy. Change pose so he proudly holds an oversized membership card in both gloved hands; expression slightly smug and delighted.
Image 2 role: product packaging and sausage reference. Faithfully represent the yellow open cardboard box with legible red and black 'WIENER BOX' wordmark, brown cardboard lid, vacuum packs of frankfurters, pale herb-speckled bratwurst, darker reddish kransky.
Composition: warm plain butter-cream studio backdrop #fff6df, clean editorial collage, all subjects fully in frame with generous 6% margins. Mascot on left, whole body visible, card held diagonally across middle foreground, open product box to the upper right behind card, sausage packs clearly visible. Mascot face and feet visible. Strong legibility at 600px. Card is the central visual hero, approximately half the total artwork width, standard landscape credit-card proportions, tilt around -8 degrees, almost front-facing. It must visibly be held by the mascot's gloves touching the card edges.
Card material: realistic midnight-black premium PVC membership card with rounded corners, visible thin beveled edge, understated satin reflections, sharply embossed warm gold type, subtle gold border and small circular sausage emblem. NO payment chip, no credit-card network logos. The deadpan seriousness of this luxury card next to a proud silly sausage is the joke.
Exact card text: top small 'WIENER BOX'; center very large on three lines 'BIG' 'WIENER' 'CLUB'; bottom small 'CARD-CARRYING WIENER'; lower right 'NO. 0001'. Gold typography must be perfectly spelled and clean.
Lighting: soft warm product photography, grounded realistic shadows beneath box, shoes, and card. Food must look like real fresh packaged sausages.
No website UI, no added headings or copy outside the card and product box, no extra props, no watermarks, no gradients in background. High-end art direction with playful Australian BBQ brand feel.


## Illustrated club card and unpacked products — 15 September 2026

Mode: built-in image generation, `compositing`. Edit target: `brand/photography/big-wiener-club.png`. Supersedes the black-and-gold card artwork in the homepage club slide.

Final original: `brand/photography/big-wiener-club-illustrated.png`. Website assets: `public/images/big-wiener-club-illustrated.webp` (1200 px), `public/images/big-wiener-club-illustrated-800.webp`, and `public/images/big-wiener-club-illustrated-480.webp`, all WebP quality 88. The original artwork is retained.

### Final prompt

Use case: compositing.
Asset type: revised square Wiener Box homepage club campaign artwork. Edit the supplied campaign image, keeping the exact orange cartoon sausage mascot identity and product-brand identity while redesigning the membership card and restaging the products.
Primary request: the club card must match the mascot's playful retro illustration style. The box needs a genuinely different product presentation from the existing upright open box.
Preserve: cheerful orange frankfurter mascot with tied ends, big cream expressive eyes, cream gloves, black rubber-hose arms and legs, red shoes, heavy black outlines, slight vintage print grain. Keep the mascot illustrated. Keep real-looking vacuum-packed sausages and real corrugated-cardboard branded packaging. Warm cream background, consistent soft upper-left studio light, grounded shadows, clean composition.
CARD REDESIGN: replace the black-and-gold luxury card completely. Make a tangible rounded rectangular membership card with a flat mustard-yellow printed face, thick slightly irregular black outline, cream inset border, chunky hand-drawn red uppercase lettering with black offset shadow matching the WIENER BOX wordmark. Small cream starbursts, a small line-art smiling sausage stamp, subtle vintage screen-print grain. This should feel like a funny souvenir card from the same illustrator who drew the mascot. No metallic gold, no serif fonts, no bank-card styling, no payment chip or logos. Very clear large hand-lettered words on three lines: "BIG" "WIENER" "CLUB". Small upper label "WIENER BOX"; small lower label "CARD-CARRYING WIENER"; tiny corner "NO. 0001". The illustrated graphic is printed on a physical matte card with a slim cream edge and very subtle natural shadow, not a luxury metal credit card. Text must be correctly spelled. Mascot proudly holds it with both gloves, arms anatomically connected, hands visibly grip card edges.
PRODUCT RESTAGING: replace the upright open-lid box entirely. Show a CLOSED low rectangular mustard-yellow shipping carton on the right, resting diagonally on the tabletop in an elevated three-quarter view so its broad top and two shallow sides are visible. Lid flush shut, no vertical cardboard flap. The top carries a big red hand-lettered "WIENER BOX" wordmark plus a printed black smiling sausage illustration; one shallow side has a black cheeky sausage-pattern graphic. Place three realistic sealed clear sausage packs in an attractive fan in front of and beside the closed box, not inside it: light peach-tan smooth frankfurters, pale herb-speckled bratwurst, reddish-brown coarse kransky. Vacuum-pouch seams and food textures look photographic, with controlled reflections. The distinct unboxed food spread is clearly readable and separate from the mascot/card. No loose raw sausages on cardboard, no invented product labels or supplier marks.
COMPOSITION: redesign the arrangement into a balanced editorial product still life. Mascot and readable card on the left, closed carton in the back-right, fanned sausage packs in the front-right. The card about 45% of canvas width, mascot face fully visible above it and red shoes below. Entire subjects inside square frame with at least 6% clean margins. The package must be clearly smaller and shallower than the old open carton. Warm cream #FFF5DD seamless backdrop. Bold, cheerful, slightly cheeky Australian BBQ branding. Finished art should blend expressive retro illustration with believable product photography.
No web UI, added headlines, watermarks, extra props, extra characters, or collage panels. Square high-resolution image.


## Recipes collection and chicken dinner campaign — 15 September 2026

Mode: built-in image generation. Original PNG files are in `brand/photography/`; website versions are WebP quality 88 at 1200, 800, and 480 px. Food photos are in `public/images/food/`; campaign artwork is in `public/images/`. Food images are generated editorial illustrations of the seeded recipes.

The campaign uses `brand/wiener-mascot-leaning.png` as its mascot reference and the generated chicken dish as its food reference.

### lemon-mustard-chicken

Original: `brand/photography/lemon-mustard-chicken.png`.

Use case: photorealistic-natural.
Asset type: square recipe food photograph for Wiener Box, a playful Australian food brand.
Primary request: a beautiful completely realistic cooked lemon-and-mustard chicken tray bake, enough for four, ready to eat. Four bone-in skin-on chicken thighs with crisp deep-golden skin, roasted small potatoes with cut golden edges, a few roasted lemon wedges, garlic cloves and scattered fresh thyme sprigs in a low cream enamel roasting dish. A thin glossy mustard pan sauce, visible whole mustard seeds, appetising browned crispy edges. No sausages in this dish.
Composition: elevated three-quarter food photography view, entire rectangular enamel dish visible within the square frame with 7% margin, on a flat warm cream #FFF5DD tabletop. Modest folded mustard-yellow linen tucked under the back edge. The food fills most of the composition. Premium editorial recipe photography, realistic proportions, warm upper-left daylight and soft shadows, natural home-cooked food with tactile surfaces, tasteful restraint, sharp appetising food detail.
No text, logo, mascot, people, cartoon elements, packaging, watermarks, uncooked pink chicken, utensils covering the food, extreme food gloss or CGI. Square high-resolution image.

### wiener-chicken-dinner

Original: `brand/photography/wiener-chicken-dinner.png`.

Use case: ads-marketing.
Asset type: square website hero campaign artwork for Wiener Box.
Input image 1 is the exact original orange sausage mascot identity reference. Input image 2 is the prepared chicken dish to include.
Create a funny new composition: our orange sausage mascot is wearing a clearly ridiculous CHICKEN COSTUME, proudly presenting the realistic lemon-mustard chicken dinner. Preserve recognisable orange elongated sausage face and body, large cream eyes, smiling black mouth, black rubber-hose legs, cream gloves, oversized red shoes, heavy black outlines, vintage print grain. Keep the character illustrated. Costume: cream-white fluffy feather suit around sausage body, little scalloped illustrated wings, open-faced chicken hood with bright red comb and a little yellow beak above the mascot's face, small white tail feathers. Orange face and red shoes clearly visible. He should look like a sausage in a fancy-dress chicken suit, not a real bird or a different mascot. Cheeky delighted expression, proud little showman's pose.
Put mascot standing on left at about 75% canvas height, one gloved hand presenting the dish and the other gesturing proudly. On right in the foreground show the PHOTOREALISTIC cream enamel roasting dish of four golden crispy chicken thighs with roast potato pieces, lemon wedges, garlic and thyme from image 2. It is sitting safely on the tabletop, not balancing precariously on the mascot. Keep the actual food beautifully realistic with warm natural lighting and realistic shadows. The dish fills the right half and overlaps slightly in front of mascot's lower body but both red shoes stay visible.
Warm flat cream #FFF5DD seamless background, minimal clean tabletop, whole character and dish entirely in square frame with generous 7% margins. Blend bold retro 2D mascot art and real food photography as in an editorial ad. Humour comes from the sausage in chicken disguise. No box, no membership card, no text, no logos, no caption, no border, no watermark. High-resolution square image.

### potato-salad

Original: `brand/photography/potato-salad.png`.

Use case: photorealistic-natural. Asset type: square editorial recipe photo for Wiener Box. Realistic cooked food, warm upper-left daylight, soft natural shadows, warm cream #FFF5DD tabletop, mustard-yellow and red accents, elevated three-quarter view. Entire main plate or bowl in frame, 8% breathing room, no text, logos, packaging, people, cartoon, or watermarks. Premium but approachable home cooking, tactile natural food surfaces, appetising and restrained. Warm German potato salad: a shallow cream ceramic serving bowl of waxy potato slices coated in a light glossy vinegar-mustard dressing, finely chopped translucent onion and fresh chopped chives. No mayonnaise, no bacon, no sausage. Tiny flecks of black pepper. A mustard-yellow linen edge at the rear, no other dishes. The salad fills the bowl generously, delicious authentic side dish.

### apple-sauerkraut

Original: `brand/photography/apple-sauerkraut.png`.

Use case: photorealistic-natural. Asset type: square editorial recipe photo for Wiener Box. Realistic cooked food, warm upper-left daylight, soft natural shadows, warm cream #FFF5DD tabletop, mustard-yellow and red accents, elevated three-quarter view. Entire main plate or bowl in frame, 8% breathing room, no text, logos, packaging, people, cartoon, or watermarks. Premium but approachable home cooking, tactile natural food surfaces, appetising and restrained. Warm apple sauerkraut: a low terracotta-red bowl filled with pale golden sauerkraut, soft translucent onion strands, small softened pale apple pieces and a few caraway seeds. Light glossy butter finish. One small parsley sprig. A subtle cream linen corner. Focus on the delicate cooked cabbage texture, no meat, no sausage, no extra dishes.

### curry-ketchup

Original: `brand/photography/curry-ketchup.png`.

Use case: photorealistic-natural. Asset type: square editorial recipe photo for Wiener Box. Realistic cooked food, warm upper-left daylight, soft natural shadows, warm cream #FFF5DD tabletop, mustard-yellow and red accents, elevated three-quarter view. Entire main plate or bowl in frame, 8% breathing room, no text, logos, packaging, people, cartoon, or watermarks. Premium but approachable home cooking, tactile natural food surfaces, appetising and restrained. Homemade curry ketchup: a small cream bowl of thick rich tomato-red curry sauce, swirled surface with a light dusting of golden curry powder, a small steel teaspoon resting beside the bowl with a little sauce on it. Mustard-yellow linen underneath one corner. The sauce is the hero and the bowl occupies 70% of the frame. No sausages, no fries, no raw vegetables, no additional dishes.

### sweet-mustard

Original: `brand/photography/sweet-mustard.png`.

Use case: photorealistic-natural. Asset type: square editorial recipe photo for Wiener Box. Realistic cooked food, warm upper-left daylight, soft natural shadows, warm cream #FFF5DD tabletop, mustard-yellow and red accents, elevated three-quarter view. Entire main plate or bowl in frame, 8% breathing room, no text, logos, packaging, people, cartoon, or watermarks. Premium but approachable home cooking, tactile natural food surfaces, appetising and restrained. Sweet Bavarian-style mustard: a small shallow mustard-yellow ceramic bowl filled with rustic amber-brown grainy sweet mustard, clearly visible yellow and brown whole and cracked mustard seeds in a thick glossy paste. A short wood spoon resting beside it, very small scattered mustard seeds, muted red linen folded at back. No sausages, no pretzels, no other dishes. The mustard has a coarse seeded texture, not smooth yellow American mustard.


## Chicken sausage correction — 15 September 2026

Mode: built-in image editing. Supersedes the chicken-thigh recipe and campaign above. Chicken sausage tray bake is the final dish. Website originals: `brand/photography/lemon-mustard-chicken-sausages.png` and `brand/photography/wiener-chicken-sausage-dinner.png`. Final assets use those basenames in `public/images/food/` and `public/images/` respectively, at 1200, 800 and 480 px, WebP quality 88.

### Recipe photo edit prompt

Edit the supplied image. Replace ALL roast chicken thigh meat with a prepared CHICKEN SAUSAGE tray bake. The dish contains eight plump real cooked chicken sausages in natural casings: pale golden tan with appetising browned patches, subtle herb flecks, rounded sausage ends, elongated cylindrical sausage links. Arrange them naturally among golden roasted baby potatoes, lemon wedges, whole garlic cloves, thyme and a glossy mustard pan sauce in the cream enamel roasting tray. Absolutely no chicken thighs, drumsticks, breasts, wings, bones or whole pieces of chicken meat. These are actual realistic cooked CHICKEN SAUSAGE LINKS. Keep photography deliciously realistic, natural soft light and warm cream #FFF5DD setting, mustard cloth, same square frame and food photography aesthetic. No text or new border.

### Campaign edit prompt

Use case: precise compositing edit. Edit the supplied image. Replace ALL roast chicken thigh meat with a prepared CHICKEN SAUSAGE tray bake. The dish contains eight plump real cooked chicken sausages in natural casings: pale golden tan with appetising browned patches, subtle herb flecks, rounded sausage ends, elongated cylindrical sausage links. Arrange them naturally among golden roasted baby potatoes, lemon wedges, whole garlic cloves, thyme and a glossy mustard pan sauce in the cream enamel roasting tray. Absolutely no chicken thighs, drumsticks, breasts, wings, bones or whole pieces of chicken meat. These are actual realistic cooked CHICKEN SAUSAGE LINKS. Keep photography deliciously realistic, natural soft light and warm cream #FFF5DD setting, mustard cloth, same square frame and food photography aesthetic. No text or new border.
Preserve the exact illustrated orange sausage mascot wearing the funny white fluffy chicken costume, the chicken head hood, red comb, yellow beak, smiling orange sausage face, cream gloves and red shoes. Preserve its drawing style, face, pose, proportions, costume, heavy black outlines and texture completely. Change ONLY the contents of the roasting tray from chicken thighs to the chicken sausage tray bake specified above. Keep the tray in the same position to the lower right and mascot to the left. Eight appetising elongated browned chicken sausages with potatoes and lemon. The chicken COSTUME remains, but every piece of meat in the tray is a SAUSAGE. No text, no outlines around canvas.


## Uncropped slideshow framing — 15 September 2026

Mode: built-in image editing. Edit target: `brand/photography/wiener-chicken-sausage-dinner.png`. Final original: `brand/photography/wiener-chicken-sausage-dinner-framed.png`. Website assets: `public/images/wiener-chicken-sausage-dinner-framed.webp`, `public/images/wiener-chicken-sausage-dinner-framed-800.webp`, and `public/images/wiener-chicken-sausage-dinner-framed-480.webp` (1200, 800, and 480 px; WebP quality 88). The full tray, cloth, and mascot now fit inside the artwork with cream margins.

### Final prompt

Use case: precise-object-edit.
Asset type: square homepage slideshow artwork.
Input image 1: EDIT TARGET, existing Wiener Box campaign.
Primary request: fix the cropped right edge by zooming out and completing the whole composition. The original cuts off the roasting tray on the right and crowds the mascot against the top. Reframe the SAME scene with substantially more breathing room on ALL sides. Make the combined mascot and roasting tray smaller within the square canvas, about 78% of total width and 80% of total height. Leave at least 10% warm cream empty space to the right of the COMPLETE tray, at least 8% under it, 8% above the mascot comb, and 8% to the left of his shoe. Show the ENTIRE roasting dish: complete rectangular enamel rim, all four corners, right outer wall, front wall, and mustard cloth fully within frame. Reconstruct the missing right-hand portion of the dish naturally. No object may touch or be cut by any image edge.
Preserve invariants: the identical orange sausage mascot in his cream-white fluffy chicken costume, red comb, yellow hood beak, orange face, cream gloves, red shoes, black rubber-hose legs, heavy black illustration outlines, distressed vintage print texture, smiling face, same presenting pose. Keep him left of the tray, whole body visible. Preserve the delicious PHOTOREALISTIC CHICKEN SAUSAGE tray bake on the right: eight golden browned sausage links in natural casings, roast potatoes, lemon wedges, garlic, thyme and mustard pan juices in a cream enamel roasting tray. These are chicken SAUSAGES, not chicken thighs or pieces of chicken.
Scene: seamless warm cream #FFF5DD background and surface, soft natural grounded shadows. Match the existing colours and mixed illustration/photography style. Preserve relative character and dish proportions while scaling down the composition. No new props, no text, no border, no outline around the canvas, no rounded photo frame, no watermark. Square output. This is a framing correction; retain the existing subject design and food. The whole tray MUST have a clear cream margin to its right and bottom.
