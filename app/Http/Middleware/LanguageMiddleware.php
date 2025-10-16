<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang')) {
            session()->put('locale', $request->lang);
        }

        $locale = session()->get('locale', 'en');

        app()->setLocale($locale);

        return $next($request);
    }
}
