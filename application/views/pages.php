<style type="text/css">
.pubtext {
	max-height:auto;
}
.pbbg {
	width:100%;
	height:100%;
	position: absolute;
	top: 0;
	left: 0;
	overflow: hidden;
	background: -moz-linear-gradient(top,  rgba(255,255,255,0) 0%, rgba(255,255,255,0.01) 1%, rgba(255,255,255,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0)), color-stop(1%,rgba(255,255,255,0.01)), color-stop(100%,rgba(255,255,255,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(255,255,255,0) 0%,rgba(255,255,255,0.01) 1%,rgba(255,255,255,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
.pubbody {
	position: relative;
}
</style>

<? if($pubs): foreach($pubs as $pub): ?>
<div class="panel">

  <div class="panel-heading">
    <h3 class="panel-title"><a href="/page/<? echo $pub->id; ?>" title=""><? echo $pub->title; ?></a><div class="pubcat pull-right">Категория: <? if($pub->cat != 0): ?><a href="<? echo '/page/'.$pub->catslug; ?>"><? echo $pub->catname; ?></a><? else: ?> —<? endif; ?></div>
	</h3>
  </div>
    <div class="panel-body">
			<div class="pubbody">
			<div class="pubtext"><? echo $pub->body; ?></div>
			<div class="pbbg"></div>
		</div>


	<span class="clearfix"></span>
	<div style="margin-bottom:10px;" class="pull-right"><a href="/page/<? echo $pub->id; ?>" class="btn btn-primary">Подробнее</a></div>
<span class="clearfix border"></span>
	</div>
	
</div>
<? endforeach; ?>
<? endif; ?>

<div class="text-center col-lg-12">
<? echo $pagination; ?>
</div>