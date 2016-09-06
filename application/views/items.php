<table class="table table-bordered" >
	<thead>
		<th>Товар</th>
		<th>В наличии</th>
		<th>Цена в <a class="modgl" onclick="price_rub();"><span class="rur">p<span>уб.</span></span></a> или <a class="modgl" onclick="price_dlr();">$</a></th>
	</thead>
	<tbody>
<? if(count($items)): foreach($items as $item): ?>
		<tr>
			
			<td class="modgl"><a class="itemlink" href="<? echo '/item/'.$item->id; ?>"><? echo empty($item->iconurl) ? '' : '<img class="iconurl" src="'.$item->iconurl.'" alt="'.$item->name.'"/>'; ?><? echo $item->name; ?></a></td>
			<td data-id="<? echo $item->count == "Файл" ? "" : $item->id ;?>"><? echo $item->count; ?></td>
			<td class="rubprice"><? echo $item->price_rub; ?> <span class="rur">p<span>уб.</span></span> за 1 шт.</td>
			<td class="dlrprice" style="display:none"><? echo $item->price_dlr; ?> $ за 1 шт.</td>
		</tr>
<? endforeach; ?>
<? else: ?>
	<tr>
		<td colspan="3">Товары отсутствуют</td>
	</tr>
<? endif; ?>
	</tbody>
</table>