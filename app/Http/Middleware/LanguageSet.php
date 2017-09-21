<?php

namespace App\Http\Middleware;

use Closure;


class LanguageSet
{
    /**
     * Handle an incoming request and by looking at the session
     * determine which locale to set.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( session('lang') !== null){
            \App::setLocale(session('lang'));
        }

        return $next($request);
    }
}

?>
