<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author  Chen Luo
*/

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this -> load -> library('authlib');
		$this -> load -> model('authmodel');
	}

	public function index()
	{
		echo "in index";
	}

	public function sign_up()
	{
		$data['username'] = $this -> input -> post('username');
		if($this -> authmodel -> username_no_duplicate($data))
		{
			$data['phone_number'] = $this -> input -> post('phone_number');
			$data['password'] = password_hash($this -> input -> post('password'));
			$data['email_address'] = $this -> input -> post('email');

			if($this -> input -> post('gender') == 'Male')
				$data['gender'] = 0;
			elseif($this -> input -> post('gender') == 'Female')
				$data['gender'] = 1;
			else
				$data['gender'] = 2;

			$data['picture_url'] = $this -> input -> post('picture_url');
			$this -> authmodel -> sign_up($data);
			echo json_encode(array('is_successful' => 1));
		}
		else
			echo json_encode(array('is_successful' => 0));
	}

	public function log_in()
	{
		$data['username'] = $this -> input -> post('username');
		$data['password'] = $this -> input -> post('password');
		if($this -> authmodel -> username_match($data))
		{
			$data['id'] = $this -> authmodel -> get_user_id($data);
			$this -> Authlib -> log_in($data);
			echo json_encode(array('is_successful' => 1));
		}
		else
			echo json_encode(array('is_successful' => 0));
	}

	public function log_out()
	{
		$this -> Authlib -> log_out();
	}
}