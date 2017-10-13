window.onload=function(){
    $("#addUserButton").click(function(){
        $e = $("#edituser");
        $e.modal("show");
        $e.find(".save").attr("disabled" , true);
        $.ajax({
            url:baseurl+"User/ajaxManageRight",
            success:function(res)
            {
                if(res.code==1)
                {
                    var data = res.data;
                    $("#edituser .form-body").html(data['addview']);
                    $e.find(".save").attr("disabled" , false);
                    $e.find(".save").click(es)
                }else{
                    htmlMsg($e.find(".errormsg") , res.msg);
                }
            },
            error:function(){
                htmlMsg($e.find(".errormsg"));
            }
        })
        function es(){
            var uname = $e.find("input[name='uname']").val();
            if(!uname)
            {
                $e.find("input[name='uname']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='uname']").parent().parent().removeClass('has-error');
            }
            var nick_name = $e.find("input[name='nick_name']").val();
            if(!nick_name)
            {
                $e.find("input[name='nick_name']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='nick_name']").parent().parent().removeClass('has-error');
            }
            var pwd = $e.find("input[name='pwd']").val();
            if(!pwd)
            {
                $e.find("input[name='pwd']").parent().parent().addClass('has-error');
                return false;
            }else{
                $e.find("input[name='pwd']").parent().parent().removeClass('has-error');
            }
            var user_level = $e.find("select[name='user_level']").val();

            var param = {
                uname:uname,
                nick_name:nick_name,
                pwd:md5(pwd),
                user_level:user_level,
            };
            $.ajax({
                url:baseurl+"user/ajaxAddUser",
                type:'post',
                data:param,
                success:function(res){
                    if(res.code !=1)
                    {
                        htmlMsg($e.find(".errormsg") ,res.msg );
                        return false;
                    }
                    $e.find(".close").click();
                    location.onload();
                },
                error:function()
                {
                    htmlMsg($e.find("errormsg"));
                }
            })
        }
    })
}