<?php
class page_model extends MY_Model {
	protected $table_name = 'pages';
	protected $order_by = 'id desc';
	public $rules = array(
		'title' => array('field' => 'title', 'label' => 'Заголовок', 'rules' => 'trim|required|max_length[100]|xss_clean'),
		'slug' => array('field' => 'slug', 'label' => 'Альт. заголовок', 'rules' => 'trim|required|max_length[100]|url_title|callback__unique_slug|xss_clean'),
		'body' => array('field' => 'body', 'label' => 'Текст', 'rules' => 'trim|required'),
		'cat' => array('field' => 'cat', 'label' => 'Категория', 'rules' => 'trim|required'),
		'show' => array('field' => 'show', 'label' => 'Вывод в блоке новостей', 'rules' => 'trim'),
	);
	
	public function get_new() {
		$page = new stdClass();
		$page->title = '';
		$page->slug = '';
		$page->body = '';
		$page->cat = '0';
		$page->show = '0';
		return $page;
	}

	public function get_nested() {
		$table = $this->db->get('pages')->result();
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