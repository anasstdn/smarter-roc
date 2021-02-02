<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
    if(in_array('role-list', permissions($this->session->userdata())))
    {
      $this->render_backend('role/index');
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

        $sql = "SELECT * FROM roles ";
        if(!empty($data['search']))
        {
        	$sql .= "WHERE name LIKE '%".$data['search']."%' OR description LIKE '%".$data['search']."%'";
        }
        $sql .= " LIMIT ".$data['offset'].",".$data['limit']; 

      	$query = $this->db->query($sql);

      	$total = $this->db->get('roles')->num_rows();

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
            if(in_array('role-edit', permissions($this->session->userdata())))
            {
              $isi_tabel[$key]['aksi'] .= "<div class='col-md-12'><div class='text-center'><a href='role/edit/".$edit."' class='btn btn-primary btn-sm' data-original-title='Edit' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp";
           }
           if(in_array('role-delete', permissions($this->session->userdata())))
           {
             $isi_tabel[$key]['aksi'].="<a href='javascript:void(0)' onclick='delete_data(\"$delete\")' class='btn btn-danger btn-sm' data-original-title='Hapus' title='Hapus'><i class='fa fa-trash' aria-hidden='true'></i></a></div></div>";
           }
         }
      	}

      	echo json_encode(array('data' => $isi_tabel, 'total' => $total));
	}

  public function create()
  {
    if(in_array('role-create', permissions($this->session->userdata())))
    {
      $sql = "SELECT * FROM permissions";
      $permissions = $this->db->query($sql);
      $data['permissions'] = $permissions;
      $this->render_backend('role/form',$data);
    }
    else
    {
      message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
      redirect('home'); 
    } 
  }

  public function store()
  {
    // $this->_validate();
    $this->db->trans_start();
    $data = array(
      'name' => $this->input->post('name'),
      'description' => $this->input->post('description'),
    );

    $this->db->insert('roles', $data);
    $role_id = $this->db->insert_id();

    foreach($this->input->post('permissions') as $key => $val)
    {
      $data_role = array(
        'role_id' => $role_id,
        'permission_id' => $val,
      );
      $insert = $this->db->insert('role_permissions', $data_role);
    }

    if($insert == true)
    {
      $status = true;
    }
    else
    {
      $status = false;
    }
    $this->db->trans_complete();
    // $insert = $this->n_model->save($data);
    message($status,'Data berhasil disimpan','Data gagal disimpan'); 
    redirect('role'); 
  }

  public function edit($id)
  {
    if(in_array('role-edit', permissions($this->session->userdata())))
    {
      $sql = "SELECT * FROM roles WHERE id ='".$id."' LIMIT 1";
      $roles = $this->db->query($sql);
      $data['roles'] = $roles;

      $sql1 = "SELECT * FROM role_permissions WHERE role_id ='".$id."'";
      $role_permission = $this->db->query($sql1);
      $data['role_permission'] = $role_permission;

      $sql = "SELECT * FROM permissions";
      $permissions = $this->db->query($sql);
      $data['permissions'] = $permissions;

      $data['id'] = $id;

      // $data['data'] = $result;
      // $data['permission_id'] = $permission_id;

      $this->render_backend('role/form-edit',$data);
    }
    else
    {
      message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
      redirect('home'); 
    }
  }

  public function update($id)
  {
    $this->db->trans_start();

    $data = array(
        'name' => $this->input->post('name'),
        'description' => $this->input->post('description'),
      );

    $this->db->update('roles', $data, array('id' => $id));

    $this->db->where('role_id', $id);
    $this->db->delete('role_permissions');

    foreach($this->input->post('permissions') as $key => $val)
    {
      $data_role = array(
        'role_id' => $id,
        'permission_id' => $val,
      );
      $insert = $this->db->insert('role_permissions', $data_role);
    }

    if($insert == true)
    {
      $status = true;
    }
    else
    {
      $status = false;
    }

    $this->db->trans_complete();

    message($status,'Data berhasil disimpan','Data gagal disimpan'); 
    redirect('role'); 
  }

  public function delete($id)
  {
    $this->db->where('role_id', $id);
    $this->db->delete('role_permissions');

    $this->db->where('id', $id);
    $this->db->delete('roles');

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