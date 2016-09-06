<? $this->load->view('components/page_head.php'); ?>
  <div class="navbar navbar-static-top">
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
					
				
					<li><? echo anchor('/page/3','<b>О</b>тзывы'); ?></li>
					<li><? echo anchor('/page/2','<b>П</b>равила'); ?></li>
                	<li><? echo anchor('/page/4','<b>FAQ</b>'); ?></li>
					<li><? echo anchor('/page/1','<b>К</b>онтакты'); ?></li>
			 
			
			</ul>
			
			</nav>
		
		  </div>
		
	</div>
  <body>
    <div class="container">
	   <? if(config_item('sitedescription') != NULL): ?>
		<div class="jumbotron">
		  <p><? echo config_item('sitedescription'); ?></p>
		</div>
		  <? endif; ?>
		<div class="row maincont">
			<div class="col-lg-8">
			
  <? if(count($breadcumbs) > 1):?>
<ol class="breadcrumb">
  <?foreach($breadcumbs as $key=>$br): ?>
    <li><a href="<? echo $br[1]; ?>"><? echo $br[0]; ?></a></li>
    <? endforeach; ?>
</ol> 
 <? endif; ?>

			<? $this->load->view($subview); ?>
			</div>
			<div class="col-lg-4">
					<div class="container">
    <div class="row">
        
        <div class="col-md-12">
         <? if($catslist): ?>
         <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Категории</h3>
    </div>
    <ul class="rmenu nav nav-pills nav-stacked">
    <? foreach($catslist as $cat) : ?>
     <li <? if($cat['sub'] == 1) echo 'class="subcat"'; ?>><a href="/page/<? echo $cat['slug']; ?>/1"> <? echo $cat['name']; ?></a></li>
    <? endforeach; ?>
    </ul>
   </div>
   <? endif; ?>
         <? if($pages) : ?> <h4 class="hnomarg"> <i class="fa fa-bookmark"></i> Закреплённые публикации</h2> <? foreach($pages as $page): ?>
         
            <div class="blockquote-box clearfix">
                <h5> <a href="/page/<? echo $page['id']; ?>"><? echo $page['title']; ?></a></h5>
            </div>
         <? endforeach; ?>
         <? endif; ?>
        </div>
    </div>
</div>

			</div>
		</div>
		<div class="row foot">
			<div class="col-lg-12">
			
			<span class="footcopy"><p><i class="fa fa-copyright"></i> <? echo $this->config->item('site_name'); ?></p></span>
			</div>
		</div>
	</div>		
	<div id="loading"><i style="position:absolute; top:50%; left:50%" class="fa fa-spinner fa-pulse fa-4x"></i></div> 
	
<? $this->load->view('components/page_foot.php'); ?>