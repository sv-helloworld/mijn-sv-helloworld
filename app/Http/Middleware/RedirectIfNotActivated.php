<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotActivated
{
    /**
     * The URIs that should be excluded from the middleware.
     *
     * @var array
     */
    protected $except = [
        'account/gedeactiveerd',
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
        if (Auth::user()->activated || $this->shouldPassThrough($request)) {
            return $next($request);
        }

        return redirect(route('account.deactivated'));
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
