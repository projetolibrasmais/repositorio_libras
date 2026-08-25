<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is in session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } 
        // Check if locale is in request
        elseif ($request->has('locale')) {
            $locale = $request->get('locale');
            Session::put('locale', $locale);
        }
        // Default to Portuguese
        else {
            $locale = 'pt_BR';
        }

        // Validate locale
        if (in_array($locale, ['pt_BR', 'en', 'es'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
