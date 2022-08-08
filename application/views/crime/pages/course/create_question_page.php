<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';
	


	if(isset($courseData))
	{
?>
	<div class="content">
		<h4  id="report_notification"><?php echo $courseData['module_name']; ?></h4>
		<h5><?php echo $error; ?> </h5>
		<h1>Question Category</h1>

<hr>
		
	<?php
			$createPermit = $this->session->userdata('createQuestionPermit');
			$userPermit = $this->session->userdata('createQuestionPermit');
			if ($createPermit >= $userPermit ) 
			{
		?>
			
			<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_category_c/<?php echo $module_id."/multiple_choice" ?>" > 
											Multiple Choice
			</a> <hr>

			<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_category_c/<?php echo $module_id."/multiple_response" ?>" >
											Multiple Response
			</a> <hr>

			<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_category_c/<?php echo $module_id."/true_or_false" ?>" >
			 								True or False
			</a> <hr>

			<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_category_c/<?php echo $module_id."/short_answer" ?>" >
											 Short Answer
			</a> <hr>

			<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_category_c/<?php echo $module_id."/select_from_lists" ?>" >
											 Select from Lists
			</a> <hr>
			  
			<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_category_c/<?php echo $module_id."/essay" ?>" >
											 Essay 
			</a> <hr>
		
		<?php
			}
		?>
			

	</div>
	

<?php 

	}
 	$this->load->view('eexam/main_parts/footer');

 ?>

