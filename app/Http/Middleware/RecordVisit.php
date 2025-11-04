<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class RecordVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $agent = strtolower($request->userAgent() ?? '');

        // 봇 필터링
        $bots = [
            'bot', 'crawl', 'spider', 'slurp', 'bing', 'duckduck',
            'baidu', 'yandex', 'sogou', 'naver', 'kakao'
        ];

        foreach ($bots as $bot) {
            if (str_contains($agent, $bot)) {
                return $next($request); // 봇인 경우 방문 기록하지 않음
            }
        }

        // 방문자 HLL 처리
        $today = now()->format('Y-m-d');
        $key = "visits:daily:{$today}";

        // Identify user by ID or IP
        $id = auth()->check() ? auth()->id() : $request->ip();

        // Record unique visit
        Redis::pfadd($key, [$id]);

        // Keep for 30 days
        Redis::expire($key, 60 * 60 * 24 * 30);

        return $next($request);
    }
}
