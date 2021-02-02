<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migrate extends CI_Controller { 

	// public function index() { 
	// 	$this->load->library('migration');
	// 	date_default_timezone_set('Asia/Jakarta');
	// 	if ($this->migration->current() === FALSE)
	// 	{
	// 		echo $this->migration->error_string();
	// 	}else{
	// 		echo "Table Migrated Successfully.";
	// 	}
	// }
	public function do_migration($version = NULL)
	{
		$this->load->library('migration');
		date_default_timezone_set('Asia/Jakarta');
		if(isset($version) && ($this->migration->version($version) == FALSE))
		{
			show_error($this->migration->error_string());
		}
		elseif(is_null($version) && $this->migration->latest() == FALSE)
		{
			show_error($this->migration->error_string());
		}
		else
		{
			echo 'Migrasi Sukses'; 
		}
	}

	public function seeding()
	{
		date_default_timezone_set('Asia/Jakarta');

		$permission_list = array(
			'developer' => [
				'user-list',
				'user-create',
				'user-edit',
				'user-delete',
				'permissions-list',
				'permissions-create',
				'permissions-edit',
				'permissions-delete',
				'role-list',
				'role-create',
				'role-edit',
				'role-delete',
				'pengaturan-list',
				'pengaturan-create',
				'pengaturan-edit',
				'pengaturan-delete',
				'profil-list',
				'profil-create',
				'profil-edit',
				'profil-delete',
			],
			'admin' => [
				'user-list',
				'user-create',
				'user-edit',
				'user-delete',
				'pengaturan-list',
				'pengaturan-create',
				'pengaturan-edit',
				'pengaturan-delete',
				'profil-list',
				'profil-create',
				'profil-edit',
				'profil-delete',	
			],
			'user' => [
				'pengaturan-list',
				'pengaturan-create',
				'pengaturan-edit',
				'pengaturan-delete',
				'profil-list',
				'profil-create',
				'profil-edit',
				'profil-delete',	
			]
		);

		$this->db->trans_start();
		$this->db->empty_table('role_permissions');
		$this->db->empty_table('role_user');
		$this->db->empty_table('permissions');
		$this->db->empty_table('roles');
		$this->db->empty_table('users');

		$this->db->query("ALTER TABLE permissions AUTO_INCREMENT = 1");
		$this->db->query("ALTER TABLE roles AUTO_INCREMENT = 1");
		$this->db->query("ALTER TABLE users AUTO_INCREMENT = 1");

		foreach ($permission_list as $key => $modules) {
			$this->db->insert('roles', ['name' => ucwords(str_replace('_', ' ', $key)) ]);
			$role_id = $this->db->insert_id();
			foreach($modules as $module => $values)
			{
				foreach (explode(',', $values) as $p => $perm) {
					$sql = "SELECT * FROM permissions WHERE name = '".$perm."' LIMIT 1";
					$data = $this->db->query($sql);

					$permission_exists = $data->result_array();
					
					if(isset($permission_exists) && !empty($permission_exists))
					{
						$this->db->where('id',$permission_exists[0]['id']);
						$this->db->update('permissions',['name' => $perm ]);
						$permission_id = $permission_exists[0]['id'];
					}
					else
					{
						$this->db->insert('permissions', ['name' => $perm ]);
						$permission_id = $this->db->insert_id();
					}
					
					// $permission_id[$key][$module+1] = $this->db->insert_id();
					$this->db->insert('role_permissions', ['role_id' => $role_id, 'permission_id' => $permission_id ]);
				}
			}

			$user = array(
				'name' => ucwords(str_replace('_', ' ', $key)),
				'username' => $key,
				'email' => $key.'@gmail.com',
				'password' => md5('password_'.$key)
			);

			$this->db->insert('users', $user);

			$user_id = $this->db->insert_id();

			$this->db->insert('role_user',['role_id' => $role_id, 'user_id' => $user_id]);

		}
		$this->db->trans_complete();

		echo 'Seeding data sukses';
	}
}