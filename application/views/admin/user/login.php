<div class="modal-header">
	<h3 class="modal-title">Логин</h3>
	<p>Войдите используя свои данные</p>
</div>
<div class="modal-body">
<? echo validation_errors(); ?>
<? echo form_open(); ?>
<table class="table">
	<tr>
		<td>E-mail:</td>
		<td><? echo form_input('email'); ?></td>
	</tr>
	<tr>
		<td>Пароль:</td>
		<td><? echo form_password('password'); ?></td>
	</tr>
	<tr>
		<td>Введите код:</td>
		<td><? echo $cap['image']; ?></td>
	</tr>
	<tr>
		<td></td>
		<td><? echo form_input('captcha'); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><? echo form_submit('submit','Войти','class="btn btn-primary"'); ?></td>
	</tr>
</table>
<? echo form_close(); ?>
</div>