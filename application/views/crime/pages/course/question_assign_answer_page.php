<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$answerError = isset($answerError) ? $answerError : '';
	$questionAnswerDataError = isset($questionAnswerDataError) ? $questionAnswerDataError : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';
	$question_id = isset($questionData) ? $questionData['question_id'] : '';
	

	if(isset($courseData))
	{


?>

	<div class="content">	
		<h5><?php echo $error; ?> </h5>
		<div class="create_button_content">
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/creat_answer_c/<?php echo $question_id."/".$module_id ?>" > Create Answer </a>
			</div>
		</div>	
	    <b id="report_notification"><?php echo $courseData['module_name']." / ".$questionData['question_category']; ?></b>
	</div>

	<div class="content">
		<h4><b id="courseAndexamTitle">	<?php echo $questionData['question_title']; ?> </b></h4>
		<hr>

	<?php
		echo $answerError;
		if (isset($allAnswers))
		{	
			$index = 1;
			foreach ($allAnswers as $answer) 
			{
?>
				<?php echo $index ?> : 
				<a href="<?php echo base_url() ?>eexam/course/courseController/edit_answer_c/<?php echo $answer['answer_id']."/".$questionData['question_id']."/".$module_id; ?>"> <?php echo $answer['answer_title'] ;?>
				 </a>
				 <?php if ($answer['answer_status'] == "right") { echo '<b id="vrai"> &#10004;</b>';}else{ echo '<b id="faux"> &#x2718;</b>';} ?>
				  
		
				<a href="<?php echo base_url() ?>eexam/course/courseController/question_delete_answer_c/<?php echo $answer['answer_id']."/".$questionData['question_id']."/".$module_id; ?>">
				<button>Delete</button>
				</a>
				<hr>
<?php	
				$index++;		
			}
		} 
?>
	</div>

<?php 

	}
	else
	{
		echo 'courseData is not set';
	}
 	$this->load->view('eexam/main_parts/footer');

 ?>

