<?php
	$_SESSION['page_name']='user';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';

		$module_id = isset($the_course) ? $the_course['module_id'] : ''; 
		$module_name = isset($the_course) ? $the_course['module_name'] : ''; 
		$module_credit = isset($the_course) ? $the_course['module_credit'] : ''; 
?>

<div id="logContainer_browse">

	<div id="registerBox">

		<h1>Edit Course</h1>

		<form id="registerForm" method="post" action="<?php echo base_url() ?>eexam/user/userController/manipulate_course_c" >
			 <h3><?php echo $error; ?> </h3>
			
			<input type="hidden"  name="module_id" value="<?php echo $module_id;  ?>" />
			<p>	
				<h5><?php echo form_error('module_name'); ?></h5>
				Role Name <br> <input type="text" name="module_name" value="<?php echo $module_name;  ?>" placeholder="Module Name" />
			</p>
			<p>	
				<h5><?php echo form_error('module_credit'); ?></h5>
				Role Percentage <br> <input type="text" name="module_credit" value="<?php echo $module_credit; ?>" placeholder="Module Credit" />
			</p>
			
			<p><input type="submit" name="update_button" value="Update Course" > </p>
			<p><input type="submit" name="delete_button" value="Delete Course" > </p>

		</form>

	</div>

</div>

<?php $this->load->view('eexam/main_parts/footer'); ?>