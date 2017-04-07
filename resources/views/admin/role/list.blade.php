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
			<div class="text-c">
				<form>
					<input type="text" class="input-text" style="width:250px" placeholder="输入角色名称" id="name" name="name" value="">
					<button type="submit" class="btn btn-success" id="submit" name=""><i class="Hui-iconfont">&#xe665;</i> 搜角色</button>
				</form>				
			</div>
			<div class="cl pd-5 bg-1 bk-gray mt-20">
				<span class="l">
				<a href="javascript:;" onclick="more_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
				<a href="javascript:;" onclick="role_add('添加角色','{{adm_url('role/add')}}','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a>
				</span>
			</div>
			<table class="table table-border table-bordered table-bg table-sort">
				<thead>
					<tr>
						<th scope="col" colspan="8">角色列表</th>
					</tr>
					<tr class="text-c">
						<th width="25"><input type="checkbox" name="count_checkbox" value=""></th>
						<th width="40">ID</th>
						<th width="150">角色名称</th>
						<th width="150">所属管理员</th>
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
	// dom:'',

	serverSide:true,                     //服务器模式
	retrieve:true,
	ajax:{
		url:'{{adm_url("role/index")}}',
		data:function(d){
			d.name=$('#name').val();
			return d;
		}
	},

	createdRow: function ( row, data, index ) {
		$('td', row).addClass('text-c');
	},
	columnDefs: [ { orderable: false, targets: [ 0,3,$('thead .text-c th').length-1 ] },{defaultContent: "",targets: "_all"}],
	columns: [
		{data:"id",render:function(data,type,full){ return "<input type='checkbox' value='"+data+"' name='id[]'>" }},
		{data:"id"},
		{data:"name"},
		{data:"admin",render:function(data,type,full){
			var str='';
			for(var i in data){
				str+=" <span class='btn btn-default radius size-S'>"+data[i].username+"</span> ";
			}
			return str;
		}},
		{data:"created_at"},
		{data:"updated_at"},
		{data:"status",render:function(data,type,full){
			return data?"<span class='label label-success radius'>已启用</span>":"<span class='label radius'>已停用</span>";
		}},
		{data:"id",render:function(data,type,full){
			return '<a style="text-decoration:none" onClick="role_status(this,'+data+','+(full.status?0:1)+')" href="javascript:;" title="'+(full.status?"禁用":"启用")+'"<i class="Hui-iconfont">'+(full.status?"&#xe631;":"&#xe6e1;")+'</i></a>\
					<a title="编辑" href="javascript:;" onclick="role_edit(\'角色编辑\',\'{{adm_url('role/edit')}}/'+data+'\',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>\
					<a title="删除" href="javascript:;" onclick="role_del(this,'+data+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>\
					<a title="编辑权限" href="javascript:;" onclick="role_permission(\'编辑权限\',\'{{adm_url('role/permission')}}/'+data+'\',\'500\',\'700\')" class="ml-5 btn btn-primary radius size-MINI" style="text-decoration:none">编辑权限</a>\
					<a title="编辑用户" href="javascript:;" onclick="role_permission(\'编辑用户\',\'{{adm_url('role/admin')}}/'+data+'\',\'500\',\'600\')" class="ml-5 btn btn-primary radius size-MINI" style="text-decoration:none">编辑用户</a>';
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
/*角色-增加*/
function role_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*角色-删除*/
function role_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("role/del")}}',{id:id,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				settime_reload_by_notice(toastr.options.timeOut,d.info);
				// layer.msg('已删除!',{icon:1,time:1000});
			}else{
				window.top.toastr.error(d.info);
			}
		},'json');		
	});
}
/*角色-编辑*/
function role_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*角色-停用||启用*/
function role_status(obj,id,status){
	var str=status?'启用':'禁用';
	layer.confirm('确认要'+str+'吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("role/upd_status")}}',{id:id,status:status,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				settime_reload_by_notice(toastr.options.timeOut,d.info);
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

/*角色-批量删除*/
function more_del() {
	var ids=get_count_checkbox_id();
	if(ids.length==0){
		layer.alert('请选择一个', {icon: 5});
		return false;
	}
	layer.confirm('确认要删除所选吗？',function(index){
		//此处请求后台程序，下方是成功后的前台处理……
		$.post('{{adm_url("role/del")}}',{id:ids,_token:$('meta[name="csrf-token"]').attr('content')},function(d){
			if(d.status){
				settime_reload_by_notice(toastr.options.timeOut,d.info);
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

/*
	参数解释：
	title	标题
	url		请求的url
	id		需要操作的数据id
	w		弹出层宽度（缺省调默认值）
	h		弹出层高度（缺省调默认值）
*/
/*角色-增加*/
function role_permission(title,url,w,h){
	layer_show(title,url,w,h);
}
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection