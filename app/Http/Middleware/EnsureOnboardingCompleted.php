<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->onboarding_completed) {
            // Prevent redirect loop if already on onboarding routes or logging out
            if (!$request->routeIs('onboarding.*') && !$request->routeIs('auth.logout')) {
                return redirect()->route('onboarding.profile');
            }
        }

        return $next($request);
    }
}
