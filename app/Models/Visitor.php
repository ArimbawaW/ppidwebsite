<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_visited',
        'visited_at'
    ];

    protected $casts = [
        'visited_at' => 'datetime'
    ];

    public $timestamps = false;

    /**
     * Catat kunjungan baru
     */
    public static function recordVisit($request)
    {
        // Get real IP (support reverse proxy/cloudflare)
        $ipAddress = self::getRealIp($request);
        $userAgent = $request->userAgent();
        $pageVisited = $request->path();
        
        // DEBUG LOG - Hapus setelah testing
        Log::info('=== VISITOR TRACKING START ===', [
            'ip' => $ipAddress,
            'user_agent' => substr($userAgent, 0, 100),
            'page' => $pageVisited,
            'all_headers' => [
                'CF-Connecting-IP' => $request->header('CF-Connecting-IP'),
                'X-Real-IP' => $request->header('X-Real-IP'),
                'X-Forwarded-For' => $request->header('X-Forwarded-For'),
                'REMOTE_ADDR' => $request->server('REMOTE_ADDR'),
            ]
        ]);
        
        // Cek apakah IP sudah mengunjungi hari ini
        $today = now()->startOfDay();
        $alreadyVisited = self::where('ip_address', $ipAddress)
            ->where('visited_at', '>=', $today)
            ->exists();

        Log::info('Already visited check', [
            'ip' => $ipAddress,
            'already_visited' => $alreadyVisited ? 'YES' : 'NO',
            'today_start' => $today->toDateTimeString()
        ]);

        // Jika belum pernah mengunjungi hari ini, catat
        if (!$alreadyVisited) {
            $visitor = self::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'page_visited' => $pageVisited,
                'visited_at' => now()
            ]);

            Log::info('✅ NEW VISITOR RECORDED!', [
                'visitor_id' => $visitor->id,
                'ip' => $ipAddress
            ]);

            // Clear cache agar total visitor terupdate
            Cache::forget('total_visitors');
            Cache::forget('today_visitors');
            Cache::forget('monthly_visitors');
            
            Log::info('Cache cleared');
        } else {
            Log::info('⏭️ VISITOR SKIPPED (already visited today)', [
                'ip' => $ipAddress
            ]);
        }
        
        Log::info('=== VISITOR TRACKING END ===');
    }

    /**
     * Dapatkan total pengunjung unique
     * Cache 5 menit untuk performa
     */
    public static function getTotalVisitors()
    {
        return Cache::remember('total_visitors', 300, function () {
            return self::distinct('ip_address')->count('ip_address');
        });
    }

    /**
     * Dapatkan pengunjung hari ini
     */
    public static function getTodayVisitors()
    {
        return Cache::remember('today_visitors', 60, function () {
            return self::whereDate('visited_at', today())
                ->distinct('ip_address')
                ->count('ip_address');
        });
    }

    /**
     * Dapatkan pengunjung bulan ini
     */
    public static function getMonthlyVisitors()
    {
        return Cache::remember('monthly_visitors', 300, function () {
            return self::whereMonth('visited_at', now()->month)
                ->whereYear('visited_at', now()->year)
                ->distinct('ip_address')
                ->count('ip_address');
        });
    }

    /**
     * Dapatkan statistik visitor
     */
    public static function getStats()
    {
        return [
            'total' => self::getTotalVisitors(),
            'today' => self::getTodayVisitors(),
            'monthly' => self::getMonthlyVisitors(),
            'yesterday' => Cache::remember('yesterday_visitors', 300, function () {
                return self::whereDate('visited_at', today()->subDay())
                    ->distinct('ip_address')
                    ->count('ip_address');
            }),
        ];
    }

    /**
     * Get real client IP (support reverse proxy/cloudflare)
     */
    private static function getRealIp($request): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',    // Cloudflare
            'HTTP_X_REAL_IP',            // Nginx
            'HTTP_X_FORWARDED_FOR',      // Standard proxy
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            $ip = $request->server($header);
            if ($ip && filter_var($ip, FILTER_VALIDATE_IP)) {
                // Jika X-Forwarded-For berisi multiple IP, ambil yang pertama
                if (str_contains($ip, ',')) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                
                Log::info("IP found from header: {$header}", ['ip' => $ip]);
                return $ip;
            }
        }

        $fallbackIp = $request->ip();
        Log::info("IP fallback to request->ip()", ['ip' => $fallbackIp]);
        return $fallbackIp;
    }
}