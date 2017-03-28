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
	<form action="{{adm_url('adm/add')}}" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{old('username')}}" placeholder="用户名" id="username" name="username">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>昵称：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="{{old('nickname')}}" placeholder="昵称" id="nickname" name="nickname">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" autocomplete="off" value="" placeholder="密码" id="password" name="password">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password_confirmation" name="password_confirmation">
			</div>
		</div>
		<!-- <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				<div class="radio-box">
					<input name="sex" type="radio" id="sex-1" checked>
					<label for="sex-1">男</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="sex-2" name="sex">
					<label for="sex-2">女</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" value="" placeholder="" id="phone" name="phone">
			</div>
		</div> -->
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" class="input-text" placeholder="@" name="email" id="email" value="{{old('email')}}">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">角色：</label>
			<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="adminRole" size="1">
					<option value="0">超级管理员</option>
					<option value="1">总编</option>
					<option value="2">栏目主辑</option>
					<option value="3">栏目编辑</option>
				</select>
				</span> </div>
		</div>
		<!-- <div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">备注：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<textarea name="" cols="" rows="" class="textarea"  placeholder="说点什么...100个字符以内" dragonfly="true" onKeyUp="textarealength(this,100)"></textarea>
				<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
			</div>
		</div> -->
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
			username:{
				required:true,
				minlength:3,
				maxlength:20
			},
			password:{
				required:true,
				minlength:5,
				maxlength:20
			},
			password_confirmation:{
				required:true,
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