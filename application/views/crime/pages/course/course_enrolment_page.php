<?php
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

		<h4  id="report_notification"><?php echo $courseData['module_name']; ?></h4>
		<h5><?php echo $error; ?> </h5>

		<h1>Browse a User</h1>

		<form id="brouseParticipant" method="post" action="<?php echo base_url() ?>eexam/course/courseController/course_brouse_participant_c/<?php echo $module_id ?>">
			<p>	
				<h5><?php echo form_error('username'); ?></h5>
				<input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="User Name" />
				<input type="submit" name="browse_button" value="Browse">
			</p>
		</form>

	</div>

<?php
	if (isset($the_user))
	{
?>
	<div class="content">

		<div id="enrolParticipant">
			<div class="create">
				<a href="<?php echo base_url() ?>eexam/course/courseController/course_enrol_participant_c/<?php echo $module_id."/".$the_user['user_id'] ?> " > Enrol</a>
			</div>
		</div>
			<b> <?php echo $the_user['username']; ?> </b>  ( role: <?php echo $the_user['role_name']; ?> ) 
		<hr>
	</div>
<?php
	}
?>



<?php 
	}
 	$this->load->view('eexam/main_parts/footer');
 ?>

