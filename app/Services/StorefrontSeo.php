<?php

namespace App\Services;

use App\Models\ProductListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StorefrontSeo
{
    public function indexingEnabled(Request $request): bool
    {
        $origin = rtrim((string) config('app.url'), '/');

        return app()->environment('production')
            && config('seo.indexing_enabled')
            && str_starts_with($origin, 'https://')
            && $request->getSchemeAndHttpHost() === $origin;
    }

    public function isPublicPage(Request $request): bool
    {
        if (array_key_exists($request->route()?->getName() ?? '', config('seo.pages'))) {
            return true;
        }

        $listing = $request->route('listing');

        return $request->routeIs('product')
            && $listing instanceof ProductListing
            && $listing->published
            && $listing->product?->status === 'published';
    }

    public function robots(Request $request): string
    {
        if (! $this->indexingEnabled($request)) {
            return 'noindex, nofollow';
        }

        if (! $this->isPublicPage($request) || ($request->routeIs('shop') && $request->query->has('category'))) {
            return 'noindex, follow';
        }

        return 'index, follow, max-image-preview:large';
    }

    /** @param array<string, mixed> $parameters */
    public function url(string $route, array $parameters = []): string
    {
        return rtrim((string) config('app.url'), '/').route($route, $parameters, absolute: false);
    }

    /**
     * @return array{title: string, canonical: ?string, meta: list<array{key: string, attribute: string, name: string, content: string}>, structuredData: ?string, breadcrumbs: list<array{name: string, url: string}>}
     */
    public function forRequest(Request $request): array
    {
        $route = $request->route()?->getName();
        $public = $this->isPublicPage($request);
        $page = config('seo.pages')[$route] ?? [
            'title' => match ($route) {
                'cart' => 'Your Box',
                'account' => 'Your Account',
                'login' => 'Sign In',
                'register' => 'Create an Account',
                'password.request' => 'Forgot Password',
                'password.reset' => 'Reset Password',
                'privacy' => 'Preview Privacy Notice',
                default => 'Wiener Box',
            },
            'description' => 'Wiener Box’s prelaunch preview. German-style sausage boxes and gifts, with Sydney delivery planned.',
        ];
        $canonical = $public && $route !== 'product' ? $this->url($route) : null;
        $image = $this->assetUrl(config('seo.image'));
        $imageAlt = config('seo.image_alt');
        $breadcrumbs = [];
        $graph = [];

        if ($public && $request->routeIs('product')) {
            /** @var ProductListing $listing */
            $listing = $request->route('listing');
            $name = $this->plainText($listing->product->translateAttribute('name'));
            $category = match ($listing->category) {
                'subscription' => 'Monthly Sausage Box',
                'gift' => 'Sausage Gift Box',
                'box' => 'One-Off Sausage Box',
                default => 'German-Style Sausages',
            };
            $description = $this->plainText($listing->story ?: $listing->product->translateAttribute('description'));
            $page = [
                'title' => $name.' | '.$category,
                'description' => Str::limit($description ?: 'Explore '.$name.' in the Wiener Box launch preview.', 160),
            ];
            $canonical = $this->url('product', ['listing' => $listing]);
            $productImage = config('seo.product_images')[$listing->slug] ?? null;
            $image = $this->assetUrl($productImage ?? config('seo.image'));
            $imageAlt = $name.' preview. Final products, contents and packaging may differ.';
            $breadcrumbs = [
                ['name' => 'Home', 'url' => $this->url('home')],
                ['name' => 'Sausage boxes & packs', 'url' => $this->url('shop')],
                ['name' => $name, 'url' => $canonical],
            ];
            $product = [
                '@type' => 'Product', '@id' => $canonical.'#product',
                'name' => $name, 'url' => $canonical,
                'description' => $description, 'category' => $category,
            ];

            if ($productImage !== null) {
                $product['image'] = [$image];
            }

            $graph[] = $product;
            $graph[] = [
                '@type' => 'BreadcrumbList',
                'itemListElement' => array_map(fn (array $crumb, int $position): array => [
                    '@type' => 'ListItem', 'position' => $position + 1,
                    'name' => $crumb['name'], 'item' => $crumb['url'],
                ], $breadcrumbs, array_keys($breadcrumbs)),
            ];
        }

        $siteName = config('seo.site_name');
        $title = $page['title'].' | '.$siteName;

        if ($public) {
            $home = $this->url('home');
            $graph[] = [
                '@type' => 'Organization', '@id' => $home.'#organization',
                'name' => $siteName, 'url' => $home,
            ];
            $graph[] = [
                '@type' => 'WebSite', '@id' => $home.'#website',
                'name' => $siteName, 'url' => $home, 'inLanguage' => 'en-AU',
                'publisher' => ['@id' => $home.'#organization'],
            ];
            $graph[] = [
                '@type' => $route === 'shop' ? 'CollectionPage' : 'WebPage',
                '@id' => $canonical.'#webpage', 'url' => $canonical,
                'name' => $title, 'description' => $page['description'],
                'isPartOf' => ['@id' => $home.'#website'], 'inLanguage' => 'en-AU',
                ...($route === 'product' ? ['mainEntity' => ['@id' => $canonical.'#product']] : []),
            ];
        }

        $meta = [
            $this->meta('description', $page['description']),
            $this->meta('robots', $this->robots($request)),
            $this->meta('og:site_name', $siteName, 'property'),
            $this->meta('og:locale', 'en_AU', 'property'),
            $this->meta('og:type', $route === 'product' ? 'product' : 'website', 'property'),
            $this->meta('og:title', $title, 'property'),
            $this->meta('og:description', $page['description'], 'property'),
            $this->meta('og:image', $image, 'property'),
            $this->meta('og:image:alt', $imageAlt, 'property'),
            $this->meta('twitter:card', 'summary_large_image'),
            $this->meta('twitter:title', $title),
            $this->meta('twitter:description', $page['description']),
            $this->meta('twitter:image', $image),
            $this->meta('twitter:image:alt', $imageAlt),
        ];

        if ($canonical !== null) {
            $meta[] = $this->meta('og:url', $canonical, 'property');
        }

        if (filled(config('seo.google_site_verification'))) {
            $meta[] = $this->meta('google-site-verification', config('seo.google_site_verification'));
        }

        return [
            'title' => $title, 'canonical' => $canonical, 'meta' => $meta,
            'structuredData' => $graph ? json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_THROW_ON_ERROR | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES) : null,
            'breadcrumbs' => $breadcrumbs,
        ];
    }

    private function plainText(?string $value): string
    {
        return Str::squish(strip_tags(html_entity_decode($value ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }

    private function assetUrl(string $path): string
    {
        return rtrim((string) config('app.url'), '/').'/'.ltrim($path, '/');
    }

    /** @return array{key: string, attribute: string, name: string, content: string} */
    private function meta(string $name, string $content, string $attribute = 'name'): array
    {
        return ['key' => $name, 'attribute' => $attribute, 'name' => $name, 'content' => $content];
    }
}
