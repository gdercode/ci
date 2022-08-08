<?php
	$_SESSION['page_name']='home';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
?>
	<div id="para">	
		<h2> Home page </h2>
		<div id="repImage">
			<img src="<?php echo base_url(); ?>assets/images/law_icon.png">
		</div>
	</div>
	<div id="para">
		
		
	</div>
	
<?php $this->load->view('crime/main_parts/footer'); ?>
