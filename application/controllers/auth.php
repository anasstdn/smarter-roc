<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('UserModel');
  }

  public function index(){
    if($this->session->userdata('authenticated')){
    	redirect('page/home'); 
    } 
    $this->render_login('login');
  }

  public function login(){
    $username = $this->input->post('username'); 
    $password = md5($this->input->post('password')); 
    $user = $this->UserModel->get($username);
    if(empty($user)){ 
      $this->session->set_flashdata('message', 'Username atau password tidak ditemukan'); 
      redirect('auth'); 
    }else{
      if($password == $user->password){ 

        $this->db->where('user_id',$user->id);
        $role_id = $this->db->get('role_user')->row();

        $session = array(
          'authenticated'=>true, 
          'username'=>$user->username,  
          'name'=>$user->name, 
          'user_id' => $user->id,
          'role_id'=>$role_id->role_id,
        );
        $this->session->set_userdata($session); 
        // message(true,'Selamat datang '.$this->session->userdata('name'),null);
        // $this->session->set_flashdata('success', 'Selamat datang '.$this->session->userdata('name')); 
        redirect('page/home'); 
      }else{
        $this->session->set_flashdata('message', 'Username atau password tidak ditemukan'); 
        redirect('auth'); 
      }
    }
  }

  public function logout(){
    $this->session->sess_destroy(); 
    redirect('auth');
  }

}