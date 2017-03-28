<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Model\PermissionModel as Permission;
use Illuminate\Support\Facades\Route;

class PermissionController extends Controller
{
    /**
     * 权限列表
     * @return [type] [description]
     */
    public function index(Request $request)
    {
        $input=$request->all();
        $where=array(['pid',0]);
        foreach ($input as $key => $value) {
            if(!empty($value)){
                if($key=='name'){
                    $where[]=array($key,'like','%'.$value.'%');
                    continue;
                }
                $where[$key]=$value;
            }
        }
        $first=Permission::where($where)->get();
        $data['list']=$this->get_list($first,array());
        dd($data);
        $data['input']=$input;
        return view('admin.permission.list',$data);
    }

    /**
     * 添加权限展示
     */
    public function add_show()
    {
        $data['list']=Permission::get();
        return view('admin.permission.add',$data);
    }

    /**
     * 执行添加操作
     */
    public function add_exec(Request $request)
    {
        $this->check_data($request);

        $res=Permission::create($request->all());
        if($res){
            return response()->json(['status'=>1,'info'=>'添加成功']);
        }else{
            return response()->json(['status'=>0,'info'=>'添加失败，请重试']);
        }
    }


    /**
     * 修改权限展示
     */
    public function edit_show($id)
    {
        if(empty($id)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }
        
        $detail=Permission::find($id);
        $data['list']=Permission::get();
        if(empty($detail)){
            return response()->json(['status'=>0,'info'=>'找不到该数据!']);
        }
        return view('admin.permission.edit',$detail,$data);
    }

    /**
     * 执行修改操作
     */
    public function edit_exec(Request $request)
    {
        $this->check_data($request);
        $data=$request->all();
        $detail=Permission::find($data['id']);
        $detail['uri']=$data['uri'];
        $detail['title']=$data['title'];
        $detail['pid']=$data['pid'];
        $detail['isshow']=$data['isshow'];
        $detail['status']=$data['status'];

        $res=$detail->save();
        if($res){
            return response()->json(['status'=>1,'info'=>'修改成功']);
        }else{
            return response()->json(['status'=>0,'info'=>'修改失败，请重试']);
        }
    }


    /**
     * 启用或者禁用权限
     */
    public function upd_status(Request $request)
    {
        $id=$request->id;
        $status=$request->status;
        if(empty($id)){
            return response()->json(['status'=>0,'info'=>'id丢失']);
        }

        $detail=Permission::find($id);
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
     * 删除权限
     */
    public function del(Request $request)
    {
        $id=$request->id;
        if(empty($id)){
            return response()->json(['status'=>0,'info'=>'id丢失']);
        }

        if(is_array($id)){
            $res=Permission::destroy($id);
        }else{
            $detail=Permission::find($id);
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
     * 获取父子级权限列表
     */
    public function get_list($data=array(),$new_data=array())
    {
        if(!empty($data)){
            foreach ($data as $key => $value) {
                $new_data[]=$value;
                $res=Permission::where('pid',$value['id'])->get();
                $new_data=$this->get_list($res,$new_data);
            }
        }else{
            return $new_data;
        }
    }

    /**
     * 验证结果
     */
    public function check_data($request)
    {
        $this->validate($request,[
            'uri'          =>  'bail|required',
            'title'        =>  'bail|required|max:50',
            'pid'          =>  'bail|required',
        ]);
    }
}
