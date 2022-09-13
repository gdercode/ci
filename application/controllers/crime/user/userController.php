<?php
class UserController extends CI_Controller		 												 		// UserController
{

	public function __construct()																			// constructor
 	{
	 	parent::__construct();  																		// for parent class
	 	$this->load->database();																		// for database
	 	$this->load->helper(array('form','url','gderfileupload'));													// for url and form
	 	$this->load->library(array('form_validation'));												// for form validation  
	 	$this->load->model('crime/crime_model','crimeManager');								// for model with an other name

	 	$needed = $this->session->userdata('adminpagePermit');
		$this->check_admin_page_permit($needed);
	}

//--------------------------------------------------------------------------------------------------------------------------------------

	private function check_admin_page_permit($need)
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

//------------------------------------------------------------------------------------------------------------------------------------

	public function index() 
	{
		$this->welcome();													// go to welcome function down below
	}

//-----------------------------------------------------------------------------------------------------------------------------------

	private function welcome() 													// private function for user page
	{
		$this->load->view('crime/pages/user/user_page');							// load a user page 
	}
//--------------------------------------------------------------------------------------------------------------------------------------


//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

	public function users_list_c()
	{
		$data['all_user']=$this->crimeManager->get_all_user(); 									// for come back to list page

		$this->load->view('crime/pages/user/user_list_page',$data); 				 // go to the user_list_page with data array of all users
	}	

//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------

	public function roles_list_c()
	{
		$data['all_role']=$this->crimeManager->get_all_role(); 									// for come back to list page

		$this->load->view('crime/pages/user/role_list_page',$data); 				 // go to the user_list_page with data array of all users
	}	

//--------------------------------------------------------------------------------------------------------------------------------------

	public function users_find_list_c()
	{
		$data['allRolles'] = $this->crimeManager->get_all_role();          // for roles
		$user_id = htmlspecialchars( $this->input->post('reg_id'));
		$data['the_user'] = $this->crimeManager->get_user_id($user_id); 		 
 		$data['all_user']=$this->crimeManager->get_all_user();

		if(empty( $data['the_user'] ))						// no user existance, then we have to give back a message
		{
		 	$data['error']="No user found"; 
		 	$this->load->view('crime/pages/user/user_list_page',$data);  // go to the user_list_page with data array of all users
		}
		else 																// user exist							
		{
			$this->load->view('crime/pages/user/manipulate_user_page',$data);  			// go to the manipulate_user page with data
		}
	}

//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------

	public function role_find_list_c()
	{
		$role_id = htmlspecialchars( $this->input->post('role_id'));
		$data['the_role'] = $this->crimeManager->get_role_id($role_id); 		
			$data['all_role']=$this->crimeManager->get_all_role();

		if(empty( $data['the_role'] ))						// no role existance, then we have to give back a message
		{
		 	$data['error']="No role found"; 
		 	$this->load->view('crime/pages/user/role_list_page',$data);  // go to the role_list_page with data array of all users
		}
		else 																// role exist							
		{
			$this->load->view('crime/pages/user/manipulate_role_page',$data);  			// go to the manipulate_role page with data
		}
	}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

	public function browse_user_c() 																// browse_user
	{
		$data['allRolles'] = $this->crimeManager->get_all_role();

		$this->form_validation->set_rules('username', 'User Name', 'trim|required|min_length[1]|max_length[12]'); // rules for username;

        if ($this->form_validation->run() == FALSE) 													// if validation fail
        {
            $this->load->view('crime/pages/user/browse_user_page',$data); 				 // go back to the browse_user_page page with data
        }
        else 																								// if yes 
        {
			$username = htmlspecialchars( $this->input->post('username') ); 					// remove tags for security

         	// check the existance of username
			$data['the_user'] = $this->crimeManager->get_user($username);  						// get all of User by username

			if(empty( $data['the_user'] ))						// no user existance, then we have to give back a message
			{
				$data['error']="No user found"; 										// set a error message
			 	$this->load->view('crime/pages/user/browse_user_page',$data);	 // return to browse_user_page with error or success message
			}
			else 																// user exist							
			{
				$this->load->view('crime/pages/user/manipulate_user_page',$data);  			// go to the manipulate_user page with data
			}
        }
	}

//--------------------------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------------------------

