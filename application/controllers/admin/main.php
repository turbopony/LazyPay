<?php
class main extends Admin_Controller {
	function __Construct() {
        parent::__construct();
    }
	
	public function index() {
		$checklicense = true;
		$this->load->view('admin/layout_main',$this->data);
	}
	public function modal() {
		$this->load->view('admin/layout_modal',$this->data);
	}
}
?>