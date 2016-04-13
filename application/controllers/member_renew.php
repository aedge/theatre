<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class member_renew extends CI_Controller {

	var $accessLevel;
 
    function __construct()
    {
        parent::__construct();
 
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */ 
 
        $this->load->library('grocery_CRUD');
		$this->load->library('system_parameter');
		$this->load->model('user','',TRUE);
		$this->load->model('member','',TRUE);
 
    }
 
    public function index()
    {
	
	}
	
	public function popup($memberid) {
	
        if($this->session->userdata('logged_in'))
	    {
			
			$paymentTypeSelect = $this->buildPaymentTypeSelect();
			$defaultdate = '';
			if(date('m') >= 7){
				$defaultdate = '30/06/' . (date('Y') + 1);
			} else {
				$defaultdate = '30/06/' . (date('Y'));
			}			
			$value = !empty($value) ? $value : $defaultdate;
			$data['paymentTypeSelect'] = $paymentTypeSelect;
			$data['expiryDate'] = $defaultdate;		
			$data['memberid'] = $memberid;
	
			$this->load->helper(array('form'));
			$this->load->view('member_renew_popup', $data);
	      
	    }
    }
	
	public function save() {
	
		$memberid    = $this->input->post('memberid');
		$expirydate  = $this->input->post('expirydate');
		$paymenttype = $this->input->post('paymenttype');
		$amountpaid  = $this->input->post('amountpaid');	
		
		$this->member->renewMember($memberid, $expirydate, $paymenttype, $amountpaid);
		
		redirect('main/members', 'refresh');
	}
	
	private function buildPaymentTypeSelect(){
		$select = '';
		$options_array = $this->getPaymentTypeOptions();
		
		$select = "<select id='field-paymenttype' name='paymenttype' class='chosen-select' data-placeholder='Select Payment Type' style='width: 250px !important'>";
		$options_array = array('' => '') + $options_array;
				
		foreach($options_array as $option)
		{
			$select .= "<option value='$option' >$option</option>";
		}
	
		$select .= "</select>";
		
		return $select;
	}
	
	private function getPaymentTypeOptions()
    {
        $row = $this->db->query("SHOW COLUMNS FROM member LIKE 'paymenttype'")->row()->Type;
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row, $enum_array );
        $enum_fields = $enum_array[1];
        foreach ($enum_fields as $key=>$value)
        {
            $enums[$value] = $value; 
        }
        return $enums;
    } 
}