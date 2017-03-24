<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class AdminModel extends Authenticatable
{
    use Notifiable;
    
    protected $table='adm_admins';
    protected $fillable=['username','password','nickname','email'];
    protected $hidden=['remember_token'];
    

    public function role()
    {
    	return $this->belongsToMany('App\Model\Role','adm_role_admin','admin_id','role_id');
    }
}
