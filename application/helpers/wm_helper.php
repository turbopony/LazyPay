<?
error_reporting(0);
if (!isset($class)) { $class = 'WMXI'; }
require_once("wm/$class.php");
function checkwm($wmid,$wm_pass,$wm_path,$fund) {
			# Форсирование использования библиотек
		 //define('WMXI_MATH', 'bcmath4'); # Варианты: gmp, bcmath4, bcmath5
		 define('WMXI_MD4', 'hash'); # Варианты: mhash, hash, class


		# Создаём объект класса. Передаваемые параметры:
		$wmxi = new WMXI(realpath('../WMXI.crt'), 'UTF-8');

		# Параметры инициализации ключем Webmoney Keeper Classic
		define('WMID', $wmid);
		define('PASS', $wm_pass);
		define('KWMFILE', $wm_path);

		$wmkey = array('pass' => PASS, 'file' => KWMFILE); 
		if($wmxi->Classic(WMID, $wmkey))
		echo '123';
		date_default_timezone_set('Europe/Moscow');
		$res = $wmxi->X3(
			$fund,  # номер кошелька для которого запрашивается операция
			0,              # номер операции (в системе WebMoney)
			0,              # номер перевода
			0,              # номер счета (в системе WebMoney) по которому выполнялась операция
			0,              # номер счета
			date('Ymd',strtotime('+1 day')),       # минимальное время и дата выполнения операции
			date('Ymd',strtotime('+1 day'))   		# максимальное время и дата выполнения операции
		);
		$resp = $res->Sort(false);
		if($resp['retval'] != 0)
		{
			die('Данные неверны!');
		}
}
function testwm($wmid,$wm_pass,$wm_path,$fund)
{
		# Форсирование использования библиотек
		// define('WMXI_MATH', 'bcmath4'); # Варианты: gmp, bcmath4, bcmath5
		 define('WMXI_MD4', 'hash'); # Варианты: mhash, hash, class


		# Создаём объект класса. Передаваемые параметры:
		$wmxi = new WMXI(realpath('../WMXI.crt'), 'UTF-8');

		# Параметры инициализации ключем Webmoney Keeper Classic
		define('WMID', $wmid);
		define('PASS', $wm_pass);
		define('KWMFILE', $wm_path);

		$wmkey = array('pass' => PASS, 'file' => KWMFILE); 
		if($wmxi->Classic(WMID, $wmkey))
		echo '123';
		date_default_timezone_set('Europe/Moscow');
		$res = $wmxi->X3(
			$fund,  # номер кошелька для которого запрашивается операция
			0,              # номер операции (в системе WebMoney)
			0,              # номер перевода
			0,              # номер счета (в системе WebMoney) по которому выполнялась операция
			0,              # номер счета
			date('Ymd',strtotime('+1 day')),       # минимальное время и дата выполнения операции
			date('Ymd',strtotime('+1 day'))   		# максимальное время и дата выполнения операции
		);
		$resp = $res->Sort(false);
		print_r($resp);
}
function check_payment($wmid,$wm_pass,$fund,$wm_path,$desc,$amount)
{
	if(!empty($wmid) && !empty($wm_pass) && !empty($fund) && !empty($wm_path) && !empty($desc) && !empty($amount))
	{
		# Форсирование использования библиотек
		 //define('WMXI_MATH', 'bcmath4'); # Варианты: gmp, bcmath4, bcmath5
		 define('WMXI_MD4', 'hash'); # Варианты: mhash, hash, class


		# Создаём объект класса. Передаваемые параметры:
		$wmxi = new WMXI(realpath('../WMXI.crt'), 'UTF-8');

		# Параметры инициализации ключем Webmoney Keeper Classic
		define('WMID', $wmid);
		define('PASS', $wm_pass);
		define('KWMFILE', $wm_path);

		if (defined('EKEY') && defined('NKEY')) { $wmkey = array('ekey' => EKEY, 'nkey' => NKEY); }
		elseif (defined('KWMDATA')) { $wmkey = array('pass' => PASS, 'data' => KWMDATA); }
		elseif (defined('KWMFILE')) { $wmkey = array('pass' => PASS, 'file' => KWMFILE); }
		if (isset($wmkey)) { $wmxi->Classic(WMID, $wmkey); }
		date_default_timezone_set('Europe/Moscow');
		$res = $wmxi->X3(
			$fund,  # номер кошелька для которого запрашивается операция
			0,              # номер операции (в системе WebMoney)
			0,              # номер перевода
			0,              # номер счета (в системе WebMoney) по которому выполнялась операция
			0,              # номер счета
			date('Ymd',strtotime('-5 day')),       # минимальное время и дата выполнения операции
			date('Ymd',strtotime('+5 day'))   		# максимальное время и дата выполнения операции
		);

		$resp = $res->Sort(false);
		if($resp['operations']['@attributes']['cnt'] == 1) {
			if($resp['operations']['operation']['desc'] == $desc && round($resp['operations']['operation']['amount'],2) == $amount && $resp['operations']['operation']['opertype'] == 0)
			{
				return TRUE;
			}
		}
		elseif (count($resp['operations']['operation']) > 1)
		{
			foreach($resp['operations']['operation'] as $oper) 
			{
				if($oper['desc'] == $desc && round($oper['amount'],2) == $amount && $oper['opertype'] == 0)
				{
					return TRUE;
				}
			}
		}
		else
		{
			return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}
?>