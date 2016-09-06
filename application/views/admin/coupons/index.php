<p class="lead pull-left">Промо-коды</p>
<? echo anchor('admin/coupons/edit','Создать выпуск',array('class'=>'pull-right btn btn-small btn-primary')); ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Имя выпуска</th>
			<th>Время действия</th>
			<th>Кол-во</th>
			<th>-</th>
			<th>Продаж</th>
			<th>Товаров</th>
			<th>Изменить</th>
		<th>Удалить</th>
		</tr>
	</thead>
	<tbody>
<? if(count($coupons)): foreach($coupons as $coupon):
 
				$timefrom = date('d.m.y',$coupon->timefrom);
				$timeto = date('d.m.y',$coupon->timeto);
				$time = 'c '.$timefrom.' до '.$timeto;
				$count = count(explode('|', $coupon->coupon));
				$goods = count(explode(',', $coupon->goods));
				if($coupon->mayused == 1) {
					$mayused = 'многократно';
				} elseif($coupon->mayused == 0) {
					$mayused = 'однократно';
				}
				?>
				
				<tr>
				<td><a href="/admin/coupons/show/<? echo $coupon->id; ?>"><? echo $coupon->name; ?></a></td>
				<td><? echo $time; ?></td>
				<td><? echo $count; ?></td>
				<td><? echo $mayused; ?></td>
				<td><? echo $coupon->used; ?></td>
				<td><? echo $goods; ?></td>	
				<td><? echo btn_edit('admin/coupons/edit/'.$coupon->id); ?></td>
				<td><? echo btn_delete('admin/coupons/delete/'.$coupon->id); ?></td>
				</tr>
			
		
		<? endforeach; ?>
<? else: ?>
	<tr>
		<td colspan="9">Промо-коды отсутствуют</td>
	</tr>
<? endif; ?>
	</tbody>
</table>