<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
?>

<div id="logContainer">

	<div id="registerBox">

		<h1>Create a User role</h1>

		<form id="registerForm" method="post">
			 <h3><?php echo $error; ?> </h3>

			<p>	
				<h5><?php echo form_error('role_name'); ?></h5>
				<input type="text" name="role_name" value="<?php echo set_value('role_name'); ?>" placeholder="Role Name" />
			</p>

			<p>	
				<h5><?php echo form_error('role_percentage'); ?></h5>
				<input type="text" name="role_percentage" value="<?php echo set_value('role_percentage'); ?>" placeholder="Role Percentage" />
			</p>
			
			<p> <input type="submit" name="reg_button" value="Create"> </p>

		</form>

	</div>

</div>

<?php $this->load->view('crime/main_parts/footer'); ?>