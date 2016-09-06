<h3><? echo empty($page->id) ? 'Добавить категорию' : 'Редактировать категорию: ' . $page->name; ?></h3>
<? echo validation_errors(); ?>
<? echo form_open(); ?>
<table class="table">
	<tr>
		<td>Имя категории:</td>
		<td><? echo form_input('name', set_value('name', $page->name),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Альт. имя:</td>
		<td><? echo form_input('slug', set_value('slug', $page->slug),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Основная категория:</td>
		<td><? echo form_dropdown('parent', $parents,$page->parent, 'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><? echo form_submit('submit','Сохранить','class="btn btn-primary"'); ?></td>
	</tr>
</table>
<? echo form_close(); ?>