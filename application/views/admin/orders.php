

<p class="lead pull-left" style='margin-top:20px;'>Заказы</p>
<div class="pull-right">
	<? echo $pages; ?>
</div>
<table class="table table-hover table-bordered">
	<thead>
		<th>ID</th>
		<th>Примечание</th>
		<th>Дата</th>
		<th>Товар</th>
		<th style="min-width:70px;">Кол-во</th>
		<th>Цена</th>
		<th>E-mail</th>
		<th>IP</th>
		<th>Оплачен</th>
		<th>Скачать</th>
	</thead>
	<tbody>
<? if(count($orders)): foreach($orders as $order): ?>
		<tr>
			<td><? echo $order->id; ?></td>
			<td><? echo $order->bill; ?></td>
			<td style="font-size:11px;"><? echo date('d-m-Y H:i:s',$order->date); ?></td>
			<td style="font-size:11px;"><? echo $order->name; ?></td>
			<td><? echo $order->count; ?></td>
			<td><? echo $order->price.' '.$order->fund; ?></td>
			<td><? echo $order->email; ?></td>
			<td><? echo $order->ip_address; ?></td>
			<td><? echo $order->paid ? 'Да' : 'Нет' ?></td>
			<td><a title="Скачать купленный товар" href="/admin/orders/getorder/<? echo $order->bill2 ;?>" class="fa fa-cloud-download"></span></td>
		</tr>
<? endforeach; ?>
<? else: ?>
	<tr>
		<td colspan="10">Заказы отсутствуют</td>
	</tr>
<? endif; ?>
	</tbody>
</table>

