<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('UserModel');
  }

  public function index()
  {
    if ($this->session->userdata('authenticated')) {
      redirect('page/home');
    }
    // botTelegram('388593288','TEST','1427433519:AAEqmIoFGcRXEt28kBra-w4y-OzSLyTwFSk');
    $this->render_login('login');
  }

  public function login()
  {
    $username = $this->input->post('username');
    $password = md5($this->input->post('password'));
    $user = $this->UserModel->get($username);
    if (empty($user)) {
      $this->session->set_flashdata('message', 'Username atau password tidak ditemukan');
      redirect('auth');
    } else {
      if ($password == $user->password) {
        if ($user->verified == TRUE) {
          $this->db->where('user_id', $user->id);
          $role_id = $this->db->get('role_user')->row();

          $session = array(
            'authenticated' => true,
            'username' => $user->username,
            'name' => $user->name,
            'user_id' => $user->id,
            'role_id' => $role_id->role_id,
          );
          $this->session->set_userdata($session);
          redirect('page/home');
        } else {
          $this->session->set_flashdata('message', 'Akun anda belum terverifikasi. Silahkan hubungi administrator untuk bantuan verifikasi akun.');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', 'Username atau password tidak ditemukan');
        redirect('auth');
      }
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    redirect('auth');
  }

  public function daftar()
  {
    if ($this->session->userdata('authenticated')) {
      redirect('page/home');
    }

    session_unset();
    session_destroy();
    $this->render_login('daftar');
  }

  public function verifikasi()
  {
    $id = $this->uri->segment(3);
    $this->db->from('registrasi_user');
    $this->db->where('id', $id);
    $query = $this->db->get();
    $data = $query->row();
    $this->db->trans_start();
    $arr = array(
      'verified' => 1,
      'updated_at' => date('Y-m-d H:i:s')
    );

    $arr_insert = array(
      'name' => $data->name,
      'username' => $data->username,
      'password' => $data->password,
      'email' => $data->email,
      'verified' => 1,
      'telegram_chat_id' => $data->telegram_chat_id,
      'created_at' => date('Y-m-d H:i:s')
    );

    $this->db->where('id', $id);
    $this->db->update('registrasi_user', $arr);

    $this->db->insert('users', $arr_insert);
    $user_id = $this->db->insert_id();
    $this->db->insert('role_user', ['role_id' => '3', 'user_id' => $user_id]);
    $this->db->trans_complete();
    $this->session->set_flashdata('success', 'Verifikasi akun telah berhasil.');
    redirect('auth');
  }

  public function sendOTP()
  {
    switch ($this->input->post('action')) {
      case "send_otp":
        $otp = rand(100000, 999999);

        $session = array(
          'name' => $this->input->post('name'),
          'username' => $this->input->post('username'),
          'email' => $this->input->post('email'),
          'password' => $this->input->post('password'),
          'telegram_chat_id' => $this->input->post('telegram_chat_id'),
          'session_otp' => $otp,
        );
        $this->session->set_userdata($session);

        try {

          $emoticon_smile = "\ud83d\ude0a";
          $text = "Halo " . $this->input->post('name') . "\n\n"

            . "Selamat datang di Aplikasi Pengaduan Kerusakan Jalan.\n"
            . "Silahkan anda masukkan kode OTP <b>" . $otp . "</b> untuk melanjutkan proses registrasi.\n\n"
            . "Terima kasih " . json_decode('"' . $emoticon_smile . '"');

          botTelegram($this->input->post('telegram_chat_id'), $text, '1427433519:AAEqmIoFGcRXEt28kBra-w4y-OzSLyTwFSk');
          require_once(APPPATH . 'views/form-verifikasi.php');
          exit();
        } catch (Exception $e) {
          die('Error: ' . $e->getMessage());
        }
        break;

      case "verify_otp":

        $otp = $this->input->post('otp');

        if ($otp == $this->session->userdata('session_otp')) {
          $this->db->trans_start();

          $user = array(
            'name' => ucwords($this->session->userdata('name')),
            'username' => $this->session->userdata('username'),
            'email' => $this->session->userdata('email'),
            'password' => md5($this->session->userdata('password')),
            'verified' => null,
            'telegram_chat_id' => $this->session->userdata('telegram_chat_id'),
            'created_at' => date('Y-m-d H:i:s')
          );

          $this->db->insert('registrasi_user', $user);

          $registrasi_id = $this->db->insert_id();

          try {

            $emoticon_smile = "\ud83d\ude0a";
            $text = "Halo " . ucwords($this->session->userdata('name')) . "\n\n"

              . "Selamat datang di Aplikasi Pengaduan Kerusakan Jalan.\n"
              . "Untuk melanjutkan registrasi silahkan anda klik pada <a href='http://" . preg_replace("#^[^:/.]*[:/]+#i", "", base_url()) . "auth/verifikasi/" . $registrasi_id . "'>link ini</a>.\n\n"
              . "Terima kasih " . json_decode('"' . $emoticon_smile . '"');

            $test = botTelegram($this->session->userdata('telegram_chat_id'), $text, '1427433519:AAEqmIoFGcRXEt28kBra-w4y-OzSLyTwFSk');
          } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
          }

          // $this->db->insert('users', $user);

          // $user_id = $this->db->insert_id();

          // $this->db->insert('role_user', ['role_id' => '3', 'user_id' => $user_id]);
          $this->db->trans_complete();

          session_unset();
          session_destroy();

          echo json_encode(array("status" => true, "type" => "success", "message" => "Verifikasi Berhasil"));
        } else {
          echo json_encode(array("type" => "error", "message" => "Kode OTP yang anda masukkan salah."));
        }
        break;
    }
  }
}
