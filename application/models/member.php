<?php 

Class Member extends CI_Model 
{

	function getAnnualMemberNumber($postArray)
	{
		$currentYear = strftime("%Y");
		$nextMemberNumber = System_Parameter::getSP( "annual_member_counter", $currentYear );
		$nextMemberNumber = $nextMemberNumber + 1;
		System_Parameter::setSP("annual_member_counter", $currentYear, $nextMemberNumber);
		
		$postArray["MembershipNumber"] = $currentYear . "-" . $
	}

}

?>