$(function(){

	//添加一级目录
	$("#addfirstmenu .save").click(function(){
		var mname = $("#addfirstmenu input[name='mname']").val();
		if(!mname)
		{
			$("#addfirstmenu input[name='mname']").parent().parent().addClass('has-error');
			return false;
		}else{
			$("#addfirstmenu input[name='mname']").parent().parent().removeClass('has-error');
		}
		
		var icon = $("#addfirstmenu input[name='icon']").val();
		if(!icon)
		{
			$("#addfirstmenu input[name='icon']").parent().parent().addClass('has-error');
			return false;
		}else{
			$("#addfirstmenu input[name='icon']").parent().parent().removeClass('has-error');
		}

		var url = $("#addfirstmenu input[name='url']").val();
		var action = $("#addfirstmenu input[name='action']").val();
		var radio = 1;
		$("#addfirstmenu input[name='status']").each(function(){
			if ($(this).attr("checked") )
			{
				radio = $(this).val();
			}
		});
		var param = {
			mname:mname,
			url:url,
			icon:icon,
			action:action,
			radio:radio,
		};
		$.ajax({
			url:"/Manage/addFirstMenu",
			data:param,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($("#addfirstmenuerrormsg") ,res.msg );
					return false;
				}
				$("#addfirstmenuerrormsg").empty();
				$("#addfirstmenu .close").click();
				location.reload();
			},
			error:function()
			{
				htmlMsg($("#addfirstmenuerrormsg"));
			}
		})
	})
	//弹出编辑目录提示框
	$(".edit_first_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if(!aname || !aid)
		{
			alertError("缺少参数");
		}
		var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>"+aname+"</span> ?";
		$("#editfirstmenu h4").html(html);
		$("#editfirstmenu input[name='id']").val(aid);
		$("#editfirstmenubutton").click();
	})


	//弹出删除目录提示框
	$(".delete_first_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if(!aname || !aid)
		{
			alertError("缺少参数");
		}
		var html = "确认删除目录 <span style='color:#d64635;font-weight: 900;'>"+aname+"</span> ?";
		$("#deletemenu h4").html(html);
		$("#deletemenu input[name='id']").val(aid);
		$("#deletemenubutton").click();
	})
	//删除目录
	$("#deletemenu .deletesure").click(function(){
		var id = $("#deletemenu input[name='id']").val();
		if(!id)
		{
			alertError("缺少参数");
			return false;
		}
		$("#deletemenu .close").click();
		$.ajax({
			url:"/Manage/deleteMenu?id="+id,
			success:function(res)
			{
				if(res.code!=1)
				{
					alertError(res.msg);
					return false;
				}
				location.reload();
			},
			error:function()
			{
				alertError('删除失败');
			}
		})
	})
	//点击复制
	$("#fullicon .item").css("cursor","pointer");
	$("#fullicon .item").click(function(){
		var icon = $(this).find("span").attr("class");
		$("#menu_icon_choose").addClass(icon);
		$("#addfirstmenu input[name='icon']").val(icon);
		$("#fullicon .close").click();
	})
})