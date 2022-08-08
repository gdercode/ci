<?php
						// for sessions and Menu and Errors handling 
//----------------------------------------------------------------------------------------------------------------------------------

	$permit = $this->session->userdata('permit');
	$needed = $this->session->userdata('courseCreatePermit');

	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div id="validateEyeTrainingOverlay"></div>


	<button onclick="buttonValidation('1')" class="validateEyeTrainingBtn" id="validateEyeBtn1" > Click </button>
	<button onclick="buttonValidation('2')" class="validateEyeTrainingBtn" id="validateEyeBtn2" > Click </button>
	<button onclick="buttonValidation('3')" class="validateEyeTrainingBtn" id="validateEyeBtn3" > Click </button>
	<button onclick="buttonValidation('4')" class="validateEyeTrainingBtn" id="validateEyeBtn4" > Click </button>
	<button onclick="buttonValidation('5')" class="validateEyeTrainingBtn" id="validateEyeBtn5" > Click </button>
	<button onclick="buttonValidation('6')" class="validateEyeTrainingBtn" id="validateEyeBtn6" > Click </button>
	<button onclick="buttonValidation('7')" class="validateEyeTrainingBtn" id="validateEyeBtn7" > Click </button>
	<button onclick="buttonValidation('8')" class="validateEyeTrainingBtn" id="validateEyeBtn8" > Click </button>
	<button onclick="buttonValidation('9')" class="validateEyeTrainingBtn" id="validateEyeBtn9" > Click </button>

	
 	<div id="dialogoverlay"></div>
	<div id="dialogbox">
		<div>
			<div id="dialogboxhead"></div>
			<div id="dialogboxbody"></div>
			<div id="dialogboxfoot"></div>
		</div>
	</div>

	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$questionError = isset($questionError) ? $questionError : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';
	$exam_id = isset($examData) ? $examData['exam_id'] : '';
	$submition_status = isset($submition) ? $submition['submition_status'] : '';

	if (isset($examData))
	{
		$startTimestamp = $examData['exam_open_date']." ".$examData['exam_open_time'];
		$endTimestamp = $examData['exam_close_date']." ".$examData['exam_close_time'];
		date_default_timezone_set('Africa/Kigali');
		$now = date('Y-m-d H:i:s');
	}

//----------------------------------------------------------------------------------------------------------------------------------
?>
	<!-- Initial data -->
	<input id="submition_status" type="hidden" value="<?php echo $submition_status; ?>">      <!--  submition_status -->
	<input id="startTimestamp" type="hidden" value="<?php echo $startTimestamp; ?>">      <!--  startTimestamp -->
	<input id="endTimestamp" type="hidden" value="<?php echo $endTimestamp; ?>">      <!--  endTimestamp -->
	<input id="now" type="hidden" value="<?php echo $now; ?>">      <!--  now -->
	<input id="permit" type="hidden" value="<?php echo $permit; ?>">      <!--  now -->

				<!-- First content -->
<!-- //---------------------------------------------------------------------------------------------------------------------------------- -->
	<div class="content">	
		<h5><?php echo $error; ?> </h5>
		<div class="create_button_content">
<?php
		if ($permit>=$needed)
		{
?>
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/exam_report_c/<?php echo $exam_id."/".$module_id ?>" > Report </a>
			</div>
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/add_question_c/<?php echo $exam_id."/".$module_id ?>" > Add Questions </a>
			</div>
<?php
		}
?>
		</div>	
	    <b  id="report_notification" ><?php echo $courseData['module_name']; ?></b>
	</div>

				<!-- secont content -->
<!-- //---------------------------------------------------------------------------------------------------------------------------------- -->

	<div class="content">
		<h4> <b id="courseAndexamTitle"> <?php echo $examData['exam_title']; ?> Questions  </b> </h4>
		<b id="report_notification" >
			<span id="eye_focus_lost_number"></span> 
			<span id="page_focus_lost_number"></span> 
		</b>
		<hr>
