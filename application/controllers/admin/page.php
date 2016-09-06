<?php
class page extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('page_model');
		$this->load->model('cats_model');
    }
	
	public function index () {
		$this->data['pages'] = $this->page_model->get();
		$arcats = array('0'=>'—');
		$cats =  $this->cats_model->get();
		foreach ($cats as $key => $value) {
			$arcats[$value->id] = $value->name;
		}
		$this->data['cats'] = $arcats;
		$this->data['subview'] = 'admin/page/index';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function edit ($id = NULL)
	{
		$cats =  $this->cats_model->get_by(array('parent'=>0));
		$arcats = array('0'=>'—');
		foreach ($cats as $key => $value) {
			$arcats[$value->id] = $value->name;
			$subcat = $this->cats_model->get_by(array('parent'=>$value->id));
			foreach ($subcat as $key => $value) {
				$arcats[$value->id] = '— '.$value->name;
			}
		}
		$this->data['cats'] = $arcats;
		if($id) {
			$this->data['page'] = $this->page_model->get($id);
			count($this->data['page']) || show_404(current_url());
		}
		else {
			$this->data['page'] = $this->page_model->get_new();
		}
		$rules = $this->page_model->rules;
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == TRUE) {
			$data = $this->page_model->array_from_post(array('title','slug','body','cat','show'));
			$this->page_model->save($data,$id);
			redirect('admin/page');
		}
		
		$this->data['subview'] = 'admin/page/edit';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function delete($id) {
		$this->page_model->delete($id);
		redirect('admin/page');
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