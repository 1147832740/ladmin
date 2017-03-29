<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
	protected $table='adm_roles';
	protected $fillable=['name','status'];
	// protected $hidden=[''];
	

	/**
	 * 角色与权限   多对多
	 * @return [type] [description]
	 */
	public function permission()
	{
		return $this->belongsToMany('adm_role_permission','role_id','permission_id');
	}

	/**
	 * 角色与管理员   多对多
	 * @return [type] [description]
	 */
	public function permission()
	{
		return $this->belongsToMany('adm_role_admin','role_id','admin_id');
	}
}