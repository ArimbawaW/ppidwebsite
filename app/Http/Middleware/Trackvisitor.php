<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya track GET requests dan bukan untuk admin/API
        if ($request->isMethod('get') && 
            !$request->is('admin/*') && 
            !$request->is('api/*') &&
            !$request->is('login') &&
            !$request->ajax()) {
            
            try {
                Log::info('TrackVisitor Middleware: Processing request', [
                    'path' => $request->path(),
                    'method' => $request->method()
                ]);
                
                Visitor::recordVisit($request);
                
            } catch (\Exception $e) {
                Log::error('Visitor tracking error', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return $next($request);
    }
}