<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
		$this->render_backend('pengaturan/profil');
	}
}