<p class="lead pull-left">Список промо-кодов</p>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Промо-код</th>
			<th>Использован <? echo $coupon->mayused==0 ? '' : '(раз)';?> </th>
		</tr>
	</thead>
	<tbody>
		<?
			foreach ($coupon->coupon as $key => $value) {
				echo '<tr>';
				echo '<td>'.$value['coupon'].'</td>';
				echo '<td>'.$value['used'].'</td>';
				echo '</tr>';
			}
			
		?>
	</tbody>
</table>