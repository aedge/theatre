<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class address_add extends CI_Controller {

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
		$this->load->model('address','',TRUE);
 
    }
 
    public function index()
    {
	
	}
	
	public function popup() {
	
        if($this->session->userdata('logged_in'))
	    {	
			$this->load->helper(array('form'));
			$this->load->view('address_add_popup');
	      
	    }
    }
	
	public function save()
	{
	
		if($this->session->userdata('logged_in'))
	    {	     
			//POST ITEMS
			$printname = $this->input->post('printname', true);
			$housename = $this->input->post('housename', true);
			$address1  = $this->input->post('address1', true);
			$address2  = $this->input->post('address2', true);
			$address3  = $this->input->post('address3', true);
			$address4  = $this->input->post('address4', true);
			$postcode  = $this->input->post('postcode', true);
			
			$insertId = $this->address->insertAddress($printname, $housename, $address1, $address2, $address3, $address4, $postcode);
			echo $insertId;
		}
	}
}