<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\PermissionModel as Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permission=Permission::get();
        foreach ($permission as $key => $value) {
            Gate::define($value['uri'],function($user,$obj){
                if(!$obj['status']){
                    return false;
                }

                $p_role_id=$obj->role()->pluck('role_id')->toArray();

                $u_role_id=$user->role()->pluck('role_id')->toArray();

                $res=array_intersect($u_role_id,$p_role_id);
                return empty($res)?false:true;
            });
        }
        //
    }
}
