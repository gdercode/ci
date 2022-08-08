<?php
	$permit = $this->session->userdata('permit');
	$needed = $this->session->userdata('courseCreatePermit');

	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 

	$error = isset($error) ? $error : '';
	$module_id = isset($courseData) ? $courseData['module_id'] : '';

	if(isset($courseData))
	{
?> 	
	<div class="menu">
		<ul>
			<li>
				<a href="<?php echo base_url() ?>eexam/course/courseController/participant_page_c/<?php echo $module_id ?>" >Participants</a>
			</li>
		</ul>
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call miniMenu ?> 	
	</div>

	<div class="content">

		<h4 id="report_notification" ><?php echo $courseData['module_name']; ?></h4>
		<h5><?php echo $error; ?> </h5>

		<div class="create_button_content">
		<?php
		if ($permit>=$needed)
		{			
		?>
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/enrol_users_page_c/<?php echo $module_id ?>" > Enrol users </a>
			</div>
		<?php } ?>
			<h1>Participants</h1> 
			<hr>
				<?php
					if (isset($allUsers))
					{	
						$index = 1;
						foreach ($allUsers as $participant) 
						{
				?>
							<?php echo $index ?> . <?php echo $participant['username'] ;?>

						<?php
						if ($permit>=$needed)
						{			
						?>
							<a href="<?php echo base_url() ?>eexam/course/courseController/user_course_remove_connection_c/<?php echo $participant['moduleID']."/".$participant['user_id']; ?>">
								<button>Remove</button>
							</a>
							<br>
						<?php } ?>
						<hr>
						
				<?php	
								$index++;		
							}
						} 
				?>
		</div>		
	</div>



<?php 
	}
 	$this->load->view('eexam/main_parts/footer');
 ?>

