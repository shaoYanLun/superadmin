//页面提示条
function htmlMsg(obj , msg , errormsg )
{
	if(!msg){
		msg = '错误 请稍后重试';
	}
	if(!errormsg){
		errormsg = '提示';
	}
	obj.html('<div class="alert alert-danger"><strong>'+errormsg+'</strong> '+ msg +' </div>');
}
//弹出提示框
function alertError(errormsg)
{
	if(!errormsg)
	{
		errormsg = '发生错误';
	}
	errormsg = '<span style="color:#d64635;font-weight: 900;">'+errormsg+'</span>';
	var html = '<div class="modal fade" id="error" tabindex="-1" role="basic" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">'+errormsg+'</h4></div><div class="modal-footer"><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button></div></div></div></div>';
	$("body").append(html);
	$("#error").modal("show");
}
//弹出提示框
function alertSuccess(errormsg)
{
	if(!errormsg)
	{
		errormsg = '操作成功';
	}
	errormsg = '<span>'+errormsg+'</span>';
	var html = '<div class="modal fade" id="error" tabindex="-1" role="basic" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button><h4 class="modal-title">'+errormsg+'</h4></div><div class="modal-footer"><button type="button" class="btn btn btn-primary" data-dismiss="modal">确定</button></div></div></div></div>';
	$("body").append(html);
	$("#error").modal("show");
}
var baseurl = "/m/"
$.extend({
	loadajax:function(obj)
	{
        Metronic.blockUI({
            boxed: true
        });
        obj.complete = function()
        {
        	Metronic.unblockUI();
        }
		$.ajax(obj);
	}
})