<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';

	$question_category = isset($questionData) ? $questionData['question_category'] : '';
	$question_id = isset($questionData) ? $questionData['question_id'] : ''; 
	$question_title = isset($questionData) ? $questionData['question_title'] : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';  


	if(isset($courseData))
	{
?>
	<div class="content">
		<h4  id="report_notification" ><?php echo $courseData['module_name']; ?></h4>
		<h1><?php echo $question_category; ?> </h1>
		<hr>
		
	 <div id="question">
	<!-- <div> -->
		<div id="questionBox">

				<h2>Question</h2>

			<form id="registerForm" method="post" action="<?php echo base_url() ?>eexam/course/courseController/update_question_c/<?php echo $question_category."/".$module_id ?>" > 
				 <h3><?php echo $error; ?> </h3>

				 <input type="hidden" name="question_id" value="<?php echo $question_id;  ?> "/>
				 <!-- <input type="hidden" name="question_category" value="<?php// echo $question_category; ?>" /> -->
				<p>	
					<h5><?php echo form_error('question_title'); ?></h5>
					<textarea name="question_title" rows="4" cols="60" placeholder="Question label"><?php echo $question_title ?></textarea>
				</p>
					
				<!-- <p>	
					<input type="hidden" name="module_id" value="<?php// echo $module_id; ?>" />
				</p> -->
				<p><input type="submit" name="update_button" value="Save Changes" > </p>


			</form>

		</div> 

	</div>
			

	</div>
	

<?php 

	}
 	$this->load->view('eexam/main_parts/footer');

 ?>

