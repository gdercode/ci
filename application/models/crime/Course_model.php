<?php
class Crime_identification_model extends CI_Model
{

	private $course_table = 'course_table';
//---------------------------------------------------------------------------------------------------------------------------------
	
	public function get_all_course()
	{
	
		return $this->db->select('`module_id`,`module_name`,`module_credit`', false)
						->from($this->course_table)
						->order_by('module_id','desc')
						->get()
						->result_array();
	}
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_course_id($course_id)
	{
	
		return $this->db->select('`module_id`,`module_name`,`module_credit`', false)
						->from($this->course_table)
						->order_by('module_id','desc')
						->where('module_id',$course_id)
						->get()
						->row_array();
	}


//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
			

					// FOR EXAM TABLE
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	private $exam_table = 'exam_table';
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
	
	public function get_all_course_exams($course_id)
	{
	
		return $this->db->select('`exam_id`,`exam_title`,`exam_description`,`exam_open_date`,`exam_open_time`,`exam_close_date`,`exam_close_time`,`exam_grade`,`exam_pass_grade`,`course_id`', false)
						->from($this->exam_table)
						->order_by('exam_id','desc')
						->where('course_id',$course_id)
						->get()
						->result_array();
	}
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
	
	// public function get_all_exam_questions($examID)
	// {
	
	// 	return $this->db->select('*', false)
	// 					->from($this->exam_table)
	// 					->order_by('exam_id','desc')
	// 					->where('exam_id',$examID)
	// 					->get()
	// 					->result_array();
	// }
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_exam_id($exam_id)
	{
	
		return $this->db->select('`exam_id`,`exam_title`,`exam_description`,`exam_open_date`,`exam_open_time`,`exam_close_date`,`exam_close_time`,`exam_grade`,`exam_pass_grade`,`course_id`', false)
						->from($this->exam_table)
						->order_by('exam_id','desc')
						->where('exam_id',$exam_id)
						->get()
						->row_array();
	}

//---------------------------------------------------------------------------------------------------------------------------------

