<?php
Class Address extends CI_Model
{
 function getAddresses($option)
 {
   if($option == "noemail"){
		$query = $this -> db -> query('SELECT distinct address.* FROM member, address where member.active and member.email = "" and member.addressid = address.addressid');
   } else {
		$query = $this -> db -> query('SELECT distinct address.* FROM member, address where member.active and member.addressid = address.addressid');
   }
  
   return $query->result();
 }
}
?>