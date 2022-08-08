<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';

	$answer_id = isset($answerData) ? $answerData['answer_id'] : ''; 
	$answer_title = isset($answerData) ? $answerData['answer_title'] : '';
	$question_id = isset($questionData) ? $questionData['question_id'] : ''; 
	$course_id = isset($courseData) ? $courseData['module_id'] : '';  


	if(isset($questionData))
	{
?>
	<div class="content">
		<h4 id="report_notification" ><?php echo $courseData['module_name']." // ".$questionData['question_title']; ?></h4>
		<hr>
		
	 <div id="question">
	<!-- <div> -->
		<div id="questionBox">

				<h2>Answer</h2>

			<form id="registerForm" method="post" action="<?php echo base_url() ?>eexam/course/courseController/update_answer_c/<?php echo $question_id."/".$course_id; ?>" > 
				 <h3><?php echo $error; ?> </h3>

				 <input type="hidden" name="answer_id" value="<?php echo $answer_id;  ?> "/>
				<p>	
					<h5><?php echo form_error('answer_title'); ?></h5>
					<textarea name="answer_title" rows="4" cols="60" placeholder="answer label"><?php echo $answer_title ?></textarea>
				</p>
				<p>
					<input id="true" type="radio" name="answerBtn" value="right" > 		  	 <label for="true">  Right Answer </label>
					<input id="false" type="radio" name="answerBtn" value="wrong" checked >  <label for="false"> Wrong Answer </label>
				</p>	
				<p><input type="submit" name="update_button" value="Save Changes" > </p>


			</form>

		</div> 

	</div>
			

	</div>
	

<?php 

	}
 	$this->load->view('eexam/main_parts/footer');

 ?>

