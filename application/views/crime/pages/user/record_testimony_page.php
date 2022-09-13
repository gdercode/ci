<?php
	$_SESSION['page_name']='testimony';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
		$error = isset($error) ? $error : '';
		$wanted_id = isset($the_wanted) ? $the_wanted['wanted_id'] : ''; 
		$wanted_first_name = isset($the_wanted) ? $the_wanted['wanted_first_name'] : ''; 
		$wanted_last_name = isset($the_wanted) ? $the_wanted['wanted_last_name'] : ''; 
		$wanted_gender = isset($the_wanted) ? $the_wanted['wanted_gender'] : ''; 
		$wanted_age = isset($the_wanted) ? $the_wanted['wanted_age'] : ''; 
?>
					<!-- IMAGES OF THE WANTED -->
    <!-- current images  -->
	<br><div id="userImages"> 
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

 

    <!-- //////////////// -->
	
<div id="logContainer_browse">
	
	<div class="testimony_tables">
		<table>
			<thead>
				<tr>
					<th> Wanted FN </th>
					<th> Wanted LN </th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> <?php echo $wanted_first_name; ?> </td>
					<td> <?php echo $wanted_last_name; ?> </td>
				</tr>
			</tbody>
		</table>
	
	<form  method="post" action="<?php echo base_url() ?>crime/user/userController/add_testimony_c" >
		 <h3><?php echo $error; ?> </h3>
		 <h5><?php echo form_error('testimony_area'); ?></h5>
		<input type="hidden"  name="wanted_id" value="<?php echo $wanted_id;  ?>" />
		<textarea id="testimony_area" name="testimony_area"></textarea>
		<p><input type="submit" name="send_button" value="SEND" > </p>
	</form>

			<h1>Testimony</h1>
			<hr>

			<?php
				if(isset($the_wanted_testimonies))
				{
					foreach($the_wanted_testimonies as $the_result)
					{
			?>
			<div class="testimony_tables">
				<?php echo $the_result['testimony_date'] ; ?><br>
				<b class="weitness"><?php echo $the_result['user_first_name']; ?></b>&nbsp;&nbsp;
				<b class="weitness"><?php echo $the_result['user_last_name']; ?></b><br><br>
				<b class="testimony"><?php echo $the_result['testimony']; ?></b> 
			</div>
 
			<?php
						
					}
				}
			?>
	</div>
</div>

<?php $this->load->view('crime/main_parts/footer'); ?>