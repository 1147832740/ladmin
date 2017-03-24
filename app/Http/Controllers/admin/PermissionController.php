<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\Permission;

class PermissionController extends Controller
{
	public function __construct()
	{
		// dd(2);
	}
	/**
     * 权限列表
     */
    public function index()
    {
    	$data['list']=$list=Permission::get();
    	return view('admin.permission.index',$data);
    }

    /**
     * 权限添加展示
     */
    public function add_show()
    {
    	return view('admin.permission.add');
    }

    /**
     * 权限添加操作
     */
    public function add(Request $request)
    {
    	$this->validate($request,[
    			'name'          =>  'bail|required',
    			'display_name'  =>  'bail|required',
    		]);

    	$permission=new Permission();
    	$data=$permission->create($request->all());
    	
    	if(!empty($data)){
    		return response()->json(['status'=>1,'info'=>'添加成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'添加失败，请重试']);
    	}
    }

}
