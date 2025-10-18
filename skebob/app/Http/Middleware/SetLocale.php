<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // 1️⃣ Get locale from query (?lang=lv)
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        }

        // 2️⃣ Get locale from session (or default to 'en')
        $locale = Session::get('locale', 'en');

        // 3️⃣ Set locale for the app
        App::setLocale($locale);

        return $next($request);
    }
}
