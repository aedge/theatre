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
		$memberNum   = $this->getMemberNumber();	
		
		$this->db->set('membernum', $memberNum);
		$this->db->set('expirydate', "STR_TO_DATE($expirydate, '%d/%m/%Y')", FALSE);
		$this->db->set('paymenttype', $paymenttype);
		$this->db->set('amountpaid', $amountpaid);;
		$this->db->where('memberid', $memberid);
		$this->db->update('member');	
	}
	
	function getMemberNumber() {
	
		$currentYear = strftime("%Y");
		
		if(date('m') < 6){
			$currentYear = date('Y') - 1;
		} else {
			$currentYear = date('Y');
		}			
		$this -> db -> select('value');
		$this -> db -> from('systemparameter');
		$this -> db -> where('section', 'annual_member_counter');
		$this -> db -> where('key', $currentYear);
		$this -> db -> limit(1);

		$query = $this -> db -> get();
		$nextMemberNumber = $query->row()->value;
		$nextMemberNumber = $nextMemberNumber + 1;
		
		$this -> db -> query("insert into systemparameter (`section`,`key`,`value`) values ('annual_member_counter','$currentYear','$nextMemberNumber') on duplicate key update `value`='$nextMemberNumber'");
		
		return $currentYear . "-" . sprintf("%04d", $nextMemberNumber);
	}

}

?>