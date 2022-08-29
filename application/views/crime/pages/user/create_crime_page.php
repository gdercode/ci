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

		<h1>Register Crime</h1>

		<form id="registerForm" method="post">
			 <h3><?php echo $error; ?> </h3>

			<p>	
				<h5><?php echo form_error('module_id'); ?></h5>
				<input type="text" name="module_id" value="<?php echo set_value('module_id'); ?>" placeholder="Module ID" />
			</p>

			<p>	
				<h5><?php echo form_error('module_name'); ?></h5>
				<input type="text" name="module_name" value="<?php echo set_value('module_name'); ?>" placeholder="Module Name" />
			</p>

			<p>	
				<h5><?php echo form_error('module_credit'); ?></h5>
				<input type="text" name="module_credit" value="<?php echo set_value('module_credit'); ?>" placeholder="Module Credit" />
			</p>
			
			<p> <input type="submit" name="reg_button" value="Create"> </p>

		</form>

	</div>

</div>

<?php $this->load->view('crime/main_parts/footer'); ?>