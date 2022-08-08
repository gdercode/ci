<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';

		$role_id = isset($the_role) ? $the_role['role_id'] : ''; 
		$role_name = isset($the_role) ? $the_role['role_name'] : ''; 
		$role_percentage = isset($the_role) ? $the_role['role_percentage'] : ''; 
?>

<div id="logContainer_browse">

	<div id="registerBox">

		<h1>Edit Role</h1>

		<form id="registerForm" method="post" action="<?php echo base_url() ?>crime/user/userController/manipulate_role_c" >
			 <h3><?php echo $error; ?> </h3>

			 <input type="hidden" name="role_id" value="<?php echo $role_id;  ?> "/>
			<p>	
				<h5><?php echo form_error('role_name'); ?></h5>
				Role Name <br> <input type="text" name="role_name" value="<?php echo $role_name;  ?>" placeholder="Role name" />
			</p>
			<p>	
				<h5><?php echo form_error('role_percentage'); ?></h5>
				Role Percentage <br> <input type="text" name="role_percentage" value="<?php echo $role_percentage; ?>" placeholder="Role Percentage" />
			</p>
			
			<p><input type="submit" name="update_button" value="Update role" > </p>
			<p><input type="submit" name="delete_button" value="Delete role" > </p>

		</form>

	</div>

</div>

<?php $this->load->view('crime/main_parts/footer'); ?>