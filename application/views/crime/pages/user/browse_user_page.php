<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
?>

<div id="logContainer">

	<div id="registerBox">

		<h1>Browse a User</h1>

		<form id="registerForm" method="post">
			 <h3><?php echo $error; ?> </h3>

			<p>	
				<h5><?php echo form_error('username'); ?></h5>
				<input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="User Name" />
			</p>
			
			<p> <input type="submit" name="browse_button" value="Browse"> </p>

		</form>

	</div>

</div>



<?php $this->load->view('crime/main_parts/footer'); ?>