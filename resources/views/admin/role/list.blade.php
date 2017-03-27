@extends('admin.main')

@section('meta')
@parent
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
@parent
@endsection

@section('header')
@parent
@endsection

@section('menu')
@parent
@show

@section('content')
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
		<span class="c-gray en">&gt;</span>
		角色管理
		<span class="c-gray en">&gt;</span>
		角色列表
		<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a>
	</nav>
	<div class="Hui-article">
		<article class="cl pd-20">
			<div class="text-c">
				<input type="text" class="input-text" style="width:250px" placeholder="输入角色名称" id="" name="">
				<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜角色</button>
			</div>
			<div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				<a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a href="javascript:;" onclick="role_add('添加角色','{{adm_url('role/add')}}','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a>
				</span>
				<span class="r">共有数据：<strong>54</strong> 条</span>
			</div>
			<table class="table table-border table-bordered table-bg">
				<thead>
					<tr>
						<th scope="col" colspan="7">角色列表</th>
					</tr>
					<tr class="text-c">
						<th width="25"><input type="checkbox" name="" value=""></th>
						<th width="40">ID</th>
						<th width="150">角色名称</th>
						<th width="130">加入时间</th>
						<th width="130">修改时间</th>
						<th width="100">是否已启用</th>
						<th width="100">操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $v)
					<tr class="text-c">
						<td><input type="checkbox" value="1" name=""></td>
						<td>{{$v['id']}}</td>
						<td>{{$v['name']}}</td>
						<td>{{$v['created_at']}}</td>
						<td>{{$v['updated_at']}}</td>
						<td class="td-status">@if($v['status'])<span class="label label-success radius">已启用</span>@else<span class="label radius">已停用</span>@endif</td>
						<td class="td-manage"><a style="text-decoration:none" onClick="@if($v['status'])role_stop(this,{{$v['id']}}) @else role_start(this,{{$v['id']}})@endif" href="javascript:;" title="停用"<i class="Hui-iconfont">@if($v['status']) &#xe631; @else &#xe6e1; @endif</i></a>
							<a title="编辑" href="javascript:;" onclick="role_edit('角色编辑','{{adm_url('role/edit',$v['id'])}}','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							<a title="删除" href="javascript:;" onclick="role_del(this,{{$v['id']}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
					</tr>
					@endforeach
					<!-- <tr class="text-c">
						<td><input type="checkbox" value="2" name=""></td>
						<td>2</td>
						<td>zhangsan</td>
						<td>13000000000</td>
						<td>admin@mail.com</td>
						<td>栏目编辑</td>
						<td>2014-6-11 11:11:42</td>
						<td class="td-status"><span class="label radius">已停用</span></td>
						<td class="td-manage"><a style="text-decoration:none" onClick="role_start(this,'10001')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe615;</i></a>
							<a title="编辑" href="javascript:;" onclick="role_edit('角色编辑','admin-add.html','2','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
							<a title="删除" href="javascript:;" onclick="role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
					</tr> -->
				</tbody>
			</table>
		</article>
	</div>
</section>
@endsection

@section('footer')
@parent
@endsection


@section('javascript')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('/admin_static/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin_static/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin_static/lib/laypage/1.2/laypage.js')}}"></script>
<script type="text/javascript">
/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*角色-增加*/
function role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*角色-删除*/
function role_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		// $.post('{{adm_url("role/del")}}',{id:id,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
		// 	if(d.status){
		// 		$(obj).parents("tr").remove();
		// 		// window.top.toastr.success(d.info);
		// 		layer.msg('已删除!',{icon:1,time:1000});
		// 	}else{
		// 		window.top.toastr.error(d.info);
		// 	}
		// },'json');		
	});
}
/*角色-编辑*/
function role_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*角色-停用*/
function role_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("role/del")}}',{id:id,status:0,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				window.top.toastr.success(d.info);
				layer.close(index);
				settime_reload(toastr.options.timeOut);
				// layer.msg('已删除!',{icon:1,time:1000});
			}else{
				window.top.toastr.error(d.info);
			}
		},'json');

		// $(obj).parents("tr").find(".td-manage").prepend('<a onClick="role_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
		// $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
		// $(obj).remove();
		// layer.msg('已停用!',{icon: 5,time:1000});
	});
}

/*角色-启用*/
function role_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("role/del")}}',{id:id,status:1,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				window.top.toastr.success(d.info);
				layer.close(index);
				settime_reload(toastr.options.timeOut);
				// layer.msg('已删除!',{icon:1,time:1000});
			}else{
				window.top.toastr.error(d.info);
			}
		},'json');

		// $(obj).parents("tr").find(".td-manage").prepend('<a onClick="role_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
		// $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
		// $(obj).remove();
		// layer.msg('已启用!', {icon: 6,time:1000});
	});
}
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection