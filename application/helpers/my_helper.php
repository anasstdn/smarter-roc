<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('random')){
	function random(){
		$number = rand(1111,9999);
		return $number;
	}
}

if ( ! function_exists('current_utc_date_time')){
	function current_utc_date_time(){
		$dateTime = gmdate("Y-m-d\TH:i:s\Z");;
		return $dateTime;
	}
}   

if ( ! function_exists('message')){
	function message($status,$success_msg,$failed_msg){
		$ci =& get_instance();
		if($status==true)
		{
			$ci->session->set_flashdata('success', $success_msg); 
		}
		else{
			$ci->session->set_flashdata('error', $failed_msg); 
		}
	}
}

if(! function_exists('dd'))
{
	function dd($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		die;
	}
}

if(! function_exists('pecah'))
{
	function pecah($arr)
	{
		return explode('-',$arr);
	}
}

if(!function_exists('permissions'))
{
	function permissions($var)
	{
		$ci =& get_instance();
		$role_id = $var['role_id'];

		$sql = "SELECT permissions.* FROM permissions JOIN role_permissions ON role_permissions.permission_id = permissions.id WHERE role_permissions.role_id = '".$role_id."'";

		$permission = $ci->db->query($sql)->result_array();

		$permission_list = array();

		if(isset($permission) && !empty($permission))
		{
			foreach($permission as $key => $val)
			{
				$permission_list[] = $val['name'];
			}
		}

		return $permission_list;
	}
}  

if(!function_exists('get_role'))
{
	function get_role($id)
	{
		$ci =& get_instance();
		$role_id = $id;

		$sql = "SELECT roles.* FROM roles WHERE roles.id = '".$id."'";
		$roles = $ci->db->query($sql)->result_array();

		$data = null;
		if(isset($roles) && !empty($roles))
		{
			$data = $roles[0]['name'];
		}

		return $data;
	}
} 

if(!function_exists('botTelegram'))
{
	function botTelegram($telegram_id, $message_text, $secret_token)
	{
		$website="https://api.telegram.org/bot".$secret_token;
		$params=[
			'chat_id' => $telegram_id,
			'text' => $message_text,
			'parse_mode' => 'HTML',
		];
		$ch = curl_init($website . '/sendMessage');
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}

if(!function_exists('getConfigValues'))
{
	function getConfigValues($value)
	{
		$ci =& get_instance();
		$sql = "SELECT * FROM config_id where config_name = '".$value."' LIMIT 1";
		$data = $ci->db->query($sql);
		if($data->num_rows() > 0)
		{
			return explode(',',$data->result_array()[0]['config_value']); 
		}
	}
}

if(!function_exists('getUserByConfig'))
{
	function getUserByConfig($config)
	{
		$ci =& get_instance();
		$ci->db->select('*');
		$ci->db->from('users');
		$ci->db->join('role_user','users.id = role_user.user_id');
		$ci->db->where_in('role_user.role_id',getConfigValues($config));
		$data = $ci->db->get();
		
		if($data->num_rows() > 0)
		{
			return $data->result();
		}
		else
		{
			return false;
		}
	}
}

if(!function_exists('getUserById'))
{
	function getUserById($id)
	{
		$ci =& get_instance();
		$ci->db->select('*');
		$ci->db->from('users');
		$ci->db->where('users.id',$id);
		$data = $ci->db->get();
		
		if($data->num_rows() > 0)
		{
			return $data->row();
		}
		else
		{
			return false;
		}
	}
}

if(!function_exists('bulan'))
{
	function bulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

if(!function_exists('dashboard_admin'))
{
	function dashboard_admin()
	{
		$ci =& get_instance();
		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$total_pengajuan = $ci->db->get()->num_rows();

		$data['total_pengajuan'] = $total_pengajuan;

		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$ci->db->where(array('pengajuan.flag_verifikasi' => NULL));
		$total_belum_verif = $ci->db->get()->num_rows();

		$data['total_belum_verif'] = $total_belum_verif;

		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$ci->db->where(array('pengajuan.flag_verifikasi' => 'Y'));
		$total_verif_diterima = $ci->db->get()->num_rows();

		$data['total_verif_diterima'] = $total_verif_diterima;

		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$ci->db->where(array('pengajuan.flag_verifikasi' => 'N'));
		$total_verif_ditolak = $ci->db->get()->num_rows();

		$data['total_verif_ditolak'] = $total_verif_ditolak;

		return $data;
	}
}

if(!function_exists('dashboard_user'))
{
	function dashboard_user()
	{
		$ci =& get_instance();
		$ci->db->select('*');
		$ci->db->from('pengajuan');
		if(in_array($ci->session->userdata('role_id'),getConfigValues('ROLE_USER')))
        {
            $ci->db->where('pengajuan.user_input',$ci->session->userdata('user_id'));
        }
		$total_pengajuan = $ci->db->get()->num_rows();

		$data['total_pengajuan'] = $total_pengajuan;

		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$ci->db->where(array('pengajuan.flag_verifikasi' => NULL));
		if(in_array($ci->session->userdata('role_id'),getConfigValues('ROLE_USER')))
        {
            $ci->db->where('pengajuan.user_input',$ci->session->userdata('user_id'));
        }
		$total_belum_verif = $ci->db->get()->num_rows();

		$data['total_belum_verif'] = $total_belum_verif;

		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$ci->db->where(array('pengajuan.flag_verifikasi' => 'Y'));
		if(in_array($ci->session->userdata('role_id'),getConfigValues('ROLE_USER')))
        {
            $ci->db->where('pengajuan.user_input',$ci->session->userdata('user_id'));
        }
		$total_verif_diterima = $ci->db->get()->num_rows();

		$data['total_verif_diterima'] = $total_verif_diterima;

		$ci->db->select('*');
		$ci->db->from('pengajuan');
		$ci->db->where(array('pengajuan.flag_verifikasi' => 'N'));
		if(in_array($ci->session->userdata('role_id'),getConfigValues('ROLE_USER')))
        {
            $ci->db->where('pengajuan.user_input',$ci->session->userdata('user_id'));
        }
		$total_verif_ditolak = $ci->db->get()->num_rows();

		$data['total_verif_ditolak'] = $total_verif_ditolak;

		return $data;
	}
}

}