<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    public function handle($request,Closure $next){

        $http_referer = $_SERVER['HTTP_REFERER'];//获取上一次浏览的页面

        $member = $request->session()->get('member','');
        if($member ==''){
            return redirect('/login?return_url=' . urlencode($http_referer));
        }

    return $next($request);
    }
}
