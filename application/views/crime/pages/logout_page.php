<?php
	$this->load->view('crime/main_parts/header');  // call header 
?>
	<div class="logout">
		<a href="<?php  echo base_url() ?>crime/crimeController/login_c" > Login </a> 
	</div>

	<div id="para">	
		<div id="repImage">
		<p>	<img src="<?php echo base_url(); ?>assets/images/student.png"> </p> <br>
		</div>
		<div id="para">
			<p>	<h1>You are Logged out</h1> </p>
			
			<p>
				<h2>
					 This system is only allowed to be used by Our Students.
				</h2>
			</p>

			<!-- <p>
				<h3>You need first of all to login. </h3>
			</p> -->



			
		</div>
		
	</div>
<?php $this->load->view('crime/main_parts/footer'); ?>
