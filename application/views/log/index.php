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
                    日志
                </div>
            </div>
            <div class="portlet-body">
                <div class="row table-toolbar">
                    <div class="col-md-6">
                        <div class="btn-group">

                            </a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                     <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>用戶名</th>
                        <th>请求url</th>
                        <th>请求标题</th>
                        <th>说明</th>
                        <th>ip</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list as $value):?>
                    <tr>
                    <td><?php echo $value['username'];?></td>
                    <td><?php echo $value['uri'];?></td>
                    <td><?php echo $value['mark'];?></td>
                    <td><?php echo $value['mark_ext'];?></td>
                    <td><?php echo $value['ip'];?></td>
                    <td><?php echo $value['ctime'];?></td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>