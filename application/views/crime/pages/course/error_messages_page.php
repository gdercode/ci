<?php
	$_SESSION['page_name']='course';
	$this->load->view('eexam/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
	$welcome_error = isset($welcome_error) ? $welcome_error : '';
?>
	<div class="content">
		
		<h5><?php echo $error; ?> </h5>
		<h5><?php echo $welcome_error; ?> </h5>
		<!-- <h1>Courses</h1> -->
<hr>
		
	</div>
	

<?php $this->load->view('eexam/main_parts/footer'); ?>

