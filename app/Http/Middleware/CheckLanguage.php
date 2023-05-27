<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage {
    public function handle(Request $request, Closure $next) {
        if ($request->header('language') != 'ar')
            $request->headers->set('language',  'en', true);
        return $next($request);
    }
}
