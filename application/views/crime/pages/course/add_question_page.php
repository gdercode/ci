<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$questionError = isset($questionError) ? $questionError : '';
	$exam_id = isset($examData) ? $examData['exam_id'] : ''; 
	$course_id = isset($courseData) ? $courseData['module_id'] : '';  
	$question_grade = isset($question_grade) ? $question_grade : '';


	if(isset($examData))
	{
?>
	<div class="content">
		<h4><b id="report_notification">All <?php echo $courseData['module_name'];?> Questions </b></h4>
		<hr>
			<h3> <?php echo $error ?></h3>

			<h5><?php echo form_error('question_grade'); ?></h5>
		<?php

			echo $questionError;
			if (isset($allCourseQuestions))
			{

				$index = 1;
				foreach ($allCourseQuestions as $question) 
				{
	?>
					<form method="post" action="<?php echo base_url() ?>eexam/course/courseController/exam_connect_question_c/">
						<?php echo $index ?> : 
						<a> <?php echo $question['question_title'] ;?> </a>
						<input type="hidden" name="course_id" value="<?php echo $question['course_id'];  ?> "/>
						<input type="hidden" name="question_id" value="<?php echo $question['question_id'];  ?> "/>
						<input type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
						<input class="questionGrade" type="text" name="question_grade" value="<?php echo $question_grade; ?>" placeholder ="Question grade">
						<input type="submit" name="" value="Add">
					</form>
					
<!-- 
					<a href="<?php// echo base_url() ?>eexam/course/courseController/exam_connect_question_c/<?php// echo $course_id."/".$question_id."/".$exam_id."/".$question_grade; ?>">
						<button>Add</button>
					</a> -->
					<hr>
					
	<?php	
					$index++;		
				}
			} 
		?>
		
			</div>
	

<?php 

	}
 	$this->load->view('eexam/main_parts/footer');

 ?>

