<?php
	$_SESSION['page_name']='user';
	$this->load->view('eexam/main_parts/header');  // call header 

		$error = isset($error) ? $error : '';
		$username = isset($username) ? $username : ''; 
?>

<div class="menu">
	<?php	$this->load->view('eexam/main_parts/menu'); 	// call menu ?> 
</div>
<div class="imgRegisterBox">
		<h1>Take a Photo</h1>
</div>
<br>
	<div class="container">
		<form method="post" action="<?php echo base_url() ?>eexam/user/userController/img_upload_c" >
	        <!-- hidden image for upload -->
	        <input type="hidden" name="image" class="image-tag">
	        <input type="hidden" name="username" value="<?php echo $username ;?>">
	       
	        <!-- images  -->
	        <div id="imageContent">
	            <div id="web_cam"></div>
	            <div id="response">
	                <label> Image will appear here </label>
	            </div>
	        </div>

	        <!-- buttons -->
	        <div class="imgBattons">
	            <input type=button value="Capture" onClick="take_snapshot()">
	            <button id="submitBtn">Submit</button>
	        </div>
            
            <!-- images name for upload -->
            <div id="pictureName">
                <div class="imgName">
                    <input type="radio" name="imgName" value="1" checked> <label>First Image</label>
                </div>
                <div class="imgName">
                    <input type="radio" name="imgName" value="2"> <label>Second Image</label> 
                </div>
                <div class="imgName">  
                    <input type="radio" name="imgName" value="3"> <label>Third Image</label> 
                </div>
                <div class="imgName">  
                    <input type="radio" name="imgName" value="4"> <label>Fourth Image</label>  
                </div>
            </div>
    
        </form>
    </div>

    <!-- current images  -->
	<div id="userImages">
		<?php 
			$imgPath = base_url('assets/images/users/'.$username);

			for ($i=1; $i <= 4; $i++) 
			{ 
				if (is_file('assets/images/users/'.$username.'/'.$i.'.jpg'))
				{
		?>
				<div id="userImage">
					<img src="<?php echo $imgPath.'/'.$i.'.jpg'; ?>" >
				</div>
		<?php 
				}
				else
				{
		?>
					<div id="noUserImage">
						<label> No Image </label>
					</div>
		<?php 
				}
			}	
			
		?>
	</div>
	

	<!-- javascripts -->
	<script src="<?php echo base_url('assets/javascript/jquery.3.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/javascript/face-registration/webcam.min.js'); ?>"></script>
 	<script src="<?php echo base_url('assets/javascript/face-registration/face-registration.js'); ?>"></script>
	
<?php $this->load->view('eexam/main_parts/footer'); ?>