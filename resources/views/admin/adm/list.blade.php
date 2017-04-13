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
	@include('admin.small_nav')
	<div class="Hui-article">
		<article class="cl pd-20">
			<form>
				<div class="text-c">
					 加入时间：
					<input type="text" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'starttime\')||\'%y-%M-%d\'}'})" id="starttime" name="starttime" placeholder="开始时间" class="input-text Wdate" style="width:120px;">
					-
					<input type="text" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'endtime\')}',maxDate:'%y-%M-%d'})" id="endtime" placeholder="结束时间" class="input-text Wdate" style="width:120px;">
					<input type="text" class="input-text" style="width:250px" placeholder="输入用户名" id="username" name="username">
					<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
				</div>
			</form>
			<div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				<!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> -->
				<a href="javascript:;" onclick="admin_add('添加管理员','{{adm_url('adm/add')}}','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
				</span>
			</div>
			<table class="table table-border table-bordered table-bg table-sort">
				<thead>
					<tr>
						<th scope="col" colspan="10">管理员列表</th>
					</tr>
					<tr class="text-c">
						<th width="25"><input type="checkbox" name="" value=""></th>
						<th width="40">ID</th>
						<th width="150">用户名</th>
						<th width="90">昵称</th>
						<th width="150">邮箱</th>
						<th>角色</th>
						<th>分值</th>
						<th width="130">加入时间</th>
						<th width="130">修改时间</th>
						<th width="100">是否已启用</th>
						<th width="100">操作</th>
					</tr>
				</thead>
				<tbody></tbody>
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
var datatable=$('.table-sort').DataTable({
	processing:true,                     //加载进度
	paging:true,
	sorting: [[ 1, "asc" ]],           //默认第几个排序
	lengthChange: true,                 //改变每页显示数据数量
	lengthMenu:[[10,15,20],[10,15,20]],
	pageLength:10,                          //默认每页显示条数
	button:['pageLength'],
	stateSave: true,                      //状态保存
	searching: false,                      //过滤功能

	serverSide:true,                     //服务器模式
	retrieve:true,
	ajax:{
		url:'{{adm_url("adm/index")}}',
		data:function(d){
			d.starttime=$('#starttime').val();
			d.endtime=$('#endtime').val();
			d.username=$('#username').val();
			return d;
		}
	},

	createdRow: function ( row, data, index ) {
		$('td', row).addClass('text-c');
	},
	columnDefs: [ { orderable: false, targets: [ 0,$('thead .text-c th').length-1 ] },{defaultContent: "",targets: "_all"}],
	columns: [
		{data:"id",render:function(data,type,full){ return "<input type='checkbox' value='"+data+"' name='id[]'>" }},
		{data:"id"},
		{data:"username"},
		{data:"nickname"},
		{data:"email"},
		{data:"role",name:'admRoles.role'},
		{data:"money",name:'admRoles.money'},
		// {data:"adm_roles.role",name:"admRoles.name",render:function(data,type,full){
		// 	var str='';
		// 	for(var i in data){
		// 		str+=" <span class='btn btn-default radius size-S'>"+data[i].name+"</span> ";
		// 	}
		// 	return str;
		// }},
		
		// {data:"adm_roles.role",name:"admRoles.money",render:function(data,type,full){
		// 	var str=0;
		// 	for(var i in data){
		// 		str+=data[i].money;
		// 	}
		// 	return str;
		// }},
		{data:"created_at"},
		{data:"updated_at"},
		{data:"status",render:function(data,type,full){
			return data?"<span class='label label-success radius'>已启用</span>":"<span class='label radius'>已停用</span>";
		}},
		{data:"id",render:function(data,type,full){
			return '<a style="text-decoration:none" onClick="'+(full.status?"admin_stop":"admin_start")+'(this,'+data+')" href="javascript:;" title="'+(full.status?"禁用":"启用")+'"<i class="Hui-iconfont">'+(full.status?"&#xe631;":"&#xe6e1;")+'</i></a>\
					<a title="编辑" href="javascript:;" onclick="admin_edit(\'管理员编辑\',\'{{adm_url('adm/edit')}}/'+data+'\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>\
					<a title="删除" href="javascript:;" onclick="admin_del(this,'+data+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
		}},
	]
});
$(function(){
	$('form').submit(function(){
		datatable.ajax.reload();
		return false;
	});
});

/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*管理员-增加*/
function admin_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-删除*/
function admin_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		// $.post('{{adm_url("adm/del")}}',{id:id,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
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
/*管理员-编辑*/
function admin_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*管理员-停用*/
function admin_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("adm/del")}}',{id:id,status:0,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				settime_reload_by_notice(toastr.options.timeOut,d.info);
				// layer.msg('已删除!',{icon:1,time:1000});
			}else{
				window.top.toastr.error(d.info);
			}
		},'json');

		// $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
		// $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
		// $(obj).remove();
		// layer.msg('已停用!',{icon: 5,time:1000});
	});
}

/*管理员-启用*/
function admin_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("adm/del")}}',{id:id,status:1,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				settime_reload_by_notice(toastr.options.timeOut,d.info);
				// layer.msg('已删除!',{icon:1,time:1000});
			}else{
				window.top.toastr.error(d.info);
			}
		},'json');

		// $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
		// $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
		// $(obj).remove();
		// layer.msg('已启用!', {icon: 6,time:1000});
	});
}
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection