<?php

namespace Tests\Feature;

use App\Models\ProductListing;
use App\Models\User;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Lunar\FieldTypes\TranslatedText;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        config(['inertia.ssr.enabled' => false, 'app.url' => 'https://wiener.example', 'seo.indexing_enabled' => false]);
    }

    #[TestWith(['/', 'German-Style Sausage Boxes in Sydney | Wiener Box'])]
    #[TestWith(['/shop', 'Sausage Boxes, Subscriptions & Gifts | Wiener Box'])]
    #[TestWith(['/delivery', 'Sydney Sausage Delivery | Check Your Postcode | Wiener Box'])]
    #[TestWith(['/how-it-works', 'How Our Sausage Boxes & Subscriptions Work | Wiener Box'])]
    public function test_public_pages_send_metadata_in_initial_html_without_ssr(string $path, string $title): void
    {
        $this->enableIndexing();

        $response = $this->get('https://wiener.example'.$path.'?utm_source=test');

        $response->assertOk()->assertHeader('X-Robots-Tag', 'index, follow, max-image-preview:large');
        $head = $this->htmlHead($response);
        $this->assertSame($title, $head->evaluate('string(//head/title)'));
        $this->assertSame(1.0, $head->evaluate('count(//head/title)'));
        $this->assertSame('https://wiener.example'.$path, $head->evaluate('string(//head/link[@rel="canonical"]/@href)'));
        $this->assertSame('https://wiener.example'.$path, $head->evaluate('string(//head/meta[@property="og:url"]/@content)'));
        $this->assertSame(1.0, $head->evaluate('count(//head/meta[@name="description"])'));
        $this->assertGreaterThan(70, strlen($head->evaluate('string(//head/meta[@name="description"]/@content)')));
        $this->assertSame('index, follow, max-image-preview:large', $head->evaluate('string(//head/meta[@name="robots"]/@content)'));
        $this->assertSame('summary_large_image', $head->evaluate('string(//head/meta[@name="twitter:card"]/@content)'));
        $graph = $this->structuredData($head);
        $this->assertSame('https://schema.org', $graph['@context']);
        $this->assertContains('Organization', array_column($graph['@graph'], '@type'));
        $this->assertContains('WebSite', array_column($graph['@graph'], '@type'));
    }

    #[TestWith(['local', true, 'https://wiener.example'])]
    #[TestWith(['staging', true, 'https://wiener.example'])]
    #[TestWith(['production', false, 'https://wiener.example'])]
    #[TestWith(['production', true, 'https://preview.example'])]
    #[TestWith(['production', true, 'http://wiener.example'])]
    public function test_indexing_requires_opt_in_and_the_https_production_origin(string $environment, bool $enabled, string $origin): void
    {
        $this->app->instance('env', $environment);
        config(['seo.indexing_enabled' => $enabled]);

        $response = $this->get($origin.'/delivery');

        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->assertSame('noindex, nofollow', $this->htmlHead($response)->evaluate('string(//meta[@name="robots"]/@content)'));
        $this->get($origin.'/sitemap.xml')->assertDontSee('<loc>', false);
        $this->get($origin.'/robots.txt')->assertDontSee('Sitemap:')->assertSee('Allow: /');
    }

    public function test_filtered_shop_is_noindex_and_canonicalizes_to_the_whole_range(): void
    {
        $this->enableIndexing();

        $response = $this->get('https://wiener.example/shop?category=gift&utm_source=test');

        $response->assertHeader('X-Robots-Tag', 'noindex, follow');
        $this->assertSame('https://wiener.example/shop', $this->htmlHead($response)->evaluate('string(//link[@rel="canonical"]/@href)'));
    }

    #[TestWith(['/cart'])]
    #[TestWith(['/login'])]
    #[TestWith(['/register'])]
    #[TestWith(['/forgot-password'])]
    #[TestWith(['/reset-password/private-token?email=private%40example.test'])]
    #[TestWith(['/privacy'])]
    public function test_utility_pages_are_noindex_and_exclude_private_urls_from_metadata(string $path): void
    {
        $this->enableIndexing();

        $response = $this->get('https://wiener.example'.$path);

        $response->assertHeader('X-Robots-Tag', 'noindex, follow');
        $head = $this->htmlHead($response);
        $this->assertSame('noindex, follow', $head->evaluate('string(//meta[@name="robots"]/@content)'));
        $this->assertSame(0.0, $head->evaluate('count(//head/link[@rel="canonical"] | //head/meta[@property="og:url"] | //head/script[@type="application/ld+json"])'));
        $this->assertStringNotContainsString('private-token', $head->document->saveHTML($head->query('//head')->item(0)));
        $this->assertStringNotContainsString('private@example.test', $head->document->saveHTML($head->query('//head')->item(0)));
    }

    public function test_account_and_admin_responses_are_noindex(): void
    {
        $this->enableIndexing();
        $user = User::factory()->create();

        $this->actingAs($user)->get('https://wiener.example/account')->assertHeader('X-Robots-Tag', 'noindex, follow');
        $this->get('https://wiener.example/admin/login')->assertHeader('X-Robots-Tag', 'noindex, follow');
    }

    #[TestWith(['bratwurst', 'Bratwurst', 'German-Style Sausages', '/images/food/bratwurst-reference.webp'])]
    #[TestWith(['the-regular', 'The Big Wiener Club', 'Monthly Sausage Box', '/images/products/regular-open-box.webp'])]
    #[TestWith(['the-fling', 'The Wurst Fling', 'One-Off Sausage Box', '/images/products/fling-open-box.webp'])]
    #[TestWith(['the-big-gesture', 'Nice Package', 'Sausage Gift Box', '/images/products/gift-open-box.webp'])]
    public function test_product_metadata_uses_catalogue_content_without_advertising_preview_prices_as_offers(string $slug, string $name, string $category, string $imagePath): void
    {
        $this->seed();
        $this->enableIndexing();
        $listing = ProductListing::where('slug', $slug)->firstOrFail();
        $listing->update(['story' => 'German-style sausages for the BBQ. Preview range; final pack sizes to be confirmed.']);

        $response = $this->get('https://wiener.example/products/'.$slug.'?utm_campaign=launch');

        $response->assertOk();
        $head = $this->htmlHead($response);
        $this->assertSame($name.' | '.$category.' | Wiener Box', $head->evaluate('string(//title)'));
        $this->assertSame($listing->story, $head->evaluate('string(//meta[@name="description"]/@content)'));
        $this->assertSame('https://wiener.example'.$imagePath, $head->evaluate('string(//meta[@property="og:image"]/@content)'));
        $this->assertFileExists(public_path($imagePath));
        $graph = collect($this->structuredData($head)['@graph'])->keyBy('@type');
        $this->assertSame($name, $graph['Product']['name']);
        $this->assertSame('https://wiener.example/products/'.$slug, $graph['Product']['url']);
        $this->assertArrayNotHasKey('offers', $graph['Product']);
        $this->assertArrayNotHasKey('aggregateRating', $graph['Product']);
        $this->assertSame([1, 2, 3], array_column($graph['BreadcrumbList']['itemListElement'], 'position'));
        $this->assertSame(['Home', 'Sausage boxes & packs', $name], array_column($graph['BreadcrumbList']['itemListElement'], 'name'));
    }

    public function test_unknown_product_photography_is_not_presented_as_an_actual_product_image(): void
    {
        $this->seed();
        ProductListing::where('slug', 'bratwurst')->firstOrFail()->update(['slug' => 'new-sausage']);

        $response = $this->get('/products/new-sausage');

        $product = collect($this->structuredData($this->htmlHead($response))['@graph'])->firstWhere('@type', 'Product');
        $this->assertArrayNotHasKey('image', $product);
    }

    public function test_metadata_and_json_ld_escape_catalogue_text(): void
    {
        $this->seed();
        $product = ProductListing::where('slug', 'bratwurst')->firstOrFail()->product;
        $attributes = $product->attribute_data;
        $attributes->put('name', new TranslatedText(['en' => 'BBQ "special" & </script><script>alert(1)</script>']));
        $product->update(['attribute_data' => $attributes]);

        $response = $this->get('/products/bratwurst');

        $head = $this->htmlHead($response);
        $this->assertSame(0.0, $head->evaluate('count(//head/script[not(@type="application/ld+json")])'));
        $this->assertSame('BBQ "special" & alert(1) | German-Style Sausages | Wiener Box', $head->evaluate('string(//title)'));
        $graph = collect($this->structuredData($head)['@graph'])->keyBy('@type');
        $this->assertSame('BBQ "special" & alert(1)', $graph['Product']['name']);
        $response->assertDontSee('</script><script>alert(1)</script>', false);
    }

    public function test_sitemap_contains_only_public_canonical_pages_and_current_published_products(): void
    {
        $this->seed();
        $this->enableIndexing();
        ProductListing::where('slug', 'bratwurst')->firstOrFail()->update(['published' => false]);
        ProductListing::where('slug', 'cheese-kransky')->firstOrFail()->product->update(['status' => 'draft']);

        $response = $this->get('https://wiener.example/sitemap.xml');

        $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml);
        $this->assertSame([
            'https://wiener.example/', 'https://wiener.example/shop',
            'https://wiener.example/delivery', 'https://wiener.example/how-it-works',
            'https://wiener.example/products/the-regular', 'https://wiener.example/products/the-fling',
            'https://wiener.example/products/the-big-gesture', 'https://wiener.example/products/classic-wieners',
        ], array_map(fn ($url): string => (string) $url->loc, iterator_to_array($xml->url, false)));
        $this->get('https://wiener.example/robots.txt')->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee("User-agent: *\nAllow: /\n\nSitemap: https://wiener.example/sitemap.xml", false)
            ->assertDontSee('Disallow: /', false);
    }

    public function test_missing_and_unpublished_products_return_noindex_404s(): void
    {
        $this->seed();
        $this->enableIndexing();
        ProductListing::where('slug', 'bratwurst')->firstOrFail()->update(['published' => false]);

        $this->get('https://wiener.example/products/bratwurst')->assertNotFound()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('https://wiener.example/products/missing')->assertNotFound()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->get('https://wiener.example/missing')->assertNotFound()->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_partial_inertia_navigation_always_refreshes_seo(): void
    {
        $this->seed();
        $initialResponse = $this->get('/products/bratwurst');
        $version = $initialResponse->viewData('page')['version'];

        $response = $this->withHeaders([
            'X-Inertia' => 'true', 'X-Inertia-Partial-Component' => 'Product',
            'X-Inertia-Partial-Data' => 'product', 'X-Inertia-Version' => $version,
        ])->get('/products/bratwurst');

        $response->assertOk()->assertJsonPath('component', 'Product')
            ->assertJsonPath('props.seo.canonical', 'https://wiener.example/products/bratwurst')
            ->assertJsonPath('props.seo.title', 'Bratwurst | German-Style Sausages | Wiener Box');
    }

    public function test_search_console_verification_is_optional_and_server_rendered(): void
    {
        config(['seo.google_site_verification' => 'verification-token']);

        $response = $this->get('/delivery');

        $this->assertSame('verification-token', $this->htmlHead($response)->evaluate('string(//meta[@name="google-site-verification"]/@content)'));
    }

    private function enableIndexing(): void
    {
        $this->app->instance('env', 'production');
        config(['seo.indexing_enabled' => true]);
    }

    private function htmlHead(TestResponse $response): DOMXPath
    {
        $document = new DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML($response->getContent());
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        return new DOMXPath($document);
    }

    /** @return array<string, mixed> */
    private function structuredData(DOMXPath $head): array
    {
        return json_decode($head->evaluate('string(//head/script[@type="application/ld+json"])'), true, flags: JSON_THROW_ON_ERROR);
    }
}
