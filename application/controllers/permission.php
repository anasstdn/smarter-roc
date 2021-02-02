<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
    if(in_array('permissions-list', permissions($this->session->userdata())))
    {
      $this->render_backend('permission/index');
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

        $sql = "SELECT * FROM permissions ";
        if(!empty($data['search']))
        {
        	$sql .= "WHERE name LIKE '%".$data['search']."%' OR description LIKE '%".$data['search']."%'";
        }
        $sql .= " LIMIT ".$data['offset'].",".$data['limit']; 

      	$query = $this->db->query($sql);

      	$total = $this->db->get('permissions')->num_rows();

      	$isi_tabel = array();

      	if($query->num_rows() > 0)
      	{
      		foreach($query->result() as $key => $val)
      		{
      			$isi_tabel[$key]['name'] = $val->name;
                $isi_tabel[$key]['description'] = $val->description;
                

                $edit = $val->id;
                $delete = $val->id;

                $isi_tabel[$key]['aksi'] = '';
                if(in_array('permissions-edit', permissions($this->session->userdata())))
                {
                	$isi_tabel[$key]['aksi'] .= "<div class='col-md-12'><div class='text-center'><a href='javascript:void(0)' onclick='edit(\"$edit\")' class='btn btn-primary btn-sm' data-original-title='Edit' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp";
                }
                if(in_array('permissions-delete', permissions($this->session->userdata())))
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
        'name' => $this->input->post('name'),
        'description' => $this->input->post('description'),
      );

    $insert = $this->db->insert('permissions', $data);
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
    $sql = "SELECT * FROM permissions WHERE id ='".$id."' LIMIT 1";
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
        'name' => $this->input->post('name'),
        'description' => $this->input->post('description'),
      );

    $this->db->update('permissions', $data, array('id' => $this->input->post('id')));
    echo json_encode(array("status" => TRUE));
  }

  public function delete($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('permissions');

    echo json_encode(array("status" => TRUE));
  }

  private function _validate()
  {
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->input->post('name') == '')
    {
      $data['inputerror'][] = 'name';
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