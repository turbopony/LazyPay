<?php
class goods_model extends MY_Model {
	protected $table_name = 'goods';
	protected $order_by = 'rank asc';
	protected $timestamps = FALSE;
	public $rules = array('name' => array('field' => 'name', 'label' => 'Название', 'rules' => 'trim|required|max_length[100]|xss_clean'), 
	'descr' => array('field' => 'descr', 'label' => 'Описание', 'rules' => 'trim|required'), 
	'iconurl' => array('field' => 'iconurl', 'label' => 'Иконка (URL)', 'rules' => 'trim|valid_url'), 
	'price_rub' => array('field' => 'price_rub', 'label' => 'Цена (Рубли)', 'rules' => 'trim|required|greater_than[0]|xss_clean'), 
	'price_dlr' => array('field' => 'price_dlr', 'label' => 'Цена (Доллары)', 'rules' => 'trim|required|greater_than[0]|xss_clean'), 
	'min_order' => array('field' => 'min_order', 'label' => 'Мин. кол-во для заказа', 'rules' => 'trim|required|greater_than[0]|xss_clean'), 
	'sell_method' => array('field' => 'sell_method', 'label' => 'Метод продажи', 'rules' => 'integer|trim|required|xss_clean'),
	'goods' => array('field' => 'goods', 'label' => 'Товар', 'rules' => 'trim') 
	);

	public function get_new() {
		$goods = new stdClass();
		$goods->name = '';
		$goods->descr = '';
		$goods->iconurl = '';
		$goods->price_rub = '';
		$goods->price_dlr = '';
		$goods->min_order = '';
		$goods->sell_method = '0';
		$goods->goods = '';
		return $goods;
	}
}

?>