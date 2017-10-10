<h3 class="page-title">
<script type="text/javascript" src="<?=static_url('global/js/jquery.qrcode.min.js')?>"></script>
<?php
echo $_current['mname'];
?> 
</h3>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <?php

            echo $_current['mname'];
?> 
            <i class="fa fa-angle-right"></i>
        </li>
<!-- 		<li>
            Data Tables
            <i class="fa fa-angle-right"></i>
        </li> -->
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    登录用户列表
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a class="btn green" href="#edituser" data-toggle="modal">
                            添加用户 <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>登录名</th>
                        <th>昵称</th>
                        <th>权限组</th>
                        <th>级别</th>
                        <th>其他权限</th>
                        <th>谷歌验证码密码</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>最新更新时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (! empty($list)) {
                        $arrDesc = c("table_desc")['user'];
        
                        $arrStatus = $arrDesc['status'];
                        $arrLevel = $arrDesc['user_level'];
                        foreach ($list as $key => $value) {
                            ?>
                                    <tr>
                                        <td><?php
                                        echo $value['username'];
                            ?></td>
                                        <td><?php
                                        echo $value['nick_name'];
                            ?></td>
                                        <td><?php
                                        echo $value['user_group'];
                            ?></td>
                                        <td>
                                        <?php
                                        echo ! empty($arrLevel[$value['user_level']]) ? $arrLevel[$value['user_level']] : "";
                            ?>  
                                        </td>
                                         <td>
																				<?php  $sr = explode(",",$value['user_right']); 
																					 $disRight = '';
																					 foreach($sr as $v){
                                              if (isset($right[$v])) {
                                                 $disRight.=$right[$v].",";
																							}
																					 }
																				  echo substr($disRight,0,-1);
																				?>  
                                        </td>
                                        <td>
                                        <?php
                                        if (!empty($value['gcode'])) {
                                        ?>
                                        <a class="btn btn-default" href="#erwm<?=$value['id']?>" data-toggle="modal"><?=$value['gcode']?></a>
                                         <script type="text/javascript">
                                               $(function(){
                                                  var jj = "<?=$value['id']?>";
                                                  var url = "<?=$value['gcode']?>";
                                                  $("#erwm"+jj+"img").qrcode(url);
                                              })
                                          </script>
                                            <?php
                                        }
                                            ?>
                                        <div id="erwm<?=$value['id']?>" class="modal fade" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog" style="    width: 280px;">
                                          <div class="modal-content" style="    width: 280px;padding: 10px;" id="erwm<?=$value['id']?>img">
                                        </div>
                                       </div>
                                      </div>
                                        </td>
                                        <td>
                                        <?php
                                        echo ! empty($arrStatus[$value['status']]) ? $arrStatus[$value['status']] : "";
                            ?>  
                                        </td>
                                        <td><?php
            
                                        echo $value['ctime'];
                            ?></td>
                                        <td><?php
            
                                        echo $value['mtime'];
                            ?></td>
                                    </tr>
                                    <?php
                        }
                    }
    ?>
                    
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?php

            echo $page_view;
?>
        </div>
    </div>
</div>
<div class="modal fade" id="edituser" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">添加用户</h4>
            </div>
            <div class="alert alert-warning" style="padding: 14px;">
                单独配置的权限优于权限组
            </div>
            <div class="errormsg">
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">目录名</label>
                        <div class="col-md-9">
                            <input type="text" name="mname" class="form-control input-inline input-medium" placeholder="目录展示名 必填">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">访问地址</label>
                        <div class="col-md-9">
                            <input type="text" name="url" class="form-control input-inline input-medium" placeholder="格式 class/function">
                            <span class="help-inline">拥有子目录的分类目录不填写</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">权限别名</label>
                        <div class="col-md-9">
                            <input type="text" name="action" class="form-control input-inline input-medium" placeholder="不建议填写">
                            <span class="help-inline">不建议填写，默认与访问地址相同</span>
                        </div>
                    </div>
                    <div class="form-group menu_icon">
                        <label class="col-md-3 control-label">图标</label>
                        <div class="col-md-9" style="padding-top: 9px;">
                            <input type="text" name="icon" class="form-control input-inline input-medium" placeholder="eg: icon-home" style="display: none;">
                            <a data-toggle="modal" href="#fullicon" class="btn btn-xs btn-success">选择图标</a>
                            <i style="margin-left: 10px;position: relative;top: 2px;" aria-hidden="true" class=""></i>
                            <br/>
                            <span class="help-inline">窄屏时只展示图标 可选图标</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">是否显示</label>
                        <div class="col-md-9">
                            <div class="radio-list">
                                <label class="radio-inline">
                                <div class=""><span class="checked"><input type="radio" name="status" value="1" checked ></span></div> 显示 </label>
                                <label class="radio-inline">
                                <div class=""><span class=""><input type="radio" name="status" value="2"></span></div> 隐藏 </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">放弃</button>
                <button type="button" class="btn blue save">保存</button>
            </div>
        </div>
    </div>
</div>