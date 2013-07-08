<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Main extends CI_Controller {

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
		$this->load->library('PDF_Label',array('format' => '3422'));
		$this->load->model('address','',TRUE);
 
    }
 
    public function index()
    {
        if($this->session->userdata('logged_in'))
	    {
	      $session_data = $this->session->userdata('logged_in');
	      $data['username'] = $session_data['username'];
		  $accessLevel = $session_data['accessLevel'];
		  redirect('main/members', 'refresh');
	    }
	    else
	    {
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    }
    }
	
	public function logout() {
		$this->session->set_userdata('logged_in', null);	
		redirect('login', 'refresh');
	}
 
    public function members()
    {
	
	    if($this->session->userdata('logged_in'))
	    {
	      $session_data = $this->session->userdata('logged_in');
	      $data['username'] = $session_data['username'];
		  $accessLevel = $session_data['accessLevel'];
	    }
	    else
	    {
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    }
		
        $crud = new grocery_CRUD();
		
		$crud->set_Subject('Member');
		$crud->set_table('member');
		
		$crud->columns('membernum','title','firstname','lastname','phone','mobile','email','agegroup','addressid','Interests','expirydate','paymenttype','amountpaid','active','blacklisted');
		
		$crud->display_as('lastname','Last Name');
		$crud->display_as('firstname','First Name');
		$crud->display_as('phone','Phone Number');
		$crud->display_as('mobile','Mobile Number');
		$crud->display_as('agegroup','Age Group');
		$crud->display_as('expirydate','Expiry Date');
		$crud->display_as('membernum','Membership Number');
		$crud->display_as('paymenttype','Payment Type');
		$crud->display_as('amountpaid','Amount Paid');
				
		$crud->set_relation('addressid','address','{housename} {addressline1}');
		$crud->display_as('addressid','Address');		
		$crud->set_relation_n_n('Interests','memberinterest','interest','memberid','interestid','description');
		$crud->add_fields('firstname','lastname','title','phone','mobile','email','agegroup','addressid','Interests');
		$crud->required_fields('firstname','lastname','agegroup','addressid','phone','title');
		
		$crud->callback_before_insert(function($post_array){
			$currentYear = strftime("%Y");			
			$this -> db -> select('value');
			$this -> db -> from('systemparameter');
			$this -> db -> where('section', annual_member_counter);
			$this -> db -> where('key', $currentYear);
			$this -> db -> limit(1);

			$query = $this -> db -> get();
			$nextMemberNumber = $query->row()->value;
			$nextMemberNumber = $nextMemberNumber + 1;
			
			$this -> db -> query("insert into systemparameter (`section`,`key`,`value`) values ('annual_member_counter','$currentYear','$nextMemberNumber') on duplicate key update `value`='$nextMemberNumber'");
			
			$post_array["membernum"] = $currentYear . "-" . $nextMemberNumber;
		
			return $post_array;
		});
		$selected = "Members";

        $output = $crud->render();				
		$output->accessLevel = $accessLevel;
        $this->_render_output($output);     
    }
	
	public function interests()
    {
		if($this->session->userdata('logged_in'))
	    {
	      $session_data = $this->session->userdata('logged_in');
	      $data['username'] = $session_data['username'];
		  $accessLevel = $session_data['accessLevel'];
	    }
	    else
	    {
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    }
	
        $crud = new grocery_CRUD();
		
		$crud->set_Subject('Interest');
		$crud->set_table('interest');
		$selected = "Interests";

        $output = $crud->render();			
		$output->accessLevel = $accessLevel;
        $this->_render_output($output);     
    }
	
	public function addresses()
    {
	
	    if($this->session->userdata('logged_in'))
	    {
	      $session_data = $this->session->userdata('logged_in');
	      $data['username'] = $session_data['username'];
		  $accessLevel = $session_data['accessLevel'];
	    }
	    else
	    {
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    }
        $crud = new grocery_CRUD();
		
		$crud->set_Subject('Address');
		$crud->set_table('address');
		$selected = "Addresses";
		$crud->columns('printname','housename','addressline1','addressline2','addressline3','addressline4','postcode');
		$crud->add_fields('printname','housename','addressline1','addressline2','addressline3','addressline4','postcode');
		$crud->edit_fields('printname','housename','addressline1','addressline2','addressline3','addressline4','postcode');
		$crud->display_as('printname','To');
		$crud->display_as('housename','House Name');
		$crud->display_as('addressline1','Line 1');
		$crud->display_as('addressline2','Line 2');
		$crud->display_as('addressline3','Line 3');
		$crud->display_as('addressline4','Line 4');
		$crud->display_as('postcode','Postcode');
		$crud->required_fields('printname','addressline1','postcode');
		
        $output = $crud->render();		
		$output->accessLevel = $accessLevel;
        $this->_render_output($output);     
    }
	
	public function users()
    {
	
	    if($this->session->userdata('logged_in'))
	    {
	      $session_data = $this->session->userdata('logged_in');
	      $data['username'] = $session_data['username'];
		  if($session_data['accessLevel'] >= 10){
			$accessLevel = $session_data['accessLevel'];
		  } else {
			redirect('login', 'refresh');
		  }
	    }
	    else
	    {
	     //If no session, redirect to login page
	     redirect('login', 'refresh');
	    }

		
        $crud = new grocery_CRUD();
		
		$crud->set_Subject('Users');
		$crud->set_table('user');
		$crud->columns('username','accesslevel');
		$crud->required_fields('username','password','accesslevel');
		$crud->add_fields('username','password','accesslevel');
		$crud->edit_fields('username','password','accesslevel');
		$crud->display_as('accesslevel','Access Level');
		$crud->display_as('username','Username');
		$crud->display_as('password','Password');
		
		$crud->callback_before_insert(function($post_array){
			$post_array["password"] = md5($post_array["password"]);
		
			return $post_array;
		});
		
		$selected = "Users";

        $output = $crud->render();			
		$output->accessLevel = $accessLevel;
        $this->_render_output($output);     
    }
	
	public function labels() {
	
		$addresses = $this->address->getAddresses();

		$this->pdf_label->AddPage();		
		
		// Print labels
		foreach($addresses as $address) {
			$text = sprintf("%s\n%s\n%s\n%s %s %s", $address->printname, $address->addressline1, $address->addressline2, $address->addressline3, $address->addressline4, $address->postcode);
			$this->pdf_label->Add_Label($text);
		}

		$this->pdf_label->Output();		
	}
	
	function _render_output($output = null)
    {
        $this->load->view('theatre_table_template.php',$output);    
    }
}

 