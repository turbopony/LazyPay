<p class="lead pull-left">Товары</p>
<? echo anchor('admin/goods/edit','Добавить товар',array('class'=>'pull-right btn btn-small btn-primary')); ?>
<div class="clearfix"></div>
<table style="width:100%;" class="table tblsort table-hover table-bordered">
	<thead>
		<th>ID</th>
		<th>Название</th>
		<th style="min-width:70px;">Кол-во</th>
		<th>Цена</th>
		<th>Изменить</th>
		<th>Удалить</th>
	</thead>
	<tbody>
<? if(count($goods)): foreach($goods as $good): ?>
		<tr id="item-<? echo $good->id; ?>">
			<td><? echo $good->id; ?></td>
			<td><? echo $good->name; ?></td>
			<td><? echo $good->count; ?></td>
			<td><? echo $good->price_rub.' <span class="rur">p<span>уб.</span></span> | '.$good->price_dlr.' $'.' за 1шт.'; ?></td>
			<td><? echo btn_edit('admin/goods/edit/'.$good->id); ?></td>
			<td><? echo btn_delete('admin/goods/delete/'.$good->id); ?></td>
		</tr>
<? endforeach; ?>
<? else: ?>
	<tr>
		<td colspan="6">Товары отсутствуют</td>
	</tr>
<? endif; ?>
	</tbody>
</table>