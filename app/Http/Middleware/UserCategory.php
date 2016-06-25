<?php

namespace App\Http\Middleware;

use Closure;

class UserCategory
{
    /**
     * Handle an incoming request and checks if the user has the required user category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $user_categories
     * @return mixed
     */
    public function handle($request, Closure $next, ...$user_categories)
    {
        $user = $request->user();

        foreach ($user_categories as $user_category) {
            if ($user->hasUserCategory($user_category)) {
                return $next($request);
            }
        }

        return redirect()->back();
    }
}
