<p class="lead pull-left">Категории</p>
<? echo anchor('admin/cats/edit','Добавить категорию',array('class'=>'pull-right btn btn-small btn-primary')); ?>
<div class="clearfix"></div>
<table class="table table-bordered">
	<thead>
		<th>Имя категории</th>
		<th>Изменить</th>
		<th>Удалить</th>
	</thead>
	<tbody>
<? 
if(count($cats)) { 
	foreach($cats as $cat) { 
		echo '<tr>';
		echo '<td>'.anchor('admin/cats/edit/'.$cat->id, $cat->name).'</td>';
		echo '<td>'.btn_edit('admin/cats/edit/'.$cat->id).'</td>';
		echo '<td>'.btn_delete('admin/cats/delete/'.$cat->id).'</td>';
		echo '</tr>';
		if(array_key_exists($cat->id,$subcats)) { 
			foreach($subcats[$cat->id] as $scat) {
				echo '<tr>';
				echo '<td>'.anchor('admin/cats/edit/'.$scat->id, '— '.$scat->name).'</td>';
				echo '<td>'.btn_edit('admin/cats/edit/'.$scat->id).'</td>';
				echo '<td>'.btn_delete('admin/cats/delete/'.$scat->id).'</td>';
				echo '</tr>';
			}
		}
	}
} else {
	?>
	<tr>
		<td colspan="3">Записи отсутствуют</td>
	</tr>
<? } ?>
	</tbody>
</table>