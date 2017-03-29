<?php

/* -----------------------   公共函数文件   ------------------------*/


/* -----------------------   声明Model类   ------------------------*/
use \App\Model\PermissionModel as Permission;


/**
 * 返回后台地址
 */
function adm_url($uri='',$parameter=array())
{
    return url('/admin/'.$uri,$parameter);
}


/**
 * 获取父子级权限列表
 */
function get_permission_list($data=array(),$new_data=array(),$level=-1,$action_method='',$id=0)
{
    if(!empty($data)){
        $level++;
        foreach ($data as $key => $value) {
        	//判断是否是当前菜单
            $value['current']=0;
        	if($value['id']==$id){
            	$value['current']=1;
        	}else if($value['uri']==$action_method){
            	$value['current']=1;
        	}

            $value['level']=$level;
            $new_data[]=$value;

            $where=[['pid',$value['id']]];
            if(!empty($id)){
            	$where[]=['status',1];
            }
            $res=Permission::where($where)->orderBy('sort','desc')->get();
            $new_data=get_permission_list($res,$new_data,$level,$action_method,$id);
        }
        return $new_data;
    }else{
        return $new_data;
    }
}