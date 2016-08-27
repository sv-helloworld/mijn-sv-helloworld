<?php

namespace App\Http\Middleware;

use Closure;
use Menu;

class SidebarMenu
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
        Menu::make('sidebar', function ($menu) {
            // Add items in specific controllers
        });

        return $next($request);
    }
}
