<?php

	include('_header.php');

	# http://wiki.webmoney.ru/wiki/show/Interfeys_X3
	$res = $wmxi->X3(
		'Z210907254635',  # номер кошелька для которого запрашивается операция
		0,              # номер операции (в системе WebMoney)
		0,              # номер перевода
		0,              # номер счета (в системе WebMoney) по которому выполнялась операция
		0,              # номер счета
		20130805,       # минимальное время и дата выполнения операции
		20130812   		# максимальное время и дата выполнения операции
	);

#	print_r($res->Sort());
	$resp = $res->Sort(false);
	//print_r($resp);
	if($resp['operations']['@attributes']['cnt'] == 1) {
		echo $resp['operations']['operation']['desc'];
	}
	elseif (count($resp['operations']['operation']) > 1)
	{
	foreach($resp['operations']['operation'] as $oper) 
	{
		echo $oper['desc'];
	}
	}
#	print_r($res->toArray());
#	print_r($res->toObject());
#	print_r($res->toString());


?>