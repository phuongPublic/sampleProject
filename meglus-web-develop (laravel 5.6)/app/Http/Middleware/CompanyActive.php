<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CompanyActive
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
        if(!Auth::user())
            return redirect()->route('front_page');

        if(Auth::user()->company_is_active == false){
            if(Auth::user()->company_generation_num < 2){
                if(isset(Auth::user()->company_expire_days) && Auth::user()->company_expire_days < 0 ){
                    return redirect()->route('supply.company.expire');
                }else{
                    if(Route::getCurrentRoute()->uri != 'mypage')
                        return redirect()->route('mypage', ['sort[updated_at]' => 'DESC']);
                    return $next($request);
                }


            }

            return redirect()->route('supply.company.expire');

        }
        return $next($request);
    }
}
