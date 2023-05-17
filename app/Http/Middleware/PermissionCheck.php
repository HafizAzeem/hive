<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helper;
use Auth;

class PermissionCheck
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
        if(Auth::user())
        {
        $permissionArr = getRoutePermission();
        $permissionArr['outlet']=1;
        $route = $request->route()->action['as'];
     
        if(isset($permissionArr[$route])){
            if($permissionArr[$route]==1){
                return $next($request);
            }
        }
        }else
        {
            return redirect('/');
        }
        return redirect()->route('access-denied');
    }
}
