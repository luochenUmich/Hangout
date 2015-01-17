<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* @author  Lim, Byunghoon <seian.hoon@gmail.com>
* 
*/
class Authlib
{
	function __construct()
	{
		$this -> ci =& get_instance();
		$this -> ci -> load -> library('session');
		$this -> ci -> load -> database();
	}

	function log_in($data)
	{
		$data['user_id'] = $data['id'];
		$data['is_login'] = true;
		$this -> ci -> session -> set_userdata($data);
	}

	function get_user_id()
	{
		return $this -> ci -> session -> userdata('user_id');
	}

	function log_out()
	{
		$this -> ci -> session -> sess_destroy();
	}

	function is_log_in()
	{
		return $this -> ci -> session -> userdata('is_login');
	}

}