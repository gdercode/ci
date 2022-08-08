<?php
$this->load->view('eexam/main_parts/header'); ?>
<?php
	$username = isset($username) ? $username : '';
?>

<div id="logContainer">

	<div id="loginBox">
		<h3 id="message" class="errorMessage" ></h3>
		<h2 id="secondMessage" class="errorMessage" >Recognition</h2>
		<div class="successMessage"><?php echo $username; ?></div>
		<input type="hidden" id="username" value="<?php echo $username;  ?> "/>
		<input type="hidden" id="baseURL"  value="<?php echo base_url(); ?>">
		<video id="videoInput" width="400" height="400" muted autoplay >

	</div>

</div>

<script difer src="<?php echo base_url('assets/javascript/face-login/face-api.min.js'); ?>"></script>
<script difer src=" <?= base_url('assets/javascript/jquery.3.min.js'); ?> "></script>
<script difer src="<?php echo base_url('assets/javascript/face-login/face-login.js'); ?>"></script>


<?php $this->load->view('eexam/main_parts/footer'); ?>