<?php
  				//for all questions 
//----------------------------------------------------------------------------------------------------------------------------------	
		echo $questionError;
	if (isset($allQuestions)) 
	{
		foreach($allQuestions as $key => $question)
		{
					// display question
//----------------------------------------------------------------------------------------------------------------------------------
?>
		<div class ="questionsBox">
			<span class="answered_notification" id="<?php echo $question['question_id'].'notification' ;?>" > 
<?php			
				if (!empty($question['user_answer'])) 
				{
					echo '&#10004;';
				}
?>
			</span>
			<a class="questionLink" href="#" >
				<?php echo $question['question_title'] ;?>
				<input id="choiceBox_id" type="hidden" class="baseURL" value="<?php echo $question['question_id'] ;?>">
			</a>
<?php
//----------------------------------------------------------------------------------------------------------------------------------

				// for each question report
//----------------------------------------------------------------------------------------------------------------------------------
			if (!empty($student_report) )
			{	
				if (isset($student_report['answer'][$question['question_id']])) 
				{
					if ($student_report['answer'][$question['question_id']]['result']>1000)
					{
						echo '<b id="report_notification"> not graded </b> <br>';
					}
					elseif ($student_report['answer'][$question['question_id']]['result'] >= $question['question_grade']/2)
					{
						echo '<b id="vrai"> &#10004;</b>';
						echo $student_report['answer'][$question['question_id']]['result']."/".$question['question_grade']." pts <br>" ;
					}
					else
					{
						echo '<b id="faux"> &#x2718;</b>';
						echo $student_report['answer'][$question['question_id']]['result']."/".$question['question_grade']." pts <br>" ;
					}
					
				}
				else
				{
					echo "0/".$question['question_grade']." pts " ;
					echo '<b id="wrong_report_notification"> not answered </b> <br>';
				}
			}
			else
			{
				echo '<br>';
			}
//----------------------------------------------------------------------------------------------------------------------------------

													// for Choices 
//----------------------------------------------------------------------------------------------------------------------------------
			if($question['question_category'] == 'essay' OR $question['question_category'] == 'short_answer')
			{
				$answer = $question['user_answer'];
?>
				<div class="choiceBox" id="<?php echo $question['question_id']?>">
				<h5><?php echo form_error('answer_title'); ?></h5>
				<form>
					<textarea id="answer_title" name="answer_title" rows="4" cols="60" placeholder="Question label" ><?php echo $answer ?></textarea>
					<input id="module_id" type="hidden" name="course_id" value="<?php echo $module_id;  ?> "/>
					<input id="question_id" type="hidden" name="question_id" value="<?php echo $question['question_id'];  ?> "/>
					<input id="exam_id" type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
					<input id="baseURL" type="hidden" class="baseURL" value="<?php echo base_url() ?>">
					<br>
					<input type="submit" name="answer" value="Save" id="saveBtn">
				</form>
				<br>
				</div>
<?php
			}
			else
			{
				if (empty($question['choices'])) 
				{
?>
					<div class="choiceBox" id="<?php echo $question['question_id']?>">
						<form id="wrong_report_notification">Sorry there is no Choice Made</form>
					</div>
<?php					
				}
				else
				{
?>
					<div class="choiceBox" id="<?php echo $question['question_id']?>" >
					<h5><?php echo form_error('answer_title'); ?></h5>
					<form method="post" action="<?php echo base_url() ?>eexam/course/courseController/insert_exam_answer_question_c/">
<?php
						$check = "";
						foreach($question['choices'] as $key => $choice)
						{
							
							if($question['user_answer'] == $choice['answer_title']){
								$check = "checked";
							}
							else{
								$check = "";
							}
?>
							<input class="answer_title" type="radio" name="answer_title" value="<?php echo $choice['answer_title'] ;?>"  <?php echo $check; ?>  >
							<a> <?php echo $choice['answer_title'] ;?> </a>
							<br>
<?php	
						} 
?>
						<input id="module_id" type="hidden" name="course_id" value="<?php echo $module_id;  ?> "/>
						<input id="question_id" type="hidden" name="question_id" value="<?php echo $question['question_id'];  ?> "/>
						<input id="exam_id" type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
						<input id="baseURL" type="hidden" class="baseURL" value="<?php echo base_url() ?>">
						<input type="submit" name="answer" value="Save" id="saveBtn2">
					</form>
					<br>
					</div>
<?php
				}
			}

//----------------------------------------------------------------------------------------------------------------------------------



				// 	for remove question into list of questions (admin)
//----------------------------------------------------------------------------------------------------------------------------------

			if ($permit>=$needed)
			{			
?>
				<a href="<?php echo base_url() ?>eexam/course/courseController/exam_remove_question_connection_c/<?php echo $module_id."/".$question['question_id']."/".$examData['exam_id']; ?>">
				<button>Remove</button>
				</a>
				<br>
				<hr>
<?php 
			} 
?>
		</div>
<?php
		}
	}

