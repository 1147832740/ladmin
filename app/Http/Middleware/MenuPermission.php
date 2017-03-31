<?php

namespace App\Http\Middleware;

use Gate;
use Closure;
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
        // dd($action_method_str);
        if($user['id']!=SUPER_ADMIN_ID){
            //判断用户是否具有当前路由权限
            if($action_method_str!='admin'){
                if(!Gate::allows($action_method_str,$info)){
                    dd('error');
                }
            }            
        }


        
        $action_method=explode('/',$action_method_str);
        $request->attributes->set('action_method',$action_method_str);
        $request->attributes->set('action_name',isset($action_method[0])?:'');
        $request->attributes->set('method_name',isset($action_method[1])?:'');

        //获取菜单
        $menu=$this->get_menu($action_method_str,$info['pid']);
        $request->attributes->set('admin_menu',$menu);

        return $next($request);
    }

    /**
     * 获取菜单
     * @return [type] [description]
     */
    public function get_menu($action_method,$id)
    {
        $first=Permission::where([['pid',0],['status',1]])->orderBy('sort','desc')->get();
        return get_permission_list($first,array(),-1,$action_method,$id);
    }
}
