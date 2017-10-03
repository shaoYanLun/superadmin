$(function(){	
	//添加删除一级目录
	$(".first_menu").click(function(){
		var $e = $("#firstmenu");
		var $this = $(this);
		//清空信息
		$e.find("input").each(function(){
			if( $this.attr("type") != "radio" )
			{
				$this.val("");
			}
		})
		$e.find(".menu_icon i").attr("class" ,"");
		$e.find(".errormsg").empty();
		$e.find("input[name='status']").eq(0).attr('checked',true);
		var aname = $this.parent().attr("aname");
		var aid = $this.parent().attr("aid");
		if(!aid)
		{
			//判定为添加目录
			var html = "添加一级目录";
			$e.find("h4").html(html);
			$e.modal("show");
			$e.find(".save").click(es)
			return false;
		}
		var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>加载中...</span> ";
		$e.find("h4").html(html);
		$e.find("input[name='id']").val(aid);
		$e.modal("show");
		$e.find(".save").attr("disabled" , true);
		$.ajax({
			url:"/Manage/getMenu?id="+aid,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($e.find(".errormsg") ,res.msg );
					return false;
				}
				var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>"+aname+"</span> ";
				$e.find("h4").html(html);
				var data = res.data;
				for (var i in data) {
					if(i != 'status')
					{
						$e.find("input[name='"+i+"']").val(data[i]);
					}else{
						$e.find("input[name='"+i+"']").each(function(){
							$(this).val() == data['status']?$(this).attr('checked',true):$(this).attr('checked',false);
						})
					}
				}
				$e.find(".menu_icon i").attr("class" ,data['icon']);
				$e.find(".save").attr("disabled" , false);
				$e.find(".save").click(es)
			},
			error:function()
			{
				htmlMsg($e.find(".errormsg"));
				$e.find(".save").attr("disabled" , false);
			}
		})
		//保存修改的目录
		function es(){
			var mname = $e.find("input[name='mname']").val();
			if(!mname)
			{
				$e.find("input[name='mname']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='mname']").parent().parent().removeClass('has-error');
			}
			var icon = $e.find("input[name='icon']").val();
			if(!icon)
			{
				$e.find("input[name='icon']").parent().parent().addClass('has-error');
				return false;
			}else{
				$e.find("input[name='icon']").parent().parent().removeClass('has-error');
			}
			var id = $e.find("input[name='id']").val();
			var url = $e.find("input[name='url']").val();
			var action = $e.find("input[name='action']").val();
			var radio = 1;
			$e.find("input[name='status']").each(function(){
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
				id:id
			};
			var url = "/Manage/editFirstMenu";
			if(!id)
			{
				url = "/Manage/addFirstMenu";
			}
			$.ajax({
				url:url,
				data:param,
				success:function(res){
					if(res.code !=1)
					{
						htmlMsg($e.find(".errormsg") ,res.msg );
						return false;
					}
					$e.find(".close").click();
					if(id)
					{
						$this.parent().find("i").eq(0).attr("class" ,icon );
						$this.parent().find("span").text(mname);
					}else{
						var data = res.data;
						var firstmenuinfohtml = '<li><a data-toggle="tab" aname="'+mname+'" aid="'+data['id']+'" href="#tab_'+data['id']+'" aria-expanded="true"><i style="top:0px" class="'+icon+'"></i> <span>'+mname+'</span><i style="top:0px" class="icon-plus pull-right add_second_menu popovers" data-content="没有子目录自动作为访问目录，拥有子目录自动作为分类目录" data-original-title="添加子目录" data-container="body" data-trigger="hover"></i><i style="top:0px" class="icon-trash pull-right delete_first_menu popovers" data-content="拥有子目录时，无法删除。自动删除已配置权限" data-original-title="删除当前目录" data-container="body" data-trigger="hover"></i><i style="top:0px" class="icon-note pull-right first_menu" title="修改当前目录"></i></a><span class=""></span></li>';
						$(".firstmenulist").append(firstmenuinfohtml);
					}
				},
				error:function()
				{
					htmlMsg($e.find("errormsg"));
				}
			})
		}
	})
	//弹出二级目录弹窗
	var $s = $("#firstmenu");
	$(".secondmenu").click(function(){
		$s.find("input").each(function(){
			if( $(this).attr("type") != "radio" )
			{
				$(this).val("");
			}
		})
		$s.find(".menu_icon i").attr("class" ,"");
		$s.find(".errormsg").empty();
		$s.find("input[name='status']").eq(0).attr('checked',true);
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if(!aid)
		{
			var html = "为<span style='color:#d64635;font-weight: 900;'>"+aname+"</span>添加子目录";
			$e.find("h4").html(html);
			$e.prev("a").click();
			return false;
		}
		$("#addsecondmenu input[name='mname']").val();
		$("#addsecondmenu input[name='icon']").val();
		$("#addsecondmenu input[name='url']").val();
		$("#addsecondmenu input[name='action']").val();
		var html = "<span style='color:#d64635;font-weight: 900;'>加载中...</span> ";
		$("#addsecondmenu h4").html(html);
		$("#addsecondmenu input[name='id']").val(aid);
		$("#addsecondmenubutton").click();
		$.ajax({
			url:"/Manage/getMenu?id="+aid,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($("#addsecondmenuerrormsg") ,res.msg );
					return false;
				}
				var data = res.data;

				$("#addsecondmenuerrormsg").empty();
				var html = "为 <span style='color:#d64635;font-weight: 900;'>"+data['mname']+" </span> 添加子目录";
				$("#addsecondmenu h4").html(html);
			},
			error:function()
			{
				htmlMsg($("#addsecondmenuerrormsg"));
			}
		})
	})
	//添加保存二级目录
	$("#addsecondmenu .save").click(function(){
		var mname = $("#addsecondmenu input[name='mname']").val();
		if(!mname)
		{
			$("#addsecondmenu input[name='mname']").parent().parent().addClass('has-error');
			return false;
		}else{
			$("#addsecondmenu input[name='mname']").parent().parent().removeClass('has-error');
		}
		
		var icon = $("#addsecondmenu input[name='icon']").val();
		if(!icon)
		{
			$("#addsecondmenu input[name='icon']").parent().parent().addClass('has-error');
			return false;
		}else{
			$("#addsecondmenu input[name='icon']").parent().parent().removeClass('has-error');
		}
		var url = $("#addsecondmenu input[name='url']").val();
		if(!url)
		{
			$("#addsecondmenu input[name='url']").parent().parent().addClass('has-error');
			return false;
		}else{
			$("#addsecondmenu input[name='url']").parent().parent().removeClass('has-error');
		}

		var url = $("#addsecondmenu input[name='url']").val();
		var id = $("#addsecondmenu input[name='id']").val();
		var action = $("#addsecondmenu input[name='action']").val();
		var radio = 1;
		$("#addsecondmenu input[name='status']").each(function(){
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
			parent:id,
		};
		$.ajax({
			url:"/Manage/addsecondmenu",
			data:param,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($("#addsecondmenuerrormsg") ,res.msg );
					return false;
				}
				$("#addsecondmenuerrormsg").empty();
				$("#addsecondmenu .close").click();
				location.reload();
			},
			error:function()
			{
				htmlMsg($("#addsecondmenuerrormsg"));
			}
		})
	})
	//弹出添加权限编辑框
	$(".add_action_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if(!aname || !aid)
		{
			alertError("缺少参数");
			return false;
		}
		var $e = $("#addactionmenu");
		$e.find("input[name='mname']").val();
		$e.find("input[name='action']").val();
		var html = "<span style='color:#d64635;font-weight: 900;'>添加权限</span> ";
		$e.find("h4").html(html);
		$e.find("input[name='id']").val(aid);
		$("#addactionmenubutton").click();
	})
	//添加权限
	$("#addactionmenu .save").click(function(){

		var $e = $("#addactionmenu");

		var action = $e.find("input[name='action']").val();
		var mname = $e.find("input[name='mname']").val();
		if(!action)
		{
			$e.find("input[name='action']").parent().parent().addClass('has-error');
			return false;
		}else{
			$e.find("input[name='action']").parent().parent().removeClass('has-error');
		}
		var id = $e.find("input[name='id']").val();
		
		var param = {
			mname:mname,
			action:action,
			parent:id,
		};
		$.ajax({
			url:"/Manage/addactionmenu",
			data:param,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($e.find(".errormsg") ,res.msg );
					return false;
				}
				$e.find(".errormsg").empty();
				$e.find(".close").click();
				location.reload();
			},
			error:function()
			{
				htmlMsg($e.find("errormsg"));
			}
		})
	})
	//弹出编辑二级目录编辑框
	$(".edit_second_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if(!aname || !aid)
		{
			alertError("缺少参数");
			return false;
		}
		var $e = $("#editsecondmenu");
		$e.find("input[name='mname']").val();
		$e.find("input[name='icon']").val();
		$e.find("input[name='url']").val();
		$e.find("input[name='action']").val();
		var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>加载中...</span> ";
		$e.find("h4").html(html);
		$e.find("input[name='id']").val(aid);
		$("#editsecondmenubutton").click();

		$.ajax({
			url:"/Manage/getMenu?id="+aid,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($e.find(".errormsg") ,res.msg );
					return false;
				}
				$e.find(".errormsg").empty();
				var html = "修改目录 <span style='color:#d64635;font-weight: 900;'>"+aname+"</span> ";
				$e.find("h4").html(html);
				var data = res.data;

				$e.find("input[name='mname']").val(data['mname']);
				$e.find("input[name='icon']").val(data['icon']);
				$e.find("input[name='url']").val(data['url']);
				$e.find("input[name='action']").val(data['action']);
				$("#edit_second_icon_choose").attr("class" ,data['icon']);

				$e.find("input[name='status']").each(function(){
					$(this).val() == data['status']?$(this).attr('checked',true):$(this).attr('checked',false);
				})
			},
			error:function()
			{
				htmlMsg($e.find(".errormsg"));
			}
		})
	})
	$("#editsecondmenu .save").click(function(){
		var $e = $("#editsecondmenu");
		var mname =$e.find("input[name='mname']").val();
		if(!mname)
		{
			$e.find("input[name='mname']").parent().parent().addClass('has-error');
			return false;
		}else{
			$e.find("input[name='mname']").parent().parent().removeClass('has-error');
		}
		var icon = $e.find("input[name='icon']").val();
		if(!icon)
		{
			$e.find("input[name='icon']").parent().parent().addClass('has-error');
			return false;
		}else{
			$e.find("input[name='icon']").parent().parent().removeClass('has-error');
		}
		var url = $e.find("input[name='url']").val();
		if(!url)
		{
			$e.find("input[name='url']").parent().parent().addClass('has-error');
			return false;
		}else{
			$e.find("input[name='url']").parent().parent().removeClass('has-error');
		}

		var id = $e.find("input[name='id']").val();
		var action = $e.find("input[name='action']").val();
		var radio = 1;
		$e.find("input[name='status']").each(function(){
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
			id:id
		};
		$.ajax({
			url:"/Manage/editSecondMenu",
			data:param,
			success:function(res){
				if(res.code !=1)
				{
					htmlMsg($e.find(".errormsg") ,res.msg );
					return false;
				}
				$e.find(".errormsg").empty();
				$e.find(".close").click();
				location.reload();
			},
			error:function()
			{
				htmlMsg($e.find(".errormsg"));
			}
		})
	})
	//弹出删除目录提示框
	$(".delete_first_menu").click(function(){
		var aname = $(this).parent().attr("aname");
		var aid = $(this).parent().attr("aid");
		if( !aid)
		{
			alertError("缺少参数");
			return false;
		}
		var html = "确认删除 <span style='color:#d64635;font-weight: 900;'>"+aname+" </span> ?";
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
		if( $("#firstmenu").css("display") == 'block' )
		{
			$("#firstmenu input[name='icon']").val(icon);
			$("#firstmenu").find(".menu_icon i").attr("class",icon);
		}else if($("#addsecondmenu").css("display") == 'block')
		{
			$("#add_icon_choose").attr("class",icon);
			$("#addsecondmenu input[name='icon']").val(icon);
		}else if($("#editsecondmenu").css("display") == 'block')
		{
			$("#edit_second_icon_choose").attr("class",icon);
			$("#editsecondmenu input[name='icon']").val(icon);
		}
		$("#fullicon .close").click();
	})
})