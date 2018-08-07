<?php
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class User_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		$this->load->library('query');
	}

  public function login_user($username,$password){
    return $this->query->select(
        array(
          'table' => 'users',
          'fields' => '*',
          'conditions' => array(
            'username' => $username,
            'passwd' => md5($password)
          )
        )
      );
  }

  public function load_user(){
    return $this->query->select(
      array(
        'table' => 'users',
        'fields' => '*'
      )
    );
  }

  public function update_userlogstatus($id, $logout = FALSE){
    return $this->query->update(
      'users',
      array(
        'user_id' => $id
      ),
      array(
        'date_last_loggedin' => date('Y-m-d H:i:s'),
        'isLoggedin' => ($logout) ? '0' : '1'
      )
    );
  }

  public function add_new_user($username,$password,$email,$fname,$mname,$lname,$position){
    return $this->query->insert('users',
        array(
          'username' => $username,
          'passwd' => md5($password),
          'email' => $email,
          'first_name' => $fname,
          'mid_name' => $fname,
          'last_name' => $mname,
          'position' => $position
        )
      );
  }

  public function update_user($id,$username,$password,$email,$fname,$mname,$lname,$position){
      return $this->query->update(
        'users',
          array(
            'user_id' => $id
          ),
          array(
            'username' => $username,
            'passwd' => md5($password),
            'email' => $email,
            'first_name' => $fname,
            'mid_name' => $fname,
            'last_name' => $mname,
            'position' => $position
          )
    );
  }

  public function get_user($id = '')
	{	
		return $this->query->select(
				array(
					'table' => 'users',
					'fields' => '*',
					'conditions' => array (
						'user_id' => $id
					)
				)
			);		
	}
}
?>
