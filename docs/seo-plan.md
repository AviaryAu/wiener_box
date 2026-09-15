# Wiener Box SEO plan and implementation

Prepared 15 September 2026. Scope: the Laravel 13 / Inertia 2 / Vue 3 storefront in this repository.

## 1. Objective and current position

Build organic discovery for a Sydney launch, turn relevant visits into launch-list signups, and prepare product pages for sales when the commerce operation is ready. The current site is a prelaunch preview: pricing, availability, delivery coverage and supplier details remain provisional.

The initial audit found:

- Every storefront page had a hard-coded `noindex, nofollow` tag.
- Page content and most titles required JavaScript; there was no Inertia rendering server entry point.
- Only the homepage had a description. Canonicals, social metadata, structured data and an XML sitemap were absent.
- Product discovery already used real links and meaningful product slugs; unpublished products correctly returned 404.
- Responsive WebP images, image dimensions, lazy loading and local fonts were already present.
- Sydney is the stated initial market. The production domain, Search Console property and analytics account have not been supplied.

**Default release decision:** prepare the complete technical implementation while keeping indexing disabled. Set the public origin and opt in when the owner is ready for discovery. Indexing is independent of opening checkout; an accurate prelaunch website can be made searchable before orders open.

No search-volume, ranking, conversion or competitor-performance claims are made. The intent map below is a starting hypothesis to validate with actual search and customer data.

## 2. Implemented technical foundation

| Area | Implementation | Acceptance condition |
| --- | --- | --- |
| Initial HTML | Inertia SSR entry point and hydration; the normal build produces browser and server bundles | Public headings, descriptions and product links are present with JavaScript disabled |
| SSR resilience | Blade renders the same metadata when the rendering service is unavailable; browser mounting handles both cases | Initial HTML retains title, canonical and metadata without SSR; full content resumes with SSR |
| Page metadata | Central `config/seo.php` and `StorefrontSeo` generate unique titles, descriptions, Open Graph and Twitter cards | One current set in raw HTML and after Inertia navigation |
| Product metadata | Actual catalogue name and story, descriptive product type and matching existing preview image | Admin content changes appear without editing a Vue page |
| Canonicals | Named route paths joined to configured `APP_URL`; query parameters excluded | Tracking URLs point to the clean public URL; request Host cannot replace the canonical origin |
| Indexing | Explicit opt-in plus production environment, HTTPS and a matching origin | Local, staging, alternate hosts and disabled releases stay noindex |
| Private/utility pages | HTTP robots headers plus storefront meta tags; no canonical, social URL or JSON-LD on private pages | Cart, account, login, registration, resets, privacy and admin remain noindex |
| Filtered shop | Category query views stay noindex with the unfiltered shop canonical | Filters do not create separate search landing pages |
| Crawl discovery | Dynamic `/robots.txt` advertises `/sitemap.xml` only when indexing is enabled | Crawlers can fetch pages and see their noindex instructions |
| Sitemap | Four public information pages plus currently published listings whose Lunar products are published | Drafts, hidden listings, utility pages and parameter URLs are absent |
| Structured data | Organization, WebSite, WebPage/CollectionPage, Product and visible product breadcrumbs | JSON parses, names and URLs agree with the displayed catalogue |
| Preview truthfulness | No provisional offers, invented ratings, supplier branding, delivery guarantees or business address in schema | Search markup does not advertise an order that cannot be placed |
| On-page clarity | Shop heading/intro, homepage box introduction and semantic product breadcrumbs | Brand copy retains its voice while explaining the range and location |
| Image loading | Product main image gets high fetch priority; page-specific assets are included in the initial document | Main product imagery and page styling are available on first render |
| Verification | Optional `GOOGLE_SITE_VERIFICATION` meta tag | Supplied Search Console verification token appears in initial HTML |

