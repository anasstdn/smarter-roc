<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
    if(in_array('pengajuan-list', permissions($this->session->userdata())))
    {
      $this->render_backend('pengajuan/form');
    }
    else
    {
      message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
      redirect('home'); 
    } 
  }

  public function store()
  {
    if(in_array('pengajuan-create', permissions($this->session->userdata())))
    {
      $input = $this->input->post();
      $this->db->trans_start();
      $data = array(
        'tgl_pengajuan' => date('Y-m-d H:i:s'),
        'nama_jalan' => $input['map_address'],
        'latitude' => $input['map_lat'],
        'longitude' => $input['map_lng'],
        'keterangan' => $input['keterangan'],
        'user_input' => $this->session->userdata('user_id'),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      );
      // dd($this->input->post());
      if(!empty($_FILES['foto']['name']))
      {
        $upload = $this->_do_upload();
        $data['foto'] = $upload;
      }

      $insert = $this->db->insert('pengajuan',$data);
      $this->db->trans_complete();

      $user = getUserById($this->session->userdata('user_id'));

      if(isset($user) && !empty($user->telegram_chat_id))
      {
       try{
        $emoticon_smile = "\ud83d\ude0a";
        $text = "Halo " . $user->name . "\n\n"

        . "Ini adalah notifikasi bot Aplikasi Pengaduan Kerusakan Jalan.\n"
        . "Pengajuan anda berhasil disimpan dengan detail lokasi di <b>".$data['nama_jalan']."</b> di titik koordinat latitude <b>".$data['latitude']."</b> dan longitude <b>".$data['longitude']."</b>. Silahkan anda menunggu verifikasi dari kami.\n\n"
        . "Terima kasih " . json_decode('"' . $emoticon_smile . '"');

        botTelegram($user->telegram_chat_id,$text,'1427433519:AAEqmIoFGcRXEt28kBra-w4y-OzSLyTwFSk');
      }catch(Exception $e){
        die('Error: '.$e->getMessage());
      }
    }

    $admin = getUserByConfig('ROLE_ADMIN');

    if(isset($admin) && !empty($admin))
    {
      foreach($admin as $key => $val)
      {
        if(!empty($val->telegram_chat_id))
        {
          try{
            $emoticon_smile = "\ud83d\ude0a";
            $text = "Halo " . $val->name . "\n\n"

            . "Ini adalah notifikasi bot Aplikasi Pengaduan Kerusakan Jalan.\n"
            . "Anda mendapatkan permintaan pengajuan dengan detail di <b>".$data['nama_jalan']."</b> di titik koordinat latitude <b>".$data['latitude']."</b> dan longitude <b>".$data['longitude']."</b>. Silahkan untuk meninjau permintaan pengajuan tersebut.\n\n"
            . "Terima kasih " . json_decode('"' . $emoticon_smile . '"');

            botTelegram($val->telegram_chat_id,$text,'1427433519:AAEqmIoFGcRXEt28kBra-w4y-OzSLyTwFSk');
          }catch(Exception $e){
            die('Error: '.$e->getMessage());
          }
        }
      }
    }

    message($insert,'Data berhasil disimpan','Data gagal disimpan');

    redirect('pengajuan');

  }
  else
  {
    message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
    redirect('home');
  }
}

private function _do_upload()
{
  $config['upload_path']          = './assets/pelaporan';
  $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf|doc|docx|mp3|mpeg';
  $config['max_size']             = 2048;
    // $config['max_width']            = 1000;
    // $config['max_height']           = 1000; 
  $config['file_name']            = round(microtime(true) * 1000); 

  $this->load->library('upload', $config);
  $this->upload->initialize($config);
  if(!$this->upload->do_upload('foto')) 
  {
    $data['inputerror'][] = 'foto';
    $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); 
    $data['status'] = FALSE;
    echo json_encode($data);
    exit();
  }
  return $this->upload->data('file_name');
}

public function verifikasi_pengajuan()
{
  if(in_array('verifikasi-pengajuan-list', permissions($this->session->userdata())))
  {
    $this->render_backend('verifikasi_pengajuan/index');
  }
  else
  {
    message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
    redirect('home'); 
  } 
}

