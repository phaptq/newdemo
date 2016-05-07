<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $checker = \Session::get('admin');
        if (is_null($checker)) {
            \Session::set('current_url', \URL::current());
            return \Redirect::action('Admin\AuthController@getLogin');
        }
        return $next($request);
    }
}
