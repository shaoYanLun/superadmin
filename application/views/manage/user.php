<h3 class="page-title">
<?php echo $_current['mname'];?> 
</h3>
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<?php echo $_current['mname'];?> 
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
		<div class="portlet box blue-hoki">
			<div class="portlet-title">
				<div class="caption">
					登录用户列表
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
					<thead>
					<tr>
						<th>登录名</th>
						<th>昵称</th>
						<th>管理组</th>
						<th>级别</th>
						<th>状态</th>
						<th>创建时间</th>
						<th>最新更新时间</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(!empty($list))
					{
						$arrDesc = c("table_desc")['user'];

						$arrStatus = $arrDesc['status'];
						$arrLevel = $arrDesc['user_level'];
						foreach ($list as $key => $value) {
					?>
					<tr>
						<td><?php echo $value['username'];?></td>
						<td><?php echo $value['nick_name'];?></td>
						<td><?php echo $value['user_group'];?></td>
						<td>
						<?php 
						echo !empty($arrLevel[$value['user_level']])?$arrLevel[$value['user_level']]:"";
						?>	
						</td>
						<td>
						<?php 
						echo !empty($arrStatus[$value['status']])?$arrStatus[$value['status']]:"";
						?>	
						</td>
						<td><?php echo $value['ctime'];?></td>
						<td><?php echo $value['mtime'];?></td>
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
			<?php echo $page_view;?>
		</div>
	</div>
</div>