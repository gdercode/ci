<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
		$wanted_id = isset($the_wanted) ? $the_wanted['wanted_id'] : ''; 
		$wanted_first_name = isset($the_wanted) ? $the_wanted['wanted_first_name'] : ''; 
		$wanted_last_name = isset($the_wanted) ? $the_wanted['wanted_last_name'] : ''; 
		$wanted_gender = isset($the_wanted) ? $the_wanted['wanted_gender'] : ''; 
		$wanted_age = isset($the_wanted) ? $the_wanted['wanted_age'] : ''; 
?>

<div id="logContainer_browse">

	<div id="registerBox">

		<h1>Edit Wanted</h1>

		<form id="registerForm" method="post" action="<?php echo base_url() ?>crime/user/userController/manipulate_wanted_c" >
			 <h3><?php echo $error; ?> </h3>
			<p><input type="submit" name="image_button" value="Face" > </p>
			
			<input type="hidden"  name="wanted_id" value="<?php echo $wanted_id;  ?>" />
			<p>	
				<h5><?php echo form_error('wanted_first_name'); ?></h5>
				Wanted First Name <br> <input type="text" name="wanted_first_name" value="<?php echo $wanted_first_name;  ?>" placeholder="Wanted First Name" />
			</p>
			<p>	
				<h5><?php echo form_error('wanted_last_name'); ?></h5>
				Wanted Last Name <br> <input type="text" name="wanted_last_name" value="<?php echo $wanted_last_name;  ?>" placeholder="Wanted Last Name" />
			</p>
			<p>	
				<h5><?php echo form_error('wanted_gender'); ?></h5>
				Wanted Gender <br> <input type="text" name="wanted_gender" value="<?php echo $wanted_gender;  ?>" placeholder="Wanted Gender" />
			</p>
			<p>	
				<h5><?php echo form_error('wanted_age'); ?></h5>
				Wanted Age <br> <input type="text" name="wanted_age" value="<?php echo $wanted_age;  ?>" placeholder="Wanted Age" />
			</p>
			
			<p><input type="submit" name="update_button" value="Update Wanted" > </p>
			<p><input type="submit" name="delete_button" value="Delete Wanted" > </p>

		</form>

	</div>

</div>

<?php $this->load->view('crime/main_parts/footer'); ?>