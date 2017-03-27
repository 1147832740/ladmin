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
    public function index()
    {
    	$data['list']=Role::get();
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
        $this->validate($request,[
                'name'=>'bail|required|max:20',
                'status'=>'bail|required',
            ]);

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
        $this->validate($request,[
                'username'=>'bail|required|max:20|min:3',
                'email'=>'bail|email',
            ]);
        $data=$request->all();
        $detail=Role::find($data['id']);
        $detail['username']=$data['username'];
        $detail['nickname']=$data['nickname'];
        $detail['email']=$data['email'];
        if(!empty($data['password'])){
            if(!empty($data['password_confirmation'])){
                if($data['password']!==$data['password_confirmation']){
                    return response()->json(['status'=>0,'info'=>'两次密码不一致']);
                }else{
                    $detail['password']=bcrypt($data['password']);
                }
            }else{
                return response()->json(['status'=>0,'info'=>'两次密码不一致']);
            }
        }

        $res=$detail->save();
        if($res){
            return response()->json(['status'=>1,'info'=>'修改成功']);
        }else{
            return response()->json(['status'=>0,'info'=>'修改失败，请重试']);
        }
    }


    /**
     * 删除角色
     */
    public function del(Request $request)
    {
        $id=$request->id;
    	$status=$request->status;
    	if(empty($id)){
    		return response()->json(['status'=>0,'info'=>'id丢失']);
    	}

    	$detail=Role::find($id);
    	$detail->status=$status;
    	$res=$detail->save();
    	if($res){
    		return response()->json(['status'=>1,'info'=>'修改成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'修改失败']);
    	}
    }
}
