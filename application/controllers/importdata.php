<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importdata extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
        if(in_array('import-list', permissions($this->session->userdata())))
        {
          $this->render_backend('import_data/index');
      }
      else
      {
          message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
          redirect('home'); 
      } 
  }

  public function upload()
  {
    // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            //redirect halaman
            redirect('importdata/');

        } else {

            $this->db->trans_start();
             $this->db->empty_table('detail_master_jalan');
            $this->db->query("ALTER TABLE detail_master_jalan AUTO_INCREMENT = 1");
            $this->db->empty_table('master_jalan');
            $this->db->query("ALTER TABLE master_jalan AUTO_INCREMENT = 1");
            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $numrow = 1;
            foreach($sheet as $key => $row){
              if($numrow > 1){
                // array_push($data, array(
                //   'nama_dosen' => $row['A'],
                //   'email' => $row['B'],
                //   'alamat' => $row['C'],
                // ));
                // dd($data);
              
                $data = array(
                  'no_ruas' => $row['A'],
                  'prefiks' => $row['B'],
                  'nama_jalan' => $row['C'],
                  'kec' => $row['D'],
                  'total_length' => floatval($row['E']) + floatval($row['F']) + floatval($row['G']) + floatval($row['H']),
                  'created_at' => date('Y-m-d H:i:s'),
                  'updated_at' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('master_jalan', $data);
                $master_jalan_id = $this->db->insert_id();

                // == Data Jalan Kriteria Baik
                $array['master_jalan_id'] = $master_jalan_id;
                $array['kriteria_id'] = '1';
                $array['length'] = $row['E'];
                $array['created_at'] = date('Y-m-d H:i:s');
                $array['updated_at'] = date('Y-m-d H:i:s');
                $this->db->insert('detail_master_jalan', $array);
                // == END
                
                // == Data Jalan Kriteria Sedang
                $array['master_jalan_id'] = $master_jalan_id;
                $array['kriteria_id'] = '2';
                $array['length'] = $row['F'];
                $array['created_at'] = date('Y-m-d H:i:s');
                $array['updated_at'] = date('Y-m-d H:i:s');
                $this->db->insert('detail_master_jalan', $array);
                // == END
                
                // == Data Jalan Kriteria Rusak Ringan
                $array['master_jalan_id'] = $master_jalan_id;
                $array['kriteria_id'] = '3';
                $array['length'] = $row['G'];
                $array['created_at'] = date('Y-m-d H:i:s');
                $array['updated_at'] = date('Y-m-d H:i:s');
                $this->db->insert('detail_master_jalan', $array);
                // == END 
                
                // == Data Jalan Kriteria Rusak Berat
                $array['master_jalan_id'] = $master_jalan_id;
                $array['kriteria_id'] = '4';
                $array['length'] = $row['H'];
                $array['created_at'] = date('Y-m-d H:i:s');
                $array['updated_at'] = date('Y-m-d H:i:s');
                $this->db->insert('detail_master_jalan', $array);
                // == END
              }
              $numrow++;
            }

            // $this->db->insert_batch('tbl_dosen', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            $this->db->trans_complete();

            //upload success
            $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('importdata/');

        }
  }
}