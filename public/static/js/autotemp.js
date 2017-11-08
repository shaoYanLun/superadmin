$(function(){
	// $("#addltable").click(function(){
	// 	var prevhtml = $(this).parent().prev().clone(true);
	// 	$(this).parent().before(prevhtml);
	// })

	$("#create").click(function(){

		$("#createfile").modal("show");
		$("#createfile .save").off();
		$("#createfile .save").click(function(){
			$("#createfile").modal("hide");
			var field = $("#createform textarea[name='field']").val();
			var tablename = $("#createform input[name='tablename']").val();
			if(!field || !tablename)
			{
				alertError("参数不能为空");
				return false;
			}
			var param = {
				tablename:tablename,
				field:field,
			}
			$.loadajax({
				url:baseurl+"Createtemp/creater",
				data:param,
				success:function(res){
					if(res.code!=1)
					{
						alertError(res.msg);
						return false;
					}
					var html = '<div class="note note-success">';
					html+='<h4>创建文件和目录</h4>';					
					var data = res.data;
					if(data['dir'])
					{
						for(var i in data['dir'])
						{
							html+="<p>"+data['dir'][i]+"</p>";
						}
					}
					if(data['file'])
					{
						for(var i in data['file'])
						{
							html+="<p>"+data['file'][i]+"</p>";
						}
					}
					html+='<h4>SQL</h4>';					
					if(data['sql'])
					{
						html+="<p>"+data['sql']+"</p>";
					}
					html+='<h4>访问</h4>';					
					html+='<a href="/'+tablename+'" target="_blank">/'+tablename+'</a>';					

					html+="</div>";
					$(".rescreateinfo").html(html);
				},
				error:function(){
					alertError(res.msg);
				}

			})
		})
	})
})