@extends('admin.main')

@section('meta')
@parent
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
	<form action="{{adm_url('role/edit')}}" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{$name}}" placeholder="角色名称" id="name" name="name">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">状态：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="status" size="1">
					<option @if($status==1) selected @endif value="1">可用</option>
					<option @if($status==0) selected @endif value="0">禁用</option>
				</select>
				</span> </div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				{{csrf_field()}}
				<input type="hidden" name="id" value="{{$id}}">
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
			username:{
				required:true,
				minlength:3,
				maxlength:20
			},
			password:{
				minlength:5,
				maxlength:20
			},
			password_confirmation:{
				minlength:5,
				maxlength:20,
				equalTo: "#password"
			},
			// sex:{
			// 	required:true,
			// },
			// phone:{
			// 	required:true,
			// 	isPhone:true,
			// },
			email:{
				required:true,
				email:true,
			},
			// adminRole:{
			// 	required:true,
			// },
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		error:"alert(1)",
		submitHandler:function(form){
			$(form).find("input[type='submit']").attr('disabled',true);
			$(form).ajaxSubmit({success:function(d){
				if(d.status){
					settime_reload_by_notice(toastr.options.timeOut,d.info);
					// var index = parent.layer.getFrameIndex(window.name);
					// parent.$('.btn-refresh').click();
					// parent.layer.close(index);
				}else{
					window.top.toastr.error(d.info);
				}
			}});
		}
	});
});
</script>
<!--/请在上方写此页面业务相关的脚本-->
@endsection