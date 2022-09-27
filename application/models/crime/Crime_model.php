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
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

				//		FOR WANTED
//-----------------------------------------------------------------------------------

	private $wanted_table = 'wanted_table';
	private $testimony_table = 'testimony_table';

//-------------------------------------------------------------------------------------

	public function check_wanted_exist($wanted_first_name,$wanted_last_name)
	{
		return $this->db->select('`wanted_id`,`wanted_first_name`,`wanted_last_name`,`wanted_gender`,`wanted_age`', false)
						->from($this->wanted_table)
						->order_by('wanted_id','desc')
						->where(array(
										'wanted_first_name' => $wanted_first_name,
										'wanted_last_name' => $wanted_last_name
									)
							)
						->get()
						->row_array();
	}

//------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------

	public function insert_wanted($wanted_first_name,$wanted_last_name,$wanted_gender,$wanted_age)
	{
		return $this->db->set( array(
										'wanted_id'			=>'',
										'wanted_first_name'	=>$wanted_first_name,
										'wanted_last_name'	=>$wanted_last_name,
										'wanted_gender'		=>$wanted_gender,
										'wanted_age'		=>$wanted_age
									) 
							 )
						->insert($this->wanted_table);
	}

//------------------------------------------------------------------------------------

	public function get_all_wanted()
	{
	
		return $this->db->select('`wanted_id`,`wanted_first_name`,`wanted_last_name`,`wanted_gender`,`wanted_age`', false)
						->from($this->wanted_table)
						->order_by('wanted_id','desc')
						->get()
						->result_array();
	}

//-----------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

	public function get_all_wanted_ids()
	{
	
		return $this->db->select('`wanted_id`', false)
						->from($this->wanted_table)
						->order_by('wanted_id','desc')
						->get()
						->result_array();
	}

//-----------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

	public function update_wanted($wanted_id,$wanted_first_name,$wanted_last_name,$wanted_gender,$wanted_age)
	{
		return $this->db->set( array(
										'wanted_first_name'=>$wanted_first_name,
										'wanted_last_name'=>$wanted_last_name,
										'wanted_gender'=>$wanted_gender,
										'wanted_age'=>$wanted_age
									) 
							 )
						->where('wanted_id',$wanted_id)
						->update($this->wanted_table);
	}

//------------------------------------------------------------------------------

	public function get_wanted_id($wanted_id)
	{
	
		return $this->db->select('`wanted_id`,`wanted_first_name`,`wanted_last_name`,`wanted_gender`,`wanted_age`', false)
						->from($this->wanted_table)
						->order_by('wanted_id','desc')
						->where('wanted_id',$wanted_id)
						->get()
						->row_array();
	}

//-----------------------------------------------------------------------------

	public function delete_wanted($wanted_first_name,$wanted_last_name)
	{
		return $this->db->where( array(
										'wanted_first_name' => $wanted_first_name,
										'wanted_last_name' => $wanted_last_name
									   )
								)->delete($this->wanted_table);
							
			
	}

//------------------------------------------------------------------------------

//------------------------------------------------------------------------------

	public function get_wanted_testimonies($wanted_id)
	{
	
		return $this->db->select('`t_id`,`u_id`,`w_id`,`testimony`,`testimony_date`,`user_first_name`,`user_last_name`', false)
						->from($this->testimony_table)
						->join('all_user_table', 'testimony_table.u_id = all_user_table.user_id')
						->order_by('t_id','desc')
						->where('w_id',$wanted_id)
						->get()
						->result_array();
	}

//-----------------------------------------------------------------------------
public function insert_testimony( $user_id, $wanted_id, $testimony )
	{
		return $this->db->set( array(
										't_id'		=>'',
										'u_id' 		=> $user_id,
										'w_id'  	=> $wanted_id,
										'testimony' => $testimony,
									) 
							 )
						->set( 'testimony_date', 'NOW()', false)
						->insert( $this->testimony_table );
	}

					//	OTHER COMMENTS
//------------------------------------------------------------------------------

	// public function count()
	// {
	// 	return $this->db->count_all($this->table);
	// }

}


?>