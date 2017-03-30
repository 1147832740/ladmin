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
	<span class="form-label col-xs-4 col-sm-2" style="margin-bottom: 10px;">用户列表：</span>
	<form action="{{adm_url('role/admin_attach')}}" method="post" class="form form-horizontal" id="form-admin-add">
		<div class="row cl">
			<div class="formControls col-xs-8 col-sm-9 skin-minimal">
				@foreach($admin as $v)
				<div class="check-box" style="padding:0px 0px 0px 20px; margin-left: 40px;">
					<input type="checkbox" id="{{$v['username']}}" value="{{$v['id']}}" name="admin_id[]" @if($role_admin->contains($v['id']))) checked="true" @endif>
					<label for="{{$v['username']}}">{{$v['username']}}</label>
				</div>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3" style="text-align: center; margin-left: 0px; width: 100%;">
				{{csrf_field()}}
				<input type="hidden" value="{{$id}}" name="id">
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
				required:true,
				maxlength:20
			},
			status:{
				required:true,
			}
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