<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require('qiwi-class.php'); 

function qiwi_pay($qiwi_num,$qiwi_pass,$bill,$price,$stat) 
{ 
     $qiwi = new QIWI_LazyPay($qiwi_num,$qiwi_pass,'cookie.txt'); 
     $date1 = date('d.m.Y',strtotime('-1 day')); 
     $date2 = date('d.m.Y',strtotime('+1 day')); 
     $operations = $qiwi->GetHistory($date1,$date2); 
     foreach($operations as $operation) 
     { 
        if(number_format($operation['dAmount'], 2, '.', '') == $price && $operation['sComment'] == $bill && $operation['sStatus'] == 'SUCCESS') 
        { 
           return 1; 
        } 
     } 
} 

function check_qiwi($qiwi_num,$qiwi_pass) 
{ 
     try { 
        $qiwi = new QIWI_LazyPay($qiwi_num,$qiwi_pass,'cookie.txt'); 
     } catch (Exception $e) { 
        die($e->getMessage()); 
     } 
} 
?>