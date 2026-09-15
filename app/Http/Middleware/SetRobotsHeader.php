<?php

namespace App\Http\Middleware;

use App\Services\StorefrontSeo;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetRobotsHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $response->headers->set('X-Robots-Tag', $response->isSuccessful()
            ? app(StorefrontSeo::class)->robots($request)
            : 'noindex, nofollow');

        return $response;
    }
}
