<p class="lead pull-left">Страницы</p>
<? echo anchor('admin/page/edit','Добавить страницу',array('class'=>'pull-right btn btn-small btn-primary')); ?>
<div class="clearfix"></div>
<table class="table table-bordered">
	<thead>
		<th>Заголовок</th>
		<th>Категория</th>
		<th>Изменить</th>
		<th>Удалить</th>
	</thead>
	<tbody>
<? if(count($pages)): foreach($pages as $page): ?>
		<tr>
			<td><? echo anchor('admin/page/edit/'.$page->id, $page->title); ?></td>
			<td><? echo $cats[$page->cat] ?></td>
			<td><? echo btn_edit('admin/page/edit/'.$page->id); ?></td>
			<td><? echo btn_delete('admin/page/delete/'.$page->id); ?></td>
		</tr>
<? endforeach; ?>
<? else: ?>
	<tr>
		<td colspan="4">Записи отсутствуют</td>
	</tr>
<? endif; ?>
	</tbody>
</table>