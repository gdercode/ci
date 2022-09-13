<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 

		$error = isset($error) ? $error : '';
		$wanted_id = isset($the_wanted) ? $the_wanted['wanted_id'] : ''; 
?>

<div class="menu">
	<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
</div>
<div class="imgRegisterBox">
		<h1>Upload pictures</h1> 
</div>
<br>
	<div id="display-image"></div>
		
    <!-- current images  -->
	<div id="userImages">
		<?php 
			$imgPath = base_url('assets/images/users/'.$wanted_id);

			for ($i=1; $i <= 4; $i++) 
			{ 
				if (is_file('assets/images/users/'.$wanted_id.'/'.$i.'.jpg'))
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

	<div class="container"> 
		<form method="post" action="<?php echo base_url() ?>crime/user/userController/img_upload_c" enctype="multipart/form-data">
	        <!-- hidden image for upload -->
	        <input type="hidden" name="wanted_id" value="<?php echo $wanted_id ;?>">
	       
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

            	        <!-- buttons -->
	        <div class="imgBattons">
	            <input type="file" id="image-input" name="image" accept="image/jpeg, image/png, image/jpg">
	            <button id="submitBtn">Submit</button>
	        </div>
    
        </form>
    </div>
	

	<!-- javascripts -->
	<script src="<?php echo base_url('assets/javascript/jquery.3.min.js'); ?>"></script>
 	<script src="<?php echo base_url('assets/javascript/face-registration/face-registration.js'); ?>"></script>
	


	
<?php $this->load->view('crime/main_parts/footer'); ?>