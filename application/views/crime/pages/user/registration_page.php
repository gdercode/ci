<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$select_error = isset($select_error) ? $select_error : '';
?>

<div id="logContainer">

	<div id="registerBox">

		<h1>Registration</h1>

		<form id="registerForm" method="post">
			 <h3><?php echo $error; ?> </h3>

			<p>	
				<h5><?php echo form_error('reg_firstname'); ?></h5>
				<input type="text" name="reg_firstname" value="<?php echo set_value('reg_firstname'); ?>" placeholder="First name" />
			</p>
			<p>	
				<h5><?php echo form_error('reg_lastname'); ?></h5>
				<input type="text" name="reg_lastname" value="<?php echo set_value('reg_lastname'); ?>" placeholder="Last name" />
			</p>
			<p>	
				<h5><?php echo form_error('reg_username'); ?></h5>
				<input type="text" name="reg_username" value="<?php echo set_value('reg_username'); ?>" placeholder="Username" />
			</p>
			<p>	
				<h5><?php echo form_error('reg_email'); ?></h5>
				<input type="text" name="reg_email" value="<?php echo set_value('reg_email'); ?>" placeholder="Email" />
			</p>
			<p>
				<h5><?php echo form_error('reg_password'); ?></h5>
				<input type="password" name="reg_password" value="<?php echo set_value('reg_password'); ?>" placeholder="Password" />
			</p>
			<p>
				<h5><?php echo form_error('reg_conf_password'); ?></h5>
				<input type="password" name="reg_conf_password" value="<?php echo set_value('reg_conf_password'); ?>" placeholder="Confirm Password" />
			</p>
			<p>
				<h5><?php echo form_error('reg_mobile'); ?></h5>
				<input type="text" name="reg_mobile" value="<?php echo set_value('reg_mobile'); ?>" placeholder="Mobile" />
			</p>

			<p>
				<h5><?php echo $select_error; ?> </h5>
				<select name="role_name_selection"  class ="role_name_selection">
				
					<option value="none" <?php echo set_select('role_name_selection','none')  ?> >Select User Role</option>
					<?php 
						if (isset($allRolles)) 
						{
							foreach($allRolles as $role)
							{
					?>
								<option 
										value=<?php echo $role['role_id']; ?> 
										<?php echo set_select('role_name_selection',$role['role_id']) ; ?>   >

										<?php echo $role['role_name']; ?> 
								</option>
					<?php
							}
						}
					?>
				</select>
			</p>

			<p> <input type="submit" name="reg_button" value="REGISTER"> </p>

		</form>


	</div>

</div>

<?php $this->load->view('crime/main_parts/footer'); ?>