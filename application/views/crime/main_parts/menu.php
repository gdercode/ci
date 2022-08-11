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

		$needed_course = $this->session->userdata('coursepagePermit');
		if ($permition>=$needed_course)
		{ 
		?>
			<li><a href="<?php echo base_url() ?>crime/CrimeController/course_pg_controller" 
				id ="<?php if( $_SESSION['page_name']=='course'){echo "selected";}else{echo "not_selected";}; ?>" > Courses </a>
			</li>

		<?php
		}

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

