<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use Auth;

class Menus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        Menu::make('menu', function($menu) {
            $menu->add('Home', ['route' => 'index']);
        });

        return $next($request);
    }
}
