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

		<h1>Register Wanted</h1>

		<form id="registerForm" method="post">
			 <h3><?php echo $error; ?> </h3>

			<p>	
				<h5><?php echo form_error('wanted_first_name'); ?></h5>
				<input type="text" name="wanted_first_name" value="<?php echo set_value('wanted_first_name'); ?>" placeholder="First Name" />
			</p>
			<p>	
				<h5><?php echo form_error('wanted_last_name'); ?></h5>
				<input type="text" name="wanted_last_name" value="<?php echo set_value('wanted_last_name'); ?>" placeholder="Last Name" />
			</p>
			<p>	
				<h5><?php echo form_error('wanted_gender'); ?></h5>
				<input type="text" name="wanted_gender" value="<?php echo set_value('wanted_gender'); ?>" placeholder="Gender" />
			</p>

			<p>	
				<h5><?php echo form_error('wanted_age'); ?></h5>
				<input type="text" name="wanted_age" value="<?php echo set_value('wanted_age'); ?>" placeholder="Age" />
			</p>
			
			<p> <input type="submit" name="reg_button" value="Send"> </p>

		</form>

	</div>

</div>

<?php $this->load->view('crime/main_parts/footer'); ?>