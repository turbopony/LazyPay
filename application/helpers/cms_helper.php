<?
function timeret($time)
    {

        $month = date( 'm',$time );
        $day   = date( 'j',$time );
        $year  = date( 'Y',$time );
        $hour  = date( 'G',$time );
        $min   = date( 'i',$time );

        $date = $day . '-' . $month . ' в ' . $hour . ':' . $min;

        $dif = time()- $time;

        if($dif<59){
            return round($dif)." сек. назад";
        }elseif($dif/60>1 and $dif/60<59){
            return round($dif/60)." мин. назад";
        }elseif($dif/3600>1 and $dif/3600<23){
            return round($dif/3600)." час. назад";
        }else{
            return $date;
        }
    }
function btn_edit ($url)
{
	return anchor($url, '<i class="fa fa-pencil"></i>');
}
function btn_delete ($url)
{
	return anchor($url, '<i class="fa fa-times"></i>',array('onclick' => "return confirm('Вы уверены что хотите удалить страницу?')"));
}

if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}
 
 
if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

function e($string) {
	return htmlentities($string);
}

function get_menu ($array) {
	$str = '';
	if(is_array($array)) {
		$str .= '<div class="list-group">'.PHP_EOL;
		foreach($array as $item) {
			//$str .= '<li>';
			$str .= '<a class="list-group-item" href="'. site_url('page/'.$item['slug']).'">'.$item['title'].'</a>';
			//$str .= '</li>'.PHP_EOL;
		}
		$str .= '</div>'.PHP_EOL;
	}
	else {
		$str = $array;
	}
	return $str;
}

function get_modals($array) {
	$str = "";
	foreach($array as $item) {
	 $str .= '
	 <div class="modal fade" id="myModal_'.$item->id.'">
		<div class="modal-dialog">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			  <h4 class="modal-title">'.$item->name.'</h4>
			</div>
			<div class="modal-body">
			  '.$item->descr.'
			</div>
		  </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	  </div><!-- /.modal -->'.PHP_EOL;
	}
	return $str;
}



?>