public function getData()
{
  $data = array(
            'offset' => !empty($this->input->post('offset')) ? $this->input->post('offset') : 0,
            'limit' => !empty($this->input->post('limit')) ? $this->input->post('limit') : 10,
            'search' => !empty($this->input->post('search')) ? $this->input->post('search') : null,
        );

        $sql = "SELECT pengajuan.* FROM pengajuan";
        if(!empty($data['search']))
        {
          $sql .= " WHERE nama_jalan LIKE '%".$data['search']."%' AND flag_verifikasi IS NULL";
        }
        else
        {
          $sql .= " WHERE flag_verifikasi IS NULL";
        }
        $sql .= " ORDER BY tgl_pengajuan DESC LIMIT ".$data['offset'].",".$data['limit']; 

        $query = $this->db->query($sql);

        $total = $this->db->get('pengajuan')->num_rows();

        $isi_tabel = array();

        if($query->num_rows() > 0)
        {
          foreach($query->result() as $key => $val)
          {
            $isi_tabel[$key]['tgl_pengajuan'] = $val->tgl_pengajuan;
            $isi_tabel[$key]['nama_jalan'] = $val->nama_jalan;
            $isi_tabel[$key]['latitude'] = $val->latitude;
            $isi_tabel[$key]['longitude'] = $val->longitude;

            $isi_tabel[$key]['user_input'] = getUserById($val->user_input)->name;

            $verifikasi = base_url('pengajuan/verifikasi/'.$val->id);

            $isi_tabel[$key]['aksi'] = '';
            if(in_array('verifikasi-pengajuan-edit', permissions($this->session->userdata())))
            {
             $isi_tabel[$key]['aksi'] .= "<div class='col-md-12'><div class='text-center'><a href='$verifikasi' class='btn btn-primary btn-sm' data-original-title='Edit' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp";
           }
         }
       }

        echo json_encode(array('data' => $isi_tabel, 'total' => $total));
}

public function verifikasi()
{
  if(in_array('verifikasi-pengajuan-edit', permissions($this->session->userdata())))
  {
    $id = $this->uri->segment(3);

    $this->db->from('pengajuan');
    $this->db->where('id =',$id);
    $pengajuan = $this->db->get();

    if($pengajuan->num_rows() > 0)
    {
      $pengajuan = $pengajuan->row();
    }

    if($pengajuan->latitude !== null && $pengajuan->longitude !== null)
    {
      $data['longlat'] = $pengajuan->latitude.','.$pengajuan->longitude;
    }

    $data['pengajuan'] = $pengajuan;
    $data['id_pengajuan'] = $id;

    $this->render_backend('verifikasi_pengajuan/verifikasi', $data);
  }
  else
  {
    message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
    redirect('home'); 
  } 
}

public function simpan_verifikasi()
{
  $input = $this->input->post();
  $this->db->trans_start();
  if($this->input->post('action'))
  {
    $data = array(
      'flag_verifikasi' => 'Y',
      'tgl_verifikasi' => date('Y-m-d H:i:s'),
      'user_update' => $this->session->userdata('user_id'),
      'updated_at' => date('Y-m-d H:i:s'),
    );
  }
  else
  {
    $data = array(
      'flag_verifikasi' => 'N',
      'tgl_verifikasi' => date('Y-m-d H:i:s'),
      'user_update' => $this->session->userdata('user_id'),
      'updated_at' => date('Y-m-d H:i:s'),
    );
  }

  $update = $this->db->update('pengajuan', $data, array('id' => $this->input->post('id_pengajuan')));

  $this->db->trans_complete();

    $user = getUserById($this->session->userdata('user_id'));

    if(isset($user) && !empty($user->telegram_chat_id))
    {
     try{
      $emoticon_smile = "\ud83d\ude0a";
      $text = "Halo " . $user->name . "\n\n"

      . "Ini adalah notifikasi bot Aplikasi Pengaduan Kerusakan Jalan.\n"
      . "Pengajuan anda berhasil disimpan dengan detail lokasi di <b>".$data['nama_jalan']."</b> di titik koordinat latitude <b>".$data['latitude']."</b> dan longitude <b>".$data['longitude']."</b>. Silahkan anda menunggu verifikasi dari kami.\n\n"
      . "Terima kasih " . json_decode('"' . $emoticon_smile . '"');

      botTelegram($user->telegram_chat_id,$text,'1427433519:AAEqmIoFGcRXEt28kBra-w4y-OzSLyTwFSk');
    }catch(Exception $e){
      die('Error: '.$e->getMessage());
    }
  }

  message($update,'Data berhasil diupdate','Data gagal diupdate');

  redirect('verifikasi_pengajuan/index');
}

}
