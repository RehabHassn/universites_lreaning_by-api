<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ChangLangMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(request()->hasHeader('lang')){
            app()->setLocale(request()->header('lang'));
        }else if ($request->hasHeader('lang')){
            app()->setLocale(request()->header('lang'));
        }else if (session()->has('lang')){
            app()->setLocale(session()->get('lang'));
        }
        return $next($request);
    }
}
