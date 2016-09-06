<h3>Настройки скрипта</h3>
<? if(isset($error)) {
		echo $error;
	}
	elseif(isset($ok)) {
		echo '<div class="alert alert-success">Данные успешно сохранены!</div>';
	}
	?>
<? echo validation_errors(); ?>
<? echo form_open_multipart(); ?>
<table class="table">
	<tr>
		<td>Название сайта:</td>
		<td><? echo form_input('site_name', set_value('site_name', $this->config->item('site_name')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Блок информации:</td>
		<td><? echo form_input('sitedescription', set_value('sitedescription', $this->config->item('sitedescription')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Мета-описание сайта:</td>
		<td><? echo form_textarea('metadescr', set_value('metadescr', $this->config->item('metadescr')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Яндекс (Client ID):</td>
		<td><? echo form_input('yad_client_id', set_value('yad_client_id', $this->config->item('yad_client_id')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Яндекс (Token):</td>
		<td><? echo form_input('yad_token', set_value('yad_token', $this->config->item('yad_token')),'class="form-control"'); ?></td>
	</tr>	
	<tr>
		<td>QIWI (Номер без +):</td>
		<td><? echo form_input('qiwi_num', set_value('qiwi_num', $this->config->item('qiwi_num')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>QIWI (Пароль):</td>
		<td><? echo form_password('qiwi_pass', set_value('wm_pass', '******'),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>WMID:</td>
		<td><? echo form_input('wmid', set_value('wmid', $this->config->item('wmid')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>WMR:</td>
		<td><? echo form_input('WMR', set_value('WMR', $this->config->item('WMR')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>WMZ:</td>
		<td><? echo form_input('WMZ', set_value('WMZ', $this->config->item('WMZ')),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Пароль от ключ-файла:</td>
		<td><? echo form_password('wm_pass', set_value('wm_pass', '******'),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Ключ-файл:</br>
		<span class="label label-success"><? echo $this->config->item('wm_key_date') ;?></span> 
		</td>
		<td><input type="file" name="userfile" size="20" class="form-control"/></td>
	</tr>
	<tr>
		<td></td>
		<td><? echo form_submit('submit','Сохранить','value="upload" class="btn btn-primary"'); ?></td>
	</tr>
</table>
<? echo form_close(); ?>
