<?php
class config extends Admin_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('siteconfig');
    }
	public function index()
	{
		$rules = $this->siteconfig->rules;
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run() == TRUE) {
			$this->load->library('encrypt');
			$query = $this->db->query("SELECT * FROM `config_data` WHERE `key` LIKE 'qiwi_%'");
			if($query->num_rows() != 2)
			{
				$this->db->query("INSERT INTO `config_data` VALUES('qiwi_num','')");
				$this->db->query("INSERT INTO `config_data` VALUES('qiwi_pass','')");
			}
			$data = $this->siteconfig->array_from_post(array('site_name','sitedescription','metadescr','yad_client_id','yad_token','qiwi_num','qiwi_pass','wmid','WMR','WMZ','wm_pass'));
			if($data['wm_pass'] == "******")
			$data['wm_pass'] = $this->encrypt->decode($this->config->item('wm_pass'));
			$data['wm_pass'] = $this->encrypt->encode($data['wm_pass']);
			
			if($data['qiwi_pass'] == "******")
			$data['qiwi_pass'] = $this->encrypt->decode($this->config->item('qiwi_pass'));
			$data['qiwi_pass'] = $this->encrypt->encode($data['qiwi_pass']);
			$this->siteconfig->update_config($data);
			if (!empty($_FILES['userfile']['name'])) {
				$this->load->helper("file"); 
				$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').site_url())).'/';
				delete_files($uppath, true);
				if(!is_dir($uppath)) {
					mkdir($uppath);
				}
				$config['upload_path'] = $uppath;
				$config['allowed_types'] = 'kwm';
				$config['max_size']	= '1';

				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload())
				{
					$error = $this->upload->display_errors();
					$this->data['error'] = $error;
				}
				else
				{
					$filename = $this->upload->data();
					$chg_date = date('d-m-Y H:i');
					$wmk_file = array(
					'name' => $filename['client_name'],
					);
					$wmk_file = $this->encrypt->encode(serialize($wmk_file));
					$this->siteconfig->save('wmk_file',$wmk_file);
					$this->siteconfig->save('wm_key_date',$chg_date);
				}
			}
			$this->data['ok'] = TRUE;
			$this->data['subview'] = 'admin/config';
			$this->load->view('admin/layout_main',$this->data);
		}
		else 
		{
		$this->data['subview'] = 'admin/config';
		$this->load->view('admin/layout_main',$this->data);
		}
	}
		
	}              
	
?>