	public function manipulate_user_c()
	{
		$data['allRolles'] = $this->crimeManager->get_all_role();
		
		if ($this->input->post('update_button'))
		{
			// set form rules

			$this->form_validation->set_rules('reg_firstname', 'First Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
			$this->form_validation->set_rules('reg_lastname', 'Last Name', 'trim|alpha_numeric|required|min_length[2]|max_length[12]');  
			$this->form_validation->set_rules('reg_username', 'Username', 'trim|required|min_length[4]|max_length[12]');  
	        $this->form_validation->set_rules('reg_email', 'Email', 'trim|required|valid_email'); 								
			$this->form_validation->set_rules('reg_password', 'Password', 'trim|min_length[8]'); 		
	        $this->form_validation->set_rules('reg_mobile', 'Mobile', 'trim|required|regex_match[/^\+(?:[0-9] ?){6,14}[0-9]$/]');  

			// remove tags for security
			$user_id=htmlspecialchars( $this->input->post('reg_id') );
			$firstname=htmlspecialchars( $this->input->post('reg_firstname') );
			$lastname=htmlspecialchars( $this->input->post('reg_lastname') );
			$username=htmlspecialchars( $this->input->post('reg_username') );
			$email=htmlspecialchars( $this->input->post('reg_email') );
			$mobile=htmlspecialchars( $this->input->post('reg_mobile') ); 

			$password = !empty( $this->input->post('reg_password') ) ? htmlspecialchars( $this->input->post('reg_password') ) : '';

			$role_id_form = htmlspecialchars( $this->input->post('role_name_selection') ); 
			$role_id = $role_id_form;

			// set the data array needed on the manupilate user page ( form )
			$data['the_user'] = array(
							'user_id' => $user_id,
							'user_first_name' => $firstname,
							'user_last_name' => $lastname,
							'username' => $username,
							'user_email' => $email,
							'user_password' => $password,
							'user_mobile' => $mobile,
							'user_role_id' => $role_id
						);
 
	        if ($this->form_validation->run() == FALSE) 												// if validation fail
	        {
	        	$data['error']="Recheck Your form"; 
	        }
	        else 		// if yes 
	        {
	        	$user =  $this->crimeManager->get_user_id($user_id);  						// get a User by id

	        	if (empty($user)) 
	        	{
	        		$data['error']="No user found"; 										// set a error message
	        	}
	        	else
	        	{
					if (empty($password))									// no password set from form
					{
						
						
						$data['pass_message']=" password hasn't been changed "; 				// set a message for password field 

						if ($role_id_form == 'none')
						{
							//update a user without password and role
							$data['select_error'] = "Role hasn't been changed";
							$this->crimeManager->update_user_no_password_and_role($user_id,$firstname,$lastname,$email,$mobile,$username); 
							$data['error']="User updated successfully"; 							// set a success message
						}
						else
						{
							//update a user without password
							$this->crimeManager->update_user_no_password($user_id,$firstname,$lastname,$email,$mobile,$username,$role_id); 
							$data['error']="User updated successfully"; 							// set a success message
						}
						


					}
					else
					{
						$hashed_pass = password_hash($password, PASSWORD_DEFAULT);  			// encrypt password for security

						if ($role_id_form == 'none')
						{
							//update a user without role
							$data['select_error'] = "Role hasn't been changed";
							$this->crimeManager->update_user_no_role($user_id,$firstname,$lastname,$email,$mobile,$username,$hashed_pass);
							$data['error']="User updated successfully"; 							// set a success message
						}
						else
						{
							// update user all fields
							$this->crimeManager->update_user($user_id,$firstname,$lastname,$email,$mobile,$username,$hashed_pass,$role_id);
							$data['error']="User updated successfully"; 							// set a success message
						}
						
					}
				}
	        }
		}
		elseif ($this->input->post('delete_button'))
		{
			$user_id=htmlspecialchars( $this->input->post('reg_id') );

			$user =  $this->crimeManager->get_user_id($user_id);  						// get a User by id
			if (empty($user)) 
	        {
	        	$data['error']="No user found"; 										// set a error message
	        }
	        else
	        {
	        	$this->crimeManager->delete_user($user_id); 							// delete a user
				$data['error']="User Deleted successfully"; 					// set a success message
			}
		}
		elseif ($this->input->post('photo_button'))
		{
			$user_id=htmlspecialchars( $this->input->post('reg_id') );

			$user =  $this->crimeManager->get_user_id($user_id);  						// get a User by id
			if (empty($user)) 
	        {
	        	$data['error']="No user found"; 										// set a error message
	        }
	        else
	        {
	        	// go to the page of taking a picture
	        	$data['username']=$user['username']; 
	        	$imgPath = 'assets/images/users/'.$user['username'];
				
				if (!is_dir($imgPath)) 
				{
					mkdir($imgPath);
				}
				 
		        $this->load->view('crime/pages/user/user_photo_page',$data);
		        return;
			}
		}
		$this->load->view('crime/pages/user/manipulate_user_page',$data);			// go back to manipulate_user page with data
	}



//-----------------------------------------------------------------------------------------------------------------------------------

public function manipulate_role_c()
	{
		if ($this->input->post('update_button'))
		{
			// set form rules

			$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
			$this->form_validation->set_rules('role_percentage', 'Role Percentage', 'trim|numeric|required|min_length[2]|max_length[12]');  

			// remove tags for security
			$role_id=htmlspecialchars( $this->input->post('role_id') );
			$role_name=htmlspecialchars( $this->input->post('role_name') );
			$role_percentage=htmlspecialchars( $this->input->post('role_percentage') );

			// set the data array needed on the manupilate role page ( form )
	        $data['the_role'] = array(
	        							'role_id' => $role_id,
	        							'role_name' => $role_name,
        								'role_percentage' => $role_percentage
        							);

	        if ($this->form_validation->run() == FALSE) 												// if validation fail
	        {
	        	$data['error']="Recheck Your form"; 
	        }
	        else 				// if yes 
	        {
	        	$role =  $this->crimeManager->get_role_id($role_id);  						// get a role by id

	        	if (empty($role)) 
	        	{
	        		$data['error']="No Role found"; 										// set a error message
	//			 	$this->load->view('crime/pages/user/browse_role_page',$data); // return to browse_role_page with error or success message
	        	}
	        	else
	        	{
					//update a role
					$this->crimeManager->update_role($role_id,$role_name,$role_percentage); 
					$data['error']="Role updated successfully"; 							// set a success message
				}
	        }
		}
		elseif ($this->input->post('delete_button'))
		{
			$role_id=htmlspecialchars( $this->input->post('role_id') );

			$role =  $this->crimeManager->get_role_id($role_id);  						// get a role by id
			if (empty($role)) 
	        {
	        	$data['error']="No role found"; 										// set a error message
	        }
	        else
	        {
	        	$this->crimeManager->delete_role($role_id); 							// delete a role
				$data['error']="role Deleted successfully"; 					// set a success message
			}
		}
		
		$this->load->view('crime/pages/user/manipulate_role_page',$data);
	}

	private function load_user_photo_page()
	{
		$this->load->view('crime/pages/user/manipulate_role_page',$data); // return to browse_user_page with error 
	}

//-----------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------

	public function img_upload_c()
	{
		$wanted_id = htmlspecialchars( $this->input->post('wanted_id') );
		$obj_sending_name='image';
		$folderPath = 'assets/images/users/'.$wanted_id.'/';
		$tobe_saved_name = htmlspecialchars( $this->input->post('imgName') );

		if (is_file($folderPath.''.$tobe_saved_name.'.jpg')) 
		{
			unlink($folderPath.''.$tobe_saved_name.'.jpg');
		}

		$image_new = fileuploadCI($obj_sending_name,$folderPath,$tobe_saved_name);
	
	 	$data['the_wanted'] = $this->crimeManager->get_wanted_id($wanted_id); 
		$this->load->view('crime/pages/user/wanted_photo_page',$data); // return to the page
		return;

	}

//-----------------------------------------------------------------------------------------------------------------------------------
	public function add_user_c() 											// add a new user
	{
		$data['allRolles'] = $this->crimeManager->get_all_role();
		// set rules for form validation 
			
		$this->form_validation->set_rules('reg_firstname', 'First Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
		$this->form_validation->set_rules('reg_lastname', 'Last Name', 'trim|alpha_numeric|required|min_length[2]|max_length[12]');  
		$this->form_validation->set_rules('reg_username', 'Username', 'trim|required|min_length[4]|max_length[12]');  
        $this->form_validation->set_rules('reg_email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('reg_password', 'Password', 'trim|required|min_length[8]'); 
        $this->form_validation->set_rules('reg_conf_password', 'Password Confirmation', 'trim|required|matches[reg_password]'); 
        $this->form_validation->set_rules('reg_mobile', 'Mobile', 'trim|required|regex_match[/^\+(?:[0-9] ?){6,14}[0-9]$/]');

        if ($this->form_validation->run() == FALSE) 									// if validation fail
        {
        	// nothing to do you will go back to the form
        }
        else 																				// if yes 
        {
         	// remove tags for security
			$firstname=htmlspecialchars( $this->input->post('reg_firstname') );
			$lastname=htmlspecialchars( $this->input->post('reg_lastname') );
			$username=htmlspecialchars( $this->input->post('reg_username') );
			$email=htmlspecialchars( $this->input->post('reg_email') );
			$password=htmlspecialchars( $this->input->post('reg_password') );
			$mobile=htmlspecialchars( $this->input->post('reg_mobile') ); 
			$role_id_form = htmlspecialchars( $this->input->post('role_name_selection') ); 

			if ($role_id_form == 'none')
			{
				$data['select_error'] = "Select User Role";
			}
			else
			{
				$role_id = $role_id_form;


				// check the existance of the username or email
				$row=$this->crimeManager->get_user($username);  // get user with this username
				
				$row_two=$this->crimeManager->get_user_email($email); // get user with this email

				$row_three=$this->crimeManager->get_user_phone($mobile); // get user with this email

				if($row) // username exist
				{
					// we have to give error message for user existance
					$data['error']="This username already exists";
				}
				elseif($row_two) // email exist
				{
					// we have to give error message for email existance
					$data['error']="This Email already exists";
				}
				elseif($row_three) // phone exist
				{
					// we have to give error message for phone existance
					$data['error']="This Phone number already exists";
				}
				else // no username or email or phone existance, then we have to register new user
				{
					$hashed_pass = password_hash($password, PASSWORD_DEFAULT);  // encrypt password for security
					$this->crimeManager->insert_users($firstname,$lastname,$email,$mobile,$username,$hashed_pass,$role_id); // register a user
					$data['error']="A User account created successfully"; 												// set a success message
				}	
			}
			
			
        }
        $this->load->view('crime/pages/user/registration_page',$data);	 // return to registration page with error or success message
	}

//------------------------------------------------------------------------------------------------------------------------------------

	public function add_role_c() 											// add a new role
	{

			// set rules for form validation 
			$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|alpha_numeric|min_length[1]|max_length[12]'); 
			$this->form_validation->set_rules('role_percentage', 'Role Percentage', 'trim|required|numeric|min_length[2]|max_length[12]'); 

	        if ($this->form_validation->run() == FALSE)								 // if validation fail
	        {
	        	$data['error'] = ''; // nothing to do , you will go back to the form 
	        }
	        else    			// if yes 
	        {
		         	// remove tags for security
				$role_name=htmlspecialchars( $this->input->post('role_name') );
				$role_percentage=htmlspecialchars( $this->input->post('role_percentage') );

				// check the existance of the role_name
				$row=$this->crimeManager->get_role($role_name);  // get role with this roleId

				if(empty($row)) // no Role existance, then we have to create a new role
				{
					$this->crimeManager->insert_role($role_name,$role_percentage); // insert a new role
					$data['error']="A New Role created successfully"; // set a success message
				}
				else // role ID exist
				{
					// we have to give error message for role existance
					$data['error']="This Role already exists";
				}	
				
	        }
	        $this->load->view('crime/pages/user/create_role_page',$data);	 // return to registration page with error or success message
	}


//------------------------------------------------------------------------------------------------------------------------------------


	public function browse_role_c() 											// browse_role
	{
		$this->form_validation->set_rules('role_name', 'Role Name', 'trim|required|min_length[1]|max_length[12]'); // rules for username;

        if ($this->form_validation->run() == FALSE) 													// if validation fail
        {
            $this->load->view('crime/pages/user/browse_role_page'); 				 // go back to the browse_role_page with data
        }
        else 																								// if yes 
        {
			$role_name = htmlspecialchars( $this->input->post('role_name') ); 					// remove tags for security

         	// check the existance of role
			$data['the_role'] = $this->crimeManager->get_role($role_name);  						// get all of role by role_name

			if(empty( $data['the_role'] ))						// no role existance, then we have to give back a message
			{
				$data['error']="No role found"; 										// set a error message
			 	$this->load->view('crime/pages/user/browse_role_page',$data);	 // return to browse_user_page with error or success message
			}
			else 																// role exist							
			{
				$this->load->view('crime/pages/user/manipulate_role_page',$data);  			// go to the manipulate_user page with data
			}
        }
	}


//----------------------------------------------------------------------------------------------------------------------------------------

									// FOR WANTED
//-------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------

	public function add_wanted_c() 											// add a new course
	{
		$this->form_validation->set_rules('wanted_first_name', 'First Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
		$this->form_validation->set_rules('wanted_last_name', 'Last Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
		$this->form_validation->set_rules('wanted_gender', 'Gender', 'trim|required|alpha_numeric|min_length[2]|max_length[6]'); 
		$this->form_validation->set_rules('wanted_age', 'Age', 'trim|required|numeric|min_length[1]|max_length[3]'); 

        if ($this->form_validation->run() == FALSE)								 // if validation fail
        {
        	$data['error'] = ''; // nothing to do 
        }
        else    			// if yes 
        {
	         	// remove tags for security
			$wanted_first_name=htmlspecialchars( $this->input->post('wanted_first_name') );
			$wanted_last_name=htmlspecialchars( $this->input->post('wanted_last_name') );
			$wanted_gender=htmlspecialchars( $this->input->post('wanted_gender') );
			$wanted_age=htmlspecialchars( $this->input->post('wanted_age') );

		// check the existance of wanted person
			$row=$this->crimeManager->check_wanted_exist($wanted_first_name,$wanted_last_name);  
			$rows=$this->crimeManager->check_wanted_exist($wanted_last_name,$wanted_first_name);
			if(empty($row) AND empty($rows)) 
			{
				$this->crimeManager->insert_wanted($wanted_first_name,$wanted_last_name,$wanted_gender,$wanted_age);
				$data['error']="recorded successfully"; // set a success message
			}
			else
			{
				$data['error']="This Person already exists";
			}
			
        }
        $this->load->view('crime/pages/user/create_crime_page',$data);	 // return to course registration page with error or success message
	}

//-------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------

	public function browse_wanted_c() 			// browse_wanted
	{
		$this->form_validation->set_rules('wanted_first_name', 'First Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
		$this->form_validation->set_rules('wanted_last_name', 'Last Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 

        if ($this->form_validation->run() == FALSE) 			// if validation fail
        {
            $this->load->view('crime/pages/user/browse_wanted_page');
        }
        else 																								
        {
			$wanted_first_name = htmlspecialchars( $this->input->post('wanted_first_name') ); 
			$wanted_last_name = htmlspecialchars( $this->input->post('wanted_last_name') ); 


			$the_wanted= $this->crimeManager->check_wanted_exist($wanted_first_name,$wanted_last_name); 
			$the_wanted2= $this->crimeManager->check_wanted_exist($wanted_last_name,$wanted_first_name);  

			if(empty($the_wanted) AND empty($the_wanted2))
			{
				$data['error']="No Person found"; 			// set a error message
			 	$this->load->view('crime/pages/user/browse_wanted_page',$data);	
			}
			else 	
			{
				if(!empty($the_wanted))
				{
					$data['the_wanted'] = $the_wanted;
				}

				if(!empty($the_wanted2))
				{
					$data['the_wanted'] = $the_wanted2;
				}
				
				$this->load->view('crime/pages/user/manipulate_wanted_page',$data); 
			}
        }
	}

//-----------------------------------------------------------------------------------------------------------------------------------

public function manipulate_wanted_c()
	{
		if ($this->input->post('update_button'))
		{
			// set form rules

			$this->form_validation->set_rules('wanted_first_name', 'First Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
		$this->form_validation->set_rules('wanted_last_name', 'Last Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
		$this->form_validation->set_rules('wanted_gender', 'Gender', 'trim|required|alpha_numeric|min_length[2]|max_length[6]'); 
		$this->form_validation->set_rules('wanted_age', 'Age', 'trim|required|numeric|min_length[1]|max_length[3]'); 

			// remove tags for security
			$wanted_id=htmlspecialchars( $this->input->post('wanted_id') );
			$wanted_first_name=htmlspecialchars( $this->input->post('wanted_first_name') );
			$wanted_last_name=htmlspecialchars( $this->input->post('wanted_last_name') );
			$wanted_gender=htmlspecialchars( $this->input->post('wanted_gender') );
			$wanted_age=htmlspecialchars( $this->input->post('wanted_age') );


			// set the data array needed on the manupilate course page ( form )
	        $data['the_wanted'] = array('wanted_id' => $wanted_id,
	        							'wanted_first_name' => $wanted_first_name,
	        							'wanted_last_name' => $wanted_last_name,
	        							'wanted_gender' => $wanted_gender,
        								'wanted_age' => $wanted_age
        							);

	        if ($this->form_validation->run() == FALSE) 												// if validation fail
	        {
	        	$data['error']="Recheck Your form"; 
	        }
	        else 				// if yes 
	        {
				$row=$this->crimeManager->check_wanted_exist($wanted_first_name,$wanted_last_name);  
				$rows=$this->crimeManager->check_wanted_exist($wanted_last_name,$wanted_first_name);

	        	if (empty($row) AND empty($rows)) 
	        	{
	        		$data['error']="No Person found"; 										// set an error message
	        	}
	        	else
	        	{
					//update wanted

					if (!empty($row))
					{
						$this->crimeManager->update_wanted($row['wanted_id'],$wanted_first_name,$wanted_last_name,$wanted_gender,$wanted_age); 
					}
					if (!empty($rows))
					{
						$this->crimeManager->update_wanted($rows['wanted_id'],$wanted_last_name,$wanted_first_name,$wanted_gender,$wanted_age); 
					}
					$data['error']="Record updated successfully"; 
				}
	        }
	        $this->load->view('crime/pages/user/manipulate_wanted_page',$data);
		}
		elseif ($this->input->post('delete_button'))
		{
			$wanted_first_name=htmlspecialchars( $this->input->post('wanted_first_name') );
			$wanted_last_name=htmlspecialchars( $this->input->post('wanted_last_name') );

			$row=$this->crimeManager->check_wanted_exist($wanted_first_name,$wanted_last_name);  
			$rows=$this->crimeManager->check_wanted_exist($wanted_last_name,$wanted_first_name);

        	if (empty($row) AND empty($rows)) 
        	{
        		$data['error']="No Person found"; 										// set an error message
        	}
        	else
        	{
        		//delete wanted

				if (!empty($row))
				{
					$this->crimeManager->delete_wanted($wanted_first_name,$wanted_last_name); 
				}
				if (!empty($rows))
				{
					$this->crimeManager->delete_wanted($wanted_last_name,$wanted_first_name);
				}
				$data['error']="Record Deleted successfully"; 		// set a success message
			}
			$this->load->view('crime/pages/user/manipulate_wanted_page',$data);
		}
		elseif ($this->input->post('image_button'))
		{
			$wanted_first_name=htmlspecialchars( $this->input->post('wanted_first_name') );
			$wanted_last_name=htmlspecialchars( $this->input->post('wanted_last_name') );

			$row=$this->crimeManager->check_wanted_exist($wanted_first_name,$wanted_last_name);  
			$rows=$this->crimeManager->check_wanted_exist($wanted_last_name,$wanted_first_name);

        	if (empty($row) AND empty($rows)) 
        	{
        		$data['error']="No Person found"; 										// set an error message
        	}
        	else
        	{
				if (!empty($row))
				{
					$wanted_id=$row['wanted_id'];
					$folderPath = 'assets/images/users/'.$wanted_id.'/';
					if (!is_dir($folderPath)) 
					{
						mkdir($folderPath);
					}
					$data['the_wanted'] = $row;
				}

				if (!empty($rows))
				{
					$wanted_id=$rows['wanted_id'];
					$folderPath = 'assets/images/users/'.$wanted_id.'/';
					if (!is_dir($folderPath)) 
					{
						mkdir($folderPath);
					}
					$data['the_wanted'] = $rows;
				}
				// $data['error']="Record Deleted successfully"; 		// set a success message
			}
			$this->load->view('crime/pages/user/wanted_photo_page',$data);
		}
		

	}

//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

	public function wanted_list_c()
	{
		$data['all_wanted']=$this->crimeManager->get_all_wanted(); 		
		if (empty($data['all_wanted']))
		{
			$data['error'] = 'There is no Person found. ';
		}
		$this->load->view('crime/pages/user/wanted_list_page',$data); 
	}


//-----------------------------------------------------------------------------------------------------------------------------------

	public function wanted_find_list_c()
	{
		$wanted_id = htmlspecialchars( $this->input->post('wanted_id'));
		$data['the_wanted'] = $this->crimeManager->get_wanted_id($wanted_id); 		

		if(empty( $data['the_wanted'] ))		
		{
			$data['error']="No Person found"; 
			$data['all_wanted']=$this->crimeManager->get_all_wanted();
		 	$this->load->view('crime/pages/user/wanted_list_page',$data); 
		}
		else 	
		{
			$this->load->view('crime/pages/user/manipulate_wanted_page',$data);  		
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

	public function wanted_find_list_c2()
	{
		$wanted_id = htmlspecialchars( $this->input->post('wanted_id'));
		$data['the_wanted'] = $this->crimeManager->get_wanted_id($wanted_id); 		

		if(empty( $data['the_wanted'] ))		
		{
			$data['error']="No Person found"; 
			$data['all_wanted']=$this->crimeManager->get_all_wanted();
		 	$this->load->view('crime/pages/user/testimony_page',$data); 
		}
		else 	
		{
			$data['the_wanted_testimonies'] = $this->crimeManager->get_wanted_testimonies($wanted_id); 
			$this->load->view('crime/pages/user/record_testimony_page',$data);  		
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------

	public function add_testimony_c() 											// add a new role
	{
		$user_details = $this->session->userdata('user_details');	
		$wanted_id=htmlspecialchars( $this->input->post('wanted_id') );
		$testimony_area=htmlspecialchars( $this->input->post('testimony_area') );
 
		$data['the_wanted'] = $this->crimeManager->get_wanted_id($wanted_id); 

			// set rules for form validation
			$this->form_validation->set_rules('testimony_area', 'Testimony', 'trim|required|min_length[1]'); 
	        if ($this->form_validation->run() == FALSE)								 // if validation fail
	        {
	        	$data['error'] = ''; // nothing to do
	        }
	        else    			// if yes 
	        {
				if(!empty($data['the_wanted']))
				{
					$this->crimeManager->insert_testimony($user_details['user_id'],$wanted_id, $testimony_area); 
					$data['error']="Testimony added successfully"; // set a success message
				}
				else 
				{
					$data['error']="No wanted found";
				}	
	        }
	        $data['the_wanted_testimonies'] = $this->crimeManager->get_wanted_testimonies($wanted_id);
	        $this->load->view('crime/pages/user/record_testimony_page',$data);	
	}


//------------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

//===========================================================================================================================================

}
?>