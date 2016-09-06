<h3><? echo empty($coupon->id) ? 'Добавить новый выпуск' : 'Редактировать выпуск: ' . $coupon->name; ?></h3>
<? echo validation_errors(); ?>
<? echo form_open(); ?>
<table class="table">
	<tr>
		<td>Название:</td>
		<td><? echo form_input('name', set_value('name', $coupon->name),'class="form-control input-small"'); ?></td>
	</tr>
	<tr>
		<td>Можно использовать:</td>
		<td><? echo form_dropdown('mayused', array('0'=>'однократно','1'=>'многократно'),$coupon->mayused,'class="form-control"'); ?></td>
	</tr>
	<? if(empty($coupon->id)): ?>
	<tr>
		<td>Кол-во для выпуска:</td>
		<td><? echo form_input('count', set_value('count', $coupon->count),'class="form-control"'); ?></td>
	</tr>
	<? endif;?>
	<tr>
		<td>Скидка в %:</td>
		<td><? echo form_input('percent', set_value('percent', $coupon->percent),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td>Время действия с:</td>
		<td><div class="input-group" id="timefrom"><? echo form_input('timefrom', set_value('timefrom', $coupon->timefrom),'class="date form-control"'); ?><span class="input-group-addon"><span class="fa fa-calendar"></span></div></td>
	</tr>
	<tr>
		<td>Время действия до:</td>
		<td><div class="input-group" id="timeto"><? echo form_input('timeto', set_value('timeto', $coupon->timeto),'class="form-control"'); ?><span class="input-group-addon"><span class="fa fa-calendar"></span></div></td>
	</tr>
	<tr>
		<td>Товар:</td>
		<td><? echo form_multiselect('goods[]', $goods,explode(',', $coupon->goods),'class="form-control"'); ?></td>
	</tr>
	<tr>
		<td></td>
		<td><? echo form_submit('submit','Сохранить','class="btn btn-primary"'); ?></td>
	</tr>
</table>
<? echo form_close(); ?>
<script type="text/javascript">
    $(function () {
        $('#timefrom').datetimepicker({
            language: 'ru'
        });
        $('#timeto').datetimepicker({
            language: 'ru'
        });
    });
</script>