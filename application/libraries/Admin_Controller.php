<?php
class Admin_Controller extends MY_Controller {
	function __construct() {
        parent::__construct();
		$this->data['title'] = 'Buy&Sell';
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('user_model');
		
		//Login check
		$excp_uris = array('admin/user/login','admin/user/logout');
		if(in_array(uri_string(), $excp_uris) == FALSE) { 
			if($this->user_model->loggedin() == FALSE) {
				redirect('admin/user/login');
			}
		}
		function valid_url($url)
		{
			$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
			return (bool) preg_match($pattern, $url);
		}
    }
}
?>