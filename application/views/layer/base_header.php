<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Metronic | Data Tables - Basic Datatables</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="<?=static_url('global/plugins/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/plugins/simple-line-icons/simple-line-icons.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/plugins/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('global/css/components.min.css')?>" id="style_components" rel="stylesheet" type="text/css"/>
<link href="<?=static_url('pages/css/layout.css')?>" rel="stylesheet" type="text/css"/>
<script src="<?=static_url('global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<link id="style_color" href="<?=static_url('pages/css/themes/default.css')?>" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content ">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="/">
			<img src="<?=static_url('pages/img/logo.png')?>" alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler hide">
			</div>
		</div>
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<div class="top-menu">
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown dropdown-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<img alt="" class="img-circle" src="<?=static_url('pages/img/avatar3_small.jpg')?>"/>
					<span class="username username-hide-on-mobile">
					Nick </span>
					<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="extra_profile.html">
							<i class="icon-user"></i> My Profile </a>
						</li>
						<li>
							<a href="page_calendar.html">
							<i class="icon-calendar"></i> My Calendar </a>
						</li>
						<li>
							<a href="inbox.html">
							<i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
							3 </span>
							</a>
						</li>
						<li>
							<a href="page_todo.html">
							<i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
							7 </span>
							</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="extra_lock.html">
							<i class="icon-lock"></i> Lock Screen </a>
						</li>
						<li>
							<a href="login.html">
							<i class="icon-key"></i> Log Out </a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="clearfix">
</div>
<div class="page-container">
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li class="sidebar-toggler-wrapper">
					<div class="sidebar-toggler">
					</div>
				</li>
				<li class="sidebar-search-wrapper">
					<form class="sidebar-search " action="extra_search.html" method="POST">
						<a href="javascript:;" class="remove">
						<i class="icon-close"></i>
						</a>
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
						</div>
					</form>
				</li>
				<?php
    if (! empty($_menulist)) {
        $start = 0;
        
        foreach ($_menulist as $menu) {
            if (empty($menu['_list'])) {
                $active = $menu['url'] == $_atfunc ? "active" : "";
                ?>
				<li class="<?php
                
echo $active;
                ?>">
					<a href="<?php
                
echo $menu['url'];
                ?>">
					<i class="<?php
                
echo $menu['icon'];
                ?>"></i>
					<span class="title">
					<?php
                
echo $menu['mname'];
                ?> </span>
					</a>
				</li>
				<?php
            } else {
                foreach ($menu['_list'] as $v) {
                    $v['url'] == $_atfunc && empty($active) ? $active = " active open " : "";
                }
                ?>
				<li class="<?php
                
echo $start == 0 ? "start" : "";
                ?> <?php
                
echo empty($active)?"":$active;
                ?>">
					<a href="javascript:;">
					<i class="<?php
                
echo $menu['icon'];
                ?>"></i>
					<span class="title"><?php
                
echo $menu['mname'];
                ?></span>
					<span class="arrow "></span>
					</a>
					<ul class="sub-menu">
						<?php
                foreach ($menu['_list'] as $v) {
                    $active = $v['url'] == $_atfunc ? "active" : "";
                    ?>
						<li class="<?php
                    
echo $active;
                    ?>">
							<a href="<?php
                    
echo $v['url'];
                    ?>">
							<i class="<?php
                    
echo $v['icon'];
                    ?>"></i>
							<?php
                    
echo $v['mname'];
                    ?></a>
						</li>
						<?php
                }
                ?>
					</ul>
				</li>
				<?php
            }
            $start ++;
        }
    }
    ?>
			</ul>
		</div>
	</div>
	<div class="page-content-wrapper">
		<div class="page-content">