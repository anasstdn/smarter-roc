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
				'acl-menu',
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

				'masterdata-menu',
					'kriteria-list',
					'kriteria-create',
					'kriteria-edit',
					'kriteria-delete',
					'subkriteria-list',
					'subkriteria-create',
					'subkriteria-edit',
					'subkriteria-delete',
					'kriteria-list',
					'kriteria-create',
					'kriteria-edit',
					'kriteria-delete',
					'import-list',
					'import-create',
					'import-edit',
					'import-delete',
				'pengajuan-menu',
					'pengajuan-list',
					'pengajuan-create',
					'pengajuan-edit',
					'pengajuan-delete',
					'verifikasi-pengajuan-list',
					'verifikasi-pengajuan-create',
					'verifikasi-pengajuan-edit',
					'verifikasi-pengajuan-delete',
					'riwayat-pengajuan-list',
					'riwayat-pengajuan-create',
					'riwayat-pengajuan-edit',
					'riwayat-pengajuan-delete',

				'spk-list',
				'spk-create',
				'spk-edit',
				'spk-delete',

				'pengaturan-list',
				'pengaturan-create',
				'pengaturan-edit',
				'pengaturan-delete',
				// 'profil-list',
				// 'profil-create',
				// 'profil-edit',
				// 'profil-delete',
			],
			'admin' => [
				'acl-menu',
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
					
				'masterdata-menu',
					'kriteria-list',
					'kriteria-create',
					'kriteria-edit',
					'kriteria-delete',
					'subkriteria-list',
					'subkriteria-create',
					'subkriteria-edit',
					'subkriteria-delete',
					'kriteria-list',
					'kriteria-create',
					'kriteria-edit',
					'kriteria-delete',
					'import-list',
					'import-create',
					'import-edit',
					'import-delete',

				'pengajuan-menu',
					'pengajuan-list',
					'pengajuan-create',
					'pengajuan-edit',
					'pengajuan-delete',
					'verifikasi-pengajuan-list',
					'verifikasi-pengajuan-create',
					'verifikasi-pengajuan-edit',
					'verifikasi-pengajuan-delete',
					'riwayat-pengajuan-list',
					'riwayat-pengajuan-create',
					'riwayat-pengajuan-edit',
					'riwayat-pengajuan-delete',

				'spk-list',
				'spk-create',
				'spk-edit',
				'spk-delete',

				'pengaturan-list',
				'pengaturan-create',
				'pengaturan-edit',
				'pengaturan-delete',
			],
			'user' => [
				'pengaturan-list',
				'pengaturan-create',
				'pengaturan-edit',
				'pengaturan-delete',
				'pengajuan-menu',
					'pengajuan-list',
					'pengajuan-create',
					'pengajuan-edit',
					'pengajuan-delete',
					'riwayat-pengajuan-list',
					'riwayat-pengajuan-create',
					'riwayat-pengajuan-edit',
					'riwayat-pengajuan-delete',	
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
				'password' => md5('12345678'),
				'verified' => TRUE,
				'created_at' => date('Y-m-d H:i:s')
			);

			$this->db->insert('users', $user);

			$user_id = $this->db->insert_id();

			$this->db->insert('role_user',['role_id' => $role_id, 'user_id' => $user_id]);

		}

		$this->db->empty_table('kriteria');
		$this->db->empty_table('sub_kriteria');
		$this->db->empty_table('config_id');

		$this->db->query("ALTER TABLE kriteria AUTO_INCREMENT = 1");
		$this->db->query("ALTER TABLE sub_kriteria AUTO_INCREMENT = 1");
		$this->db->query("ALTER TABLE config_id AUTO_INCREMENT = 1");


		$data_kriteria = array(
			[
				'kriteria' => 'Baik', 
				'rangking' => '1'
			],
			[
				'kriteria' => 'Sedang', 
				'rangking' => '2'
			],
			[
				'kriteria' => 'Rusak Ringan', 
				'rangking' => '3'
			],
			[
				'kriteria' => 'Rusak Berat', 
				'rangking' => '4'
			],
		);

		foreach($data_kriteria as $key => $val)
		{
			$this->db->insert('kriteria', $val);
		}

		$data_subkriteria = array(
			[
				'sub_kriteria' => '76-100', 
				'rangking' => '1'
			],
			[
				'sub_kriteria' => '51-75.99', 
				'rangking' => '2'
			],
			[
				'sub_kriteria' => '26-50.99', 
				'rangking' => '3'
			],
			[
				'sub_kriteria' => '0-25.99', 
				'rangking' => '4'
			],
		);

		foreach($data_subkriteria as $key => $val)
		{
			$this->db->insert('sub_kriteria', $val);
		}

		$data_config=array(
    		[
    			'table_source'=>'roles',
    			'config_name'=>'ROLE_ADMIN',
    			'config_value'=>'1,2',
    			'description'=>'Role yang tercatat sebagai Admin',
    		],
    		[
    			'table_source'=>'roles',
    			'config_name'=>'ROLE_DEVELOPER',
    			'config_value'=>1,
    			'description'=>'Role untuk Developer',
    		],
    		[
    			'table_source'=>'roles',
    			'config_name'=>'ROLE_ADMIN',
    			'config_value'=>2,
    			'description'=>'Role untuk Admin Sistem',
    		],
            [
                'table_source'=>'roles',
                'config_name'=>'ROLE_USER',
                'config_value'=>3,
                'description'=>'Role untuk User Sistem',
            ],
            [
                'table_source'=>'kriteria',
                'config_name'=>'KRITERIA_BAIK',
                'config_value'=>1,
                'description'=>'Kriteria Baik',
            ],
            [
                'table_source'=>'kriteria',
                'config_name'=>'KRITERIA_SEDANG',
                'config_value'=>2,
                'description'=>'Kriteria Sedang',
            ],
            [
                'table_source'=>'kriteria',
                'config_name'=>'KRITERIA_RUSAK_RINGAN',
                'config_value'=>3,
                'description'=>'Kriteria Rusak Ringan',
            ],
            [
                'table_source'=>'kriteria',
                'config_name'=>'KRITERIA_RUSAK_BERAT',
                'config_value'=>4,
                'description'=>'Kriteria Rusak Berat',
            ],
            [
                'table_source'=>'sub_kriteria',
                'config_name'=>'KRITERIA_76_100',
                'config_value'=>1,
                'description'=>'Kriteria 76-100',
            ],
            [
                'table_source'=>'sub_kriteria',
                'config_name'=>'KRITERIA_51_75',
                'config_value'=>2,
                'description'=>'Kriteria 51-75',
            ],
            [
                'table_source'=>'sub_kriteria',
                'config_name'=>'KRITERIA_26_50',
                'config_value'=>3,
                'description'=>'Kriteria 26-50',
            ],
            [
                'table_source'=>'sub_kriteria',
                'config_name'=>'KRITERIA_0_25',
                'config_value'=>4,
                'description'=>'Kriteria 0-25',
            ],
    		[
    			'table_source'=>'',
    			'config_name'=>'Y-m-d',
    			'config_value'=>'Y-m-d',
    			'description'=>'Date Y-m-d format',
    		],
    		[
    			'table_source'=>'',
    			'config_name'=>'d-m-Y',
    			'config_value'=>'d-m-Y',
    			'description'=>'Date d-m-Y format',
    		],
    		[
    			'table_source'=>'',
    			'config_name'=>'Ymd',
    			'config_value'=>'Ymd',
    			'description'=>'Date ymd format',
    		],
    		[
    			'table_source'=>'',
    			'config_name'=>'dmY',
    			'config_value'=>'dmY',
    			'description'=>'Date dmy format',
    		],
    		[
    			'table_source'=>'',
    			'config_name'=>'d/m/Y',
    			'config_value'=>'d/m/Y',
    			'description'=>'Date d/m/y format',
    		],
    		[
    			'table_source'=>'',
    			'config_name'=>'Y/m/d',
    			'config_value'=>'Y/m/d',
    			'description'=>'Date y/m/d format',
    		],
    	);

    	foreach($data_config as $key => $val)
		{
			$this->db->insert('config_id', $val);
		}

		$this->db->trans_complete();

		echo 'Seeding data sukses';
	}
}