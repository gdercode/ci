<?php
class Crime_identification_Controller extends CI_Controller										// Course controller
{
	public function __construct()										// constructor
 	{
	 	parent::__construct();  										// for parent class
	 	$this->load->database();										// for database
	 	$this->load->helper(array('form','url'));						// for url and form
	 	$this->load->library(array('form_validation'));					// for form validation  	
	 	$this->load->model('crime/Crime_model','crimeManager');
	 	$this->session->set_userdata('crimeCreatePermit', '70');

	 	$needed = $this->session->userdata('crimepagePermit');
		$this->check_crime_page_permit($needed);

	 }

//-------------------------------------------------------------------------------------------------------------------------------

	private function check_crime_page_permit($need)
	{
		$permit = $this->session->userdata('permit');									// keep in variable permit session
		$needed = $need;																// keep in variable needed permit session
		if (!$permit)     																	// if there is no permit session 
		{
			redirect('crime/crimeController/logout_c');										// go back to logout controller 
		}
		elseif ($permit<$needed)										// if permit session is there but less than the needed
		{
			redirect('crime/crimeController/home_c');								// go back to homepage controller 	
		}
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	private function check_crime_create_permit()
	{
		$permit = $this->session->userdata('permit');
		$needed = $this->session->userdata('crimeCreatePermit');
		
		if ($permit>=$needed)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

//--------------------------------------------------------------------------------------------------------------------------------

	public function index() // chech for permitions
	{
		$this->welcome("");											// go to welcome function down below
	}

//--------------------------------------------------------------------------------------------------------------------------------

	private function welcome($welcome_error) 
	{
		$data['all_wanted_ids']=$this->crimeManager->get_all_wanted_ids(); 	
		$data['welcome_error']=$welcome_error;

		$this->load->view('crime/pages/face_recognition_page',$data);

		return ;
	}

//-----------------------------------------------------------------------------------------------------------------------------------

//=================================================================================================================================
	
}
?>