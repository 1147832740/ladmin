@extends('admin.main')

@section('meta')
@parent
<link rel="stylesheet" href="{{asset('/admin_static/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css')}}" type="text/css">
<meta name="_token" content="{{ csrf_token() }}"/>
@endsection

@section('title')
@parent
@endsection

@section('header')
@endsection

@section('menu')
@show

@section('content')
<article class="cl pd-20">
	<ul id="treeDemo" class="ztree" style="padding-left: 50px;"></ul>
	<div class="row cl">
		<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3" style="text-align: center; margin-left: 0px; width: 100%;">
			<input class="btn btn-primary radius" id="submit" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
		</div>
	</div>
</article>
@endsection

@section('footer')
@parent
@endsection


@section('javascript')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('/admin_static/lib/My97DatePicker/4.8/WdatePicker.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin_static/lib/datatables/1.10.0/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin_static/lib/laypage/1.2/laypage.js')}}"></script>
<script type="text/javascript" src="{{asset('/admin_static/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js')}}"></script>
<script type="text/javascript">
var setting = {
	check:{
		enable: true,
		chkStyle: "checkbox",
		chkboxType: { "Y": "ps", "N": "ps" },
		chkDisabledInherit: true
	},
	view: {
		dblClickExpand: false,
		showLine: false,
		selectedMulti: false
	},
	data: {
		simpleData: {
			enable:true,
			idKey: "id",
			pIdKey: "pId",
			rootPId: ""
		}
	},
	// view: {
	// 	fontCss: {
	// 		fontSize:"15px"
	// 	}
	// }
	callback: {
		// beforeClick: function(treeId, treeNode) {
		// 	var zTree = $.fn.zTree.getZTreeObj("tree");
		// 	if (treeNode.isParent) {
		// 		zTree.expandNode(treeNode);
		// 		return false;
		// 	} else {
		// 		demoIframe.attr("src",treeNode.file + ".html");
		// 		return true;
		// 	}
		// }
	}
};

var zNodes =[
	{ id:0, name:"全部权限" ,checked : @if(!empty($permission)) true @else false @endif }
];
@foreach($permission as $v)
zNodes.push({id:{{$v['id']}},pId:{{$v['pid']}},name:'{{$v["title"]}}',level:{{$v['level']}} ,checked : @if($role_permission->contains($v['id'])) true @else false @endif });
@endforeach
var code;

function showCode(str) {
	if (!code) code = $("#code");
	code.empty();
	code.append("<li>"+str+"</li>");
}

$(document).ready(function(){
	var t = $("#treeDemo");
	t = $.fn.zTree.init(t, setting, zNodes);
	t.expandAll(true);

	$("#submit").click(function(){
		var tree=$.fn.zTree.getZTreeObj("treeDemo");
		var nodes=tree.getCheckedNodes();
		var permission_id=[];
		for(var i=0; i<nodes.length; i++){
			permission_id.push(nodes[i].id);
		}

		console.log(permission_id);
		var obj=this;
		if(!$(this).attr('disabled')){
			$.post('{{adm_url("role/permission_attach")}}',{id:{{$id}},permission_id:permission_id,_token:$('meta[name="_token"]').attr('content')},function(d){
				$(obj).attr('disabled',true);
				if(d.status){
					settime_reload_by_notice(toastr.options.timeOut,d.info);
				}else{
					window.top.toastr.error(d.info);
				}
			},'json');
		}		
		return false;
	});
});
</script>

<!--/请在上方写此页面业务相关的脚本-->
@endsection