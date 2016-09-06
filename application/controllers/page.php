<?php
class page extends FE_Controller {
	function __Construct() {
        parent::__construct();
		$this->load->model('page_model');
		$this->load->model('cats_model');
    }
	public function index()
	{
		$this->data['pages'] = '';

		//Список категорий
		$allcats = $this->cats_model->get_by(array('parent'=>'0'));
		$catslist = array();
		foreach ($allcats as $key => $value) {
			$subcats = $this->cats_model->get_by(array('parent'=>$value->id));
			$catslist[] = array('slug'=>$value->slug,'name'=>$value->name,'sub'=>0);
			foreach ($subcats as $skey => $svalue) {
				$catslist[] = array('slug'=>$svalue->slug,'name'=>$svalue->name,'sub'=>1);
			}
		}
		$this->data['catslist'] = $catslist;
		$frt = $this->uri->segment(1);
		$snd = $this->uri->segment(2);
		$trd = $this->uri->segment(3);
		if($frt == 'page' && empty($snd) && empty($trd)) 
			redirect('/page/p/1');

		//Страница
		if(is_numeric($snd) && $snd != 'p') {
			$this->data['subview'] = 'page';
			$this->data['page'] = $this->page_model->get_by(array('id' => (string) $snd),TRUE);
			count($this->data['page']) || show_404(current_url());
			$this->data['title'] = $this->data['page']->title.' - ';
			array_push($this->data['breadcumbs'], array('Публикации','/page/'));
			if($this->data['page']->cat != 0) {
				$cat = $this->cats_model->get_by(array('id'=>$this->data['page']->cat),TRUE);
				array_push($this->data['breadcumbs'], array($cat->name,'/page/'.$cat->slug));
			}
			array_push($this->data['breadcumbs'], array($this->data['page']->title,$snd));
		} 
		//Категория
		elseif(!is_numeric($snd) && $snd != 'p' && $snd) {
			if(!is_numeric($trd))
				redirect('page/'.$snd.'/1');
			$curp = $trd-1;
			$cat = $this->cats_model->get_by(array('slug'=>$snd),1);
			$subcats = $this->cats_model->get_by(array('parent'=>$cat->id));
			$subcids = array($cat->id);
			foreach ($subcats as $key => $value) {
				$subcids[] = $value->id;
			}
			$this->data['subview'] = 'pages';
			$count = $this->page_model->get_count(array('cat',$subcids));
			$pubs = $this->page_model->get_bynum(5,$curp,array('cat',$subcids));
			foreach ($pubs as $key => $value) {
				if($value->cat != 0) {
					$cat = $this->cats_model->get_by(array('id'=>$value->cat),1);
					$pubs[$key]->catname = $cat->name;
					$pubs[$key]->catslug = $cat->slug;
				} else {
					$pubs[$key]->catname = '—';
				}
			}
			$this->data['pubs'] = $pubs;
			count($this->data['pubs']) || show_404(current_url());
			array_push($this->data['breadcumbs'], array('Публикации','/page/'));
			array_push($this->data['breadcumbs'], array($cat->name,$cat->slug.'/'));
			$this->data['title'] = $cat->name.' - ';
			$this->data['pagination'] = $this->pagination($count,$curp,'/page/'.$snd.'/');
		}
		//Главная
		elseif($snd == 'p') {
			if(empty($trd))
				redirect('/page/p/1');
			$curp = $trd-1;
			$this->data['subview'] = 'pages';
			$pubs = $this->page_model->get_bynum(5,$curp);
			foreach ($pubs as $key => $value) {
				if($value->cat != 0) {
					$cat = $this->cats_model->get_by(array('id'=>$value->cat),1);
					$pubs[$key]->catname = $cat->name;
					$pubs[$key]->catslug = $cat->slug;
				} else {
					$pubs[$key]->catname = '—';
				}
			}
			$this->data['pubs'] = $pubs;
			count($this->data['pubs']) || show_404(current_url());
			array_push($this->data['breadcumbs'], array('Публикации','/page/'));
			$this->data['title'] = 'Публикации - ';
			$count = $this->page_model->get_count();
			$this->data['pagination'] = $this->pagination($count,$curp,'/page/p/');
		}
		$this->load->view('main_layout',$this->data);
		
	}
	private function pagination($count,$page,$backurl) {
		$this->load->library('pagination');
		$ord_per_page = 5;
		$maxpage = ceil($count / $ord_per_page);
		$config['base_url'] = $backurl;
		$config['total_rows'] = $maxpage;
		$config['per_page'] = 1; 
		$config['uri_segment'] = 3;
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
}
?>