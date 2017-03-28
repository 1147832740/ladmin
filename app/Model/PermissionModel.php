<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PermissionModel extends Model
{
	protected $table='adm_permissions';
	protected $fillable =['uri','title','pid','isshow'];
}