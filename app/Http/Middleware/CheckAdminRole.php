<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole {
    public function handle(Request $request, Closure $next): Response {
        $user = Auth::user();
        if ($user instanceof User)
            if ($user->role == 'admin') {
                return $next($request);
            }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
