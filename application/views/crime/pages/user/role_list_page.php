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
	<h1>Users List</h1>
	<table>
		<div id="cont">
		<thead>
			<tr>
				<th> Role Name </th>
				<th> Role Percentage </th>
				<th> Edit </th>
			</tr>
		</thead>
		<tbody>
			<?php
				if (isset($all_role)) 
				{
					foreach ($all_role as $result) // get row by row data to avoid array 
					{
			?>
						<tr>
							<td> <?php echo $result['role_name']; ?> </td>
							<td> <?php echo $result['role_percentage']; ?> </td>
							<td>
								<form method="post" action="<?php echo base_url() ?>crime/user/userController/role_find_list_c" >
									<input type="submit" value="Edit" name="edit_button">
									<input type="hidden" name="role_id" value="<?php echo $result['role_id'];  ?> "/>
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