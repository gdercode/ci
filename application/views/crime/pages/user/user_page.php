<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$this->load->view('crime/pages/user/user_page_blocks/miniMenu'); 	// call miniMenu

?>
	<div id="para">
		<h2 color="red"> User page</h2>
	</div>

	<div id="para">	
		<div id="repImage">
			<img src="<?php echo base_url(); ?>assets/images/law_icon.png">
		</div>
	</div> 

<?php $this->load->view('crime/main_parts/footer'); ?>
