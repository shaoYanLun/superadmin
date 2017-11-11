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
        <div class="note note-danger">
			<p>
			 注:此功能为系统配置，调用方式:gconfig("配置的ckey")\
			</p>
		</div>
        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    系统配置
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">
                            <a class="btn green" href="#edituser" data-toggle="modal">
                            添加自定义配置 <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>变量名称</th>
                        <th>变量key</th>
                        <th>变量value</th>
                        <th>说明</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($config as $value):?>
                    <tr>
                    <td><?php echo $value['cname'];?></td>
                    <td><?php echo $value['ckey'];?></td>
                    <td><?php echo $value['cvalue'];?></td>
                    <td><?php echo $value['mark'];?></td>
                    <td>
                    <a>编辑</a>
                     <?php if ($value['type']!=1):?>
                       <a>|删除</a>
                     <?php endif;?>
                    </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>