<?php
class Crime_model extends CI_Model
{

//--------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

					//	FOR USER
// ------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------

	private $user_table = 'all_user_table';

//-------------------------------------------------------------------------------------

	public function insert_users( $firstname, $lastname, $email, $mobile, $username, $password, $role_id)
	{
		return $this->db->set( array(
										'user_id'=>'',
										'user_first_name' => $firstname,
										'user_last_name'  => $lastname,
										'user_email'      => $email,
										'user_mobile'     => $mobile,
										'username'        => $username,
										'user_password'   => $password,
										'user_role_id'         => $role_id
									) 
							 )
						->set( 'registration_date', 'NOW()', false)
						->set( 'user_update_date', 'NOW()', false)
						->insert( $this->user_table );
	}

//------------------------------------------------------------------------------------

public function get_user_password($user_id)
	{
	
		return $this->db->select('user_password')
						->from($this->user_table)
						->where('user_id',$user_id)
						->get()
						->row_array();
	}

//---------------------------------------------------------------------------------

	public function get_all_user()
	{
	
		return $this->db->select('`user_id`,`user_first_name`,`user_last_name`,`user_email`, `user_mobile`,`username`,`user_password`, DATE_FORMAT(`registration_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'registration_date\',DATE_FORMAT(`user_update_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'user_update_date\',`user_role_id`', false)
						->from($this->user_table)
						->order_by('user_id','desc')
						->get()
						->result_array();
	}

//-----------------------------------------------------------------------------------

	public function get_user($username)
	{
	
		return $this->db->select('`user_id`,`user_first_name`,`user_last_name`,`user_email`, `user_mobile`,`username`,`user_password`, DATE_FORMAT(`registration_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'registration_date\',DATE_FORMAT(`user_update_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'user_update_date\', `user_role_id`', false)
						->from($this->user_table)
						->order_by('user_id','desc')
						->where('username',$username)
						->get()
						->row_array();
	}

//----------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------

	public function get_user_id($user_id)
	{
	
		return $this->db->select('`user_id`,`user_first_name`,`user_last_name`,`user_email`, `user_mobile`,`username`,`user_password`, DATE_FORMAT(`registration_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'registration_date\',DATE_FORMAT(`user_update_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'user_update_date\', `user_role_id` ', false)
						->from($this->user_table)
						->order_by('user_id','desc')
						->where('user_id',$user_id)
						->get()
						->row_array();
	} 

//-----------------------------------------------------------------------------------

	public function get_user_email($email)
	{
	
		return $this->db->select('`user_id`,`user_first_name`,`user_last_name`,`user_email`, `user_mobile`,`username`,`user_password`, DATE_FORMAT(`registration_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'registration_date\',DATE_FORMAT(`user_update_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'user_update_date\',`user_role_id`', false)
						->from($this->user_table)
						->order_by('user_id','desc')
						->where('user_email',$email)
						->get()
						->result_array();
	}

//-----------------------------------------------------------------------------------

	public function get_user_phone($mobile)
	{
	
		return $this->db->select('`user_id`,`user_first_name`,`user_last_name`,`user_email`, `user_mobile`,`username`,`user_password`, DATE_FORMAT(`registration_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'registration_date\',DATE_FORMAT(`user_update_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'user_update_date\', `user_role_id`', false)
						->from($this->user_table)
						->order_by('user_id','desc')
						->where('user_mobile',$mobile)
						->get()
						->row_array();
	}
//----------------------------------------------------------------------------------

	public function get_user_permit($username)
	{
	
		return $this->db->select('`user_id`,`user_first_name`,`user_last_name`,`user_email`, `user_mobile`,`username`,`user_password`, DATE_FORMAT(`registration_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'registration_date\',DATE_FORMAT(`user_update_date`,\'%d/%m/%Y &agrave; %H:%i:%s\') AS \'user_update_date\', `all_user_table.user_role_id`, `role_name`, `role_percentage`')
						->from('all_user_table')
						->join('role_table', 'role_table.role_id = all_user_table.user_role_id')
						->order_by('user_id','desc')
						->where('username',$username)
						->get()
						->row_array();
	}

//-------------------------------------------------------------------------------

