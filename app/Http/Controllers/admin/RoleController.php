<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\RoleModel as Role;
use Illuminate\Support\Facades\Route;

class RoleController extends Controller
{
	/**
	 * 角色列表
	 * @return [type] [description]
	 */
    public function index(Request $request)
    {
    	$input=$request->all();
    	$where=array();
    	foreach ($input as $key => $value) {
    		if(!empty($value)){
    			if($key=='name'){
    				$where[]=array($key,'like','%'.$value.'%');
    				continue;
    			}
    			$where[$key]=$value;
    		}
    	}
    	$data['list']=Role::where($where)->get();
    	$data['input']=$input;
    	return view('admin.role.list',$data);
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
