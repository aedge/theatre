<?php
Class Address extends CI_Model
{
 function getAddresses($email, $renew)
 {
 
   $queryText = 'SELECT distinct address.* FROM member, address where member.memberid > 0';
	if(date('m') < 6){
		$searchYear = date('Y') - 1;
	} else {
		$searchYear = date('Y');
	}
   
   if($email == 'yes'){
		$queryText = $queryText . ' and member.email != "" ';
   } else if($email == 'no') {
		$queryText = $queryText . ' and member.email = "" ';
   }
   
   if($renew == 'yes'){
		$queryText = $queryText . ' and member.membernum like "'. $searchYear .'%" ';
   } else if($renew == 'no') {
		$queryText = $queryText . ' and member.membernum like "'. ($searchYear - 1) .'%" ';
   }
   
   $queryText = $queryText . ' and member.addressid = address.addressid order by member.lastname';
   
   $query = $this -> db -> query($queryText);
   
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