SSR serves the same content to visitors and crawlers. Google can render JavaScript, but recommends server rendering or pre-rendering to improve access for users and crawlers. [Google JavaScript SEO](https://developers.google.com/search/docs/crawling-indexing/javascript/javascript-seo-basics)

### Key files

- `config/seo.php`: public page copy, image mapping, verification and indexing switch.
- `app/Services/StorefrontSeo.php`: page metadata, canonical URLs and JSON-LD.
- `app/Http/Middleware/SetRobotsHeader.php`: robots response headers, including errors and admin responses.
- `app/Http/Controllers/SeoController.php`: dynamic robots and sitemap.
- `resources/js/components/SeoHead.ts`: reactive Inertia head output.
- `resources/views/seo.blade.php`: metadata fallback using the same server data.
- `resources/js/ssr.ts`, `resources/js/resolvePage.ts`, `resources/js/app.ts`: rendering and hydration.
- `tests/Feature/SeoTest.php`, `tests/Browser/seo.spec.ts`: SEO regression coverage.

### Indexing rules

| URL/environment | Rule |
| --- | --- |
| Any nonproduction environment, HTTP origin, alternate origin, or indexing disabled | `noindex, nofollow` |
| Canonical HTTPS production: home, shop, delivery, how-it-works, published product | `index, follow, max-image-preview:large` |
| Shop with `category` parameter | `noindex, follow`; canonical `/shop` |
| Account/cart/auth/privacy/admin and other utility responses | `noindex, follow` on successful production responses |
| Errors and redirects | `noindex, nofollow` HTTP header |

Robots allows crawling so bots can read noindex tags. It is not access control: private accounts still require authentication. Blocking a page in robots can prevent Google from reading its noindex instruction. [Google noindex guidance](https://developers.google.com/search/docs/crawling-indexing/block-indexing)

The initial catalogue gives **10 sitemap URLs** when all six listings are published. Sitemap entries update with publication changes. `lastmod` is intentionally omitted because there is no reliable timestamp covering every visible page-content change. Scale to a sitemap index if the catalogue approaches protocol limits. [Google sitemap guidance](https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap)

## 3. Search intent and page ownership

Keep one primary page for each intent. Preserve existing product slugs when changing display names; an intentional slug migration needs a one-hop permanent redirect and updated internal links.

| Search intent hypothesis | Primary page | Required content / conversion |
| --- | --- | --- |
| German sausage boxes Sydney; Wiener Box brand | `/` | Explain the box, Sydney launch status, product choices and launch signup |
| Sausage boxes, subscriptions and gifts | `/shop` | Compare the available formats; link to all products |
| Monthly sausage subscription box | `/products/the-regular` | The Big Wiener Club: proposed contents and cadence; confirmed renewal/skip terms before sales |
| One-off sausage box | `/products/the-fling` | The Wurst Fling: contents, occasions and how it differs from monthly |
| Sausage gift box Sydney | `/products/the-big-gesture` | Nice Package: gift contents; gift message, recipient and delivery arrangements when confirmed |
| Classic wieners / frankfurters | `/products/classic-wieners` | Product identity, flavour and serving ideas; verified pack information |
| German bratwurst Sydney | `/products/bratwurst` | Specific bratwurst information and verified preparation guidance |
| Cheese kransky Sydney | `/products/cheese-kransky` | Product-specific flavour, pack information and allergens when confirmed |
| Chilled sausage delivery Sydney | `/delivery` | Actual eligible postcodes, charges, timing and delivery expectations once contracted |
| How sausage subscriptions work | `/how-it-works` | Clear steps and links to the relevant products and delivery page |

Validate wording after launch using Search Console queries, customer enquiries and conversion data. Review relevant local search results before expanding a topic; do not treat a generic high-volume keyword as proof of buying intent.

Avoid standalone suburb pages with repeated copy. Add category landing pages only when they provide useful comparison, enough distinct products and unique content. For now, individual products own subscription and gift intent, and the existing category filters remain browsing tools.

## 4. Content and trust work

### Before enabling public discovery

1. Confirm the spelling **Wiener Box**, canonical domain and public contact route.
2. Review every preview statement for accuracy. Ensure the site still clearly says orders are not open.
3. Check that every published product has a useful, distinct story and a relevant image. Existing photography is labelled as preview/serving imagery; replace it with verified final product photography when available.
4. Confirm all public links and the launch-list journey on mobile.
5. Select the actual production domain and validate the technical checks in section 6.

### Before selling or adding commercial rich results

- Publish confirmed pack weights/counts, inclusions, ingredients, allergens and storage/preparation instructions. Supplier or qualified food-safety review must establish these facts.
- Confirm price, tax treatment, availability, delivery regions/charges, shipping times and returns terms against live commerce behaviour.
- Add visible contact/support details and actual business information, plus terms and subscription rules.
- Replace preview descriptions and photographs with approved sales content.
- Add real `Offer` data only when checkout, inventory and pricing are authoritative. Handle unavailable products honestly and do not call a preview a preorder unless orders can actually be placed.
- Consider Merchant Center/free listings once accurate product feeds and purchase pages exist. Reconcile feed prices/stock with Lunar and the checkout source of truth.
- Add genuine product reviews only after collecting them; never turn supplier awards into customer ratings.

Current Product markup identifies products but deliberately has no offers or reviews, so it is **not yet eligible for Google product rich results**. Add the required supported commercial data at the sales milestone. [Google Product requirements](https://developers.google.com/search/docs/appearance/structured-data/product-snippet)

Organization markup currently includes the brand name and URL. Extend it with the real logo, contact details and verified profiles when those are confirmed and visible. [Organization documentation](https://developers.google.com/search/docs/appearance/structured-data/organization)

### Editorial programme: first 90 days after discovery opens

| Timing | Deliverable | Purpose / gate |
| --- | --- | --- |
| Weeks 1–2 | Complete product-page review, launch FAQ and delivery explanation | Resolve unanswered purchase questions before writing more pages |
| Weeks 3–4 | Wiener, bratwurst and cheese kransky comparison guide | Help shoppers choose; supplier review for specific claims; link to the three packs |
| Weeks 5–6 | Sausage box for a small BBQ: serving ideas and quantities | Use tested portions and final pack sizes; link to the one-off box |
| Weeks 7–8 | Chilled food gifting guide for Sydney | Explain actual recipient/delivery arrangements; link to Nice Package |
| Weeks 9–10 | Real box unpacking, sourcing and founder story | Establish trust with original imagery and verified relationships |
| Weeks 11–12 | Refresh pages using search queries and support questions | Improve pages with impressions and weak conversion; merge overlapping content |

These are editorial briefs, not content already published. Each new guide needs an original contribution, descriptive title/H1, useful internal links, an author/reviewer where appropriate and a clear next action. Add recipe schema only to complete, tested recipes with all required visible fields.

## 5. Local discovery and authority

- Describe the actual Sydney service area consistently. Do not imply national delivery before it exists.
- Check Google Business Profile eligibility against the real fulfilment model before creating a listing; online-only businesses are ineligible. Do not invent a storefront or use an unstaffed address to obtain a map listing. [Business eligibility](https://support.google.com/business/answer/13763036)
- Publish consistent business/contact information on owned profiles and genuine relevant directories once confirmed.
- Pursue relevant coverage through real supplier relationships, community events, Sydney food publications and original recipes. Partner links should describe the actual relationship.
- Seek honest feedback after fulfilment. Avoid paid link schemes, bulk directory submissions or location pages created solely for search traffic.

## 6. Deployment and launch runbook

### Configuration

The canonical origin is `APP_URL`; use one HTTPS origin with no path, query or fragment. This is also used for share images and sitemap URLs. Example values below are placeholders, not a registered domain:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-confirmed-domain.example
SEO_INDEXING_ENABLED=false
INERTIA_SSR_ENABLED=true
INERTIA_SSR_URL=http://127.0.0.1:13714
GOOGLE_SITE_VERIFICATION=
```

### Build and operate SSR

1. Install the existing lockfile dependencies in the deployment environment. No new package dependencies were introduced for SEO.
2. Run `npm run build`. Deploy `public/build` and the entire `bootstrap/ssr` output together with the application.
3. Run `php artisan inertia:start-ssr --no-interaction` as a supervised, automatically restarted process. Use the project-supported Node runtime; the local verification runtime is Node 22.
4. Keep the rendering port private to the application network; the installed Inertia server binds port 13714. Do not expose it as a public service.
5. Restart the rendering process after each build/deploy so its loaded modules match the release. Use `php artisan inertia:check-ssr --no-interaction` for the health check.
6. If environment values change, rebuild Laravel’s config cache in deployment. Confirm trusted-proxy configuration makes Laravel see the real HTTPS scheme and canonical host.

The setup follows the installed Inertia v2 rendering workflow. A separate Node service is required in production; building the bundle alone does not run it. [Inertia SSR documentation](https://inertiajs.com/docs/v2/advanced/server-side-rendering)

### Domain and launch checks

- Configure TLS and permanent redirects at the hosting layer: HTTP to HTTPS and the alternate hostname to the chosen hostname. Preserve meaningful paths/query strings and avoid redirect chains.
- Ensure the host routes `/robots.txt` through Laravel. Remove any stale static robots file from prior releases/CDN caches.
- Avoid caching personalised Inertia HTML or JSON publicly. Preserve Inertia’s `Vary` behaviour; use long-lived caching for versioned static assets.
- Verify the public home, shop, one product, delivery and how-it-works in raw HTML and with JavaScript disabled. Confirm one title, description and canonical; social image URLs must resolve publicly.
- Test the production `APP_URL` origin with `SEO_INDEXING_ENABLED=true` in the release validation environment. All four indexing gates must agree; do not remove the gates to work around proxy misconfiguration.
- Confirm the sitemap contains only clean, public URLs and that `/cart`, `/account`, reset pages and admin remain noindex.
- Validate markup with Google Rich Results Test and Schema.org Validator. The preview Product offer limitation above is expected until sales data exists.
- Verify the owned Search Console domain property (DNS preferred), or enter the supplied URL-prefix verification token in `GOOGLE_SITE_VERIFICATION`.
- When ready, set `SEO_INDEXING_ENABLED=true` on canonical production, refresh config/cache, fetch the live robots file and submit `/sitemap.xml` in Search Console. Inspect a sample of public URLs.

Production publishing, DNS changes, Search Console verification/submission and Merchant Center setup have not been performed in this repository task. They require the actual domain and account access.

### Regression checks

```sh
php artisan test --compact tests/Feature/SeoTest.php tests/Feature/CommerceTest.php tests/Feature/ProductionCatalogueSeederTest.php
npm run typecheck
npm run build
```

Start the local application and SSR process, then run `npm run test:browser -- tests/Browser/seo.spec.ts`. The browser checks require the existing six-product preview catalogue and installed Playwright browser; `PREVIEW_URL` can point them at a separate local test server. Do not run account/cart regression flows against live customer data.

Verified locally on 15 September 2026: **47 PHP tests passed** (27 SEO cases plus 20 catalogue/commerce cases), **11 browser tests passed** (SEO and storefront flows), TypeScript checking passed, browser/SSR builds passed, and Pint and diff whitespace checks passed. Browser checks used the local preview at port 8010 with the rendering service running. Production crawling, rich-results validation and field performance remain launch checks.

For an SSR outage, retain the Blade metadata fallback and browser rendering while restoring the daemon. Do not change indexability as a transient outage workaround. Roll back matching PHP, browser and SSR artifacts together if a release fails.

## 7. Performance and measurement

### Performance

Keep the current responsive images, explicit dimensions and local fonts. Audit the production mobile experience after deployment; local build size is not a Core Web Vitals score.

Targets at the 75th percentile of real visits: LCP at most 2.5 seconds, INP below 200 ms and CLS below 0.1. Check the home, shop and a product page with PageSpeed Insights and monitor field data when traffic is sufficient. [Core Web Vitals guidance](https://developers.google.com/search/docs/appearance/core-web-vitals)

Prioritise the largest visible image, reduce competing early image downloads, keep below-the-fold images lazy, and watch carousel/font layout stability. Measure server response time and SSR availability. Do not introduce a heavy analytics/tag stack without measuring its effect.

### Measurement design

Search Console and analytics are not connected yet. Select the actual analytics provider and consent approach before enabling tracking. Do not send emails, addresses, reset tokens or other personal data in URLs or analytics payloads.

| Metric | Source | Review |
| --- | --- | --- |
| Eligible sitemap URLs vs indexed URLs; unexpected exclusions | Search Console indexing and sitemap reports | Weekly during launch |
| Nonbrand impressions, clicks and CTR by landing page/query | Search Console | Weekly, with 28-day comparisons when available |
| Organic landing visits to successful launch signups | Analytics plus deduplicated successful server submissions | Weekly |
| Product views to preview-cart use | Analytics, explicitly labelled preview activity | Weekly before sales |
| Organic paid orders, net revenue and contribution | Paid order records and deduplicated purchase events after sales open | Weekly after sales |
| LCP, INP, CLS and rendering failures | Field data, PageSpeed Insights and application monitoring | After releases and monthly |

Proposed events: `view_item`, `delivery_check_completed` (planned/outside area only), `generate_lead` after a successful launch signup, and later `purchase` after server-confirmed payment. A form click is not a lead; a preview cart is not revenue. Resolve duplicate signups and repeated payment webhooks before counting conversions.

Assign an owner to a weekly 30-minute review: engineering handles crawl/rendering defects, the founder approves business facts and the content owner updates useful pages. Establish a baseline in the first month before setting traffic or lead targets. No ranking or traffic guarantee is implied.

## 8. Priority and ownership

| Priority | Work | Owner | Status |
| --- | --- | --- | --- |
| P0 | Crawlable rendering, metadata, canonicals, sitemap, indexing controls and regression coverage | Engineering | Implemented in this repository |
| P0 | Confirm domain, production SSR supervision, redirects and launch indexability | Founder + hosting owner | Deployment action required |
| P0 | Verify and submit Search Console; inspect live rendering | Domain/account owner | Access required |
| P1 | Final product facts, delivery policy, business details and real imagery | Founder + supplier/operations | Required before sales |
| P1 | Analytics and successful-signup measurement | Founder + engineering | Provider/access and consent decisions required |
| P1 | Live offers, Merchant Center and stock/price consistency | Commerce engineering | After checkout and fulfilment are ready |
| P2 | Original guides, eligible local presence and relevant partnerships | Content + founder | Follow the 90-day programme |
| Ongoing | Query review, content refinement, performance and indexation monitoring | Named SEO owner | Begin after public deployment |
