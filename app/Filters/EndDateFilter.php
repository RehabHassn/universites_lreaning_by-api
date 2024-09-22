<?php

namespace App\Filters;
use Closure;
class EndDateFilter
{
    public function handle($request ,Closure $next){
        if(request()->filled('end_date')){
            return $next($request)
                ->where('created_at','<=',request('end_date'));
        }



        return $next($request);

    }
}
