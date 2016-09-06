<?php
class cats_model extends MY_Model {
	protected $table_name = 'cats';
	protected $order_by = 'id';
	public $rules = array(
		'name' => array('field' => 'name', 'name' => 'Имя категории', 'rules' => 'trim|required|max_length[100]|xss_clean'),
		'slug' => array('field' => 'slug', 'label' => 'Альтернативное имя', 'rules' => 'trim|required'),
		'parent' => array('field' => 'parent', 'label' => 'Основная категория', 'rules' => 'trim')
	);
	
	public function get_new() {
		$page = new stdClass();
		$page->name = '';
		$page->slug = '';
		$page->parent = '0';
		return $page;
	}
	public function get_nested() {
		$table = $this->db->get('cats')->result();
		if(count($table))
		{
			foreach($table as $key=>$item) {
				$ret[] = array(
				'name' => $item->name,
				'slug' => $item->slug,
				'parent' => $item->parent
				);
			}
		}
		else
		{
			$ret = 'Записи отсутствуют!';
		}
		return $ret;
	}
}
?>