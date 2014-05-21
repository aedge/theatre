<?php
Class Address extends CI_Model
{
 function getAddresses($option)
 {
   if($option == "noemail"){
		$query = $this -> db -> query('SELECT distinct address.* FROM member, address where member.active and member.email = "" and member.addressid = address.addressid order by member.lastname');
   } else {
		$query = $this -> db -> query('SELECT distinct address.* FROM member, address where member.active and member.addressid = address.addressid order by member.lastname');
   }
  
   return $query->result();
 }
 
 function insertAddress($printname, $housename, $address1, $address2, $address3, $address4, $postcode) 
 {
	//SAVE TO DATABASE
	$data = array(
				'printname' => $printname,
				'housename' => $housename,
				'addressline1' => $address1,
				'addressline2' => $address2,
				'addressline3' => $address3,
				'addressline4' => $address4,
				'postcode' => $postcode,				
				  );
				  
	 return $this->db->insert('address', $data);
  }

}
?>