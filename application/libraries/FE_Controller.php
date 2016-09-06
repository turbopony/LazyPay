<?php
class FE_Controller extends MY_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('page_model');
		$this->load->model('order_model');
		$pages = $this->page_model->get_by(array('show'=>1));
		$npages = array();
		foreach ($pages as $key => $value) {
			$npages[] = array('title'=>$value->title,'id'=>$value->id,'body'=>$this->cut_string($value->body,150));
		}
		$this->data['pages'] = $npages;
		$this->data['catslist'] = '';
		$this->data['menu'] = $this->page_model->get_nested();
		$this->data['breadcumbs'] = array(array('Главная','/'));
	
		
    }

    function cut_string($string, $length = 200)
	{
	    if ($length && strlen($string) > $length)
	    {
	        $str = strip_tags($string);
	        $str = rtrim($str, strstr($str, "\r\n"));
	        $str = substr($str, 0, $length);
	        $pos = strrpos($str, ' ');
	        return substr($str, 0, $pos).'…';
	    }
	    return $string;
	}
}
?>