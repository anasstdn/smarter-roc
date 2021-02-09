<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
		$user_id = $this->session->userdata('user_id');
		$sql = "SELECT * FROM users where id = '".$user_id."' LIMIT 1";
		$data = $this->db->query($sql);

		$arr = array();
		if($data->num_rows() > 0)
		{
			$arr['data'] = $data->result_array()[0];
		}

		$this->render_backend('settings/index', $arr);
	}

	public function store()
	{
		$all_data = $this->input->post();

		$data['name'] = $all_data['name'];
		$data['username'] = $all_data['username'];
		$data['email'] = $all_data['email'];
		if(!empty($all_data['password']))
		{
			$data['password'] = md5($all_data['password']);
		}
		$data['telegram_chat_id'] = $all_data['telegram_chat_id'];

		$update = $this->db->update('users', $data, array('id' => $this->session->userdata()['user_id']));

		$this->session->set_userdata(['name' => $all_data['name'],'username' => $all_data['username']]); 

		message($update,'Data berhasil diupdate','Data gagal diupdate');
		redirect('settings');
	}
}