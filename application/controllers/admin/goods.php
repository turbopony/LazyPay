<?php
class goods extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('goods_model');
    }
	
	public function index () {
				
		$items = $this->goods_model->get();
		foreach($items as $item) {
			if($item->sell_method == 0)
			{
				if(!empty($item->goods)) {
					$data = explode(PHP_EOL,$this->encrypt->decode($item->goods));
				}
				else {
					$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->name));
					$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$item->name)).'/';
					$data = file($uppath.$filename);
				}
				
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
		}
		$this->data['goods'] = $items;
		$this->data['subview'] = 'admin/goods/index';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function edit ($id = NULL)
	{
		if($id) {
			$this->data['goods'] = $this->goods_model->get($id);
			count($this->data['goods']) || $this->data['errors'][] = 'Страница не найдена';
			if($this->data['goods']->sell_method == 0) {
				if(!empty($this->data['goods']->goods))
					{
					$this->data['goods']->goods = $this->encrypt->decode($this->data['goods']->goods);
				} else {
					$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$this->data['goods']->name));
					$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$this->data['goods']->name)).'/';
					$this->data['goods']->goods = implode(file($uppath.$filename));
				}
			}
		}
		else {
			$this->data['goods'] = $this->goods_model->get_new();
			$this->data['goods']->filename = '';
		}
		$rules = $this->goods_model->rules;
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == TRUE) {
			$data = $this->goods_model->array_from_post(array('name','descr','iconurl','price_rub','price_dlr','min_order','sell_method','goods'));
			$data['price_rub'] = number_format($data['price_rub'], 2, '.', '');
			$data['price_dlr'] = number_format($data['price_dlr'], 2, '.', '');
			if ($data['sell_method'] == 1) {
				if(!empty($_FILES['userfile']['name']))
				{
					$this->load->helper("file"); 
					$filename = $_FILES['userfile']['name'];
					$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$data['name'])).'/';
					delete_files($uppath, true);
					if(!is_dir($uppath)) {
						mkdir($uppath);
					}
					$config['upload_path'] = $uppath;
					$config['allowed_types'] = '*';
					$config['max_size']	= '100000';

					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload())
					{
						$error = $this->upload->display_errors();
						$this->data['errors'] = $error;
						$this->data['subview'] = 'admin/goods/edit';
						$this->load->view('admin/layout_main',$this->data);
					}
					else
					{
						$data['goods'] = $filename;
						$this->goods_model->save($data,$id);
						redirect('admin/goods');
					}
				}
				else 
				{
					$data = $this->goods_model->array_from_post(array('name','descr','iconurl','price_rub','price_dlr','min_order'));
					$data['price_rub'] = number_format($data['price_rub'], 2, '.', '');
					$data['price_dlr'] = number_format($data['price_dlr'], 2, '.', '');
					$this->goods_model->save($data,$id);
					redirect('admin/goods');
				}
			}
			elseif($data['sell_method'] == 0)
			{	
				$this->load->helper("file"); 
				$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$data['name']));
				$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$data['name'])).'/';
				delete_files($uppath, true);
				if(!is_dir($uppath)) {
					mkdir($uppath);
				}
				file_put_contents($uppath.$filename, $data['goods']);
				$data['goods'] = "";
				$this->goods_model->save($data,$id);
				redirect('admin/goods');
			}
		}
		else
		{
			$this->data['error'] = validation_errors();
			$this->data['subview'] = 'admin/goods/edit';
			$this->load->view('admin/layout_main',$this->data);
		}
		
		
	}
	
	public function delete($id) {
		$this->load->helper("file"); 
		$data = $this->goods_model->get($id);
		if($data->sell_method == 0)
		{
			$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$data->name));
			$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$data->name)).'/';
		}
		elseif($data->sell_method == 1)
		{
			$filename = $data->goods;
			$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$data->name)).'/';
		}
		delete_files($uppath, true);
		rmdir($uppath);
		$this->goods_model->delete($id);
		redirect('admin/goods');
	}
	
	public function _unique_slug($str) {
		$id = $this->uri->segment(4);
		$this->db->where('slug',$this->input->post('slug'));
		!$id || $this->db->where('id !=',$id);
		$goods = $this->goods_model->get();
		
		if(count($goods)) {
			$this->form_validation->set_message('_unique_slug','%s должен быть уникальным');
			return FALSE;
		}
		return TRUE;
	}
	public function chg_order_ajax() {
		$items = $this->input->post('item');
		$total_items = count($this->input->post('item'));
		for($item = 0; $item < $total_items; $item++ )
		{
			$data = array(
				'id' => $items[$item],
				'rank' => $rank = $item
			);
			$this->db->where('id', $data['id']);
			$this->db->update('goods', $data);
		}  
	}
}
?>