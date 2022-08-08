<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';

	$exam_id = isset($examData) ? $examData['exam_id'] : set_value('exam_id'); 
	$exam_title = isset($examData) ? $examData['exam_title'] : set_value('exam_title');
	$exam_description = isset($examData) ? $examData['exam_description'] : set_value('exam_description');
	$exam_open_date = isset($examData) ? $examData['exam_open_date'] : set_value('exam_open_date');
	$exam_open_time = isset($examData) ? $examData['exam_open_time'] : set_value('exam_open_time'); 
	$exam_close_date = isset($examData) ? $examData['exam_close_date'] : set_value('exam_close_date');
	$exam_close_time = isset($examData) ? $examData['exam_close_time'] : set_value('exam_close_time');
	$exam_pass_grade = isset($examData) ? $examData['exam_pass_grade'] : set_value('exam_pass_grade');
	$exam_grade = isset($examData) ? $examData['exam_grade'] : set_value('exam_grade');
	$module_id = isset($courseData) ? $courseData['module_id'] : set_value('module_id');

	if(isset($courseData))
	{
?>
	<div class="content">
		<h4 id="report_notification" ><?php echo $courseData['module_name']; ?></h4>
		<hr>
		
	 <div id="exam">
		<div id="examBox">

			<h2>Exam</h2>

			<form method="post" action="<?php echo base_url() ?>eexam/course/courseController/update_exam_c/<?php echo $module_id ?>" > 
				 <h3><?php echo $error; ?> </h3>

				 <input type="hidden" name="exam_id" value="<?php echo $exam_id;  ?> "/>
				
				<h5><?php echo form_error('exam_title'); ?></h5>
				<p>	<input id="examName" type="text" name="exam_title" value="<?php  echo $exam_title ;?>" placeholder="Exam Name" /> </p>

				<h5><?php echo form_error('exam_description'); ?></h5>
				<textarea name="exam_description" rows="4" cols="60" placeholder="Description"><?php echo $exam_description ; ?></textarea>
			

				<h5> <?php echo form_error('exam_open_date'); ?> <?php echo form_error('exam_open_time'); ?> </h5>
				Open exam:
				<input type="date" name="exam_open_date" value="<?php echo $exam_open_date; ?>" >
				<input type="time" name="exam_open_time" value="<?php echo $exam_open_time; ?>" >
			
				<h5> <?php echo form_error('exam_close_date'); ?> <?php echo form_error('exam_close_time'); ?> </h5>
				Close exam:
				<input type="date" name="exam_close_date" value="<?php echo $exam_close_date; ?>" >
				<input type="time" name="exam_close_time" value="<?php echo $exam_close_time; ?>" >
				

				<h5><?php echo form_error('exam_grade'); ?></h5>
				Grade:
				<input id="examGrade" type="text" name="exam_grade" value="<?php echo $exam_grade; ?>" placeholder ="Grade">

				<h5><?php echo form_error('exam_pass_grade'); ?></h5>				
				Pass grade:
				<input id="examPassGrade" type="text" name="exam_pass_grade" value="<?php echo $exam_pass_grade; ?>" placeholder ="Pass grade"> %
					
				<p> <input type="submit" name="update_button" value="Save Changes" > </p>


			</form>

		</div> 

	</div>
			

	</div>
	

<?php 

	}
 	$this->load->view('eexam/main_parts/footer');

 ?>

