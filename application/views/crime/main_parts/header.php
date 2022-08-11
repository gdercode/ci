<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	 <link rel = "stylesheet" type = "text/css"
	 href = "<?php echo base_url(); ?>assets/css/style.css">
	<title> Criminal Identification System </title>
</head>

<body>
	<div class="container">
		<?php
			if ($this->session->userdata('permit')) 
			{
				$userDetails = $this->session->userdata('user_details');

		?>
			<div class="logout"> 
				<b><?php echo $userDetails['username'];  ?></b> 
				<a href="<?php  echo base_url() ?>crime/CrimeController/logout_c" > Logout  </div></a> 

		<?php

			}
		?>
			<center><nav class="menu_breadge">
				<!-- empty part for desine  -->
			</nav></center>
			<center><nav class="menu_breadge">
				<font color="White" size="7px"> <b>Criminal Identification System</b> </font> 
			</nav></center>
			<center><nav class="menu_breadge">
				<!-- empty part for desine  -->
			</nav></center>

			 <!-- <img src="<?php// echo base_url(); ?>assets/images/law_icon.png" height="50" align="left">
			<div class="company_name">
				<font size ='5' color="gray">
					<b>Criminal Identification System</b>	
				</font> <br>
				<font color="gray"> CIS </font>
			</div> -->



			
			