//----------------------------------------------------------------------------------------------------------------------------------

							// for total report (all questions) 
//----------------------------------------------------------------------------------------------------------------------------------

			if (!empty($student_report) )
			{
				if ($student_report['total_result']>1000)
				{
					echo '<h5> Some marks are missing <h5><hr>';
				}
				else
				{
					echo "TOTAL = ".$student_report['total_result']."/".$maximum." pts <hr>" ;
				}
			}
//----------------------------------------------------------------------------------------------------------------------------------

					// For Student only 
//----------------------------------------------------------------------------------------------------------------------------------
		
		if ($permit<$needed)          
		{
			if (isset($examData))
			{
				$startTimestamp = $examData['exam_open_date']." ".$examData['exam_open_time'];
				$endTimestamp = $examData['exam_close_date']." ".$examData['exam_close_time'];
				date_default_timezone_set('Africa/Kigali');
				$now = date('Y-m-d H:i:s');
			}

					// during examination time 
//----------------------------------------------------------------------------------------------------------------------------------
			if ($now >= $startTimestamp AND $now <= $endTimestamp)
			{
				if ($submition['submition_status']!='submit') 
				{
?>
					<button id="startBtn">
						Show Questions
						<input id="module_id" type="hidden" name="course_id" value="<?php echo $module_id;  ?> "/>
						<input id="exam_id" type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
						<input id="baseURL" type="hidden" class="baseURL" value="<?php echo base_url() ?>">
						<br>
					</button>
					<button id="submitBtn">
						Submit exam
						<input id="module_id" type="hidden" name="course_id" value="<?php echo $module_id;  ?> "/>
						<input id="exam_id" type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
						<input id="baseURL" type="hidden" class="baseURL" value="<?php echo base_url() ?>">
						<br>
					</button>
	<?php 
				}
				else
				{
					 echo '<h3>Exam already submitted</h3>';
				}
			}
//----------------------------------------------------------------------------------------------------------------------------------
?>
						<!-- javascript inclusion -->
<!-- //---------------------------------------------------------------------------------------------------------------------------------- -->
<?php
		}
?>
 	</div>




 <!-- //---------------------------------------------------------------------------------------------------------------------------------- -->
	<div id="eyeTrackingJs">
		<!-- <script type="text/javascript" src="https://webgazer.cs.brown.edu/webgazer.js?"></script> -->
		<script type="text/javascript" src="<?php echo base_url('assets/javascript/webgazer.js'); ?>"></script>
	</div>	
	<script type="text/javascript" src="<?php echo base_url('assets/javascript/jquery.3.min.js'); ?>"></script>
 	<script type="text/javascript" src="<?php echo base_url('assets/javascript/assign_question_page.js'); ?>"></script>
	

	

 <?php
 	$this->load->view('eexam/main_parts/footer');

 ?>

