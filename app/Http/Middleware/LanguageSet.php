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
        // If we've passed in a language once, remember it in the cookie
        if( $request->input('lang') ){
            $lang = $request->input('lang');

            if( 
              $lang !== \App::getLocale() and 
              in_array(strtolower($lang), config('app.available_locales'))
            ) {
                \App::setLocale($lang);
            }

            // TODO: Add a mechanism to remember the lanuage choice on a user
            // session
        }

        return $next($request);
    }

}

?>
