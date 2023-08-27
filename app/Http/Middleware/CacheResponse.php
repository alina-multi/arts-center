<?php

namespace App\Http\Middleware;

use App\Events\WorkUserPublished;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $ttl = 60*60*24)
    {
        $response = $next($request);

        if (method_exists($response, 'getData')) {
            $data = json_encode($response->getData());
            $url = $request->getRequestUri();
            Redis::connection('externalCache')->set($url, $data,"EX", $ttl);
        }

        return $response;
    }
}
