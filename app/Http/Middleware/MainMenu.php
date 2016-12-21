<?php

namespace App\Http\Middleware;

use Auth;
use Menu;
use Closure;

class MainMenu
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
        Menu::make('menu', function ($menu) {
            //$menu->add('Home', ['route' => 'index']);

            $menu->add('Lidmaatschap', ['route' => 'subscription.index']);
            $menu->lidmaatschap->prepend('<i class="fa fa-pencil-square-o" aria-hidden="true"></i> ');

            $menu->add('Activiteiten', ['route' => 'activity.index']);
            $menu->activiteiten->prepend('<i class="fa fa-bus" aria-hidden="true"></i> ');
            $menu->activiteiten->add('Aanmeldingen', ['route' => 'activity_entry.index']);

            $menu->add('Betalingen', ['route' => 'payment.index']);
            $menu->betalingen->prepend('<i class="fa fa-money" aria-hidden="true"></i> ');

            // Check if the user is authenticated
            if (Auth::check()) {
                if (Auth::user()->hasAccountType('admin')) {
                    $menu->add('Beheren', ['route' => 'user.index']);
                    $menu->beheren->prepend('<i class="fa fa-cog" aria-hidden="true"></i> ');
                    $menu->beheren->add('Gebruikers beheren', ['route' => 'user.index']);
                    $menu->beheren->add('Inschrijvingen beheren', ['route' => 'subscription.manage']);
                    $menu->beheren->add('Aanmeldingen beheren', ['route' => 'activity.manage']);
                }
            }
        });

        return $next($request);
    }
}
