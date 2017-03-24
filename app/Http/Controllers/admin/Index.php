<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class Index extends Controller
{
    public function index()
    {
    	return view("admin.index.index");
    }

    public function test()
    {
    	$first=\App\Model\Role::where("name",'admin')->first();
    	// $res=$first->attachPermission(1);
    	dd(Route::currentRouteAction());
    }
}
