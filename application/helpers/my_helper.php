<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('random')){
	function random(){
		$number = rand(1111,9999);
		return $number;
	}
}

if ( ! function_exists('current_utc_date_time')){
	function current_utc_date_time(){
		$dateTime = gmdate("Y-m-d\TH:i:s\Z");;
		return $dateTime;
	}
}   

if ( ! function_exists('message')){
	function message($status,$success_msg,$failed_msg){
		$ci =& get_instance();
		if($status==true)
		{
			$ci->session->set_flashdata('success', $success_msg); 
		}
		else{
			$ci->session->set_flashdata('error', $failed_msg); 
		}
	}
}

if(! function_exists('dd'))
{
	function dd($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		die;
	}
}

if(! function_exists('pecah'))
{
	function pecah($arr)
	{
		return explode('-',$arr);
	}
}

if(!function_exists('permissions'))
{
	function permissions($var)
	{
		$ci =& get_instance();
		$role_id = $var['role_id'];

		$sql = "SELECT permissions.* FROM permissions JOIN role_permissions ON role_permissions.permission_id = permissions.id WHERE role_permissions.role_id = '".$role_id."'";

		$permission = $ci->db->query($sql)->result_array();

		$permission_list = array();

		if(isset($permission) && !empty($permission))
		{
			foreach($permission as $key => $val)
			{
				$permission_list[] = $val['name'];
			}
		}

		return $permission_list;
	}
}  

if(!function_exists('get_role'))
{
	function get_role($id)
	{
		$ci =& get_instance();
		$role_id = $id;

		$sql = "SELECT roles.* FROM roles WHERE roles.id = '".$id."'";
		$roles = $ci->db->query($sql)->result_array();

		$data = null;
		if(isset($roles) && !empty($roles))
		{
			$data = $roles[0]['name'];
		}

		return $data;
	}
} 

