<?php

namespace App\Http\Controllers;

use App\Models\ProductListing;
use App\Models\Recipe;
use App\Services\StorefrontSeo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function robots(Request $request, StorefrontSeo $seo): Response
    {
        $contents = "User-agent: *\nAllow: /\n";

        if ($seo->indexingEnabled($request)) {
            $contents .= "\nSitemap: ".$seo->url('sitemap')."\n";
        }

        return response($contents, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(Request $request, StorefrontSeo $seo): Response
    {
        $urls = [];

        if ($seo->indexingEnabled($request)) {
            foreach (array_keys(config('seo.pages')) as $route) {
                $urls[] = $seo->url($route);
            }

            foreach (ProductListing::query()->published()->orderBy('id')->cursor() as $listing) {
                $urls[] = $seo->url('product', ['listing' => $listing]);
            }

            foreach (Recipe::query()->published()->orderBy('position')->orderBy('id')->cursor() as $recipe) {
                $urls[] = $seo->url('recipes.show', ['recipe' => $recipe]);
            }
        }

        return response()->view('sitemap', ['urls' => $urls], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
