<?php
################################################################################
#                                                                              #
# Webmoney XML Interfaces by DKameleon (http://dkameleon.com)                  #
#                                                                              #
# Updates and new versions: http://my-tools.net/wmxi/                          #
#                                                                              #
# Server requirements:                                                         #
#  - SimpleXML                                                                 #
#                                                                              #
################################################################################


# including classes
if (!defined('__DIR__')) { define('__DIR__', dirname(__FILE__)); }
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'WMXICore.php');


# WMXI class
class WMXI extends WMXICore {

	# interface X3
	# http://wiki.webmoney.ru/wiki/show/Interfeys_X3
	public function X3($purse, $wmtranid, $tranid, $wminvid, $orderid, $datestart, $datefinish) {
		$reqn = $this->_reqn();
		$req = new SimpleXMLElement('<w3s.request/>');
		$req->reqn = $reqn;

		if ($this->classic) {
			$req->wmid = $this->wmid;
			$req->sign = $this->_sign($purse.$reqn);
		}
		$group = 'getoperations';
		$req->$group->purse = $purse;
		$req->$group->wmtranid = $wmtranid;
		$req->$group->tranid = $tranid;
		$req->$group->wminvid = $wminvid;
		$req->$group->orderid = $orderid;
		$req->$group->datestart = $datestart;
		$req->$group->datefinish = $datefinish;
		$url = $this->classic ? 'https://w3s.webmoney.ru/asp/XMLOperations.asp' : 'https://w3s.wmtransfer.com/asp/XMLOperationsCert.asp';

		return $this->_request($url, $req->asXML(), __FUNCTION__);
	}

}


?>