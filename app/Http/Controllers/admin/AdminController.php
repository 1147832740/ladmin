<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\Auth;
use \App\Model\AdminModel as User;
use Datatables;

class AdminController extends Controller
{
	/**
	 * 管理员列表
	 * @return [type] [description]
	 */
    public function index(\Illuminate\Http\Request $request)
    {
        if(Request::ajax()){
            $input=$request->all();
            // dd($input);
            if(!empty($input['order'][0]['column']==5)){
                $obj=User::with(['role'=>function($query){
                    global $input;
                dd($input);
                    $query->orderBy('adm_roles.name',$input['order'][0]['dir']);
                }]);
            }else{
                $obj=User::with('role');
            }
            return Datatables::of($obj->get())->make(true);
        }else{
            return view('admin.adm.list');
        }
    }

    /**
     * 添加管理员展示
     */
    public function add_show()
    {
    	return view('admin.adm.add');
    }

    /**
     * 执行添加操作
     */
    public function add_exec(Request $request)
    {
        $this->validate($request,[
                'username'=>'bail|required|max:20|min:3',
                'password'=>'bail|required|max:20|min:5',
                'email'=>'bail|email',
            ]);

        $res=User::create($request->all());
        if($res){
            return response()->json(['status'=>1,'info'=>'添加成功']);
        }else{
            return response()->json(['status'=>0,'info'=>'添加失败，请重试']);
        }
    }


    /**
     * 修改管理员展示
     */
    public function edit_show($id)
    {
        if(empty($id)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }
        
        $detail=User::find($id);
        if(empty($detail)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }
        return view('admin.adm.edit',$detail);
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
        $detail=User::find($data['id']);
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
     * 删除管理员
     */
    public function del(Request $request)
    {
        $id=$request->id;
    	$status=$request->status;
    	if(empty($id)){
    		return response()->json(['status'=>0,'info'=>'id丢失']);
    	}

    	$detail=User::find($id);
    	$detail->status=$status;
    	$res=$detail->save();
    	if($res){
    		return response()->json(['status'=>1,'info'=>'修改成功']);
    	}else{
    		return response()->json(['status'=>0,'info'=>'修改失败']);
    	}
    }
}
