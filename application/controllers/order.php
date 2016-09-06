<?php
class order extends FE_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('order_model');
		$this->load->model('goods_model');
    }
	public function index()
	{
		$rules = $this->order_model->rules;
		$this->form_validation->set_rules($rules);
	
		if ($this->form_validation->run() == TRUE) {
			
			$data = $this->order_model->array_from_post(array('email','count','type','fund','coupon'));
			$item = $this->goods_model->get($data['type']);
			
			//Проверка ID товара
			if(!count($item)){
				$resp['error'] =  'Такого товара не существует!';
				echo json_encode($resp);
				return false;
			}
			
			//Проверка кол-ва товара, если товар - файл, то не проверяем!
			if($item->sell_method == 0)
			{
				$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->name));
				$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$item->name)).'/';
				$encdata = file($uppath.$filename);
				if(empty($encdata)) 
				{
					$item->count = '0';
				}
				else
				{
					$item->count = count($encdata);
					$item->goods = "";
				}
				if($item->count < $data['count'])
				{
					$resp['error'] =  'Такого количества товара нет!';
					echo json_encode($resp);
					return false;
				}
				if($item->min_order > $data['count'])
				{
					$resp['error'] = 'Мин. кол-во для заказа: '.$item->min_order;
					echo json_encode($resp);
					return false;
				}
			}
			elseif($item->sell_method == 1)
			{
				$item->count = 'Файл';
				$data['count'] = 'Файл';
				$item->goods = "";
			}

			//Проверка метода оплаты
			if($data['fund'] == 1)
			{
				$pay = 'WMR';
				$fund = $this->config->item('WMR');
				if($item->sell_method == 0 or $item->sell_method == 2)
				$price = ($data['count']) * $item->price_rub;
				else
				$price = $item->price_rub;
			}
			elseif($data['fund'] == 2)
			{
				$pay = 'WMZ';
				$fund = $this->config->item('WMZ');
				if($item->sell_method == 0 or $item->sell_method == 2)
				$price = ($data['count']) * $item->price_dlr;
				else
				$price = $item->price_dlr;
			}
			elseif($data['fund'] == 3)
			{
				$pay = 'YAD';
				$fund = $this->config->item('yad_wallet');
				if($item->sell_method == 0 or $item->sell_method == 2)
				$price = ($data['count']) * $item->price_rub;
				else
				$price = $item->price_rub;
			}
			elseif($data['fund'] == 4)
			{
				$pay = 'QIWI';
				$fund = $this->config->item('qiwi_num');
				if($item->sell_method == 0 or $item->sell_method == 2)
				$price = $data['count'] * $item->price_rub;
				else
				$price = $item->price_rub;
			}
			else
			{
				echo 'Выбран неверный метод оплаты!';
				return false;
			}
			$rand = random_string('alnum',15);
			if($data['fund'] == 1 or $data['fund'] == 2)
			{
				$this->load->helper('wm_helper');
				$wmid = $this->config->item('wmid');
				$wm_pass = $this->encrypt->decode($this->config->item('wm_pass'));
				$wmk_file = unserialize($this->encrypt->decode($this->config->item('wmk_file')));
				$wmk_file = $wmk_file['name'];
				$wmk_path = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').site_url())).'/'.$wmk_file;
				checkwm($wmid,$wm_pass,$wmk_path,$fund);
			}
			elseif($data['fund'] == 3)
			{
				$this->load->helper('yad_helper');
				$clid = config_item('yad_client_id');
				$token = config_item('yad_token');
				check_yad($clid,$token);
			}
			elseif($data['fund'] == 4)
			{
				$this->load->helper('qiwi_helper');
				$qiwi_num = config_item('qiwi_num');
				$qiwi_pass = $this->encrypt->decode(config_item('qiwi_pass'));
				check_qiwi($qiwi_num,$qiwi_pass);
			}
			

			//Купон
			$coupon = $data['coupon'];
			//Проверяем длину купона
			if(strlen($coupon) == 10) {
				//Проверяем существование купона
				$cpnquery = $this->db->query("SELECT * FROM coupons WHERE coupon LIKE ".$this->db->escape('%'.$coupon.'%'));
				$row = $cpnquery->row();

				$cpngoods = explode(',', $row->goods);
				//Проверяем купон-товар
				if(!in_array($item->id, $cpngoods)) {
					$resp['error'] =  'Неверный промо-код!';
					echo json_encode($resp);
					return false;
				}
				//Проверяем дату
				$curdate = time();
				$timeto = $row->timeto;
				$timefrom = $row->timefrom;
				if($curdate > $timeto || $curdate < $timefrom) {
					$resp['error'] =  'Неверный промо-код!';
					echo json_encode($resp);
					return false;
				}
				//Проверяем кол-во использований
				if($row->mayused == 0) {
					$cpnused = $this->db->query("SELECT * FROM used_coupons WHERE coupon LIKE ".$this->db->escape('%'.$coupon.'%'))->num_rows();
					if($cpnused > 0) {
						$resp['error'] =  'Неверный промо-код!';
						echo json_encode($resp);
						return false;
					}
				}
				//Пересчитываем цену
				$price = $price-($price*$row->percent/100);
				$price = number_format($price, 2, '.', '');
				$this->db->query("INSERT INTO used_coupons VALUES(NULL,$row->id,".$this->db->escape($coupon).")");
			} elseif(strlen($coupon) > 0 && strlen($coupon) != 10) {
				$resp['error'] =  'Неверный промо-код!';
				echo json_encode($resp);
				return false;
			}
			$price = number_format($price, 2, '.', '');
			//Если все данные верные, то собираем запрос к БД
			$order['bill'] = 'bill['.$rand.']';
			$order['name'] = $item->name;
			$order['email'] = $data['email'];
			$order['date'] = microtime(true);
			$order['item_id'] = $item->id; 
			$order['count'] = $data['count']; 
			$order['price'] = $price;
			$order['session_key'] = $this->session->userdata('session_id');
			$order['ip_address'] = $this->session->userdata('ip_address');
			$order['fund'] = $pay;
			$order['redeemed'] = FALSE;
			$order['paid'] = FALSE;
			
			$this->order_model->save($order);
			
			//Собираем форму платежа
			$form['ok'] = 'TRUE';
			$form['bill'] = 'bill['.$rand.']';
			$form['name'] = $item->name;
			$form['count'] = $data['count']; 
			$form['pay'] = $pay; 
			$form['price'] = $price;
			$form['fund'] = $fund;
			$form['check_url'] = site_url('/order/'.$rand);
			
			echo json_encode($form);
		}
		else {
			$res['error'] = validation_errors('<div>', '</div>');
			print_r($res);
		}			
	}
	
	public function checkpay() {
		if(preg_match('/^[a-zA-Z0-9]{15}+$/',$this->uri->segment(2),$bill))
		{	
			$resp['status'] = 'false';
			$retname = $bill[0].'.txt';
			$savebill = $bill[0];
			$bill = 'bill['.$bill[0].']';
			$order = $this->order_model->get_by(array('bill' => $bill),TRUE);
			if(count($order)) {
				$item = $this->goods_model->get($order->item_id);
				if(count($item)) {
					$this->load->helper('wm_helper');
					$this->load->helper('yad_helper');
					$this->load->helper('qiwi_helper');
					$this->load->helper('download');
					
					
					
					$mailview['sitename'] = $this->config->item('site_name');
					$mailview['siteurl'] = site_url();
					$mailview['savebill'] = $savebill;
					$mailview['name'] = $item->name;
					
					if($order->count == 0)
						$mailview['count'] = 'Файл';
					else
						$mailview['count'] = $order->count;
					$mailview['paytype'] = $order->fund;
					$mailview['price'] = $order->price;
 					$mailtemp = $this->load->view('mail',$mailview,true);
					
					
					if($order->paid == FALSE) {
						if($order->fund == "WMR" or $order->fund == "WMZ")
						{
							$wmid = $this->config->item('wmid');
							$wm_pass = $this->encrypt->decode($this->config->item('wm_pass'));
							$wmk_file = unserialize($this->encrypt->decode($this->config->item('wmk_file')));
							$wmk_file = $wmk_file['name'];
							$wmk_path = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').site_url())).'/'.$wmk_file;
							$price = $order->price;
							if($order->fund == "WMR")
							{
								$fund = $this->config->item('WMR');
							}
							elseif($order->fund == "WMZ")
							{
								$fund = $this->config->item('WMZ');
							}
							else
							{
								return false;
							}	
							$chkpay = check_payment($wmid,$wm_pass,$fund,$wmk_path,$bill,$price);
						}
						elseif($order->fund == "YAD")
						{
							$clid = config_item('yad_client_id');
							$token = config_item('yad_token');
							$price = $order->price;
							$chkpay = check_pay_yad($clid,$token,$bill,$price);
						}
						elseif($order->fund == "QIWI")
						{
							$qiwi_num = config_item('qiwi_num');
							$qiwi_pass = $this->encrypt->decode(config_item('qiwi_pass'));
							$price = $order->price;
							$chkpay = qiwi_pay($qiwi_num,$qiwi_pass,$bill,$price);
						
						}
						if($chkpay == TRUE) 
						{	
							if($item->sell_method == 0)
							{
								$count = $order->count;
								$filename = preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->name));
								$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$filename.$item->name)).'/';
								$goods = file($uppath.$filename,FILE_IGNORE_NEW_LINES);
								$paidgoods = implode("\r\n",array_splice($goods, 0, $count));
								$goods = implode("\r\n",$goods);
								$smbill = md5(config_item('encryption_key').$savebill).'.txt';
								file_put_contents($uppath.$filename,$goods);
								file_put_contents('./assets/uploads/orders/'.$smbill,$paidgoods);
								$saveord['goods'] = $smbill;
							}
							elseif($item->sell_method == 1) 
							{
								$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->goods.$item->name)).'/'.$item->goods;
								$retname = $item->goods;
								$paidgoods = file_get_contents($uppath);
							}
							$saveord['paid'] = TRUE;
							$this->order_model->save($saveord,$order->id);
							///mail
							$from = parse_url(site_url());
							$from = 'salebot@'.$from['host'];
							$this->load->library('email');
							$this->email->from($from, 'SaleBot');
							$this->email->to($order->email);  
							$this->email->subject('Покупка на сайте '.$this->config->item('site_name'));
							$this->email->message($mailtemp);	
							$this->email->send();
							
							if (!$this->input->is_ajax_request()) {
								force_download($retname, $paidgoods);
							}
							$resp['status'] = 'ok';
							$resp['chkurl'] = site_url('order/'.$savebill);
						}
						else {
							$resp['status'] = 'false';
						}
					}
					elseif($order->paid == TRUE)
					{
						if($item->sell_method == 0)
						{
							$smbill = md5(config_item('encryption_key').$savebill).'.txt';
							$uppath = './assets/uploads/orders/';
							
							if (!$this->input->is_ajax_request()) {
								force_download($savebill.'.txt', file_get_contents($uppath.$smbill));
							}
						}
						elseif($item->sell_method == 1) 
						{
							$uppath = './assets/uploads/'.preg_replace('/[^\p{L}\p{N}\s]/u','', md5(config_item('encryption_key').$item->goods.$item->name)).'/'.$item->goods;
							if (!$this->input->is_ajax_request()) {
								force_download($item->goods, file_get_contents($uppath));
							}
						}						
						$resp['status'] = 'ok';
						$resp['chkurl'] = site_url('order/'.$savebill);
					}
					else
					{
						$resp['status'] = 'false';
					}
					
				}
				echo json_encode($resp);
			
			}
		}
	}
		
}
	
?>