<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class RedirectIfNotVerified
{
    /**
     * The URIs that should be excluded from the middleware.
     *
     * @var array
     */
    protected $except = [
        '/'
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
        if($this->shouldPassThrough($request)) {
            return $next($request);
        }

        if (!Auth::user()->verified) {
            Flash::warning('U moet uw e-mailadres verifieren voor u deze pagina kunt bezoeken.');
            return redirect('/');
        }

        return $next($request);
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
