<?php

namespace App\Http\Middleware;

use Closure;


class LanguageSet
{
    /**
     * Handle an incoming request and determine the locale to set
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check for $_GET param of lang to set language, fall back to English
        $lang = $request->input('lang');

        if( 
          $lang !== \App::getLocale() and 
          in_array(strtolower($lang), config('app.available_locales'))
        ) {
            \App::setLocale($lang);
        }

        return $next($request);
    }

}

?>
