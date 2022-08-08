<?php
	$permit = $this->session->userdata('permit');
	$needed = $this->session->userdata('courseCreatePermit');

	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 

	$error = isset($error) ? $error : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';
	$examError = isset($examError) ? $examError : '';
	$questionError = isset($questionError) ? $questionError : '';
	$answerError = isset($answerError) ? $answerError : '';

if(isset($courseData))
{
?> 	


	<!-- For confirmation box -->
	<div id="dialogoverlay"></div>
	<div id="dialogbox">
		<div>
			<div id="dialogboxhead"></div>
			<div id="dialogboxbody"></div>
			<div id="dialogboxfoot"></div>
		</div>
	</div>


	<div class="menu">
		<ul>
			<li>
				<a href="<?php echo base_url() ?>eexam/course/courseController/participant_page_c/<?php echo $module_id ?>" >Participants</a>
			</li>
		</ul>
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call miniMenu ?> 	
	</div>

	<div class="content">

		<h4  id="report_notification" ><?php echo $courseData['module_name']; ?></h4>
		<h5><?php echo $error; ?> </h5>


		<div class="create_button_content">
		<?php
			if ($permit>=$needed)
			{			
		?>
			
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/creat_exam_c/<?php echo $module_id ?>" > Create Exam </a>
			</div>

		<?php } ?>

			<h1>Exams</h1> 
			<hr>
		</div>		

			<?php
				echo $examError;
				if (isset($allExams))
				{
						$index = 1;
						foreach ($allExams as $exam) 
						{
							$myLink = base_url('eexam/course/courseController/exam_assign_question_c/').$exam['exam_id']."/".$exam['course_id'];
							$message = 'When attending the exam,<br>Keep your eye focused on the examination page only and do not reload this page or visit other pages, because any temptation of what said above, will be considered as a cheating case.<br><br>Are you ready to obey all of the instructions mentioned above?';
							$operation = 'attendExam';

							echo $index.'.';

							if ($permit<$needed)
							{
					?>
								<a onclick="confirmObj.render('<?php echo $operation; ?>','<?php echo $myLink; ?>','<?php echo $message; ?>')"> <?php echo $exam['exam_title'] ;?></a>
					<?php		
							} 
					?>	

						<?php
							if ($permit>=$needed)
							{			
						?>
								<a href="<?php echo $myLink; ?>"> <?php echo $exam['exam_title'] ;?></a>
								<a href="<?php echo base_url() ?>eexam/course/courseController/delete_exam_c/<?php echo $exam['exam_id']."/".$exam['course_id']; ?>">
									<button>Delete</button>
								</a>
								<a href="<?php echo base_url() ?>eexam/course/courseController/edit_exam_c/<?php echo $exam['exam_id']."/".$exam['course_id'];?>">
									<button>Edit</button>
								</a>
					  <?php 
							}
						?>

						<hr>
							
			<?php	
						$index++;		
						}
				} 
			?>

	</div>

	

<?php
	if ($permit>=$needed)
	{			
?>
	<div class="content">
		<div class="create_button_content">
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/creat_question_c/<?php echo $module_id ?>" > Create Question </a>
			</div> 

			<h1>Questions</h1>
			<hr>
		</div>	
			<?php
				echo $questionError;
				if (isset($allQuestions))
				{
					$index = 1;
					foreach ($allQuestions as $question) 
					{
		?>
						
						<?php echo $index ?> : 

							<a href="<?php echo base_url() ?>eexam/course/courseController/question_assign_answer_c/<?php echo $question['question_id']."/".$question['course_id']; ?>">
								 <?php echo $question['question_title'] ;?>
							 </a>

						<a href="<?php echo base_url() ?>eexam/course/courseController/delete_question_c/<?php echo $question['question_id']."/".$question['course_id']; ?>">
							<button>Delete</button>
						</a>

						<a href="<?php echo base_url() ?>eexam/course/courseController/edit_question_c/<?php echo $question['question_id']."/".$question['course_id']; ?>">
							<button>Edit</button>
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
}
 	$this->load->view('eexam/main_parts/footer');
 ?>

<script type="text/javascript" src="<?php echo base_url('assets/javascript/alerts.js'); ?>"></script>