<?php
class CrimeController extends CI_Controller  						// main controller
{
	public function __construct()									// constructor
 	{
	 	parent::__construct();  									// for parent class
	 	$this->load->database();									// for database
	 	$this->load->helper(array('form','url'));					// for url and form
	 	$this->load->library(array('form_validation'));				// for form validation  
	 	$this->load->model('crime/Crime_model','crimeManager');		// for model with an other name
	 	
	 	$this->session->set_userdata('adminpagePermit', '80');
	 	$this->session->set_userdata('crimepagePermit', '50');
	 	$this->session->set_userdata('homepagePermit', '30');

	 	$this->add_super_admin();
	}

//---------------------------------------------------------------------------------
	
// add superAdmin by default if he is not there.
	 private function add_super_admin()
	 {
	 	$firstname='superAdmin';
		$lastname= 'superAdmin';
		$username='superAdmin';
		$email='superAdmin@gmail.com';
		$password='superAdmin';
		$mobile=''; 
		$role_id='1';
		$role_name = 'superAdmin';
		$role_percentage = 100;

		$userData=$this->crimeManager->get_user($username);	// get user with this username 
		if(empty($userData)) 							//if row is empty = no username found,
		{
			$roleData = $this->crimeManager->get_role($role_name); 
			if (empty($roleData)) 
			{
				$this->crimeManager->insert_role($role_name,$role_percentage);// register a superAdmin role by default first
			}
			else
			{
				$role_id = $roleData['role_id'];
			}

			$hashed_pass = password_hash($password, PASSWORD_DEFAULT); 		// encrypt password for security
			// register superAdmin by default
			$this->crimeManager->insert_users($firstname,$lastname,$email,$mobile,$username,$hashed_pass,$role_id); 
		}
	 }

//---------------------------------------------------------------------------------

	
	private function check_home_page_permit($need)
	{
		$permit = $this->session->userdata('permit');			// keep in variable permit session
		$needed = $need;							// keep in variable needed permit session
		if (!$permit)     			// if there is no permit session 
		{
			redirect('crime/CrimeController/logout_C');			// go back to logout controller 
			return;
		}
		elseif ($permit<$needed)			// if permit session is there but less than the needed
		{
			redirect('crime/CrimeController/logout_C');			// go back to logout controller 	
			return;
		}			
	}
//-------------------------------------------------------------------------------

	public function index()  										// index function
	{
		$this->login_C(); 
		return;
	}

//--------------------------------------------------------------------------------------

	public function logout_c()  										// logout_C function
	{
		 if (session_status() === PHP_SESSION_ACTIVE) 
		 {
		  	$this->session->unset_userdata('adminpagePermit', '80');
	 		$this->session->unset_userdata('crimepagePermit', '50');
	 		$this->session->unset_userdata('homepagePermit', '30');
		 	$this->session->unset_userdata('permit');
		 	$this->session->unset_userdata('user');
		 	$this->session->unset_userdata('user_details');
		 } 
		 elseif (session_status() === PHP_SESSION_NONE) 
		 {
		  	echo "No session";
		 } 

		$this->load->view('crime/pages/logout_page');				// load a logout page 
	}

//------------------------------------------------------------------------

	public function login_C()  									// login function
	{
		$permit = $this->session->userdata('permit');	// keep in variable permit session
		if ($permit)     									// if there is permit session 
		{
			$this->home_c();							// go directly to home_c function
			return;
		}

		$this->form_validation->set_rules('log_username','Username','trim|required|min_length[4]|max_length[12]'); 		
	 	$this->form_validation->set_rules('log_password', 'Password', 'trim|required|min_length[8]'); 	// rules for password

		if ($this->form_validation->run() == FALSE)						 // if validation fail
		{
			$data['error'] = "You are not logged in";
			$this->load->view('crime/pages/login_page',$data);		// go to the login page with data
			return;
		}
		else 															//if yes
		{
			// remove tags for security
			$username=htmlspecialchars( $this->input->post('log_username') );
			$password=htmlspecialchars( $this->input->post('log_password') );

			// check the existance of a username
			$row = $this->crimeManager->get_user($username);			// get user with this username

			if(empty($row)) 										//if row is empty = no username found,
			{
				$data['error']="This user does not exist";						// we give error message
				$this->load->view('crime/pages/login_page',$data);	// go to the login page with data
				return;
			}
			else 											// if yes there is that username
			{
				$pass_from_db = $row['user_password']; 		//get user_password from database into a variable
						
				// check correct password 
				if (!password_verify($password, $pass_from_db ))	// if both password are not the same (decrypt and compare)
				{
					$data['error']="Wrong password!"; 			// error message for wrong password
					$this->load->view('crime/pages/login_page',$data);	// go to the login page with data
					return;
				}
				else 						// if passwords are the same
				{
					$userRole = $this->crimeManager->get_user_permit($username);
					$this->session->set_userdata('permit', $userRole['role_percentage']); //your permmitions in the system
					$this->session->set_userdata('user', $username);		 // set session for all pages
					$this->session->set_userdata('user_details', $userRole);	// set user details session for all pages

					$this->home_c();	 	// then you will be redireceted to home_page 
					return;
				}
			}
			return;
		}

	}

//--------------------------------------------------------------------------------
/*
	Public function face_recognition_C()         							  // homepage function
	{

		// $username=htmlspecialchars( $this->input->post($sent_user) );
		$username = $this->input->post('sent_user') ;
		$userRole = $this->crimeManager->get_user_permit($username);
		$this->session->set_userdata('permit', $userRole['role_percentage']); //your permmitions in the system
		$this->session->set_userdata('user', $username);		 // set session for all pages
		$this->session->set_userdata('user_details', $userRole);	// set user details session for all pages

		// $this->login_c();	 	// then you will be redireceted to home_page 
		// $this->load->view('crime/pages/home_page');		// load a home page 
		return;
	}
*/
//---------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------

	Public function home_C()         							  // homepage function
	{
		$needed = $this->session->userdata('homepagePermit');		// needed permit for homepage
		$this->check_home_page_permit($needed);		// check homepage permit

		$this->load->view('crime/pages/home_page');		// load a home page 
		return;
	}

//---------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------

	Public function testimony_c()         							  // homepage function
	{
		$needed = $this->session->userdata('homepagePermit');	
		$this->check_home_page_permit($needed);		
		
		$data['all_wanted']=$this->crimeManager->get_all_wanted(); 		
		if (empty($data['all_wanted']))
		{
			$data['error'] = 'There is no Person found. ';
		}
		$this->load->view('crime/pages/user/testimony_page',$data);
		return;
	}

//---------------------------------------------------------------------------------------------
	
	Public function user_pg_controller()						// user_pg_controller function
	{
		redirect('crime/user/userController');					// go to user controller
	}

//------------------------------------------------------------------------------------

	Public function crime_pg_controller()			// course_pg function
	{
		redirect('crime/crime_identification/Crime_identification_Controller');		// go to course controller
	}

//-------------------------------------------------------------------------------------------------

}

?>