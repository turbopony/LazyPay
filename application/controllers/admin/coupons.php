<?php
class coupons extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('coupons_model');
		$this->load->model('goods_model');
    }
	
	public function index () {
		$coupons = $this->coupons_model->get();
		foreach ($coupons as $key => $value) {
			$coupons[$key]->used = $this->db->query('SELECT id FROM used_coupons WHERE mainid=\''.$value->id.'\'')->num_rows();
		}
		$this->data['coupons'] = $coupons;
		
		$this->data['subview'] = 'admin/coupons/index';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function show($id = NULL) {
		if(!$id)
			redirect('admin/coupons');
		$coupon = $this->coupons_model->get($id);
		$retgoods = array();
		$goods = explode(',', $coupon->goods);
		foreach ($goods as $key => $value) {
			$item = $this->goods_model->get($value);
			$retgoods[] = array('id'=>$item->id,'name'=>$item->name);
		}
		$rblock = 
		'<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Товар для промо-кодов</h3>
			</div>	
			<div class="list-group">';
		foreach ($retgoods as $key => $value) {
			$id = $value['id'];
			$name = $value['name'];
			$rblock .= '<a target="_blank" class="list-group-item" href="/item/'.$id.'">'.$name.'</a>';
		}
		$rblock .= '</div></div>';
		//print_r($coupon);
		$coupon->coupon = explode('|', $coupon->coupon);
		$newcpn = array();
		foreach ($coupon->coupon as $key => $value) {
			$query = $this->db->query('SELECT * FROM used_coupons WHERE coupon=\''.$value.'\'');
			$newcpn[$key]['coupon'] = $value;
			$used = $query->num_rows();
			if($coupon->mayused == 0) {
				if($used > 0)
					$newcpn[$key]['used'] = 'Да';
				else
					$newcpn[$key]['used'] = 'Нет';
			} else {
				$newcpn[$key]['used'] = $query->num_rows();
			}

			
		}
		$coupon->coupon = $newcpn;
		$this->data['rblock'] = $rblock;
		$this->data['coupon'] = $coupon;
		$this->data['subview'] = 'admin/coupons/show';
		$this->load->view('admin/layout_main',$this->data);
	}

	public function edit ($id = NULL)
	{
		if($id) {
			$coupon = $this->coupons_model->get($id);
			$goods = $this->goods_model->get();
			$ngoods = array();
			foreach ($goods as $key => $value) {
				$ngoods[$value->id] = $value->name;
			}
			$coupon->timefrom = date('d.m.Y H:i',$coupon->timefrom);
			$coupon->timeto = date('d.m.Y H:i',$coupon->timeto);
			$this->data['goods'] = $ngoods;
			$this->data['coupon'] = $coupon;
			count($this->data['coupon']) || $this->data['errors'][] = 'Страница не найдена';
			$savecpns = $coupon->coupon;
			$checkpost = $this->input->post();
			if(!empty($checkpost))
				$_POST['count'] = 10;
		}
		else {
			$goods = $this->goods_model->get();
			$ngoods = array();
			foreach ($goods as $key => $value) {
				$ngoods[$value->id] = $value->name;
			}
			$this->data['goods'] = $ngoods;
			$this->data['coupon'] = $this->coupons_model->get_new();
		}
		$rules = $this->coupons_model->rules;
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == TRUE) {
			$data = $this->coupons_model->array_from_post(array('name','mayused','count','percent','timefrom','timeto','goods'));
			$data['goods'] = implode(',', $data['goods']);
			$data['timefrom'] = strtotime($data['timefrom']);
			$data['timeto'] = strtotime($data['timeto']);
			if(empty($savecpns)) {
				$coupons = array();
				for($i=0;$i<$data['count'];$i++)
				$coupons[] = random_string('alnum', 10);
				$data['coupon'] = implode('|', $coupons);
			} else {
				$data['coupon'] = $savecpns;
			}
			
			unset($data['count']);
			$this->coupons_model->save($data,$id);
			redirect('admin/coupons');
		}
		
		$this->data['subview'] = 'admin/coupons/edit';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function delete($id) {
		$this->coupons_model->delete($id);
		redirect('admin/coupons');
	}
	
	public function _unique_slug($str) {
		$id = $this->uri->segment(4);
		$this->db->where('slug',$this->input->post('slug'));
		!$id || $this->db->where('id !=',$id);
		$page = $this->page_model->get();
		
		if(count($page)) {
			$this->form_validation->set_message('_unique_slug','%s должен быть уникальным');
			return FALSE;
		}
		return TRUE;
	}
}
?>