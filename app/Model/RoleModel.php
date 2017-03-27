<?php 
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
	protected $table='adm_roles';
	protected $fillable=['name','status'];
	// protected $hidden=[''];
}