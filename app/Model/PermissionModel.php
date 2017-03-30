<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
	protected $table='adm_permissions';
	protected $fillable =['uri','title','sort','pid','isshow'];

	/**
	 * 权限与角色   多对多
	 * @return [type] [description]
	 */
	public function role()
	{
		return $this->belongsToMany('App\Model\PermissionModel','adm_role_permission','permission_id','role_id');
	}
}