<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\UserType;

class ModeratorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (($request->user()->role == 'moderator' || $request->user()->role == 'admin')) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}
