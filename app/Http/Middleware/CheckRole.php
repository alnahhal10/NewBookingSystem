<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
{
    if (!$request->user() || !$request->user()->hasRole($role)) {
        // إذا مش مسجل دخول
        if (!$request->user()) {
            return redirect()->route('login');
        }
        // إذا مسجل بس ما عنده صلاحية
        abort(403, 'ما عندك صلاحية للوصول لهاد الصفحة');
    }

    return $next($request);
}
}
