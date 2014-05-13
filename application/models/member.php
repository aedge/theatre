<?php 

Class Member extends CI_Model 
{
/**
	function getAnnualMemberNumber($postArray)
	{
		$currentYear = strftime("%Y");
		$nextMemberNumber = System_Parameter::getSP( "annual_member_counter", $currentYear );
		$nextMemberNumber = $nextMemberNumber + 1;
		System_Parameter::setSP("annual_member_counter", $currentYear, $nextMemberNumber);
		
		$postArray["MembershipNumber"] = $currentYear . "-" . $
	}

**/	
	function renewMember($memberid, $expirydate, $paymenttype, $amountpaid){
		
		$expirydate  = $this->db->escape($expirydate);		
		$this->db->set('expirydate', "STR_TO_DATE($expirydate, '%d/%m/%Y')", FALSE);
		$this->db->set('paymenttype', $paymenttype);
		$this->db->set('amountpaid', $amountpaid);;
		$this->db->where('memberid', $memberid);
		$this->db->update('member');	
	}

}

?>