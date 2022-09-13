<nav> 
	<ul>

		<?php
		$permition = $this->session->userdata('permit');


		$needed_home = $this->session->userdata('homepagePermit');
		if ($permition>=$needed_home)
		{
		?>
			<li>

				<a href="<?php echo base_url() ?>crime/CrimeController/home_c" 
				id ="<?php  if( $_SESSION['page_name']=='home'){echo "selected";}else{echo "not_selected";}; ?>" > Home </a>
			</li>

		
		<?php
		}

		$needed_testimony = $this->session->userdata('homepagePermit');
		if ($permition>=$needed_testimony)
		{
		?>
			<li>

				<a href="<?php echo base_url() ?>crime/CrimeController/testimony_c" 
				id ="<?php  if( $_SESSION['page_name']=='testimony'){echo "selected";}else{echo "not_selected";}; ?>" > Testimony </a>
			</li>

		
		<?php
		}

		// $needed_crime_identification = $this->session->userdata('crimepagePermit');
		// if ($permition>=$needed_crime_identification)
		// { 
		// ?>
			 <!-- <li><a href="<?php //echo base_url() ?>crime/CrimeController/crime_pg_controller" 
		 		id ="<?php// if( $_SESSION['page_name']=='identification'){echo "selected";}else{echo "not_selected";}; ?>" > Crime Identification </a>
		// 	</li> -->

		 <?php
		// }

		$needed_admin = $this->session->userdata('adminpagePermit');
		if ($permition>=$needed_admin)
		{ 
		?>
			<li><a href="<?php echo base_url() ?>crime/CrimeController/user_pg_controller"  
				id ="<?php if( $_SESSION['page_name']=='user'){echo "selected";}else{echo "not_selected";}; ?>" > Site Administration </a>
			</li>
		<?php  
		}  
		?>

	</ul>
			
	
</nav>

