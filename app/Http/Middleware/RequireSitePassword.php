<?php

namespace App\Http\Middleware;

use App\Models\Configuration;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireSitePassword
{
    public const SESSION_KEY = 'site_gate_passed';
    public const CONFIG_KEY = 'site_password';

    /**
     * Handle an incoming request. If a site password is set and the user hasn't
     * passed the gate, redirect to the gate page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $password = Configuration::get(self::CONFIG_KEY);

        // No password set: allow everyone
        if (empty($password)) {
            return $next($request);
        }

        // Already passed the gate in this session
        if ($request->session()->get(self::SESSION_KEY) === true) {
            return $next($request);
        }

        // Logged-in admins skip the gate
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request);
        }

        // Allow access to gate page and gate submit
        if ($request->routeIs('site-gate') || $request->routeIs('site-gate.post')) {
            return $next($request);
        }

        // Allow login and logout
        if ($request->routeIs('login') || $request->routeIs('login.post') || $request->routeIs('logout')) {
            return $next($request);
        }

        // Allow all admin routes (admin can set the password)
        if ($request->is('admin') || $request->is('admin/*')) {
            return $next($request);
        }

        return redirect()->route('site-gate');
    }
}
