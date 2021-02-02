<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends MY_Controller {
  public function home(){
    // function render_backend tersebut dari file core/MY_Controller.php
     // load view home.php
    message(true,'Selamat datang, anda berhasil login ke sistem!',''); 
    redirect('home'); 
  }

  public function profil(){
    // function render_backend tersebut dari file core/MY_Controller.php
    if(in_array('profil-list', permissions($this->session->userdata())))
    {
      redirect('profil'); 
    }
    else
    {
      message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
      redirect('home'); 
    }
  }

  public function permission(){
    // function render_backend tersebut dari file core/MY_Controller.php
    if(in_array('permissions-list', permissions($this->session->userdata())))
    {
      redirect('permission'); 
    }
    else
    {
      message(false,'','403! Anda tidak memiliki ijin akses pada halaman ini!'); 
      redirect('home'); 
    }
  }

  public function clustering(){
    // function render_backend tersebut dari file core/MY_Controller.php
    redirect('clustering'); 
  }

  public function rekap(){
    // function render_backend tersebut dari file core/MY_Controller.php
    redirect('clustering/index_rekap'); 
  }

  public function pengguna(){
    if($this->session->userdata('role') != 'admin') // Jika user yg login bukan admin
      show_404(); // Redirect ke halaman 404 Not found
    // function render_backend tersebut dari file core/MY_Controller.php
    $this->render_backend('pengguna'); // load view pengguna.php
  }

  public function kontak(){
    // function render_backend tersebut dari file core/MY_Controller.php
    $this->render_backend('kontak'); // load view kontak.php
  }

  public function user()
  {
    redirect('user'); 
  }

   public function kriteria()
  {
    redirect('kriteria'); 
  }

}