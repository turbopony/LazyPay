<?php
class cats extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('cats_model');
    }
	
	public function index () {
		$subcats = array();
		$cats =  $this->cats_model->get_by(array('parent'=>0));
		$this->data['cats'] = $cats;
		foreach ($cats as $key => $value) {
			$scats = $this->cats_model->get_by(array('parent'=>$value->id));
			if($scats) {
				$subcats[$value->id] = $scats;
			}
		}
		$this->data['subcats'] = $subcats;
		$this->data['subview'] = 'admin/cats/index';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function edit ($id = NULL)
	{
		if($id) {
			$this->data['page'] = $this->cats_model->get($id);
			$cats =  $this->cats_model->get_by(array('parent'=>0));
			$parents = array('0'=>'—');
			foreach ($cats as $key => $value) {
				if($id != $value->id)
					$parents[$value->id] = $value->name;
			}
			$this->data['parents'] = $parents;
			count($this->data['page']) ||show_404(current_url());
		}
		else {
			$this->data['page'] = $this->cats_model->get_new();
			$cats =  $this->cats_model->get_by(array('parent'=>0));
			$parents = array('0'=>'—');
			foreach ($cats as $key => $value) {
				$parents[$value->id] = $value->name;
			}
			$this->data['parents'] = $parents;
		}
		$rules = $this->cats_model->rules;
		$this->form_validation->set_rules($rules);
		
		if($this->form_validation->run() == TRUE) {
			$data = $this->cats_model->array_from_post(array('name','slug','parent'));
			$this->cats_model->save($data,$id);
			redirect('admin/cats');
		}
		
		$this->data['subview'] = 'admin/cats/edit';
		$this->load->view('admin/layout_main',$this->data);
	}
	
	public function delete($id) {
		$subcats = $this->cats_model->get_by(array('parent'=>$id));
		foreach ($subcats as $key => $value) {
			$this->cats_model->delete($value->id);
		}
		$this->cats_model->delete($id);
		redirect('admin/cats');
	}
	
	public function _unique_slug($str) {
		$id = $this->uri->segment(4);
		$this->db->where('slug',$this->input->post('slug'));
		!$id || $this->db->where('id !=',$id);
		$page = $this->cats_model->get();
		
		if(count($page)) {
			$this->form_validation->set_message('_unique_slug','%s должен быть уникальным');
			return FALSE;
		}
		return TRUE;
	}
}
?>