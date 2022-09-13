<?php
	$_SESSION['page_name']='identification';
	$this->load->view('crime/main_parts/header'); 

	$username = isset($username) ? $username : '';
?>
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>


		<input type="file" id="imageUpload">

		<div class="imgBattons">
            <input type="file" id="image-input" name="image" accept="image/jpeg, image/png, image/jpg">
            <button id="submitBtn" onclick="recognize_face()">Identify</button> 
        </div>




<div id="logContainer">

	<div id="loginBox">
		<h3 id="message" class="errorMessage" ></h3>
		<h2 id="secondMessage" class="errorMessage" >Recognition</h2>
		<div class="successMessage"><?php //echo $username; ?></div>
		<input type="hidden" id="username" value="<?php //echo $username;  ?> "/>
		<input type="hidden" id="baseURL"  value="<?php // echo base_url(); ?>">
		<!-- <div id="imageBoxView" width="400" height="400" > </div> -->
	</div>
	

</div>
<div id="display-image"></div>

<script difer src="<?php echo base_url('assets/javascript/face-login/face-api.min.js'); ?>"></script>
<script difer src=" <?= base_url('assets/javascript/jquery.3.min.js'); ?> "></script>
<script difer src="<?php echo base_url('assets/javascript/face-login/face-login.js'); ?>"></script>


<?php $this->load->view('crime/main_parts/footer'); ?>
