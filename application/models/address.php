
<?php
Class Address extends CI_Model
{
 function getAddresses()
 {
   $this -> db -> select('*');
   $this -> db -> from('address');
   $this -> db -> from('member');
   $this -> db -> where('address.addressid', 'member.addressid');
   $this -> db -> where('member.active', 'true');
   
   $query = $this -> db -> get();

   return $query->result();
 }
}
?>

