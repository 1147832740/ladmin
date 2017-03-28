/**
 * 公共函数列表
 */

//页面跳转
function settime_reload_by_notice(timeout=0,info='') {
	if(info!='' && false){
		window.top.toastr.success(info);
	}
	timeout=0;
	setTimeout(function(){
		window.top.location.reload();
	},timeout);
}

//获取批量删除 单选框id值
function get_count_checkbox_id() {
	var ids=[];
	$("table.table>tbody>.text-c>td:first-child>input[type='checkbox']:checked").each(function(){
		ids.push(parseInt($(this).val()));
	});
	return ids;
}