<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subkriteria extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
    if(in_array('subkriteria-list', permissions($this->session->userdata())))
    {
      $this->render_backend('subkriteria/index');
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

        $sql = "SELECT * FROM sub_kriteria ";
        if(!empty($data['search']))
        {
          $sql .= "WHERE sub_kriteria LIKE '%".$data['search']."%' OR rangking LIKE '%".$data['search']."%'";
        }
        $sql .= " LIMIT ".$data['offset'].",".$data['limit']; 

        $query = $this->db->query($sql);

        $total = $this->db->get('sub_kriteria')->num_rows();

        $isi_tabel = array();

        if($query->num_rows() > 0)
        {
          foreach($query->result() as $key => $val)
          {
            $isi_tabel[$key]['sub_kriteria'] = $val->sub_kriteria;
            $isi_tabel[$key]['rangking'] = $val->rangking;
                

                $edit = $val->id;
                $delete = $val->id;

                $isi_tabel[$key]['aksi'] = '';
                if(in_array('subkriteria-edit', permissions($this->session->userdata())))
                {
                  $isi_tabel[$key]['aksi'] .= "<div class='col-md-12'><div class='text-center'><a href='javascript:void(0)' onclick='edit(\"$edit\")' class='btn btn-primary btn-sm' data-original-title='Edit' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp";
                }
                if(in_array('subkriteria-delete', permissions($this->session->userdata())))
                {
                  $isi_tabel[$key]['aksi'].="<a href='javascript:void(0)' onclick='delete_data(\"$delete\")' class='btn btn-danger btn-sm' data-original-title='Hapus' title='Hapus'><i class='fa fa-trash' aria-hidden='true'></i></a></div></div>";
                }
          }
        }

        echo json_encode(array('data' => $isi_tabel, 'total' => $total));
  }

  public function store()
  {
    $this->_validate();
    $data = array(
        'sub_kriteria' => $this->input->post('sub_kriteria'),
        'rangking' => $this->input->post('rangking'),
      );

    $insert = $this->db->insert('sub_kriteria', $data);
    if($insert == true)
    {
      $status = true;
    }
    else
    {
      $status = false;
    }
    // $insert = $this->n_model->save($data);
    echo json_encode(array("status" => $status));
  }

  public function edit($id)
  {
    $sql = "SELECT * FROM sub_kriteria WHERE id ='".$id."' LIMIT 1";
    $data = $this->db->query($sql);

    $result = null;
    if($data->num_rows() > 0)
    {  
      $result = $data->result_array()[0];
    }

    echo json_encode($result);
  }

  public function update()
  {
    $this->_validate();
    $data = array(
        'sub_kriteria' => $this->input->post('sub_kriteria'),
        'rangking' => $this->input->post('rangking'),
      );

    $this->db->update('sub_kriteria', $data, array('id' => $this->input->post('id')));
    echo json_encode(array("status" => TRUE));
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('sub_kriteria');

    echo json_encode(array("status" => TRUE));
  }

  private function _validate()
  {
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->input->post('sub_kriteria') == '')
    {
      $data['inputerror'][] = 'sub_kriteria';
      $data['error_string'][] = 'Silahkan isi data';
      $data['status'] = FALSE;
    }

    if($this->input->post('rangking') == '')
    {
      $data['inputerror'][] = 'rangking';
      $data['error_string'][] = 'Silahkan isi data';
      $data['status'] = FALSE;
    }

    if($data['status'] === FALSE)
    {
      echo json_encode($data);
      exit();
    }
  }

}