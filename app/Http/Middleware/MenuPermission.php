<?php

namespace App\Http\Middleware;

use Gate;
use Closure;
use Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use \App\Model\PermissionModel as Permission;

class MenuPermission
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
        $user=Auth::user();

        //获取当前路由菜单
        $action_method_str=str_replace('admin/','',$request->path());
        $info=Permission::where('uri',$action_method_str)->first();

        //获取菜单
        $menu=$this->get_menu($action_method_str,$info['pid'],$request);
        $request->attributes->set('admin_menu',$menu);

        //让404页面重新匹配路由
        Route::getRoutes()->match($request);

        //判断用户是否具有当前路由权限
        if(!empty($user) && $user['id']!=SUPER_ADMIN_ID){
            //定义不需判断的路由
            $no_judge=['admin','login','logout'];
            if(!in_array($action_method_str,$no_judge)){
                if(!empty($info)){
                    if(!Gate::allows($action_method_str,$info)){
                        return response()->view('errors.forbid');
                    }
                }
            }
        }


        

        return $next($request);
    }

    /**
     * 获取菜单
     * @return [type] [description]
     */
    public function get_menu($action_method,$id,$request)
    {
        $first=Permission::where([['pid',0],['status',1]])->orderBy('sort','desc')->get();
        return get_permission_list($first,array(),-1,$action_method,$id,$request);
    }
}
