<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
		$this->render_backend('home_developer');
	}

    public function loadMap()
    {
        $this->db->select('*');
        $this->db->from('pengajuan');
        $this->db->join('users','users.id = pengajuan.user_input');
        $this->db->where('MONTH(tgl_pengajuan)',date('m'));
        $this->db->where('YEAR(tgl_pengajuan)',date('Y'));
        if(in_array($this->session->userdata('role_id'),getConfigValues('ROLE_USER')))
        {
            $this->db->where('pengajuan.user_input',$this->session->userdata('user_id'));
        }
        $data = $this->db->get();

        $result = array();
        if($data->num_rows() > 0)
        {
            foreach($data->result() as $key => $val)
            {
                $result[$key]['tgl_pengajuan'] = date('d-m-Y H:i:s',strtotime($val->tgl_pengajuan));
                $result[$key]['nama_jalan'] = $val->nama_jalan;
                $result[$key]['latitude'] = $val->latitude;
                $result[$key]['longitude'] = $val->longitude;
                $result[$key]['keterangan'] = $val->keterangan;
                $result[$key]['name'] = $val->name;
            }
        }

        echo json_encode($result);
    }
}