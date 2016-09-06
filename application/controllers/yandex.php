<?
class yandex extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('siteconfig');
		$this->load->helper('yad_helper');
    }
	
	public function index()
	{
		$clid = config_item('yad_client_id');
		$token = config_item('yad_token');
		$query = $this->db->query("SELECT * FROM `config_data` WHERE `key` LIKE 'yad_%'");
		if($query->num_rows() != 3)
		{
			$this->db->query("INSERT INTO `config_data` VALUES('yad_client_id','')");
			$this->db->query("INSERT INTO `config_data` VALUES('yad_token','')");
			$this->db->query("INSERT INTO `config_data` VALUES('yad_wallet','')");
		}
		if (empty($token) && !empty($clid)) { 
			create_cid($clid);
		}
		elseif(empty($clid))
		{
			echo 'Установите верный Client ID в настройках скрипта! </br> <a href="/admin/config">Вернуться в админ-панель</a>';
		}
	}
	
	public function token()
	{
		$clid = config_item('yad_client_id');
		$token = config_item('yad_token');
		if (empty($token)) { 
			$code = $_GET['code'];
			$token = create_token($clid,$code);
			if(!empty($token['token']) && !empty($token['wallet']))
			{
				$this->siteconfig->save('yad_token',$token['token']);
				$this->siteconfig->save('yad_wallet',$token['wallet']);
				echo "Яндекс успешно настроен! </br> <a href='/admin'>Вернуться в админ-панель</a>";
			}
			else
			{
				echo $token['error'];
			}
		}
	}
	
	
	public function check()
	{
		$clid = config_item('yad_client_id');
		$token = config_item('yad_token');
		$operations = get_operations($clid,$token);
		echo "<pre>";
		foreach($operations as $operation)
		{
			$resp = get_operation($clid,$token,$operation->operationId); 
			print_r($resp);
		}
	}

}
?>