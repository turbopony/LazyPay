<?
class qiwi extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('siteconfig');
		$this->load->helper('qiwi_helper');
    }
	
	public function index()
	{

	}
	
	public function check()
	{
		$qiwi_num = config_item('qiwi_num');
		$qiwi_pass = $this->encrypt->decode(config_item('qiwi_pass'));
		print_r(check_qiwi($qiwi_num,$qiwi_pass));
	}
	
}
?>