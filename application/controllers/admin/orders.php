<?php
class orders extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('goods_model');
		$this->load->model('order_model');
    }
	
	public function index () {
		redirect('admin/orders/page');
		/*$orders = $this->order_model->get_page(array('paid' => '1'));
		foreach($orders as $order) {
			if(empty($order->name)) {
				$name = $this->goods_model->get($order->item_id);
				if(!empty($name))
				{
					$name = $name->name;
					$order->name = $name;
				}
				else
				{
					$order->name = '<b>Товар был удален</b>';
				}
			}
			preg_match('#(?<=bill\[)[a-zA-Z0-9]{15}(?=\])#',$order->bill,$bill);
			$order->bill2 = $bill[0];
		}
		$this->data['orders'] = $orders;
		$this->data['subview'] = 'admin/orders';
		$this->load->view('admin/layout_main',$this->data);*/
	}
	
	public function page($page = 0) {
		$page = (int) $page;

		if(empty($page)) {
			$orders = $this->order_model->get_page(array('paid' => '1'));
			$page = 0;
		}
		elseif ($page > 0) {
			$page -= 1;
			$orders = $this->order_model->get_page(array('paid' => '1'),$page);
		}
		foreach($orders as $order) {
			if(empty($order->name)) {
				$name = $this->goods_model->get($order->item_id);
				if(!empty($name))
				{
					$name = $name->name;
					$order->name = $name;
				}
				else
				{
					$order->name = '<b>Товар был удален</b>';
				}
			}
			preg_match('#(?<=bill\[)[a-zA-Z0-9]{15}(?=\])#',$order->bill,$bill);
			$order->bill2 = $bill[0];
		}
		
		$this->data['pages'] = $this->pagination($page+1);
		$this->data['orders'] = $orders;
		$this->data['subview'] = 'admin/orders';
		$this->load->view('admin/layout_main',$this->data);
	}

	public function pagination($page) {
		$this->load->library('pagination');
		$ord_per_page = 50;
		$maxpage = round($this->order_model->get_count(array('paid' => '1')) / $ord_per_page);
		$config['base_url'] = '/admin/orders/page/';
		$config['total_rows'] = $maxpage;
		$config['per_page'] = 1; 
		$config['uri_segment'] = 4;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = 2;
		$config['first_link'] = 'В начало';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'В конец';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$this->pagination->initialize($config); 

		return $this->pagination->create_links();
		/*$ord_per_page = 50;
		$maxpage = round($this->order_model->get_count(array('paid' => '1')) / $ord_per_page);
		echo $page;
		$pagelast = $page + 2;
		$pagemin = $page - 2;
		if($pagemin <= 0)
			$pagemin = 1;
		if($pagelast > $maxpage)
			$pagelast = $maxpage;
  		print_r(range($pagemin,$pagelast));*/
	}

	public function getorder() {
		if(preg_match('/^[a-zA-Z0-9]{15}+$/',$this->uri->segment(4),$bill))
		{	
			$retname = $bill[0].'.txt';
			$savebill = $bill[0];
			$bill = 'bill['.$bill[0].']';
			$this->load->helper('download');
			$order = $this->order_model->get_by(array('bill' => $bill),TRUE);
			if(count($order)) 
			{
				$item = $this->goods_model->get($order->item_id);
				if($item->sell_method == 0)
				{
					$smbill = md5(config_item('encryption_key').$savebill).'.txt';
					$uppath = './assets/uploads/orders/';
					force_download($retname, file_get_contents($uppath.$smbill));
				}
				elseif($item->sell_method == 1) 
				{
					$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->goods.$item->name)).'/'.$item->goods;
					force_download($item->goods, file_get_contents($uppath));
				}
			}
		}
	}
}
?>