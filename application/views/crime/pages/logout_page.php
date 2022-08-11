<?php
	$this->load->view('crime/main_parts/header');  // call header 
?>
	<div class="logout">
		<a href="<?php  echo base_url() ?>crime/CrimeController/login_c" > Login </a> 
	</div>

	<div id="para">	
		<div id="repImage">
		<p>	<img src="<?php echo base_url(); ?>assets/images/law_icon.png"> </p> <br>
		</div>
		<div id="para">
			<p>	<h1>You are Logged out</h1> </p>
		</div>
		
	</div>
<?php $this->load->view('crime/main_parts/footer'); ?>
