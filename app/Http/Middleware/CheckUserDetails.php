<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckUserDetails
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
        $user = Auth::user();

        if (! empty($user->address) && ! empty($user->zip_code) && ! empty($user->city)) {
            return $next($request);
        }

        flash('Vul a.u.b. je accountgegevens aan om verder te gaan.', 'warning');

        return redirect(route('account.edit'));
    }
}
