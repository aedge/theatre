<?php
Class Totals extends CI_Model
{
 function getPaidTotals()
 {
 
	if(date('m') < 6){
		$currentYear = date('Y') - 1;
	} else {
		$currentYear = date('Y');
	}
	
   $this -> db -> select('paymenttype');
   $this -> db -> select_sum('amountpaid');
   $this -> db -> from('member');
	$this -> db -> like('membernum', $currentYear, 'after');
   $this -> db -> group_by('paymenttype');

   $query = $this -> db -> get();
   return $query->result();
 }
}
?>