	public function update_user($user_id,$firstname,$lastname,$email,$mobile,$username,$password,$role_id)
	{
		return $this->db->set( array(
										'user_first_name'=>$firstname,
										'user_last_name'=>$lastname,
										'user_email'=>$email,
										'user_mobile'=>$mobile,
										'username'=>$username,
										'user_password'=>$password,
										'user_role_id'=>$role_id
									) 
							 )
						->set('user_update_date', 'NOW()',false)
						->where('user_id',$user_id)
						->update($this->user_table);
	}

//---------------------------------------------------------------------------------

	public function update_user_no_role($user_id,$firstname,$lastname,$email,$mobile,$username,$password)
	{
		return $this->db->set( array(
										'user_first_name'=>$firstname,
										'user_last_name'=>$lastname,
										'user_email'=>$email,
										'user_mobile'=>$mobile,
										'username'=>$username,
										'user_password'=>$password
									) 
							 )
						->set('user_update_date', 'NOW()',false)
						->where('user_id',$user_id)
						->update($this->user_table);
	}

//-----------------------------------------------------------------------------------

	public function update_user_no_password($user_id,$firstname,$lastname,$email,$mobile,$username,$role_id)
	{
		return $this->db->set( array(
										'user_first_name'=>$firstname,
										'user_last_name'=>$lastname,
										'user_email'=>$email,
										'user_mobile'=>$mobile,
										'username'=>$username,
										'user_role_id'=>$role_id
									) 
							 )
						->set('user_update_date', 'NOW()')
						->where('user_id',$user_id)
						->update($this->user_table);
	}

//-----------------------------------------------------------------------------------

	public function update_user_no_password_and_role($user_id,$firstname,$lastname,$email,$mobile,$username)
	{
		return $this->db->set( array(
										'user_first_name'=>$firstname,
										'user_last_name'=>$lastname,
										'user_email'=>$email,
										'user_mobile'=>$mobile,
										'username'=>$username
									) 
							 )
						->set('user_update_date', 'NOW()')
						->where('user_id',$user_id)
						->update($this->user_table);
	}

//------------------------------------------------------------------------------------

	public function delete_user($user_id)
	{
		return $this->db->where('user_id',$user_id)->delete($this->user_table);
	}


//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------
//----------------------------------------------------------------------------------


				//		FOR ROLE
//-----------------------------------------------------------------------------------

	private $role_table = 'role_table';

//-------------------------------------------------------------------------------------

	public function insert_role($role_name,$role_percentage)
	{
		return $this->db->set( array(
										'role_id'			=>'',
										'role_name'			=>$role_name,
										'role_percentage'	=>$role_percentage
									) 
							 )
						->insert($this->role_table);
	}

//------------------------------------------------------------------------------------

	public function get_all_role()
	{
	
		return $this->db->select('`role_id`,`role_name`,`role_percentage`', false)
						->from($this->role_table)
						->order_by('role_id','desc')
						->get()
						->result_array();
	}

//-----------------------------------------------------------------------------------

	public function get_role($rolename)
	{
	
		return $this->db->select('`role_id`,`role_name`,`role_percentage`', false)
						->from($this->role_table)
						->order_by('role_id','desc')
						->where('role_name',$rolename)
						->get()
						->row_array();
	}

//------------------------------------------------------------------------------------

	public function update_role($role_id,$role_name,$role_percentage)
	{
		return $this->db->set( array(
										'role_name'=>$role_name,
										'role_percentage'=>$role_percentage
									) 
							 )
						->where('role_id',$role_id)
						->update($this->role_table);
	}

//------------------------------------------------------------------------------

	public function get_role_id($role_id)
	{
	
		return $this->db->select('`role_id`,`role_name`,`role_percentage`', false)
						->from($this->role_table)
						->order_by('role_id','desc')
						->where('role_id',$role_id)
						->get()
						->row_array();
	}

//-----------------------------------------------------------------------------

	public function delete_role($role_id)
	{
		return $this->db->where('role_id',$role_id)->delete($this->role_table);
	}

//------------------------------------------------------------------------------

					//	OTHER COMMENTS
//------------------------------------------------------------------------------

	// public function count()
	// {
	// 	return $this->db->count_all($this->table);
	// }

}


?>