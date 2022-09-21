<?php
	$_SESSION['page_name']='identification';
	$this->load->view('crime/main_parts/header'); 

	$username = isset($username) ? $username : '';
?>
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
	




<div id="logContainer">

	<div id="loginBox">
		<input type="hidden" id="username" value="<?php //echo $username;  ?> "/>
		<input type="hidden" id="baseURL"  value="<?php // echo base_url(); ?>">
	</div>
	<center><b id="message" class="errorMessage" ></b></center>
</div>
<div id="display-image"></div>
<input type="file" id="image-input" name="image" accept="image/jpeg, image/png, image/jpg">
<label id="image-input-label" for="image-input">Upload</label>

<form>
	<input type="hidden" name="wanted_id">
	<input type="submit" id="submitBtn" name="">
	<label id="submitBtn-label" for="submitBtn">View</label>
</form>





<script difer src="<?php echo base_url('assets/javascript/face-login/face-api.min.js'); ?>"></script>
<script difer src=" <?= base_url('assets/javascript/jquery.3.min.js'); ?> "></script>
<script difer src="<?php echo base_url('assets/javascript/face-login/face-login.js'); ?>"></script>


<?php $this->load->view('crime/main_parts/footer'); ?>
