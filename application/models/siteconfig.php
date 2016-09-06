<?php
$router =& load_class('Router', 'core');
$dir = $router->fetch_directory();

class siteconfig extends MY_Model {
	public $rules = array(
		'site_name' => array('field' => 'site_name', 'label' => 'Название сайта', 'rules' => 'trim'),
		'sitedescription' => array('field' => 'sitedescription', 'label' => 'Фраза под заголовком', 'rules' => 'trim|max_length[255]'),
		'metadescr' => array('field' => 'metadescr', 'label' => 'Мета-описание сайта', 'rules' => 'trim'),
		'yad_client_id' => array('field' => 'yad_client_id', 'label' => 'Яндекс(Client ID)', 'rules' => 'trim'),
		'yad_token' => array('field' => 'yad_token', 'label' => 'Яндекс(Token)', 'rules' => 'trim'),		
		'qiwi_num' => array('field' => 'qiwi_num', 'label' => 'QIWI(Номер без +)', 'rules' => 'trim'),
		'qiwi_pass' => array('field' => 'qiwi_pass', 'label' => 'QIWI(Пароль)', 'rules' => 'trim'),
		'wmid' => array('field' => 'wmid', 'label' => 'wmid', 'rules' => 'integer|trim|xss_clean'),
		'WMR' => array('field' => 'WMR', 'label' => 'WMR', 'rules' => 'trim|xss_clean'),
		'WMZ' => array('field' => 'WMZ', 'label' => 'WMZ', 'rules' => 'trim|xss_clean'),
		'wm_pass' => array('field' => 'WMZ', 'label' => 'WMZ', 'rules' => 'trim'),
	);
 public function __construct()
 {
  parent::__construct();
 }
 public function get_all()
 {
  return $this->db->get('config_data');
 }
 public function update_config($data)
 {
  $success = '0';
  foreach($data as $key=>$value)
  {
   if(!$this->save($key,$value))
   {
    $success='1';
    break;  
   }
  }
  return $success;
 }
 public function save($key,$value)
 {
  $config_data=array(
    'key'=>$key,
    'value'=>$value
    );
  $this->db->where('key', $key);
  return $this->db->update('config_data',$config_data); 
 }
}
?>