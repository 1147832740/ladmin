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
	callback: {
		beforeClick: function(treeId, treeNode) {
			var zTree = $.fn.zTree.getZTreeObj("tree");
			if (treeNode.isParent) {
				zTree.expandNode(treeNode);
				return false;
			} else {
				demoIframe.attr("src",treeNode.file + ".html");
				return true;
			}
		}
	}
};

var zNodes =[
	{ id:0, name:"全部权限", open:true}
];
@foreach($permission as $v)
zNodes.push({id:{{$v['id']}},pId:{{$v['pid']}},name:'{{$v["title"]}}'});
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
	// demoIframe = $("#testIframe");
	// demoIframe.bind("load", loadReady);
	// var zTree = $.fn.zTree.getZTreeObj("tree");
	// zTree.selectNode(zTree.getNodeByParam("id",'11'));
});
</script>

<!--/请在上方写此页面业务相关的脚本-->
@endsection