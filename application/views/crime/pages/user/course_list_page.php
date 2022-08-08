<?php
	$_SESSION['page_name']='user';
	$this->load->view('crime/main_parts/header');  // call header 
?> 	
	<div class="menu">
		<?php	$this->load->view('crime/main_parts/menu'); 	// call menu ?> 
	</div>
<?php
	$error = isset($error) ? $error : '';
?>

<div id="table_box">
<div class="tables">
	<h3><?php echo $error; ?> </h3>
	<h1>Courses List</h1>
	<table>
		<div id="cont">
		<thead>
			<tr>
				<th> Module ID </th>
				<th> Module Name </th>
				<th> Module Credit </th>
				<th> Edit </th>
			</tr>
		</thead>
		<tbody>
			<?php
				if (isset($all_course)) 
				{
					foreach ($all_course as $result) // get row by row data to avoid array 
					{
			?>
						<tr>
							<td> <?php echo $result['module_id']; ?> </td>
							<td> <?php echo $result['module_name']; ?> </td>
							<td> <?php echo $result['module_credit']; ?> </td>
							<td>
								<form method="post" action="<?php echo base_url() ?>crime/user/userController/course_find_list_c" >
									<input type="submit" value="Edit" name="edit_button">
									<input type="hidden" name="module_id" value="<?php echo $result['module_id'];  ?> "/>
								</form>
							</td>
						</tr>
					
			<?php 

					}
				}
			?>
		</tbody>
		</div>	
	</table>
</div>
</div>



<?php $this->load->view('crime/main_parts/footer'); ?>