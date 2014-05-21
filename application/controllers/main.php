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
		$this->load->library('PDF_Label',array('format' => 'THEATRE1'));
		$this->load->model('address','',TRUE);
		$this->load->model('totals','',TRUE);
		$this->load->model('member','',TRUE);
 
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
		
		$crud->columns('membernum','title','initials','firstname','lastname','phone','mobile','email','agegroup','addressid','Interests','expirydate','paymenttype','amountpaid','active');
		
		$crud->display_as('lastname','Last Name');
		$crud->display_as('firstname','First Name');
		$crud->display_as('phone','Phone Number');
		$crud->display_as('mobile','Mobile Number');
		$crud->display_as('agegroup','Age Group');
		$crud->display_as('expirydate','Expiry Date');
		$crud->display_as('membernum','Member Number');
		$crud->display_as('paymenttype','Pay Type');
		$crud->display_as('amountpaid','Paid');
		$crud->display_as('initials','Init');
		$crud->display_as('blacklisted','Black listed');
				
		$crud->set_relation('addressid','address','{addressline1}');
		$crud->display_as('addressid','Address');		
		$crud->set_relation_n_n('Interests','memberinterest','interest','memberid','interestid','description');
		$crud->add_fields('membernum','title','initials','firstname','lastname','phone','mobile','email','agegroup','addressid','Interests','expirydate','active');
		$crud->required_fields('firstname','lastname','agegroup','addressid','phone','title');
		
		$crud->callback_before_insert(array($this,'member_insert'));
		$crud->callback_add_field('expirydate', array($this, 'field_expirydate_add'));
		$crud->field_type('membernum', 'invisible');
		
		$crud->add_action('','/theatre/assets/uploads/general/refresh16.png','member_renew/popup','fancybox-link fancybox.ajax');
		
		
		$selected = "Members";
		
		$crud->set_css('assets/grocery_crud/css/ui/simple/jquery-ui-1.9.0.custom.min.css');
		$crud->set_js('assets/grocery_crud/js/'.grocery_CRUD::JQUERY);
		$crud->set_js('assets/grocery_crud/js/jquery_plugins/ui/'.grocery_CRUD::JQUERY_UI_JS);		
		$crud->set_css('assets/grocery_crud/themes/flexigrid/css/flexigrid.css');
		$crud->set_js('assets/grocery_crud/themes/flexigrid/js/jquery.form.js');	
		$crud->set_js('assets/grocery_crud/themes/flexigrid/js/flexigrid-add.js');
		$crud->set_css('assets/grocery_crud/css/jquery_plugins/chosen/chosen.css');
		$crud->set_js('assets/grocery_crud/js/jquery_plugins/jquery.chosen.min.js');
		$crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.chosen.config.js');		
		
		if( $crud->getState() == 'add' ) { //add these only in add form
			$crud->set_css('assets/fancybox/jquery.fancybox.css?v=2.0.6');
			$crud->set_js('assets/grocery_crud/js/jquery_plugins/config/jquery.datepicker.config.js');
			$crud->set_js('assets/fancybox/jquery.fancybox.pack.js?v=2.0.6');
		}

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
		$crud->field_type('password', 'password');	
		$crud->field_type('accesslevel', 'enum', array('1','5','100'));
		$crud->callback_before_insert(array($this,'user_insert'));
		
		$selected = "Users";

        $output = $crud->render();			
		$output->accessLevel = $accessLevel;
        $this->_render_output($output);     
    }
	
	public function labels($option) {
	
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
	
		$addresses = $this->address->getAddresses($option);

		$this->pdf_label->AddPage();		
		
		// Print labels
		foreach($addresses as $address) {
			$addressArray = array();			
			if(strlen($address->printname) > 30){
				$andPosition = strrpos($address->printname, "&");
				array_push($addressArray, substr($address->printname, 0, $andPosition));
				array_push($addressArray, substr($address->printname, $andPosition));
			} else {
				array_push($addressArray, $address->printname);
			} 
			
			if($address->housename != ""){
				array_push($addressArray, $address->housename);
			}
			if($address->addressline1 != ""){
				array_push($addressArray, $address->addressline1);
			}
			if($address->addressline2 != ""){
				array_push($addressArray, $address->addressline2);
			}
			if($address->addressline3 != ""){
				array_push($addressArray, $address->addressline3);
			}
			if($address->addressline4 != ""){
				array_push($addressArray, $address->addressline4);
			}
			
			do{
				array_push($addressArray, "");
			} while(count($addressArray) < 6);
			
			for($i=0;$i<count($addressArray);$i++){
				if($addressArray[$i] == ""){
					$addressArray[$i] = $address->postcode;
					$i = count($addressArray);
				}
			}		
			
			//$text = sprintf("%s/n%s\n%s\n%s", $line1, $line2, $line3, $line4);
			$text = sprintf("%s\n%s\n%s\n%s\n%s\n%s", $addressArray[0],$addressArray[1],$addressArray[2],$addressArray[3],$addressArray[4],$addressArray[5]);  
			$this->pdf_label->Add_Label($text);
		}

		$this->pdf_label->Output();		
	}
	
	public function paid_totals() {
		
		if($this->session->userdata('logged_in'))
	    {
	      
			$result = $this->totals->getPaidTotals();
			$html = "";
			if($result){				
				$html = '<div style="width: 200px; height: 200px; " class="popup" >';
				$html .= '<table width="100%"><tr><th align="left">Payment Type</th><th align="left">Total</th></tr>';
				foreach($result as $row){
					if($row->paymenttype != ""){
						$html .= '<tr><td align="left">'. $row->paymenttype . '</td><td align="left">' . $row->amountpaid . '</td></tr>';
					}				
				}
				$html .= '</table></div>';
			}
		
			echo $html;
		}
	}
	
	function member_insert($post_array){
		$currentYear = strftime("%Y");
		
		if(date('m') <= 7){
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
		
		$post_array["membernum"] = $currentYear . "-" . sprintf("%04d", $nextMemberNumber);
	
		return $post_array;
	}
	
	function user_insert($post_array){
		if(!empty($post_array['password'])){
			$password = $post_array["password"];
			$password = md5($password);
			$post_array["password"] = $password;
		} else {
			unset($post_array['password']);
		}
		
		return $post_array;
	}
	
	function field_expirydate_add($value = '') 
	{
		$defaultdate = '';
		if(date('m') >= 4){
			$defaultdate = '30/06/' . (date('Y') + 1);
		} else {
			$defaultdate = '30/06/' . (date('Y'));
		}			
		$value = !empty($value) ? $value : $defaultdate;
		$return = '<input id="field-expirydate" name="expirydate" type="text" value="'. $value .'" maxlength="10" class="datepicker-input" /> ';		
        $return .= '<a class="datepicker-input-clear" tabindex="-1">Clear</a> (dd/mm/yyyy)';
        return $return;
	}
	
    function _render_output($output = null)
    {
        $this->load->view('theatre_table_template.php',$output);    
    }
}