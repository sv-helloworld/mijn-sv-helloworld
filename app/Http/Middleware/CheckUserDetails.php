<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckUserDetails
{
    /**
     * The URIs that should be excluded from the middleware.
     *
     * @var array
     */
    protected $except = [
        '/account/bewerken',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }

        $user = Auth::user();

        if (! empty($user->address) && ! empty($user->zip_code) && ! empty($user->city)) {
            return $next($request);
        }

        flash('Vul a.u.b. je accountgegevens aan om verder te gaan.', 'warning');

        return redirect(route('account.edit'));
    }

    /**
     * Determine if the request has a URI that should pass through the middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}
