<?php
Class Totals extends CI_Model
{
 function getPaidTotals()
 {
   $this -> db -> select('paymenttype');
   $this -> db -> select_sum('amountpaid');
   $this -> db -> from('member');
   $this -> db -> group_by('paymenttype');

   $query = $this -> db -> get();
   return $query->result();
 }
}
?>