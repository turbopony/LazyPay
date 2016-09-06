<?php
class coupons_model extends MY_Model {
   protected $table_name = 'coupons';
   protected $order_by = 'id desc';
   protected $timestamps = FALSE;
   public $rules = array(
               array(
                     'field'   => 'name', 
                     'label'   => 'Название', 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'mayused', 
                     'label'   => 'Можно использовать', 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'count', 
                     'label'   => 'Кол-во для выпуска', 
                     'rules'   => 'trim|required|integer|xss_clean|greater_than[0]'
                  ),
               array(
                     'field'   => 'percent', 
                     'label'   => 'Скидка в %', 
                     'rules'   => 'trim|required|integer|xss_clean|greater_than[0]|less_than[101]'
                  ),
               array(
                     'field'   => 'timefrom', 
                     'label'   => 'Время действия с', 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'timeto', 
                     'label'   => 'Время действия до', 
                     'rules'   => 'trim|required|xss_clean'
                  ),
               array(
                     'field'   => 'goods', 
                     'label'   => 'Товар', 
                     'rules'   => 'required'
                  ),
            );

   public function get_last() {
      $this->db->order_by("id", "desc"); 
      $orders = $this->db->get_where('orders',array('paid'=>1),3,0)->result();
      return $orders;
   }

   public function get_new() {
      $coupon = new stdClass();
      $coupon->name = '';
      $coupon->count = '';
      $coupon->goods = '';
      $coupon->percent = '';
      $coupon->timeto = '';
      $coupon->timefrom = '';
      $coupon->mayused = '';
      return $coupon;
   }
         
}
?>