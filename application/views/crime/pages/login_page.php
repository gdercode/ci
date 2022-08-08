<?php
$this->load->view('crime/main_parts/header'); ?>

<div id="logContainer">

	<div id="loginBox">

		<h1>Login</h1>
			
		<form id="loginForm" method="post">
			<h3> <?php echo $error; ?> </h3>
			<p>	
				<h5><?php echo form_error('log_username'); ?></h5>
				<input type="text" name="log_username" value="<?php echo set_value('log_username'); ?>" placeholder="Username" />
			</p>
			<p>
				<h5><?php echo form_error('log_password'); ?></h5>
				<input type="password" name="log_password" value="<?php echo set_value('log_password'); ?>" placeholder="Password" />
			</p>

			<p> <input type="submit" name="Login_button" value="LOGIN"> </p>

		</form>
		<br>

	</div>

</div>


<?php $this->load->view('crime/main_parts/footer'); ?>
