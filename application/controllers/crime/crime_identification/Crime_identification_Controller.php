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

	private function check_course_create_permit()
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
		$data['welcome_error']=$welcome_error;
		$this->load->view('crime/pages/face_recognition_page',$data);

		return ;
	}

//-----------------------------------------------------------------------------------------------------------------------------------
/*
	public function course_page_c($moduleID)
	{
		$module_id = htmlspecialchars($moduleID);
		$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
		if($this->check_course_enrolment_permit($module_id) == FALSE OR empty($courseData))
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}
		
		$allExams = $this->crimeIdentificationManager->get_all_course_exams($module_id);  // get  all exam of this course
		if (empty($allExams))
		{
			$data['examError'] = "No Exam Found";
		}

		$allQuestions = $this->crimeIdentificationManager->get_all_course_questions($module_id);  // get  all question of this course
		if (empty($allQuestions))
		{
 			$data['questionError'] = "No Question Found";
		}

		$data['courseData'] = $courseData;
		$data['allExams'] = $allExams;
		$data['allQuestions'] = $allQuestions;
		$this->load->view('crime/pages/course/course_exams_page',$data);
		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

	public function participant_page_c($moduleID)
	{
		$module_id = htmlspecialchars($moduleID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE OR empty($data['courseData']))
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		$allUserConnection = $this->crimeIdentificationManager->get_all_user_course_connection($module_id);  // get User and course connection

		if (empty($allUserConnection))
		{
			$data['error']="No User found";
		}
		else
		{
			$data['allUsers']=$allUserConnection;
		}
		$this->load->view('crime/pages/course/course_participants_page',$data);
		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

	public function enrol_users_page_c($moduleID)
	{
		$module_id = htmlspecialchars($moduleID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}
		
		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']) )
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		$this->load->view('crime/pages/course/course_enrolment_page',$data);
		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------

	public function course_brouse_participant_c($moduleID)
	{
		$module_id = htmlspecialchars($moduleID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)				// check enrolment
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}
		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))  // check permition
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}
		
		// form validation;
		$this->form_validation->set_rules('username', 'User Name', 'trim|required|min_length[1]|max_length[12]'); 
        if ($this->form_validation->run() == FALSE) 									// if validation fail
        {
            $this->load->view('crime/pages/course/course_enrolment_page',$data);
            return;
        }
        
        $username = htmlspecialchars( $this->input->post('username') ); 					// remove tags for security

     	// check the existance of username
		$data['the_user'] = $this->crimeManager->get_user_permit($username);  						// get all of User by username

		if(empty( $data['the_user'] ))						// no user existance, then we have to give back a message
		{
			$data['error']="No user found"; 										// set a error message
		}
		$this->load->view('crime/pages/course/course_enrolment_page',$data);

		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------------------------------------

	public function course_enrol_participant_c($moduleID, $userID)
	{
		$module_id = htmlspecialchars($moduleID);
		$user_id = htmlspecialchars($userID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}
		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}
     
     	// check the existance of username
		$this_user= $this->crimeManager->get_user_id($user_id);  						// get a User by id
		if(empty( $this_user ))						// no user existance, then we have to give back a message
		{
			$data['error']="No user found"; 										// set a error message
		}
		else
		{
			$userConnection= $this->crimeIdentificationManager->get_user_course_connection($user_id, $module_id);  // get User and course connection
			// insert connection

			if (empty($userConnection))
			{
				$this->crimeIdentificationManager->insert_user_course_connection($user_id, $module_id); 
				$data['error']="User enrolled successfully";
			}
			else
			{
				$data['error']="User is already enrolled into this course";
			}
		}
		$this->load->view('crime/pages/course/course_enrolment_page',$data);
		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------------

	public function user_course_remove_connection_c($moduleID, $userID)
	{
		$module_id = htmlspecialchars($moduleID);
		$user_id = htmlspecialchars($userID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		$this_user= $this->crimeManager->get_user_id($user_id);  						// get a User by id
		// get User and course connection
		$userConnection= $this->crimeIdentificationManager->get_user_course_connection($user_id, $module_id); 

		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}
		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		if(empty( $this_user ) OR empty($userConnection))		// no user existance, then we have to give back a message
		{
			$data['error']="Invalid data"; 										// set a error message
		}

			// insert connection
		$this->crimeIdentificationManager->remove_user_course_connection($user_id, $module_id); 
		$data['error']="User removed successfully";
		$data['allUsers'] = $this->crimeIdentificationManager->get_all_user_course_connection($module_id); // get all User and course connection

		$this->load->view('crime/pages/course/course_participants_page',$data);

		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------------


//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------




//===========================================================================================================================================
//==============================================================================================================================


									// FOR EXAMS
//==============================================================================================================================
//-----------------------------------------------------------------------------------------------------------------------------

	public function creat_exam_c($moduleID)
	{
		$module_id = htmlspecialchars($moduleID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		$createPermit = $this->session->userdata('createQuestionPermit');
		$userPermit = $this->session->userdata('permit');
		if ($userPermit < $createPermit ) 
		{
			$data['error'] = "Your permition do not allow you to perfom this task!";
			$this->load->view('crime/pages/course/course_page',$data);
			return;
		}

		$this->load->view('crime/pages/course/create_exam_page',$data);
		return;
	}

//---------------------------------------------------------------------------------------------------------------------------------

	public function update_exam_c( $moduleID )
	{
		$module_id = htmlspecialchars($moduleID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

   		// remove tags for security
		$exam_id = htmlspecialchars( $this->input->post('exam_id') );
		$exam_title=htmlspecialchars( $this->input->post('exam_title') );
		$exam_description = htmlspecialchars( $this->input->post('exam_description') );
		$exam_open_date=htmlspecialchars( $this->input->post('exam_open_date') );
		$exam_close_date=htmlspecialchars( $this->input->post('exam_close_date') );
		$exam_open_time=htmlspecialchars( $this->input->post('exam_open_time') );
		$exam_close_time=htmlspecialchars( $this->input->post('exam_close_time') );
		$exam_grade=htmlspecialchars( $this->input->post('exam_grade') );
		$exam_pass_grade=htmlspecialchars( $this->input->post('exam_pass_grade') );

		$this->form_validation->set_rules('exam_title', 'Exam Title', 'trim|required|min_length[2]|max_length[40]');
		$this->form_validation->set_rules('exam_description', 'Exam Description', 'trim|required'); 
		$this->form_validation->set_rules('exam_open_date', 'Open Date', 'required'); 
		$this->form_validation->set_rules('exam_close_date', 'Close Date', 'required');  
		$this->form_validation->set_rules('exam_open_time', 'Open Time', 'required'); 
		$this->form_validation->set_rules('exam_close_time', 'Close Time', 'required'); 
		$this->form_validation->set_rules('exam_grade', 'Exam Grade', 'trim|required|numeric|min_length[1]|max_length[3]'); 
		$this->form_validation->set_rules('exam_pass_grade', 'Exam Pass Grade', 'trim|required|numeric|min_length[1]|max_length[3]');  
		$startTimestamp = $exam_open_date." ".$exam_open_time;
		$endTimestamp = $exam_close_date." ".$exam_close_time;

	 	if ($this->form_validation->run() == FALSE) 												// if validation fail
	    {
	      	$data['error']="Recheck your form"; 
	      	$this->load->view('crime/pages/course/create_exam_page',$data);
	      	return;
        }
       
       	if ($endTimestamp <= $startTimestamp )
        {
        	$data['error']="Exam can not close before open time "; 
	      	$this->load->view('crime/pages/course/create_exam_page',$data);
	      	return;
        }
       
        $examData =  $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
		if (empty($examData) ) 
        {
			// insert exam
 			$this->crimeIdentificationManager->insert_exam($exam_title,$exam_description,$exam_open_date,$exam_open_time,$exam_close_date,$exam_close_time,$exam_grade,$exam_pass_grade,$module_id); 
 			$data['error']="Exam Created successfully";
 		}
 		else
 		{
 			//update a exam
			$this->crimeIdentificationManager->update_exam($exam_id,$exam_title,$exam_description,$exam_open_date,$exam_open_time,$exam_close_date,$exam_close_time,$exam_grade,$exam_pass_grade,$module_id); 
			$data['error']="Exam updated successfully"; 						// set a success message
		}

		$data['allExams'] = $this->crimeIdentificationManager->get_all_course_exams($module_id);  // get  all exam of this course
		if (empty($data['allExams']))
		{
			$data['examError'] = "No Exam Found";
		}

		$data['allQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id);  // get  all question of this course
		if (empty($data['allQuestions']))
		{
			$data['questionError'] = "No Question Found";
		}
		$this->load->view('crime/pages/course/course_exams_page',$data);

		return;
	}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------
	
	public function delete_exam_c($examID, $moduleID)
	{
		$exam_id = htmlspecialchars($examID);
		$module_id = htmlspecialchars($moduleID);

		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		$examData =  $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
		if (empty($examData)) 
        {
        	$data['error']="No Exam found"; 										// set an error message
        }
        else
        {
        	$this->crimeIdentificationManager->delete_exam($exam_id); 							// delete a exam
			$data['error']="Exam Deleted successfully"; 					// set a success message
		}

		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);

		$data['allQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id);  // get  all question of this course
		if (empty($data['allQuestions']))
		{
			$data['questionError'] = "No Question Found";
		}

		$data['allExams'] = $this->crimeIdentificationManager->get_all_course_exams($module_id);  // get  all exam of this course
		if (empty($data['allExams']))
		{
			$data['examError'] = "No Exam Found";
		}
		$this->load->view('crime/pages/course/course_exams_page',$data);
		return;
	}

//------------------------------------------------------------------------------------------------------------------------------

	public function edit_exam_c($examID, $moduleID)
	{
		$exam_id = htmlspecialchars($examID);
		$module_id = htmlspecialchars($moduleID);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		$examData =  $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
		if (empty($examData)) 
        {
        	$data['error']="No Exam found"; 										// set an error message
        }
        else
        {
        	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
        	$data['examData'] =  $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
		}
		$this->load->view('crime/pages/course/create_exam_page',$data);

		return;
	}


//-----------------------------------------------------------------------------------------------------------------------------
//*****************************************************************************************************************************

	private function wait_the_start($examID, $moduleID)
	{
		$exam_id = htmlspecialchars($examID);
		$module_id = htmlspecialchars($moduleID);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
		$examData =  $this->crimeIdentificationManager->get_exam_id($exam_id); 

		if (empty($courseData) OR empty($examData) OR $courseData['module_id'] !== $examData['course_id'] ) 
		{
			$this->welcome("Invalid selected data");
			return;
		}

        $startTimestamp = $examData['exam_open_date']." ".$examData['exam_open_time'];
		$endTimestamp = $examData['exam_close_date']." ".$examData['exam_close_time'];
		date_default_timezone_set('Africa/Kigali');
		$now = date('Y-m-d H:i:s');

		///////   -----------            GO Display result          -----------         //////////

		// $user 	 = $this->session->userdata('user_details');
		// $user_id = $user['user_id'];
		
		$data['courseData'] = $courseData;
        $data['examData'] =  $examData;

		if ($now < $startTimestamp) 
		{
			$data['error'] = ' Wait for the exam start time : '. $startTimestamp;
			$this->load->view('crime/pages/course/error_messages_page',$data);
			return;
		}
		elseif ($now > $endTimestamp)
		{
			$data['error'] = ' the exam has ended ';
			$this->load->view('crime/pages/course/error_messages_page',$data);
			return;
		}
		
	}

//****************************************************************************************************************************
//----------------------------------------------------------------------------------------------------------------------------
	
	public function exam_assign_question_c($examID, $moduleID)
	{
		$exam_id = htmlspecialchars($examID);
		$module_id = htmlspecialchars($moduleID);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}	

		$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
		$examData =  $this->crimeIdentificationManager->get_exam_id($exam_id); 

		if (empty($courseData) OR empty($examData) OR $courseData['module_id'] !== $examData['course_id'] ) 
		{
			$this->welcome("Invalid selected data");
			return;
		}

        $startTimestamp = $examData['exam_open_date']." ".$examData['exam_open_time'];
		$endTimestamp = $examData['exam_close_date']." ".$examData['exam_close_time'];

		date_default_timezone_set('Africa/Kigali');
		$now = date('Y-m-d H:i:s');

		if($this->check_course_create_permit() == FALSE AND $now < $endTimestamp )
		{
			$this->wait_the_start($exam_id, $module_id);					// wait the start of exam
		}


		///////   -----------            GO Display result          -----------         //////////

		$user 	 = $this->session->userdata('user_details');
		$user_id = $user['user_id'];
		
		$data['courseData'] = $courseData;
        $data['examData'] =  $examData;

		$allQuestions = $this->crimeIdentificationManager->get_all_exam_questions_connection($exam_id);
		if (empty($allQuestions))
		{
			$data['error'] = 'No Question Found';
		}
		else
		{
			foreach($allQuestions as $key => $question)
			{
				$data['allQuestions'] [ $question['question_id']] = [
					'question_id' => $question['question_id'],
					'question_title' => $question['question_title'],
					'question_grade' => $question['question_grade'],
					'question_category' => $question['question_category']
				];

				$data['allQuestions'] [ $question['question_id']]['choices'] = $this->crimeIdentificationManager->get_all_question_answers($question['question_id']);  // get  all choices of this question

				$user_answwer =  $this->crimeIdentificationManager->get_student_exam_connection($user_id, $exam_id, $question['question_id']); // the answer of user
				$data['allQuestions'][$question['question_id']]['user_answer'] = $user_answwer['answer'];
			}
		
			if ($now > $endTimestamp) 
			{
				$data['maximum'] = 0;

				foreach($data['allQuestions'] as $row)
				{
					$data['maximum'] += $row['question_grade'];
				}

				$allStudentExamAnswers =  $this->crimeIdentificationManager->get_all_student_exam_answers($user_id, $exam_id);
				
				if (!empty($allStudentExamAnswers)) 
				{
					foreach($allStudentExamAnswers as $row)
					{
					
						$data['student_report']['info'] = ['user_id' => $row['user_id'], 'username' => $row['username']];

						$data['student_report']['answer'][$row['question_id']]['result'] = $row['answer_grade'];

						if (empty($data['student_report']['total_result']))
						{
							$data['student_report']['total_result'] = 0;
						}
						$data['student_report']['total_result'] += $row['answer_grade'];
					}
				}
			}
			elseif ($now <= $endTimestamp AND $now >=$startTimestamp)
			{
				$data['submition'] =  $this->crimeIdentificationManager->get_user_attemption($user_id, $exam_id); 
			}
		}
		
		$this->load->view('crime/pages/course/exam_assign_question_page',$data);

// echo '<pre>';
// print_r($data['allQuestions']);
// echo '</pre>';
		return;



	}
//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------

	public function add_question_c($examID, $moduleID)
	{
		$exam_id = htmlspecialchars($examID);
		$module_id = htmlspecialchars($moduleID);
		$data['examData'] = $this->crimeIdentificationManager->get_exam_id($exam_id);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
	
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		if (empty($data['examData']))
		{
			$data['error'] = "No Exam found";
		}

		$data['allCourseQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id);  // get  all question of this course
		if (empty($data['allCourseQuestions']))
		{
			$data['questionError'] = "No Question Found";
		}
		$this->load->view('crime/pages/course/add_question_page',$data);
		return;
	}

//---------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------

	public function exam_connect_question_c()
	{

		$this->form_validation->set_rules('question_grade', 'Question Grade', 'trim|required|numeric|min_length[1]|max_length[2]');

		$module_id = htmlspecialchars( $this->input->post('course_id') );
		$question_id = htmlspecialchars( $this->input->post('question_id') );
		$exam_id = htmlspecialchars( $this->input->post('exam_id') );
		$question_grade = htmlspecialchars( $this->input->post('question_grade') );

		$this_exam= $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
		$this_question= $this->crimeIdentificationManager->get_question_id($question_id);  			// get a queestion by id
		$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE OR empty($courseData) OR empty( $this_exam ) OR empty( $this_question ))
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}
		
		if ($this->form_validation->run() == FALSE) 												// if validation fail
	    {
	    	$data['allCourseQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id); 
			if (empty($data['allCourseQuestions']))
			{
				$data['questionError'] = "No Question Found";
			}
			$data['courseData'] = $courseData;
			$data['examData'] = $this_exam;
	      	$this->load->view('crime/pages/course/add_question_page',$data);
	      	return;
        }
    
		  // get exam and question connection
		$examQuestionConnection= $this->crimeIdentificationManager->get_exam_question_connection($exam_id, $question_id);  
		// insert connection
		if (empty($examQuestionConnection))
		{
			$this->crimeIdentificationManager->insert_question_exam_connection($question_id, $exam_id, $question_grade); 
			$data['error']="Question added successfully";
		}
		else
		{
			$data['error']="Question already exists in this Exam";
		}


		// ------         FOR Display        --------// 

		// get  all question of this course
		$data['allCourseQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id); 
		if (empty($data['allCourseQuestions']))
		{
			$data['questionError'] = "No Question Found";
		}
		$data['courseData'] = $courseData;
		$data['examData'] = $this_exam;
		$this->load->view('crime/pages/course/add_question_page',$data);
		return;
	}

//------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------

public function  exam_remove_question_connection_c($moduleID, $questionID, $examID)
{
	$module_id = htmlspecialchars($moduleID);
	$question_id = htmlspecialchars($questionID);
	$exam_id = htmlspecialchars($examID);
	
	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam= $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
	$this_question= $this->crimeIdentificationManager->get_question_id($question_id);  			// get a queestion by id
	$examQuestionConnection= $this->crimeIdentificationManager->get_exam_question_connection($exam_id, $question_id);  // get exam and question connection

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
		return;
	}

	if($this->check_course_create_permit()==FALSE OR empty($data['courseData']) OR empty($examQuestionConnection) OR empty($this_exam) OR empty($this_question))
	{
		$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
		return;

	}

	// remove connection

	$this->crimeIdentificationManager->remove_exam_question_connection($exam_id, $question_id);
	$this->crimeIdentificationManager->remove_enswered_exam_question_connection($exam_id, $question_id); 
	$data['error']="Question removed successfully";

		
	///////   -----------            GO Display result          -----------         //////////

		$user 	 = $this->session->userdata('user_details');
		$user_id = $user['user_id'];

		$data['examData'] = $this_exam;
		$allQuestions = $this->crimeIdentificationManager->get_all_exam_questions_connection($exam_id);
		if (empty($allQuestions))
		{
			$data['error'] = 'No Question Found';
		}
		else
		{

			foreach($allQuestions as $key => $question)
			{
				$data['allQuestions'] [ $question['question_id']] = [
					'question_id' => $question['question_id'],
					'question_title' => $question['question_title'],
					'question_grade' => $question['question_grade'],
					'question_category' => $question['question_category']
				];

				$data['allQuestions'] [ $question['question_id']]['choices'] = $this->crimeIdentificationManager->get_all_question_answers($question['question_id']);  // get  all choices of this question
			}
		}

		$startTimestamp = $this_exam['exam_open_date']." ".$this_exam['exam_open_time'];
		$endTimestamp = $this_exam['exam_close_date']." ".$this_exam['exam_close_time'];
		
		date_default_timezone_set('Africa/Kigali');
		$now = date('Y-m-d H:i:s');

		if ($now > $endTimestamp) 
		{
			$data['maximum'] = 0;

			foreach($data['allQuestions'] as $row)
			{
				$data['maximum'] += $row['question_grade'];
			}
			
			$allStudentExamAnswers =  $this->crimeIdentificationManager->get_all_student_exam_answers($user_id, $exam_id);
			
			if (!empty($allStudentExamAnswers)) 
			{
				foreach($allStudentExamAnswers as $row)
				{
				
					$data['student_report']['info'] = ['user_id' => $row['user_id'], 'username' => $row['username']];

					$data['student_report']['answer'][$row['question_id']]['result'] = $row['answer_grade'];

					if (empty($data['student_report']['total_result']))
					{
						$data['student_report']['total_result'] = 0;
					}
					$data['student_report']['total_result'] += $row['answer_grade'];

				}
			}
		}
		$this->load->view('crime/pages/course/exam_assign_question_page',$data);
		return;
}

//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------
public function  exam_enswer_question_page_c2($moduleID,$questionID,$examID)
{
	$this->ansering($moduleID,$questionID,$examID);
}

public function  exam_enswer_question_page_c()
{
	$module_id = $this->input->post('moduleID');
	$question_id = $this->input->post('questionID');
	$exam_id = $this->input->post('examID');
	$this->ansering($module_id,$question_id,$exam_id);
}


private function ansering($moduleID,$questionID,$examID)
{
	$module_id = htmlspecialchars($moduleID);
	$question_id = htmlspecialchars($questionID);
	$exam_id = htmlspecialchars($examID);
	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);


 	// check the existance of exam and question
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
	$this_question = $this->crimeIdentificationManager->get_question_id($question_id);  			// get a queestion by id

	if($this->check_course_enrolment_permit($module_id) == FALSE OR empty($data['courseData']) OR empty( $this_exam ) OR empty( $this_question ))
	{

		$this->welcome(" Not allowed ");					// go back to enrolment page
		return;
	}



	$startTimestamp = $this_exam['exam_open_date']." ".$this_exam['exam_open_time'];
	$endTimestamp = $this_exam['exam_close_date']." ".$this_exam['exam_close_time'];
	date_default_timezone_set('Africa/Kigali');
	$now = date('Y-m-d H:i:s');

	if($this->check_course_create_permit() == FALSE AND $now < $startTimestamp )
	{
		$this->wait_the_start($exam_id, $module_id);					// wait the start of exam
	}


	// Needed for display page
	$data['examData'] = $this_exam;
	$data['questionData'] = $this_question;
	$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this question
	if (empty($data['allAnswers']))
	{
		$data['answerError'] = "No Answer choice set";
	}


	
	// get user answered questions 
	$user 	 = $this->session->userdata('user_details');
	$user_id = $user['user_id'];
	$data['StudentExamQuestionAnswer'] =  $this->crimeIdentificationManager->get_student_exam_connection($user_id, $exam_id, $question_id);

	$data['submition'] =  $this->crimeIdentificationManager->get_user_attemption($user_id, $exam_id);
	// Display page
	if ($this_question['question_category'] == 'essay' OR $this_question['question_category'] == 'short_answer')
	{
		$this->load->view('crime/pages/course/essay_or_short_answer_page',$data);
		return;
	}
	else
	{
		$this->load->view('crime/pages/course/exam_answer_question_page',$data);		
		return;
	}
	
}

//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------		

public function  insert_exam_answer_question_c()
{
	$user 	 = $this->session->userdata('user_details');
	$user_id = $user['user_id'];

	$module_id = htmlspecialchars( $this->input->post('course_id') );
	$exam_id = htmlspecialchars( $this->input->post('exam_id') );
	$question_id = htmlspecialchars( $this->input->post('question_id') );
	$answer_title = htmlspecialchars( $this->input->post('answer_title') );

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);
	$questionData = $this->crimeIdentificationManager->get_question_id($question_id);  // get a queestion by id

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome("Not Enrolled Into this course OR Invalid data");	// go back to enrolment page
		return;
	}

	if (empty($courseData) OR empty($this_exam) OR  $courseData['module_id'] !== $this_exam['course_id'])
	{
		$this->welcome("Invalid selected data");
		return;
	}   
   
	$startTimestamp = $this_exam['exam_open_date']." ".$this_exam['exam_open_time'];
	$endTimestamp = $this_exam['exam_close_date']." ".$this_exam['exam_close_time'];
	date_default_timezone_set('Africa/Kigali');
	$now = date('Y-m-d H:i:s');

	if($this->check_course_create_permit() == FALSE AND $now > $endTimestamp )
	{
		$this->wait_the_start($exam_id, $module_id);					// wait the start of exam
		return;
	}

				    	//  for questiongrade
	$question_in_exam = $this->crimeIdentificationManager->get_exam_question_connection($exam_id, $question_id);
	$question_grade = $question_in_exam['question_grade'];

		// for answer_grade
	if ($questionData['question_category'] == 'essay' OR $questionData['question_category'] == 'short_answer')
	{
		$answer_grade = 1001; // impossible marks 
	}
	else
	{
    	$question_with_right_answer= $this->crimeIdentificationManager->get_question_with_right_answer($question_id);
		if ($answer_title == $question_with_right_answer['answer_title'])
		{
			$answer_grade = $question_grade;
		}
		else
		{
			$answer_grade = 0;	
		}
	}

	// get user and exam connection
	$userExamConnection= $this->crimeIdentificationManager->get_student_exam_connection($user_id ,$exam_id, $question_id); 
	
	// insert connection
	if (empty($userExamConnection))
	{
		$this->crimeIdentificationManager->insert_student_exam_connection($user_id, $exam_id,$question_id, $answer_title ,$answer_grade); 
		return;
	}
	else
	{
		$this->crimeIdentificationManager->update_student_exam_connection($user_id, $exam_id,$question_id, $answer_title ,$answer_grade); 
		return;
	}

	return;
}

//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------		

public function  exam_report_c($examID, $moduleID)
{
	$module_id = htmlspecialchars($moduleID);
	$exam_id=htmlspecialchars($examID);

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$examData =  $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id

	if (empty($courseData) OR empty($examData) OR $courseData['module_id'] !== $examData['course_id'] ) 
	{
		$this->welcome("Invalid selected data");
		return;
	}
	
	if($this->check_course_enrolment_permit($module_id) == FALSE OR $this->check_course_create_permit() == FALSE)
	{
		$this->welcome(" You are not allowed to perfom this task ");
		return;
	}

	$allQuestions = $this->crimeIdentificationManager->get_all_exam_questions_connection($exam_id);
		if (empty($allQuestions))
		{
			$this->welcome("No Question Found");
			return;
		}
		else
		{

			foreach($allQuestions as $key => $question)
			{
				$data['allQuestions'] [ $question['question_id']] = [
					'question_id' => $question['question_id'],
					'question_title' => $question['question_title'],
					'question_grade' => $question['question_grade'],
					'question_category' => $question['question_category']
				];

				$data['allQuestions'] [ $question['question_id']]['choices'] = $this->crimeIdentificationManager->get_all_question_answers($question['question_id']);  // get  all choices of this question
			}
		}


	$data['maximum'] = 0;

	foreach($data['allQuestions'] as $row)
	{
		$data['maximum'] += $row['question_grade'];
	}


	$allStudentExamAnswers =  $this->crimeIdentificationManager->get_exam_all_students_with_answers($exam_id);

	if (!empty($allStudentExamAnswers)) 
	{
		foreach($allStudentExamAnswers as $row)
		{
		
			$data['student_report'][$row['user_id']]['info'] = ['user_id' => $row['user_id'], 'username' => $row['username']];

			$data['student_report'][$row['user_id']]['answer'][$row['question_id']]['result'] = $row['answer_grade'];

			if (empty($data['student_report'][$row['user_id']]['total_result']))
			{
				$data['student_report'][$row['user_id']]['total_result'] = 0;
			}
			$data['student_report'][$row['user_id']]['total_result'] += $row['answer_grade'];


			$data['student_report'][$row['user_id']]['exam_monitoring'] = $this->crimeIdentificationManager->get_user_attemption($row['user_id'] ,$exam_id);

		}
	}
	$data['courseData'] = $courseData;
	$data['examData'] =  $examData;
	$this->load->view('crime/pages/course/exam_report_page',$data);

	// echo "<pre>";
	// print_r($data['student_report']);
	// echo "<pre>";
	
	return;
}

//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

public function  exam_grade_manual_page_c($user_id, $moduleID, $questionID, $examID)
{
	$user_id = htmlspecialchars($user_id);
	$module_id = htmlspecialchars($moduleID);
	$question_id = htmlspecialchars($questionID);
	$exam_id = htmlspecialchars($examID);
	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);

 	// check the existance of exam and question
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id
	$this_question = $this->crimeIdentificationManager->get_question_id($question_id);  			// get a queestion by id

	//  for questiongrade
	$question_in_exam = $this->crimeIdentificationManager->get_exam_question_connection($exam_id, $question_id);
	$data['question_grade'] = $question_in_exam['question_grade'];

	if(empty($data['courseData']) OR empty( $this_exam ) OR empty( $this_question ) OR $data['courseData']['module_id'] !== $this_exam['course_id'])
	{
		$this->welcome("Invalid selected data");					// go back to enrolment page
		return;
	}

	if($this->check_course_enrolment_permit($module_id) == FALSE OR $this->check_course_create_permit() == FALSE)
	{
		$this->welcome(" You are not allowed to perfom this task ");
		return;
	}

	// Needed for display page
	$data['examData'] = $this_exam;
	$data['questionData'] = $this_question;

	$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this question
	if (empty($data['allAnswers']))
	{
		$data['answerError'] = "No Answer choice set";
	}

	// get user answered questions 
	$data['StudentExamQuestionAnswer'] =  $this->crimeIdentificationManager->get_student_exam_connection($user_id, $exam_id, $question_id);

	// Display page

	if ($this_question['question_category'] == 'essay' OR $this_question['question_category'] == 'short_answer')
	{
		$this->load->view('crime/pages/course/essay_or_short_answer_grade_manual_page',$data);
		return;
	}
	else
	{
		$this->load->view('crime/pages/course/exam_grade_manual_page',$data);
		return;
	}
	
}

//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------		

public function  update_grade_manual_c()
{
	$user_id = htmlspecialchars( $this->input->post('user_id') );
	$module_id = htmlspecialchars( $this->input->post('course_id') );
	$exam_id=htmlspecialchars( $this->input->post('exam_id') );
	$question_id = htmlspecialchars( $this->input->post('question_id') );
	$answer_grade=htmlspecialchars( $this->input->post('grade') );

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);
	$questionData = $this->crimeIdentificationManager->get_question_id($question_id);  // get a queestion by id

	//  for questiongrade
	$question_in_exam = $this->crimeIdentificationManager->get_exam_question_connection($exam_id, $question_id);
	$question_grade = $question_in_exam['question_grade'];

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome("Not Enrolled Into this course OR Invalid data");					// go back to enrolment page
		return;
	}

	if (empty($courseData) OR empty($this_exam) OR  $courseData['module_id'] !== $this_exam['course_id'])
	{
		$this->welcome("Invalid selected data");
		return;
	}

	$this->form_validation->set_rules('grade', 'grade', 'trim|required|numeric|min_length[1]|max_length[7]'); 
    
    if ($this->form_validation->run() == FALSE OR $answer_grade>$question_grade) 		// if validation fail
    {
    	$data['courseData']=$courseData;
    	$data['examData']=$this_exam;
    	$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);
    	$data['questionData'] = $questionData;  // get a queestion by id
    	$data['question_grade'] = $question_grade ;
    	$data['StudentExamQuestionAnswer'] =  $this->crimeIdentificationManager->get_student_exam_connection($user_id, $exam_id, $question_id);


    	if($answer_grade>$question_grade)
    	{
    		$data['error'] = 'invalid grade';	
    	}

    	if ($questionData['question_category'] == 'essay' OR $questionData['question_category'] == 'short_answer')
    	{
    		$this->load->view('crime/pages/course/essay_or_short_answer_grade_manual_page',$data);
    		return;
    	}
    	else
    	{
    		$this->load->view('crime/pages/course/exam_grade_manual_page',$data);
    		return;
    	}
    }
    
	// update grade
	$this->crimeIdentificationManager->update_manual_grade_connection($user_id, $exam_id,$question_id,$answer_grade);
	$data['error'] = 'grade updated successfully';


	///////   -----------            GO Display result          -----------         //////////

	// Needed for display page
	$data['courseData']=$courseData;
	$data['examData'] = $this_exam;
	$data['questionData'] = $questionData;
	$data['question_grade'] = $question_grade ;

	$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this question
	if (empty($data['allAnswers']))
	{
		$data['answerError'] = "No Answer choice set";
	}

	// get user answered questions 
	$data['StudentExamQuestionAnswer'] =  $this->crimeIdentificationManager->get_student_exam_connection($user_id, $exam_id, $question_id);

	// Display page
	if ($questionData['question_category'] == 'essay' OR $questionData['question_category'] == 'short_answer')
	{
		$this->load->view('crime/pages/course/essay_or_short_answer_grade_manual_page',$data);
		return;
	}
	else
	{
		$this->load->view('crime/pages/course/exam_grade_manual_page',$data);
		return;
	}
	
}

//-----------------------------------------------------------------------------------------------------------------------------------

public function  download_report_c($examID, $moduleID)
{
	$module_id = htmlspecialchars($moduleID);
	$exam_id=htmlspecialchars($examID);

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$examData =  $this->crimeIdentificationManager->get_exam_id($exam_id);  						// get a exam by id

	if (empty($courseData) OR empty($examData) OR $courseData['module_id'] !== $examData['course_id'] ) 
	{
		$this->welcome("Invalid selected data");
		return;
	}
	
	if($this->check_course_enrolment_permit($module_id) == FALSE OR $this->check_course_create_permit() == FALSE)
	{
		$this->welcome(" You are not allowed to perfom this task ");
		return;
	}

	$allQuestions = $this->crimeIdentificationManager->get_all_exam_questions_connection($exam_id);
		if (empty($allQuestions))
		{
			$this->welcome("No Question Found");
			return;
		}
		else
		{

			foreach($allQuestions as $key => $question)
			{
				$data['allQuestions'] [ $question['question_id']] = [
					'question_id' => $question['question_id'],
					'question_title' => $question['question_title'],
					'question_grade' => $question['question_grade'],
					'question_category' => $question['question_category']
				];

				$data['allQuestions'] [ $question['question_id']]['choices'] = $this->crimeIdentificationManager->get_all_question_answers($question['question_id']);  // get  all choices of this question
			}
		}

	$maximum = 0;

	foreach($allQuestions as $row)
	{
		$maximum += $row['question_grade'];
	}


	$allStudentExamAnswers =  $this->crimeIdentificationManager->get_exam_all_students_with_answers($exam_id);

	if (!empty($allStudentExamAnswers)) 
	{
		foreach($allStudentExamAnswers as $row)
		{
		
			$student_report[$row['user_id']]['info'] = ['user_id' => $row['user_id'], 'username' => $row['username']];

			$student_report[$row['user_id']]['answer'][$row['question_id']]['result'] = $row['answer_grade'];

			if (empty($student_report[$row['user_id']]['total_result']))
			{
				$student_report[$row['user_id']]['total_result'] = 0;
			}
			$student_report[$row['user_id']]['total_result'] += $row['answer_grade'];


			// $data['student_report'][$row['user_id']]['exam_monitoring'] = $this->crimeIdentificationManager->get_user_attemption($row['user_id'] ,$exam_id);
		}
	}

	$exam_title = $examData['exam_title'];

	$this->download_excel($allQuestions , $exam_title, $student_report, $maximum);
	return;
}


//*************************************************************************************
//*************************************************************************************

	 private function download_excel($allQuestions, $exam_title, $student_report, $maximum)
	 {
	 	header('Content-Type: application/vnd.ms-excel');
	 	header('Content-Disposition: attachment; filename='.$exam_title.'.xlsx');
		$spreadSheet = new Spreadsheet();
	 	$sheet = $spreadSheet->getActiveSheet();
		
		// for username Title
	 	$sheet->setCellValue('A1', 'Username');

	 	// for questions titles
		$i = 1;	
		$message='';
		$lastLeng=0;
		foreach($allQuestions as $question)
		{
			$leng = 1;
			for ($char = 'B'; $char <= 'Z'; $char++)
			{
	    		$column = $char;
	  			if ($leng == $i)
	  		  	{
	        		break;
	    		}
	    		$leng++;
	    		$lastLeng = $leng+1;
			}
			$message = 'Q'.$i.' /'.$question['question_grade'];
			$sheet->setCellValue($column.'1',$message);

			$i++;
		} 

		// for total title
		$j=1;
		for ($char = 'B'; $char <= 'Z'; $char++)
		{
    		$column = $char;
  			if ($lastLeng == $j)
  		  	{
        		break;
    		}
    		$j++;
		}
		$message = 'Total/'.$maximum;
		$sheet->setCellValue($column.'1',$message);


		//	for usernames and questions columns
		$column  = '';
		$row = 3;

		foreach($student_report as $student_id => $report)
		{
			$sheet->setCellValue('A'.$row, $report['info']['username']);
			
			$i=1;
			$message='';
			$lastLeng=0;
			foreach($allQuestions as $question)
			{
				$leng = 1;
				for ($char = 'B'; $char <= 'Z'; $char++)
				{
		    		$column = $char;
		  			if ($leng == $i)
		  		  	{
		        		break;
		    		}
		    		$leng++;
		    		$lastLeng = $leng+1;
				}
				$i++;

			 	if (isset($report['answer'][$question['question_id']])) 
			 	{
			 		if ($report['answer'][$question['question_id']]['result']>1000)
					{
						$message =' not graded ';
						$sheet->setCellValue($column.''.$row,$message);
					}
					elseif ($report['answer'][$question['question_id']]['result'] >= $question['question_grade']/2)
					{
						$message = $report['answer'][$question['question_id']]['result'];
						$sheet->setCellValue($column.''.$row,$message);
					}
					else
					{
						$message = $report['answer'][$question['question_id']]['result'];
						$sheet->setCellValue($column.''.$row,$message);
					}
				}
				else
				{
					$message = 0 ;
					$sheet->setCellValue($column.''.$row,$message);
				}
			} 



			// for totals column
			$j=1;
			$column  = '';


			for ($char = 'B'; $char <= 'Z'; $char++)
			{
	    		$column = $char;
	  			if ($lastLeng == $j)
	  		  	{
	        		break;
	    		}
	    		$j++;
			}

			if ($report['total_result'] < 1000)
			{
				$message = $report['total_result'];
			}

			$sheet->setCellValue($column.''.$row,$message);

			$row++;
		}

		// // for totals column
		// $j=1;
		// $column  = '';
		// $row = 3;

		// foreach($student_report as $student_id => $report)
		// {
		// 	for ($char = 'B'; $char <= 'Z'; $char++)
		// 	{
	 //    		$column = $char;
	 //  			if ($lastLeng == $j)
	 //  		  	{
	 //        		break;
	 //    		}
	 //    		$j++;
		// 	}

		// 	if ($report['total_result'] < 1000)
		// 	{
		// 		$message = $report['total_result'];
		// 	}
		// 	else
		// 	{
		// 		$message = $report['total_result'];
		// 	}
		// 	$sheet->setCellValue($column.''.$row,$message);

		// 	$row++;
		// }
						
	 	$writer = new Xlsx($spreadSheet);
	 	$writer->save('php://output');

	 }

//*************************************************************************************
//*************************************************************************************

//-----------------------------------------------------------------------------------------------------------------------------------
public function  insert_user_attemption()
{
	$user 	 = $this->session->userdata('user_details');
	$user_id = $user['user_id'];
	$module_id = htmlspecialchars($this->input->post('moduleID'));
	$exam_id = htmlspecialchars($this->input->post('examID'));

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome("Not Enrolled Into this course OR Invalid data");		// go back to enrolment page
		return;
	}

	if (empty($courseData) OR empty($this_exam) OR $courseData['module_id'] !== $this_exam['course_id'])
	{
		// echo 'Ntibirenga aha ';
		$this->welcome("Invalid selected data");
		return;
	}

	// get user and exam connection
	$user_exam_attemption= $this->crimeIdentificationManager->get_user_attemption($user_id ,$exam_id); 
	
	// insert connection
	if (empty($user_exam_attemption))
	{
		$this->crimeIdentificationManager->insert_user_attemption($user_id, $exam_id); 
		// $this->welcome('Exam Submitted successfully');
		return;
	}
	else
	{
		$attemption = $user_exam_attemption['number_of_attemption'];
		$attemption++;
		$this->crimeIdentificationManager->update_number_of_attemption($user_id, $exam_id, $attemption);
		return;
	}
}
//--------------------------------------------------------------------------------------------------------------
//*************************************************************************************

//-----------------------------------------------------------------------------------------------------------------------------------
public function  updateFocusLost_c()
{
	$user 	 = $this->session->userdata('user_details');
	$user_id = $user['user_id'];
	$module_id = htmlspecialchars($this->input->post('moduleID'));
	$exam_id = htmlspecialchars($this->input->post('examID'));

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome("Not Enrolled Into this course OR Invalid data");		// go back to enrolment page
		return;
	}

	if (empty($courseData) OR empty($this_exam) OR $courseData['module_id'] !== $this_exam['course_id'])
	{
		// echo 'Ntibirenga aha ';
		$this->welcome("Invalid selected data");
		return;
	}

	// get user and exam connection
	$user_exam_attemption= $this->crimeIdentificationManager->get_user_attemption($user_id ,$exam_id); 
	
	// insert connection
	if (empty($user_exam_attemption))
	{
		// nothing to do 
		return;
	}
	else
	{
		$page_focus_lost = $user_exam_attemption['page_focus_lost'];
		$page_focus_lost++;
		$this->crimeIdentificationManager->update_number_of_page_focus_lost($user_id, $exam_id, $page_focus_lost);

		echo $page_focus_lost;
		return;
	}
}
//--------------------------------------------------------------------------------------------------------------
//*************************************************************************************

//-----------------------------------------------------------------------------------------------------------------------------------
public function  updateEyeFocusLost_c()
{
	$user 	 = $this->session->userdata('user_details');
	$user_id = $user['user_id'];
	$module_id = htmlspecialchars($this->input->post('moduleID'));
	$exam_id = htmlspecialchars($this->input->post('examID'));

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome("Not Enrolled Into this course OR Invalid data");		// go back to enrolment page
		return;
	}

	if (empty($courseData) OR empty($this_exam) OR $courseData['module_id'] !== $this_exam['course_id'])
	{
		// echo 'Ntibirenga aha ';
		$this->welcome("Invalid selected data");
		return;
	}

	// get user and exam connection
	$user_exam_attemption= $this->crimeIdentificationManager->get_user_attemption($user_id ,$exam_id); 
	
	// insert connection
	if (empty($user_exam_attemption))
	{
		// nothing to do 
		return;
	}
	else
	{
		$eye_focus_lost = $user_exam_attemption['eye_focus_lost'];
		$eye_focus_lost++;
		$this->crimeIdentificationManager->update_number_of_eye_focus_lost($user_id, $exam_id, $eye_focus_lost);

		echo $eye_focus_lost;
		return;
	}
}
//--------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
public function  update_submition_c()
{
	$user 	 = $this->session->userdata('user_details');
	$user_id = $user['user_id'];
	$module_id = htmlspecialchars($this->input->post('moduleID'));
	$exam_id = htmlspecialchars($this->input->post('examID'));
	$status = htmlspecialchars($this->input->post('message'));

	$courseData = $this->crimeIdentificationManager->get_course_id($module_id);
	$this_exam = $this->crimeIdentificationManager->get_exam_id($exam_id);

	if($this->check_course_enrolment_permit($module_id) == FALSE)
	{
		$this->welcome("Not Enrolled Into this course OR Invalid data");					// go back to enrolment page
		return;
	}

	if (empty($courseData) OR empty($this_exam) OR empty($status) OR $courseData['module_id'] !== $this_exam['course_id'])
	{
		$this->welcome("Invalid selected data");
		return;
	}

	// get user and exam connection
	$user_exam_attemption= $this->crimeIdentificationManager->get_user_attemption($user_id ,$exam_id); 
	
	// insert connection
	if (empty($user_exam_attemption))
	{
		$this->welcome('Invalid Data');
		return;
	}
	else
	{
		if ($user_exam_attemption['submition_status']=='submit') 
		{
			$this->welcome('Invalid Data');
		}
		else
		{
			$submition = 'submit';
			$this->crimeIdentificationManager->update_submition($user_id, $exam_id, $submition);
			$this->welcome('Exam Submitted successfully');
			return;
		}
	}
}
//-------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------

									//	FOR QUESTION
//===========================================================================================================================================
//-------------------------------------------------------------------------------------------------------------------------------------------

	public function creat_question_c($moduleID)
	{
		$module_id = htmlspecialchars($moduleID);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome(" You are not Enrolled Into this course ");					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome(" You are not allowed to perfom this task ");					// go back to enrolment page
			return;
		}

		if (empty($data['courseData']))
		{
			$data['error'] = "No Course found";
		}

		$createPermit = $this->session->userdata('createQuestionPermit');
		$userPermit = $this->session->userdata('permit');
		if ($userPermit >= $createPermit ) 
		{
			$this->load->view('crime/pages/course/create_question_page',$data);
			return;
		}
		else
		{
			$data['error'] = "Your permition do not allow you to perfom this task!";
			$this->load->view('crime/pages/course/course_page',$data);
			return;
		}
	}

//------------------------------------------------------------------------------------------------------------------------------------


	public function creat_question_category_c($moduleID, $categ)
	{
		$module_id = htmlspecialchars($moduleID);

		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		$data['questionData'] = array(
										'question_id'   =>  '',
										'question_title'   =>  '',
										'question_category'   =>  htmlspecialchars($categ)
									);

		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if (empty($data['courseData']))
		{
			$data['error'] = "No Course found";
		}
		
		$createPermit = $this->session->userdata('createQuestionPermit');
		$userPermit = $this->session->userdata('permit');
		if ($userPermit >= $createPermit ) 
		{
			$this->load->view('crime/pages/course/create_question_category_page',$data);
			return;
		}
		else
		{
			$data['error'] = "Your permition do not allow you to perfom this task!";
			$this->load->view('crime/pages/course/course_page',$data);
			return;
		}
	}

//------------------------------------------------------------------------------------------------------------------------------------

	public function update_question_c($categ, $moduleID )
	{
		// remove tags for security
		
		$question_category = htmlspecialchars($categ);
		$module_id = htmlspecialchars($moduleID);
		$question_id = htmlspecialchars( $this->input->post('question_id') );
		$question_title=htmlspecialchars( $this->input->post('question_title') );
		
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}	   

		if (!empty($question_title))
		{	
			$questionData =  $this->crimeIdentificationManager->get_question_id($question_id);  						// get a question by id
			
			if (empty($questionData)) 
	        {
				// insert question
				$this->crimeIdentificationManager->insert_question($question_title,$question_category,$module_id); 
				$data['error']="Question Created successfully";
			}
			else
			{
				//update a question
				$this->crimeIdentificationManager->update_question($question_id,$question_title,$question_category,$module_id); 
				$data['error']="Question updated successfully"; 						// set a success message
			}

			$data['allExams'] = $this->crimeIdentificationManager->get_all_course_exams($module_id);  // get  all exam of this course
			if (empty($data['allExams']))
			{
				$data['examError'] = "No Exam Found";
			}

			$data['allQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id);  // get  all question of this course
			if (empty($data['allQuestions']))
			{
				$data['questionError'] = "No Question Found";
			}
			$this->load->view('crime/pages/course/course_exams_page',$data);
			return;
		}
		else
		{
			$data['error']="Type the question";

			$data['questionData'] = array(
											'question_id'       =>  $question_id,
											'question_title'	=>  $question_title,
											'question_category'	=>  $question_category
										);

			$this->load->view('crime/pages/course/create_question_category_page',$data);
			return;
		}
	}

//----------------------------------------------------------------------------------------------------------------------------------------
	
	public function delete_question_c($questionID, $moduleID)
	{
		$question_id = htmlspecialchars($questionID);
		$module_id = htmlspecialchars($moduleID);
		
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE OR empty($data['courseData']))
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		$questionData =  $this->crimeIdentificationManager->get_question_id($question_id);  						// get a question by id
		if (empty($questionData)) 
        {
        	$data['error']="Invalid selected question"; 										// set an error message
        }
        else
        {
        	$this->crimeIdentificationManager->delete_question($question_id); 							// delete a question
			$data['error']="Question Deleted successfully"; 					// set a success message
		}

		$data['allExams'] = $this->crimeIdentificationManager->get_all_course_exams($module_id);  // get  all exam of this course
		if (empty($data['allExams']))
		{
			$data['examError'] = "No Exam Found";
		}

		$data['allQuestions'] = $this->crimeIdentificationManager->get_all_course_questions($module_id);  // get  all question of this course
		if (empty($data['allQuestions']))
		{
			$data['questionError'] = "No Question Found";
		}

		$this->load->view('crime/pages/course/course_exams_page',$data);
		return;
	}

//-------------------------------------------------------------------------------------------------------------------------
	
	public function edit_question_c($questionID, $moduleID)
	{
		$question_id = htmlspecialchars($questionID);
		$module_id = htmlspecialchars($moduleID);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		$questionData =  $this->crimeIdentificationManager->get_question_id($question_id);  						// get a question by id
		if (empty($questionData)) 
        {
        	$data['error']="No Question found"; 										// set an error message
        }
        else
        {
        	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
        	$data['questionData'] =  $this->crimeIdentificationManager->get_question_id($question_id);  						// get a question by id
		}
		$this->load->view('crime/pages/course/create_question_category_page',$data);
		return;
	}

//-----------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------
	
	public function question_assign_answer_c($questionID, $moduleID)
	{
		$question_id = htmlspecialchars($questionID);
		$module_id = htmlspecialchars($moduleID);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}
		
		$questionData =  $this->crimeIdentificationManager->get_question_id($question_id);  						// get a question by id
		if (empty($questionData)) 
        {
        	$data['error']="No Question found"; 										// set an error message
        }
        else
        {
        	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
        	$data['questionData'] =  $questionData;
        	$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this question
			if (empty($data['allAnswers']))
			{
				$data['answerError'] = "No Answer Found";
			}
		}
		$this->load->view('crime/pages/course/question_assign_answer_page',$data);
		return;
	}
//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------

									// FOR ANSWER
//===============================================================================================================================
//-------------------------------------------------------------------------------------------------------------------------------

	public function creat_answer_c($questionID, $moduleID)
	{
		$question_id = htmlspecialchars($questionID);
		$module_id = htmlspecialchars($moduleID);
		$data['questionData'] = $this->crimeIdentificationManager->get_question_id($question_id);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
	
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		if (empty($data['questionData']))
		{
			$data['error'] = "No Question found";
		}

		$this->load->view('crime/pages/course/create_answer_page',$data);
		return;
	}

//------------------------------------------------------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------------------------------------------------------

	public function update_answer_c($questionID, $courseID)
	{

		// remove tags for security
		
		$module_id = htmlspecialchars($courseID);
		$question_id = htmlspecialchars($questionID);
		$answer_id = htmlspecialchars( $this->input->post('answer_id') );
		$answer_title=htmlspecialchars( $this->input->post('answer_title') );
		$answer_status=htmlspecialchars( $this->input->post('answerBtn') );

		$data['questionData'] = $this->crimeIdentificationManager->get_question_id($question_id);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE OR empty($data['questionData']))
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		if (empty($answer_title))
		{ 
			$data['error']="Type the answer";

			$data['answerData'] = array(
											'answer_id'       =>  $answer_id,
											'answer_title'	=>  $answer_title
										);

			$this->load->view('crime/pages/course/create_answer_page',$data);	
			return;
		}
		else
		{
			$answerData =  $this->crimeIdentificationManager->get_answer_id($answer_id);  						// get a answer by id
			
			if (empty($answerData)) 
	        {
	        	if ($data['questionData']['question_category'] == "true_or_false")
	        	{
	        		$theAnswers = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this course
	        		if (count($theAnswers)>=2) 
	        		{
	        			$data['error'] = "True or False category requires two answers only";
	        		}
	        		else
	        		{
	        			if ($answer_status == "right")
						{
							// update all answers with wrong
							$this->crimeIdentificationManager->update_question_answer_status($question_id,"wrong"); 
						}
						elseif ($answer_status == "wrong")
						{
							// update all answers with right
							$this->crimeIdentificationManager->update_question_answer_status($question_id,"right");
						}
	        			// insert answer
						$this->crimeIdentificationManager->insert_answer($answer_title, $answer_status, $question_id); 
						$data['error']="Answer Created successfully";
	        		}
	        		
	        	}
	        	elseif($data['questionData']['question_category'] == "essay" )
	        	{
	        		$data['error'] = "It is not allowed to set answer for Essay category";
	        	}
	        	elseif ( $data['questionData']['question_category'] == "short_answer") 
	        	{
	        		$data['error'] = "It is not allowed to set answer for Short answer category";
	        	}
	        	else
	        	{
		       			// insert answer
					$this->crimeIdentificationManager->insert_answer($answer_title, $answer_status, $question_id); 
					$data['error']="Answer Created successfully";
	        	}

			}
			else
			{
				if ($data['questionData']['question_category'] == "true_or_false" )
				{
					if ($answer_status == "right")
					{
						// update all answers with wrong
						$this->crimeIdentificationManager->update_question_answer_status($question_id,"wrong"); 
					}
					elseif ($answer_status == "wrong")
					{
						// update all answers with right
						$this->crimeIdentificationManager->update_question_answer_status($question_id,"right");
					}

					//update a answer
					$this->crimeIdentificationManager->update_answer($answer_id,$answer_title,$answer_status); 
					$data['error']="Answer updated successfully"; 	

				}
				elseif($data['questionData']['question_category'] == "essay" )
	        	{
	        		$data['error'] = "It is not allowed to set answer for Essay category";
	        	}
	        	elseif ( $data['questionData']['question_category'] == "short_answer") 
	        	{
	        		$data['error'] = "It is not allowed to set answer for Short answer category";
	        	}
	        	else
	        	{
		        	//update a answer
					$this->crimeIdentificationManager->update_answer($answer_id,$answer_title,$answer_status); 
					$data['error']="Answer updated successfully"; 						// set a success message
	        	}
				
			}

			$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this course
			if (empty($data['allAnswers']))
			{
				$data['answerError'] = "No Answer Found";
			}
			$this->load->view('crime/pages/course/question_assign_answer_page',$data);
			return;
		}
	 }

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------
	
	public function question_delete_answer_c($answerID, $questionID, $moduleID)
	{
		$answer_id   = htmlspecialchars($answerID);
		$question_id = htmlspecialchars($questionID);
		$module_id   = htmlspecialchars($moduleID);

		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment page
			return;
		}

		if($this->check_course_create_permit() == FALSE)
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		$answerData =  $this->crimeIdentificationManager->get_answer_id($answer_id);  						// get a answer by id
		if (empty($answerData)) 
        {
        	$data['error']="Invalid selected Answer"; 										// set an error message
        }
        else
        {
        	$this->crimeIdentificationManager->delete_answer($answer_id); 							// delete a answer
			$data['error']="Answer Deleted successfully"; 					// set a success message
		}

		$data['questionData'] = $this->crimeIdentificationManager->get_question_id($question_id);
		$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);

		$data['allAnswers'] = $this->crimeIdentificationManager->get_all_question_answers($question_id);  // get  all answer of this course
		if (empty($data['allAnswers']))
		{
			$data['answerError'] = "No Answer Found";
		}
		$this->load->view('crime/pages/course/question_assign_answer_page',$data);
		return;
			
	}

//----------------------------------------------------------------------------------------------------------------------------------------

	public function edit_answer_c($answerID, $questionID, $moduleID)
	{
		$answer_id   = htmlspecialchars($answerID);
		$question_id = htmlspecialchars($questionID);
		$module_id   = htmlspecialchars($moduleID);

		
		if($this->check_course_enrolment_permit($module_id) == FALSE)
		{
			$this->welcome('You are not Enrolled Into this course');					// go back to enrolment 
			return;
		}

		if($this->check_course_create_permit() == TRUE)
		{
			$this->welcome('You are not allowed to perfom this task');					// go back to enrolment page
			return;
		}

		$answerData =  $this->crimeIdentificationManager->get_answer_id($answer_id);  						// get a answer by id
		if (empty($answerData)) 
        {
        	$data['error']="No Answer found"; 										// set an error message
        }
        else
        {
        	$data['courseData'] = $this->crimeIdentificationManager->get_course_id($module_id);
        	$data['questionData'] = $this->crimeIdentificationManager->get_question_id($question_id);
        	$data['answerData'] =  $this->crimeIdentificationManager->get_answer_id($answer_id);  		// get a answer by id

		}
		$this->load->view('crime/pages/course/create_answer_page',$data);
		return;
	    
	}

*/
//=================================================================================================================================
	
}
?>