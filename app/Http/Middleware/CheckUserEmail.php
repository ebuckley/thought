<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->email === 'ersinbuckley@gmail.com') {
            return $next($request);
        }

        // Redirect or respond with an error if the email doesn't match
        return redirect()->route('dashboard')->with('error', 'Access denied.');
    }
}
