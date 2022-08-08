<?php
	$permit = $this->session->userdata('permit');
	$needed = $this->session->userdata('courseCreatePermit');

	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
		$error = isset($error) ? $error : '';
	// $answerError = isset($answerError) ? $answerError : '';
		$student_grade = isset($student_grade) ? $student_grade : '';
		$module_id = isset($courseData) ? $courseData['module_id'] : '';
		$exam_id = isset($examData) ? $examData['exam_id'] : '';
		$question_id = isset($questionData) ? $questionData['question_id'] : '';
		$answer      = isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['answer'] : '';
		$student_grade =isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['answer_grade'] : '';
		$user_id =isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['userID'] : '';
		$username =isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['username'] : '';

		if ($student_grade>1000)
		{
			$student_grade = '';
		}
	 
?>
	<div class="content">	
		<h5><?php echo $error; ?> </h5>
	    <b  id="report_notification" ><?php echo $username." // ".$courseData['module_name']." // ".$examData['exam_title']; ?></b>
	</div>
	<div class="content">
		<h4><b id="courseAndexamTitle">	<?php echo $questionData['question_title']; ?> </b></h4>
		<hr>
		<h5><?php echo form_error('grade'); ?></h5>
		<form method="post" action="<?php echo base_url() ?>eexam/course/courseController/update_grade_manual_c/">
			<textarea disabled	 name="answer_title" rows="4" cols="60" placeholder="Question label" ><?php echo $answer ?></textarea>
			<input type="hidden" name="user_id" value="<?php echo $user_id;  ?> "/>
			<input type="hidden" name="course_id" value="<?php echo $module_id;  ?> "/>
			<input type="hidden" name="question_id" value="<?php echo $question_id;  ?> "/>
			<input type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
			<br>
			<input id="assign_grade" type="text" name="grade" placeholder="Grade" value="<?php echo $student_grade ; ?>">
			/<?php echo $question_grade.' pts' ?>
			<input type="submit" name="answer" value="Save">
		</form>
	</div>

<?php 
 	$this->load->view('eexam/main_parts/footer');
 ?>

