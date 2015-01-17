<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* @author  Chen Luo
*/

class Activity extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this -> load -> model('activitymodel');
		$this -> load -> model('usermodel');
		$this -> load -> library('authlib');
	}

	public function get_activities()
	{
		$data['category'] = $this -> input -> post('category');
		$result = $this -> activitymodel -> get_activities($data);
		if(count($result) == 0)
			$result['is_successful'] = 0;
		else 
			$result['is_successful'] = 1;
		echo json_encode($result);
	}

	public function post_activity()
	{
		$data['time_month'] = $this -> input -> post('month');
		$data['time_day'] = $this -> input -> post('day');
		$data['time_hour'] = $this -> input -> post('hour');
		$data['time_minute'] = $this -> input -> post('minute');
		$data['dest_lat'] = $this -> input -> post('dest_lat');
		$data['dest_lgt'] = $this -> input -> post('dest_lgt');
		$data['depart_lat'] = $this -> input -> post('depart_lat');
		$data['depart_lgt'] = $this -> input -> post('depart_lgt');
		$data['user_id'] = $this -> authlib -> get_user_id();
		$data['description'] = $this -> input -> post('description');
		$data['category'] = $this -> input -> post('category');
		$this -> activitymodel -> post_activity();
	}

	public function join_activity()
	{
		$data['sender_id'] = $this -> authlib -> get_user_id();
		$data['activity_id'] = $this -> input -> post('activity_id');
		$data['receiver_id'] = $this -> activitymodel -> get_receiver_id($this -> input -> post('activity_id'));
		$data['activity_title'] = $this -> activitymodel -> get_activity_title($this -> input -> post('activity_id'));
		$data['status'] = 0;
		$data['picture_url'] = $this -> usermodel -> get_picture_url($data['sender_id']);
		$this -> activitymodel -> insert_notification($data);
	}

	public function agree_join()
	{
		$data['activity_id'] = $this -> input -> post('activity_id');
		$data['sender_id'] = $this -> input -> post('sender_id');
		$data['receiver_id'] = $this -> input -> post('receiver_id');
		$this -> activitymodel -> agree_join($data);
	}

	public function decline_join()
	{
		$data['activity_id'] = $this -> input -> post('activity_id');
		$data['sender_id'] = $this -> input -> post('sender_id');
		$data['receiver_id'] = $this -> input -> post('receiver_id');
		$this -> activitymodel -> decline_join($data);
	}

	public function get_post_activities()
	{
		$data['user_id'] = $this -> authlib -> get_user_id();
		$result = $this -> activitymodel -> get_post_activities($data);
		echo json_encode($result);
	}

	public function get_join_activities()
	{
		$data['user_id'] = $this -> authlib -> get_user_id();
		$result = $this -> activitymodel -> get_join_activities($data);
		echo json_encode($result);
	}

	public function get_notifications()
	{
		$data['user_id'] = $this -> authlib -> get_user_id();
		$result = $this -> activitymodel -> get_notifications($data);
		echo json_encode($result);
	}

}