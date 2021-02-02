<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->library(['form_validation']);
		$this->load->helper(['url']);

		date_default_timezone_set("ASIA/JAKARTA");

	}

	public function index(){
    if(in_array('user-list', permissions($this->session->userdata())))
    {
      // $this->db->table('roles');
      $roles = $this->db->get('roles');
      $data['roles'] = $roles->result();

      $this->render_backend('user/index',$data);
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

        $sql = "SELECT users.*,role_user.role_id FROM users JOIN role_user ON role_user.user_id = users.id ";
        if(!empty($data['search']))
        {
        	$sql .= "WHERE name LIKE '%".$data['search']."%' OR username LIKE '%".$data['search']."%' OR email LIKE '%".$data['search']."%'";
        }
        $sql .= " LIMIT ".$data['offset'].",".$data['limit']; 

      	$query = $this->db->query($sql);

      	$total = $this->db->get('users')->num_rows();

      	$isi_tabel = array();

      	if($query->num_rows() > 0)
      	{
      		foreach($query->result() as $key => $val)
      		{
      			$isi_tabel[$key]['name'] = $val->name;
            $isi_tabel[$key]['username'] = $val->username;
            $isi_tabel[$key]['email'] = $val->email;

            $isi_tabel[$key]['role'] = '';

            if(get_role($val->role_id) == 'Developer')
            {
              $isi_tabel[$key]['role'] .= "<span class='badge badge-success'>".get_role($val->role_id)."</span>";
            }
            if(get_role($val->role_id) == 'Admin')
            {
              $isi_tabel[$key]['role'] .= "<span class='badge badge-primary'>".get_role($val->role_id)."</span>";
            }
            if(get_role($val->role_id) == 'User')
            {
              $isi_tabel[$key]['role'] .= "<span class='badge badge-info'>".get_role($val->role_id)."</span>";
            }
            
            $edit = $val->id;
            $delete = $val->id;

            $isi_tabel[$key]['aksi'] = '';
            if(in_array('user-edit', permissions($this->session->userdata())))
            {
             $isi_tabel[$key]['aksi'] .= "<div class='col-md-12'><div class='text-center'><a href='javascript:void(0)' onclick='edit(\"$edit\")' class='btn btn-primary btn-sm' data-original-title='Edit' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></a>&nbsp";
           }
           if(in_array('user-delete', permissions($this->session->userdata())))
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
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'password' => md5($this->input->post('password')),
      );

    $insert = $this->db->insert('users', $data);

    $user_id = $this->db->insert_id();

    $this->db->insert('role_user',['role_id' => $this->input->post('roles'), 'user_id' => $user_id]);

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
    $sql = "SELECT users.*,role_user.role_id FROM users JOIN role_user ON role_user.user_id = users.id WHERE users.id ='".$id."' LIMIT 1";
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
    if(!empty($this->input->post('password')))
    {
      $data = array(
        'name' => $this->input->post('name'),
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
        'password' => $this->input->post('password'),
      );
    }
    else
    {
      $data = array(
        'name' => $this->input->post('name'),
        'username' => $this->input->post('username'),
        'email' => $this->input->post('email'),
      );
    }
    
    $this->db->update('users', $data, array('id' => $this->input->post('id')));

    $this->db->update('role_user', array('role_id' => $this->input->post('roles')), array('user_id' => $this->input->post('id')));

    echo json_encode(array("status" => TRUE));
  }

  public function delete($id)
  {
    $this->db->where('user_id', $id);
    $this->db->delete('role_user');

    $this->db->where('id', $id);
    $this->db->delete('users');

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

    if($this->input->post('username') == '')
    {
      $data['inputerror'][] = 'username';
      $data['error_string'][] = 'Silahkan isi data';
      $data['status'] = FALSE;
    }
    else
    {
      if($this->checkValid('users','username',$this->input->post('username')) == false)
      {
        $data['inputerror'][] = 'username';
        $data['error_string'][] = 'Username '.$this->input->post('username')." sudah digunakan oleh user lain";
        $data['status'] = FALSE;
      }
    }

    if($this->input->post('email') == '')
    {
      $data['inputerror'][] = 'email';
      $data['error_string'][] = 'Silahkan isi data';
      $data['status'] = FALSE;
    }
    else
    {
      if($this->checkValid('users','email',$this->input->post('email')) == false)
      {
        $data['inputerror'][] = 'email';
        $data['error_string'][] = 'Email '.$this->input->post('email')." sudah digunakan oleh user lain";
        $data['status'] = FALSE;
      }
    }

    if(empty($this->input->post('id')))
    {
      if($this->input->post('password') == '')
      {
        $data['inputerror'][] = 'password';
        $data['error_string'][] = 'Silahkan isi data';
        $data['status'] = FALSE;
      }
      else
      {
        if(strlen($this->input->post('password')) < 8)
        {
          $data['inputerror'][] = 'password';
          $data['error_string'][] = 'Silahkan isi password dengan panjang minimal 8 karakter';
          $data['status'] = FALSE;
        }
      }
    }
    
    if($this->input->post('roles') == '')
    {
      $data['inputerror'][] = 'roles';
      $data['error_string'][] = 'Silahkan isi data';
      $data['status'] = FALSE;
    }

    if($data['status'] === FALSE)
    {
      echo json_encode($data);
      exit();
    }
  }

  private function checkValid($table,$username,$value)
  {
    $id = $this->input->post('id');
    $sql = "SELECT * FROM ";
    $sql .= $table;

    if(empty($id))
    {
      $sql .= " WHERE ".$username." = '".$value."' LIMIT 1";
    }
    else
    {
      $sql .= " WHERE ".$username." = '".$value."' AND id <> '".$id."' LIMIT 1";
    }
    

    $data = $this->db->query($sql);

    $status = true;
    if($data->num_rows() > 0)
    {
      $status = false;
    }
    return $status;
  }

}