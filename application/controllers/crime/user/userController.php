<?php
class UserController extends CI_Controller														 		// UserController
{

	public function __construct()																			// constructor
 	{
	 	parent::__construct();  																		// for parent class
	 	$this->load->database();																		// for database
	 	$this->load->helper(array('form','url'));													// for url and form
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
/*
	public function roles_list_c()
	{
		$data['all_role']=$this->crimeManager->get_all_role(); 									// for come back to list page

		$this->load->view('crime/pages/user/role_list_page',$data); 				 // go to the user_list_page with data array of all users
	}	
*/
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
/*
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
*/
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
		
		$this->load_user_photo_page();
	}

	private function load_user_photo_page()
	{
		$this->load->view('crime/pages/user/manipulate_role_page',$data); // return to browse_user_page with error 
	}

//-----------------------------------------------------------------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------------------------------------------------------
/*
	public function img_upload_c()
	{
	    $username = htmlspecialchars( $this->input->post('username') );
	    $img = htmlspecialchars( $this->input->post('image') );
	    $name = htmlspecialchars( $this->input->post('imgName') );
		
		$img_name = $name . '.jpg';
		$folderPath = 'assets/images/users/'.$username.'/';
		  
	    $fetch_imgParts = explode(";base64,", $img);
	    $image_type_aux = explode("image/", $fetch_imgParts[0]);
	    $image_type = $image_type_aux[1];
	    $image_base64 = base64_decode($fetch_imgParts[1]);  
	    $file = $folderPath .'/'.$img_name;
	    file_put_contents($file, $image_base64);
	 
	 	$data['username'] = $username;
		$this->load->view('crime/pages/user/user_photo_page',$data); // return to the page
		return;

	}
*/
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
/*
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

*/
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

									// FOR COURSE
//-------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------
/*
	public function add_course_c() 											// add a new course
	{

			// set rules for form validation 
			$this->form_validation->set_rules('module_id', 'Module ID', 'trim|required|min_length[1]|max_length[10]'); 
			$this->form_validation->set_rules('module_name', 'Course Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
			$this->form_validation->set_rules('module_credit', 'Course Credit', 'trim|required|numeric|min_length[1]|max_length[2]'); 

	        if ($this->form_validation->run() == FALSE)								 // if validation fail
	        {
	        	$data['error'] = ''; // nothing to do , you will go back to the form 
	        }
	        else    			// if yes 
	        {
		         	// remove tags for security
				$module_id=htmlspecialchars( $this->input->post('module_id') );
				$module_name=htmlspecialchars( $this->input->post('module_name') );
				$module_credit=htmlspecialchars( $this->input->post('module_credit') );

				// check the existance of the module id
				$row=$this->crimeManager->get_course($module_id);  // get course with this course id

				if(empty($row)) // no course existance, then we have to create a new course
				{
					$this->crimeManager->insert_course($module_id,$module_name,$module_credit); // insert a new course
					$data['error']="A New Course created successfully"; // set a success message
				}
				else // Course ID exist
				{
					// we have to give error message for course existance
					$data['error']="This Module ID already exists";
				}	
				
	        }
	        $this->load->view('crime/pages/user/create_course_page',$data);	 // return to course registration page with error or success message
	}

//-------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------------------

	public function browse_course_c() 											// browse_course
	{
		$this->form_validation->set_rules('module_id', 'Module ID', 'trim|required|min_length[1]|max_length[12]'); // rules for module ID;

        if ($this->form_validation->run() == FALSE) 													// if validation fail
        {
            $this->load->view('crime/pages/user/browse_course_page'); 				 // go back to the browse_course_page with data
        }
        else 																								// if yes 
        {
			$module_id = htmlspecialchars( $this->input->post('module_id') ); 					// remove tags for security

         	// check the existance of course
			$data['the_course'] = $this->crimeManager->get_course($module_id);  						// get all of courses by course ID

			if(empty( $data['the_course'] ))						// no course existance, then we have to give back a message
			{
				$data['error']="No Course found"; 										// set a error message
			 	$this->load->view('crime/pages/user/browse_course_page',$data);	 // return to browse_course_page with error or success message
			}
			else 																// course exist							
			{
				$this->load->view('crime/pages/user/manipulate_course_page',$data);  			// go to the manipulate_user page with data
			}
        }
	}

//-----------------------------------------------------------------------------------------------------------------------------------

public function manipulate_course_c()
	{
		if ($this->input->post('update_button'))
		{
			// set form rules

			$this->form_validation->set_rules('module_id', 'Course ID', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
			$this->form_validation->set_rules('module_name', 'Course Name', 'trim|required|alpha_numeric|min_length[2]|max_length[12]'); 
			$this->form_validation->set_rules('module_credit', 'Course Credit', 'trim|numeric|required|min_length[1]|max_length[4]');  

			// remove tags for security
			$module_id=htmlspecialchars( $this->input->post('module_id') );
			$module_name=htmlspecialchars( $this->input->post('module_name') );
			$module_credit=htmlspecialchars( $this->input->post('module_credit') );

			// set the data array needed on the manupilate course page ( form )
	        $data['the_course'] = array(
	        							'module_id' => $module_id,
	        							'module_name' => $module_name,
        								'module_credit' => $module_credit
        							);

	        if ($this->form_validation->run() == FALSE) 												// if validation fail
	        {
	        	$data['error']="Recheck Your form"; 
	        }
	        else 				// if yes 
	        {
	        	$course =  $this->crimeManager->get_course_id($module_id);  						// get a course by id

	        	if (empty($course)) 
	        	{
	        		$data['error']="No course found"; 										// set an error message
	        	}
	        	else
	        	{
					//update a course
					$this->crimeManager->update_course($module_id,$module_name,$module_credit); 
					$data['error']="Course updated successfully"; 							// set a success message
				}
	        }
		}
		elseif ($this->input->post('delete_button'))
		{
			$module_id=htmlspecialchars( $this->input->post('module_id') );

			$course =  $this->crimeManager->get_course_id($module_id);  						// get a course by id
			if (empty($course)) 
	        {
	        	$data['error']="No Course found"; 										// set an error message
	        }
	        else
	        {
	        	$this->crimeManager->delete_course($module_id); 							// delete a course
				$data['error']="Course Deleted successfully"; 					// set a success message
			}
		}
		$this->load->view('crime/pages/user/manipulate_course_page',$data); // return to browse_course_page with error 

	}

//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

	public function courses_list_c()
	{
		$data['all_course']=$this->crimeManager->get_all_course(); 			 						// for come back to list page
		if (empty($data['all_course']))
		{
			$data['error'] = 'There is no course found. ';
		}
		$this->load->view('crime/pages/user/course_list_page',$data); 				 // go to the course_list_page with data array of all courses
	}


//-----------------------------------------------------------------------------------------------------------------------------------

	public function course_find_list_c()
	{
		$module_id = htmlspecialchars( $this->input->post('module_id'));
		$data['the_course'] = $this->crimeManager->get_course_id($module_id); 		
			$data['all_course']=$this->crimeManager->get_all_course();

		if(empty( $data['the_course'] ))						// no course existance, then we have to give back a message
		{
		 	$data['error']="No course found"; 
		 	$this->load->view('crime/pages/user/course_list_page',$data);  // go to the course_list_page with data array of all courses
		}
		else 																// role exist							
		{
			$this->load->view('crime/pages/user/manipulate_course_page',$data);  			// go to the manipulate_course page with data
		}
	}
*/
//-----------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------

//===========================================================================================================================================

}
?>