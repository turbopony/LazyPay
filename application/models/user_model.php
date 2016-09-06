<?
class user_model extends MY_Model {
	protected $table_name = 'users';
	protected $order_by = 'name';
	public $rules = array(
	'email' => array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|xss_clean'),
	'password' => array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required'),
	'captcha' => array('field' => 'captcha', 'label' => 'Captcha', 'rules' => 'trim|required')
	);
	
	function __construct() 
	{
		parent::__construct();
	}
	
	public function login(){
		$val = $this->db->query("SELECT 1 FROM captcha");
		$user = $this->get_by(array(
		'email' => $this->input->post('email'),
		'password' => $this->hash($this->input->post('password')),
		), TRUE);
		$expiration = time()-45; // Two hour limit
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	

		// Then see if a captcha exists:
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($this->input->post('captcha'), $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		if ($row->count == 0)
		{
		    return FALSE;
		}
		else {
			if(count($user)) {
				$data = array(
					'name' => $user->name,
					'email' => $user->email,
					'id' => $user->id,
					'loggedin' => TRUE,
					);
				$this->session->set_userdata($data);
				return TRUE;
			}
		}	
	}
	
	public function loggedin(){
		return (bool) $this->session->userdata('loggedin');
	}
	
	public function logout(){
		$this->session->sess_destroy();
	}
	
	public function hash($string){
		return md5($string);
	}
}
?>