<script src="<?=static_url('js/autotemp.js')?>" type="text/javascript"></script>
<h3 class="page-title">
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
    </ul>
</div>
<div class="note note-success">
    <p>
        此功能可以直接根据数据表生成可访问列表，controller,model,view一应生成相应的列表查询，后期会增加复杂sql生成，省去编写页面的时间。同时会增加页面的增删改查。这样的话，你不用开发就可以实现数据库的简单操作和后台列表
    </p>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form" id="createform">
        	<div class="form-body">
        		<div class="form-group">
					<label>查询字段 <span class="small"> 全部使用*,规则同SQL中字段查询</span></label>
					<textarea name="field" class="form-control" rows="3"></textarea>
				</div>
        	</div>
        	<div class="form-group">
				<label>主表 <span class="small"> 暂不支持连表查询</span></label>
				<input type="text" name="tablename" class="form-control" placeholder="暂不支持连表查询">
			</div>
			<div class="form-group">
				<button class="btn btn-danger" id="create">开 始 生 成</button>
			</div>

        </div>
    </div>
    <div class="col-md-6 rescreateinfo">
    </div>
</div>
<div class="modal fade" id="createfile" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title" style="color:#d64635;font-weight: 900;">确认生成目录?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">放弃</button>
                <button type="button" class="btn btn-danger save" data-dismiss="modal">确认</button>
            </div>
        </div>
    </div>
</div>