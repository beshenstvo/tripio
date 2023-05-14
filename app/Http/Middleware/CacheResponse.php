<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheResponse
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (config('app.cache_responses')) {
            Cache::put($request->url(), $response->getContent(), config('app.cache_time'));
        }

        return $response;
    }
}
