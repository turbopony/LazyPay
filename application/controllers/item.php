<?php
class item extends FE_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('item_model');
    }
	public function index()
	{	

		$this->data['subview'] = 'item';
		$item = $this->item_model->get_by(array('id' => (int) $this->uri->segment(2)),TRUE);
		count($item) || show_404(current_url());
		if($item->sell_method == 0)
		{
			$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->name));
			$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$item->name)).'/';
			$data = file($uppath.$filename);
			if(empty($data)) 
			{
				$item->count = '0';
			}
			else
			{
				$item->count = count($data);
				$item->goods = "";
			}
		}
		elseif($item->sell_method == 1)
		{
			$item->count = 'Файл';
			$item->goods = "";
		}			
		elseif($item->sell_method == 2)
		{
			$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->name));
			$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$item->name)).'/';
			$data = file_get_contents($uppath.$filename);
			$data = explode("[sep]",$data);
			if(empty($data)) 
			{
				$item->count = '0';
			}
			else
			{
				$item->count = count($data);
				$item->goods = "";
			}
		}
		$ret = array();
		$WMR = $this->config->item('WMR');
		$WMZ = $this->config->item('WMZ');
		$YAD = $this->config->item('yad_wallet');
		$QIWI = $this->config->item('qiwi_num');
		if(!empty($WMR)) {
			$ret[] = array(
			'fundid' => '1',
			'fundname' => 'WMR'
			);
		}
		
		if(!empty($WMZ)) {
			$ret[] = array(
			'fundid' => '2',
			'fundname' => 'WMZ'
			);
		}
		
		if(!empty($YAD)) {
			$ret[] = array(
			'fundid' => '3',
			'fundname' => 'Яндекс.Деньги'
			);
		}		
		
		if(!empty($QIWI)) {
			$ret[] = array(
			'fundid' => '4',
			'fundname' => 'QIWI'
			);
		}
		$this->data['funds'] = $ret;
		$this->data['item'] = $item;
		$this->data['title'] = $item->name.' - ';
		array_push($this->data['breadcumbs'], array($item->name,'/item/'.$item->id));
		$this->load->view('main_layout',$this->data);
	}

	public function id($id) {
		echo $id;
	}
}
?>