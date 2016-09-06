<h3><? echo empty($page->id) ? 'Добавить страницу' : 'Редактировать страницу: ' . $page->title; ?></h3>
<? echo validation_errors(); ?>
<? echo form_open(); ?>
<table class="table">
	<tr>
		<td>Заголовок:</td>
		<td><? echo form_input('title', set_value('title', $page->title),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Альт. заголовок:</td>
		<td><? echo form_input('slug', set_value('slug', $page->slug),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Текст:</td>
		<td><? echo form_textarea('body', set_value('body', $page->body), 'class="tinymce"'); ?></td>
	</tr>
	<tr>
		<td>Категория:</td>
		<td><? echo form_dropdown('cat', $cats,$page->cat, 'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Закрепить:</td>
		<td><? echo form_checkbox('show', '1', $page->show); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><? echo form_submit('submit','Сохранить','class="btn btn-primary"'); ?></td>
	</tr>
</table>
<? echo form_close(); ?>