	public function delete_exam($exam_id)
	{
		return $this->db->where('exam_id',$exam_id)->delete($this->exam_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function update_exam($exam_id,$exam_title,$exam_description,$exam_open_date,$exam_open_time,$exam_close_date,$exam_close_time,$exam_grade,$exam_pass_grade,$course_id)
	{
		return $this->db->set( array(
										'exam_title'=>$exam_title,
										'exam_description'=>$exam_description,
										'exam_open_date'=>$exam_open_date,
										'exam_open_time'=>$exam_open_time,
										'exam_close_date'=>$exam_close_date,
										'exam_close_time'=>$exam_close_time,
										'exam_grade'=>$exam_grade,
										'exam_pass_grade'=>$exam_pass_grade,
										'course_id'=>$course_id
									) 
							 )
						->where('exam_id',$exam_id)
						->update($this->exam_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------

	public function insert_exam( $exam_title,$exam_description,$exam_open_date,$exam_open_time,$exam_close_date,$exam_close_time,$exam_grade,$exam_pass_grade, $course_id)
	{
		return $this->db->set( array(
										'exam_id' => "",
										'exam_title'=>$exam_title,
										'exam_description'=>$exam_description,
										'exam_open_date'=>$exam_open_date,
										'exam_open_time'=>$exam_open_time,
										'exam_close_date'=>$exam_close_date,
										'exam_close_time'=>$exam_close_time,
										'exam_grade'=>$exam_grade,
										'exam_pass_grade'=>$exam_pass_grade,
										'course_id'=>$course_id
									) 
							 )
						->insert( $this->exam_table );
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------


					// FOR QUESTION TABLE
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	private $question_table = 'question_table';
//---------------------------------------------------------------------------------------------------------------------------------
	public function get_all_course_questions($course_id)
	{
	
		return $this->db->select('`question_id`,`question_title`,`question_category`,`course_id`', false)
						->from($this->question_table)
						->order_by('question_id','desc')
						->where('course_id',$course_id)
						->get()
						->result_array();
	}
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_question_id($question_id)
	{
	
		return $this->db->select('question_id,question_title,question_category,course_id', false)
						->from($this->question_table)
						->order_by('question_title','desc')
						->where('question_id',$question_id)
						->get()
						->row_array();
	}


//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_question_with_right_answer($question_id)
	{
		$where = array('question_table.question_id' => $question_id , 'answer_status' => "right" );
		
		return $this->db->select('question_table.question_id,question_title,question_category,course_id,answer_id,answer_title,answer_status,answer_table.id_question', false)
						->from($this->question_table)
						->join('answer_table','answer_table.id_question = question_table.question_id')
						->order_by('question_title','desc')
						->where($where)
						->where('answer_status','right')
						->get()
						->row_array();
	}


//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function delete_question($question_id)
	{
		return $this->db->where('question_id',$question_id)->delete($this->question_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function update_question($question_id,$question_title,$question_category,$course_id)
	{
		return $this->db->set( array(
										'question_title'=>$question_title
									) 
							 )
						->where('question_id',$question_id)
						->update($this->question_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------

	public function insert_question( $question_title, $question_category, $course_id)
	{
		return $this->db->set( array(
										'question_id' => "",
										'question_title' => $question_title,
										'question_category'  => $question_category,
										'course_id'      => $course_id
									) 
							 )
						->insert( $this->question_table );
	}

//---------------------------------------------------------------------------------------------------------------------------------

					// FOR ANSWER TABLE
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	private $answer_table = 'answer_table';
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
	
	public function get_all_question_answers($questionID)
	{
	
		return $this->db->select('*', false)
						->from($this->answer_table)
						->order_by('answer_id','desc')
						->where('id_question',$questionID)
						->get()
						->result_array();
	}
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_answer_id($answer_id)
	{
	
		return $this->db->select('*', false)
						->from($this->answer_table)
						->order_by('answer_id','desc')
						->where('answer_id',$answer_id)
						->get()
						->row_array();
	}

//---------------------------------------------------------------------------------------------------------------------------------

	public function delete_answer($answer_id)
	{
		return $this->db->where('answer_id',$answer_id)->delete($this->answer_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function update_answer($answer_id,$answer_title,$answer_status)
	{
		return $this->db->set( array(
										'answer_title'=>$answer_title,
										'answer_status'      => $answer_status
									) 
							 )
						->where('answer_id',$answer_id)
						->update($this->answer_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function update_question_answer_status($question_id,$answer_status)
	{
		return $this->db->set( array(
										'answer_status'      => $answer_status
									) 
							 )
						->where('id_question',$question_id)
						->update($this->answer_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------

	public function insert_answer( $answer_title, $answer_status, $questionID )
	{
		return $this->db->set( array(
										'answer_id' => "",
										'answer_title' => $answer_title,
										'answer_status'      => $answer_status,
										'id_question'      => $questionID
										
									) 
							 )
						->insert( $this->answer_table );
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------


								// FOR QUESTION ANSWER CONNECTION TABLE
//---------------------------------------------------------------------------------------------------------------------------------

	// private $question_answer_connection_table = 'question_answer_connection_table';
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	// public function get_questionAnswer_ids($questionID, $answerID)
	// {
	// 	$where = array('question_id' => $questionID , 'answer_id' => $answerID );
	
	// 	return $this->db->select('`question_id`,`answer_id`', false)
	// 					->from($this->question_answer_connection_table)
	// 					->order_by('answer_id','desc')
	// 					->where($where)
	// 					->get()
	// 					->row_array();
	// }

//---------------------------------------------------------------------------------------------------------------------------------

// public function insert_questionAnswer_ids($questionID, $answerID)
// 	{
// 		return $this->db->set( array(
// 										'question_id' => $questionID,
// 										'answer_id'   => $answerID
// 									) 
// 							 )
// 						->insert( $this->question_answer_connection_table );
// 	}
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------


								// FOR USER COURSE CONNECTION TABLE
//---------------------------------------------------------------------------------------------------------------------------------

	private $user_course_connection_table = 'user_course_connection_table';
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function insert_user_course_connection($userID, $courseID)
	{
		return $this->db->set( array(
										'userID' => $userID,
										'moduleID'   => $courseID
									) 
							 )
						->insert( $this->user_course_connection_table );
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_all_user_course_connection($courseID)
	{
		$where = array('moduleID' => $courseID );
	
		return $this->db->select('*', false)
						->from($this->user_course_connection_table)
						->join('all_user_table','all_user_table.user_id = user_course_connection_table.userID')
						->join('course_table','course_table.module_id = user_course_connection_table.moduleID')
						->order_by('user_id','desc')
						->where($where)
						->get()
						->result_array();
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_user_course_connection($userID, $courseID)
	{
		$where = array('userID' => $userID , 'moduleID' => $courseID );
	
		return $this->db->select('*', false)
						->from($this->user_course_connection_table)
						->join('all_user_table','all_user_table.user_id = user_course_connection_table.userID')
						->join('course_table','course_table.module_id = user_course_connection_table.moduleID')
						->order_by('user_id','desc')
						->where($where)
						->get()
						->row_array();
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function remove_user_course_connection($userID, $courseID)
	{
		$where = array('userID' => $userID , 'moduleID' => $courseID );
	
		return $this->db->where($where)
						->delete($this->user_course_connection_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------



									// FOR EXAM QUESTION CONNECTION TABLE
//---------------------------------------------------------------------------------------------------------------------------------

	private $question_exam_connection_table = 'question_exam_connection_table';
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function insert_question_exam_connection($questionID, $examID, $question_grade)
	{
		return $this->db->set( array(
										'question_ids' => $questionID,
										'exam_ids' => $examID,
										'question_grade'   => $question_grade
									) 
							 )
						->insert( $this->question_exam_connection_table );
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_all_exam_questions_connection($examID)
	{
		$where = array('exam_ids' => $examID );
	
		return $this->db->select('*', false)
						->from($this->question_exam_connection_table)
						->join('exam_table','exam_table.exam_id = question_exam_connection_table.exam_ids')
						->join('question_table','question_table.question_id = question_exam_connection_table.question_ids')
						->order_by('exam_ids','desc')
						->where($where)
						->get()
						->result_array();
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_exam_question_connection($examID, $questionID)
	{
		$where = array('exam_ids' => $examID , 'question_ids' => $questionID );
	
		return $this->db->select('*', false)
						->from($this->question_exam_connection_table)
						->join('exam_table','exam_table.exam_id = question_exam_connection_table.exam_ids')
						->join('question_table','question_table.question_id = question_exam_connection_table.question_ids')
						->order_by('exam_ids','desc')
						->where($where)
						->get()
						->row_array();
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function remove_exam_question_connection($examID, $questionID)
	{
		$where = array('exam_ids' => $examID , 'question_ids' => $questionID );
	
		return $this->db->where($where)
						->delete($this->question_exam_connection_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

										// FOR STUDENT EXAM CONNECTION TABLE
//---------------------------------------------------------------------------------------------------------------------------------

	private $student_answers_table = 'student_answers_table';
//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function remove_enswered_exam_question_connection($examID, $questionID)
	{
		$where = array('examID' => $examID , 'questionID' => $questionID );
	
		return $this->db->where($where)
						->delete($this->student_answers_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function insert_student_exam_connection($userID, $examID, $questionID, $answer_title, $answer_grade)
	{
		return $this->db->set( array(
										'userID' => $userID,
										'examID' => $examID,
										'questionID' => $questionID,
										'answer'   => $answer_title,
										'answer_grade'   => $answer_grade
									) 
							 )
						->insert( $this->student_answers_table );
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function update_student_exam_connection($userID, $examID, $questionID, $answer_title, $answer_grade)
	{
		$where = array('userID' => $userID , 'examID' => $examID, 'questionID' => $questionID );
		
		return $this->db->set( array(
										'answer'=>$answer_title,
										'answer_grade'   => $answer_grade
									) 
							 )
						->where($where)
						->update($this->student_answers_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function update_manual_grade_connection($userID, $examID, $questionID, $answer_grade)
	{
		$where = array('userID' => $userID , 'examID' => $examID, 'questionID' => $questionID );
		
		return $this->db->set( array(
										'answer_grade'   => $answer_grade
									) 
							 )
						->where($where)
						->update($this->student_answers_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------

	public function get_exam_all_students_with_answers($examID)
	{
		$where = array('examID' => $examID);
	
		return $this->db->select('*', false)
						->from($this->student_answers_table)
						->join('all_user_table','all_user_table.user_id = student_answers_table.userID')
						->join('exam_table','exam_table.exam_id = student_answers_table.examID')
						->join('question_table','question_table.question_id = student_answers_table.questionID')
						->order_by('user_id','desc')
						->where($where)
						->get()
						->result_array();
	}

//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------

	public function get_all_student_exam_answers($userID, $examID)
	{
		$where = array('userID' => $userID , 'examID' => $examID);
	
		return $this->db->select('*', false)
						->from($this->student_answers_table)
						->join('all_user_table','all_user_table.user_id = student_answers_table.userID')
						->join('exam_table','exam_table.exam_id = student_answers_table.examID')
						->join('question_table','question_table.question_id = student_answers_table.questionID')
						->order_by('user_id','desc')
						->where($where)
						->get()
						->result_array();
	}

//---------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------

	public function get_student_exam_connection($userID, $examID, $questionID)
	{
		$where = array('userID' => $userID , 'examID' => $examID, 'questionID' => $questionID );
	
		return $this->db->select('*', false)
						->from($this->student_answers_table)
						->join('all_user_table','all_user_table.user_id = student_answers_table.userID')
						->join('exam_table','exam_table.exam_id = student_answers_table.examID')
						->join('question_table','question_table.question_id = student_answers_table.questionID')
						->order_by('user_id','desc')
						->where($where)
						->get()
						->row_array();
	}

//-----------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------

	public function remove_student_exam_connection($userID, $examID, $questionID)
	{
		$where = array('userID' => $userID , 'examID' => $examID, 'questionID' => $questionID );
	
		return $this->db->where($where)
						->delete($this->student_answers_table);
	}

//---------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------				



						// FOR EXAM MONITORING TABLE
//-----------------------------------------------------------------------------------------------------------

	private $exam_monitoring_table = 'exam_monitoring_table';
//---------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------

	public function insert_user_attemption($userID, $examID)
	{
		return $this->db->set( array(
										'id_of_user' => $userID,
										'id_of_exam' => $examID,
										'eye_focus_lost'   => '0',
										'page_focus_lost'   => '0',
										'number_of_attemption' => '1',
										'submition_status'   => 'none'
									) 
							 )
						->insert( $this->exam_monitoring_table );
	}
//----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------

	public function get_user_attemption($userID, $examID)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID);
	
		return $this->db->select('*', false)
						->from($this->exam_monitoring_table)
						->order_by('id_of_exam','desc')
						->where($where)
						->get()
						->row_array();
	}
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------		
	public function delete_user_attemption($userID, $examID)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID);
		return $this->db->where($where)->delete($this->exam_monitoring_table);
	}

//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------	
	public function update_submition($userID, $examID,$status)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID );
		
		return $this->db->set( array(
										'submition_status'=>$status
									) 
							 )
						->where($where)
						->update($this->exam_monitoring_table);
	}
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------	
	public function update_eye_focus_lost($userID, $examID,$number)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID );
		
		return $this->db->set( array(
										'eye_focus_lost'=>$number
									) 
							 )
						->where($where)
						->update($this->exam_monitoring_table);
	}
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------	
	public function update_page_focus_lost($userID, $examID,$number)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID );
		
		return $this->db->set( array(
										'page_focus_lost'=>$number
									) 
							 )
						->where($where)
						->update($this->exam_monitoring_table);
	}
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------	
	public function update_number_of_attemption($userID, $examID,$number)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID );
		
		return $this->db->set( array(
										'number_of_attemption'=>$number
									) 
							 )
						->where($where)
						->update($this->exam_monitoring_table);
	}
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------	
	public function update_number_of_page_focus_lost($userID, $examID,$number)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID );
		
		return $this->db->set( array(
										'page_focus_lost'=>$number
									) 
							 )
						->where($where)
						->update($this->exam_monitoring_table);
	}
//----------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------	
	public function update_number_of_eye_focus_lost($userID, $examID,$number)
	{
		$where = array('id_of_user' => $userID , 'id_of_exam' => $examID );
		
		return $this->db->set( array(
										'eye_focus_lost'=>$number
									) 
							 )
						->where($where)
						->update($this->exam_monitoring_table);
	}
//----------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------

	// public function update_all_submition($examID,$status)
	// {
	// 	$where = array('examID' => $examID );
		
	// 	return $this->db->set( array(
	// 									'submition'=>$status
	// 								) 
	// 						 )
	// 					->where($where)
	// 					->update($this->exam_monitoring_table);
	// }
//-----------------------------------------------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------



}


?>