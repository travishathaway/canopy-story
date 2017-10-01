<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Auth\Middleware\Authenticate;

class AuthorizeAdmin extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        parent::handle($request, $next, $guards);

        if( $this->auth->user()->isAdmin() ) {
            return $next($request);
        }

        abort(404);
    }
}
