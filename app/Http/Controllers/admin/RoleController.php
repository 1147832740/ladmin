<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\Role;

class RoleController extends Controller
{
    public function add()
    {
    	// $owner = new \App\Model\Role();
		// $owner->name         = 'owner';
		// $owner->display_name = 'Project Owner'; // optional
		// $owner->description  = 'User is the owner of a given project'; // optional
    	// dd($owner);
		// $owner->save();

		$admin = new Role();
		$admin->name         = 'test4';
		$admin->display_name = 'test'; // optional
		$admin->description  = 'test'; // optional
		$admin->save();
    }
}
