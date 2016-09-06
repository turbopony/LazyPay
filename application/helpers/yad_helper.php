<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(1);
require_once('lib/YandexMoney.php');

function create_cid($clid)
{
	$red_uri = "http://".$_SERVER['HTTP_HOST'].'/yandex/token';
    $scope = "account-info " .
        "operation-history " .
        "operation-details ";
    $authUri = YandexMoney::authorizeUri($clid, $red_uri, $scope);
    header('Location: ' . $authUri);	
}

function create_token($clid,$code)
{
	$ym = new YandexMoney($clid);
	$red_uri = "http://".$_SERVER['HTTP_HOST'].'/yandex/token';
	$receiveTokenResp = $ym->receiveOAuthToken($code, $red_uri);
	if ($receiveTokenResp->isSuccess()) {
		$resp['token'] = $receiveTokenResp->getAccessToken();
	} else {
		$resp['error'] = "Error: " . $receiveTokenResp->getError();
		return $resp;
	}
	$getwallet = $ym->accountInfo($resp['token']);
	if ($getwallet->isSuccess()) {
		$resp['wallet'] = $getwallet->getAccount();
		return $resp;
	} else {
		$resp['error'] = "Error: " . $getwallet->getError();
		return $resp;
	}
}

function get_operations($clid,$token)
{
	if(!empty($token))
	{
		$ym = new YandexMoney($clid);
		$resp = $ym->operationHistory($token, 0, 10);
		if ($resp->isSuccess()) {
			$res = $resp->getOperations();
			return $res;
		}
	}
}

function get_operation($clid,$token,$id)
{
	$ym = new YandexMoney($clid);
	$resp = $ym->operationDetail($token, $id); 
	return $resp;
}

function check_pay_yad($clid,$token,$bill,$price)
{
	$operations = get_operations($clid,$token);
	foreach($operations as $operation)
	{
		$resp = get_operation($clid,$token,$operation->operationId);
		if(number_format($resp->amount, 2, '.', '') == $price && $resp->message == $bill && empty($resp->codepro))
		return TRUE;
	}
}


function check_yad($clid,$token)
{
	if(!empty($token))
	{
		$ym = new YandexMoney($clid);
		$resp = $ym->operationHistory($token, 0, 3);
		if ($resp->isSuccess()) {
			$res['operations'] = $resp->getOperations();
		} else {
			die($resp->getError());
		}
	}
	else
	{
		die();
	}
}

?>