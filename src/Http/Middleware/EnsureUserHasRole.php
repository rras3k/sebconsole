<?php


namespace Rras3k\Sebconsole\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Rras3k\SebconsoleRoot\facades\RoleUser;


class EnsureUserHasRole 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // if ($request->user()->roles()->where('nom', $role)->exists()) return $next($request);

        if (RoleUser::hasRole($role)) return $next($request);

        abort(403);
    }
}
