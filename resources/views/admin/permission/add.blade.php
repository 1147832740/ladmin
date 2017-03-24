@extends('admin.main')

@section('meta')
@parent
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
	<form action="{{adm_url('permission/add')}}" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{old('name')}}" placeholder="权限名称" id="name" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限展示名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{old('display_name')}}" placeholder="权限展示名称" id="display_name" name="display_name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限描述：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="description" id="description" cols="" rows="" class="textarea valid" placeholder="权限描述" dragonfly="true" onkeyup="textarealength(this,100)">{{old('description')}}</textarea>
				<p class="textarea-numberbar"><em class="textarea-length">100</em>/100</p>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				{{csrf_field()}}
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
			</div>
		</div>
	</form>
</article>
@endsection

@section('footer')
@parent
@endsection


@section('javascript')
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="{{asset('/admin_static/lib/jquery.validation/1.14.0/jquery.validate.js')}}"></script> 
<script type="text/javascript" src="{{asset('/admin_static/lib/jquery.validation/1.14.0/validate-methods.js')}}"></script> 
<script type="text/javascript" src="{{asset('/admin_static/lib/jquery.validation/1.14.0/messages_zh.js')}}"></script> 
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});
	
	$("#form-admin-add").validate({
		rules:{
			name:{
				required:true
			},
			display_name:{
				required:true
			},
			description:{
				required:false
			}
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		error:"alert(1)",
		submitHandler:function(form){
			$(form).ajaxSubmit({success:function(d){
				// console.log(d);
				if(d.status){
					window.top.toastr.success(d.info);
					var index = parent.layer.getFrameIndex(window.name);
					parent.$('.btn-refresh').click();
					parent.layer.close(index);
					setTimeout(function(){
						window.top.location.reload();
					},toastr.options.timeOut);
				}else{
					window.top.toastr.error(d.info);
				}
			}});
		}
	});
});
function textarealength(which,max) {
	var maxChars = max;
	if (which.value.length > maxChars)
	which.value = which.value.substring(0,maxChars);
	var curr = maxChars - which.value.length;
	$('.textarea-length')[0].innerHTML = curr.toString()
}
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection