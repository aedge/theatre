<?php 

Class Member extends CI_Model 
{
	function renewMember($memberid, $expirydate, $paymenttype, $amountpaid){
		
		$expirydate  = $this->db->escape($expirydate);	
		$memberNum   = $this->getMemberNumber($memberid);	
		
		$this->db->set('membernum', $memberNum);
		$this->db->set('expirydate', "STR_TO_DATE($expirydate, '%d/%m/%Y')", FALSE);
		$this->db->set('paymenttype', $paymenttype);
		$this->db->set('amountpaid', $amountpaid);
		$this->db->set('active', 1);
		$this->db->where('memberid', $memberid);
		$this->db->update('member');	
	}
	
	function getMemberNumber($memberid) {
	
		$currentYear = strftime("%Y");
		$lastYear = 0;
		
		if(date('m') < 5){
			$currentYear = date('Y') - 1;
		} else {
			$currentYear = date('Y');
		}			
		
		$lastYear = $currentYear - 1;
		$this -> db -> select('membernum');
		$this -> db -> from('member');
		$this -> db -> where('memberid', $memberid);
		$this -> db -> limit(1);

		$query = $this -> db -> get();
		$currentMemberNumber = $query->row()->membernum ;
		$memberNumberArray = explode("-", $currentMemberNumber);
		$newMemberNumber = $currentYear . "-" . $memberNumberArray[count($memberNumberArray) - 1];
		
		return $newMemberNumber;
	}
	
	function checkDuplicateMember($memberNumber) {
		
		$this -> db -> select('membernum');
		$this -> db -> from('member');
		$this -> db -> like('membernum','$memberNumber','before'); 
		$this -> db -> limit(1);
		
		$query = $this -> db -> get();
		
		if($query->num_rows() > 0){
			return true;
		}
		
		return false;
		
	}

}

?>