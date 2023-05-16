<?php


namespace Rras3k\Sebconsole\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Rras3k\SebconsoleRoot\facades\RoleUser;

use Rras3k\Sebconsole\Models\Log;



class LogRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::init();
        return $next($request);


    }
}
