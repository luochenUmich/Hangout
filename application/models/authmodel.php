<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author Chen Luo
**/

class Authmodel extends CI_Model
{
	function __construct()
	{
		$this -> load -> database();
	}

	public function sign_up($data)
	{
		$this -> db -> insert('user', $data);
	}

	public function get_picture_url($user_id)
	{
		$this -> db -> select('picture_url');
		$this -> db -> from('user');
		$this -> db -> where(array(
			'id' => $user_id,
			)
		);
		$result = $this -> db -> get() -> result_array();
		return $result[0]['picture_url'];
	}

	public function username_no_duplication($data)
	{
		$this -> db -> select();
		$this -> db -> from('user');
		$this -> db -> where(array(
			'username' => $data['username'],
			)
		);
		$result = $this -> db -> get() -> result_array();
		if(count($result) == 0)
			return 1;
		else
			return 0;
	}

	public function username_match($data)
	{
		$this -> db -> select('password');
		$this -> db -> from('user');
		$this -> db -> where(array(
			'username' => $data['username'],
			)
		);
		$result = $this -> db -> get() ->  result_array();

		if(password_verify($data['password'], $result[0]['password']))
			return 1;
		else
			return 0;
	}

	public function get_user_id($data)
	{
		$this -> db -> select('id');
		$this -> db -> from('user');
		$this -> db -> where(array(
			'username' => $data['username'],
			)
		);
		$result = $this -> db -> get() -> result_array();
		return $result[0]['id'];
	}
}