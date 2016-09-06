<?php
class item_model extends MY_Model {
	protected $table_name = 'goods';
	protected $order_by = 'id';
	public $rules = array(
	'email' => array('field' => 'title', 'label' => 'Заголовок', 'rules' => 'trim|required|max_length[100]|xss_clean'),
	'slug' => array('field' => 'slug', 'label' => 'Альт. заголовок', 'rules' => 'trim|required|max_length[100]|url_title|callback__unique_slug|xss_clean'),
	'body' => array('field' => 'body', 'label' => 'Текст', 'rules' => 'trim|required'),
	);
	
	public function get_new() {
		$page = new stdClass();
		$page->title = '';
		$page->slug = '';
		$page->body = '';
		return $page;
	}
	public function get_nested() {
		$table = $this->db->get('goods')->result();
		if(count($table))
		{
		foreach($table as $key=>$item) {
			$ret[] = array(
			'title' => $item->title,
			'slug' => $item->slug,
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