<?php
class MY_Controller extends CI_Controller {
	public $data = array();
	function __Construct() {
        parent::__construct();
		$this->data['errors'] = array();
		$this->data['site_name'] = config_item('sitename');
    }
}
?>