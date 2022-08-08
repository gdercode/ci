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
	$answerError = isset($answerError) ? $answerError : '';

	$module_id = isset($courseData) ? $courseData['module_id'] : '';
	$exam_id = isset($examData) ? $examData['exam_id'] : '';
	$question_id = isset($questionData) ? $questionData['question_id'] : '';
	$user_id =isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['userID'] : '';
	$username =isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['username'] : '';
	$student_grade =isset($StudentExamQuestionAnswer) ? $StudentExamQuestionAnswer['answer_grade'] : '';
	if ($student_grade>1000)
	{
		$student_grade = '';
	}
?>
	

	<div class="content">	
		<h5><?php echo $error; ?> </h5>
	    <b id="report_notification"><?php echo $username." // ".$courseData['module_name']." // ".$examData['exam_title']; ?></b>

	</div>
	<div class="content">
		<h4><b id="courseAndexamTitle">	<?php echo $questionData['question_title']; ?> </b></h4>
		<hr>
	<?php
		echo $answerError;
		if (isset($allAnswers))
		{
			// $student_grade='';	
	?>
		<h5><?php echo form_error('grade'); ?></h5>
		<form method="post" action="<?php echo base_url() ?>eexam/course/courseController/update_grade_manual_c/">
	<?php
		foreach ($allAnswers as $answer) 
		{
			$check = "";

			if (isset($StudentExamQuestionAnswer))
			{
				$student_grade = $StudentExamQuestionAnswer['answer_grade'];

				if($StudentExamQuestionAnswer['answer'] == $answer['answer_title'])
				{
					$check = "checked";
				}
				else
				{
					$check = "";
				}
			}
?>
			<input disabled type="radio" name="answer_title" value="<?php echo $answer['answer_title'] ;?>" <?php echo $check; ?> >
			<a> <?php echo $answer['answer_title'];?> </a>
			<?php
				if($answer['answer_status'] == 'right' ){ echo '<b id="report_notification"> right answer </b> ';}
			 ?>
			<input type="hidden" name="user_id" value="<?php echo $user_id;  ?> "/>
			<input type="hidden" name="course_id" value="<?php echo $module_id; ?> "/>
			<input type="hidden" name="question_id" value="<?php echo $question_id;  ?> "/>
			<input type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
			<br>
<?php	
		
			

		} 
?>
			<input id="assign_grade" type="text" name="grade" placeholder="Grade" value="<?php echo $student_grade ; ?>">
			/<?php echo $question_grade.' pts' ?>
			<input type="submit" name="answer" value="Save">
		</form>
		
<?php
	} 
?>
	</div>

<?php 
 	$this->load->view('eexam/main_parts/footer');
 ?>

