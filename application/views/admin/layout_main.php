<? $this->load->view('admin/components/adm_head')?>
  <body>
    <div class="navbar navbar-static-top navbar-inverse">
		<div class="container">
			<div class="navbar-header">
			  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
				<span class="sr-only">Развернуть/Свернуть</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			 <a class="navbar-brand" href="<? echo site_url('/'); ?>"><? echo config_item('site_name'); ?></a>
			</div>
			<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
				<ul class="nav navbar-nav">
					<li><? echo anchor('admin/goods','Товары'); ?></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Публикации<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><? echo anchor('admin/page','Страницы'); ?></li>
							<li><? echo anchor('admin/cats','Категории'); ?></li>
						</ul>
			        </li>
					<li><? echo anchor('admin/orders','Заказы'); ?></li>
					<li><? echo anchor('admin/coupons','Промо-коды'); ?></li>
					<li><? echo anchor('admin/config','Настройки'); ?></li>
				</ul>
				<ul class="nav navbar-nav pull-right">
					<li><? echo anchor('admin/user/logout','<i class="fa fa-power-off"></i> Выйти'); ?></li>
				</ul>
			</nav>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="<? echo $subview == 'admin/orders' ? 'col-lg-12' : 'col-lg-8';?>">
			<? empty($subview) ? "" : $this->load->view($subview)  ?>
			</div>
			<? if($subview != 'admin/orders'): ?>
			<div class="col-lg-4">
			<? echo empty($rblock) ? "" : $rblock ?>
			</div>
			<? endif; ?>
		</div>
	</div>
<? $this->load->view('admin/components/adm_foot'); ?>