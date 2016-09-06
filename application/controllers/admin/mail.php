<?
class mail extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('order_model');
    }
	
	public function index() {
		$query = $this->db->query("SELECT DISTINCT `email` FROM `orders` WHERE `paid`=1");
		foreach ($query->result() as $row) {
			echo $row->email.'</br>';
			$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
			mail($row->email, 'В наличии появился Humble Origin Bundle! '.site_url(), "В наличии имеется Humble Origin Bundle (BTA - 5$)\n Включает в себя 19 ключей активации!\n Цена:160руб.\nСпеши купить:".site_url(),$headers); 
		}
	}
}