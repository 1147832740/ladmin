<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Request;
use \App\Model\RoleModel as Role;
use \App\Model\PermissionModel as Permission;
use \App\Model\AdminModel as Admin;
use Illuminate\Support\Facades\Route;
use Datatables;

class RoleController extends Controller
{
	/**
	 * 角色列表
	 * @return [type] [description]
	 */
    public function index(\Illuminate\Http\Request $request)
    {
    	if(Request::ajax()){
    		$input=$request->all();
	    	$where=array();
			if(!empty($input['name'])){
				$where[]=array('name','like','%'.$input['name'].'%');
			}
            return Datatables::of(Role::where($where)->with('admin')->get())->make(true);
        }else{
    		return view('admin.role.list');
        }
    }

    /**
     * 添加角色展示
     */
    public function add_show()
    {
    	return view('admin.role.add');
    }

    /**
     * 执行添加操作
     */
    public function add_exec(Request $request)
    {
        $this->check_data($request);

        $res=Role::create($request->all());
        if($res){
            return response()->json(['status'=>1,'info'=>'添加成功']);
        }else{
            return response()->json(['status'=>0,'info'=>'添加失败，请重试']);
        }
    }


    /**
     * 修改角色展示
     */
    public function edit_show($id)
    {
        if(empty($id)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }
        
        $detail=Role::find($id);
        if(empty($detail)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }
        return view('admin.role.edit',$detail);
    }

    /**
     * 执行修改操作
     */
    public function edit_exec(Request $request)
    {
        $this->check_data($request);
        $data=$request->all();
        $detail=Role::find($data['id']);
        $detail['name']=$data['name'];
        $detail['status']=$data['status'];

        $res=$detail->save();
        if($res){
            return response()->json(['status'=>1,'info'=>'修改成功']);
        }else{
            return response()->json(['status'=>0,'info'=>'修改失败，请重试']);
        }
    }


    /**
     * 启用或者禁用角色
     */
    public function upd_status(Request $request)
    {
        $id=$request->id;
    	$status=$request->status;
    	if(empty($id)){
    		return response()->json(['status'=>0,'info'=>'id丢失']);
    	}

    	$detail=Role::find($id);
    	if(empty($detail)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }

    	$detail->status=$status;
    	$res=$detail->save();
    	if($res){
    		return response()->json(['status'=>1,'info'=>'修改成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'修改失败']);
    	}
    }

    /**
     * 删除角色
     */
    public function del(Request $request)
    {
    	$id=$request->id;
    	if(empty($id)){
    		return response()->json(['status'=>0,'info'=>'id丢失']);
    	}

    	if(is_array($id)){
    		$res=Role::destroy($id);
    	}else{
    		$detail=Role::find($id);
	    	if(empty($detail)){
	            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
	        }

	    	$res=$detail->delete();
    	}
    	
    	if($res){
    		return response()->json(['status'=>1,'info'=>'删除成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'删除失败']);
    	}
    }

    /**
     * 获取角色权限
     */
    public function permission($id)
    {
    	if(empty($id)){
    		return response()->json(['status'=>0,'info'=>'丢失id']);
    	}

    	$role=Role::find($id);

        $where=array(['pid',0]);
    	$first=Permission::where($where)->orderBy('sort','desc')->get();
        $data['permission']=get_permission_list($first,array());
        $data['role_permission']=$role->permission()->get();
    	$data['id']=$id;

    	return view('admin.role.permission',$data);
    }

    /**
     * 绑定权限
     */
    public function permission_attach(Request $request)
    {
    	$input=$request->all();
    	if((isset($input['permission_id']) && !is_array($input['permission_id'])) || empty($input['id'])){
    		return response()->json(['status'=>0,'info'=>'数据错误']);
    	}

    	$role=Role::find($input['id']);

    	$data=[];
    	if(isset($input['permission_id'])){
	    	foreach ($input['permission_id'] as $key => $value) {
	    		if($value){
	    			$data[$value]=['updated_at' => date("Y-m-d H:i:s")];
	    		}
	    	}
    	}    	

    	$res=$role->permission()->sync($data);
    	if($res){
    		return response()->json(['status'=>1,'info'=>'修改成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'修改失败']);
    	}
    }

    /**
     * 获取属于该角色的管理员
     */
    public function admin($id)
    {
    	if(empty($id)){
    		return response()->json(['status'=>0,'info'=>'丢失id']);
    	}

    	$role=Role::find($id);
    	$data['role_admin']=$role->admin()->pluck('adm_admins.id');
    	$data['admin']=Admin::where('id','!=',SUPER_ADMIN_ID)->get();
    	$data['id']=$id;

    	return view('admin.role.admin',$data);
    }

    /**
     * 绑定角色
     */
    public function admin_attach(Request $request)
    {
    	$input=$request->all();
    	if((isset($input['admin_id']) && !is_array($input['admin_id'])) || empty($input['id'])){
    		return response()->json(['status'=>0,'info'=>'数据错误']);
    	}

    	$role=Role::find($input['id']);

    	$data=[];
    	if(isset($input['admin_id'])){
	    	foreach ($input['admin_id'] as $key => $value) {
	    		$data[$value]=['updated_at' => date("Y-m-d H:i:s")];
	    	}
    	}    	

    	$res=$role->admin()->sync($data);
    	if($res){
    		return response()->json(['status'=>1,'info'=>'修改成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'修改失败']);
    	}
    }

    /**
     * 验证结果
     */
    public function check_data($request)
    {
    	$this->validate($request,[
            'name'=>'bail|required|max:20',
            'status'=>'bail|required',
        ]);
    }
}
