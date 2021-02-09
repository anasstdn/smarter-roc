<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migration_Pengajuan extends CI_Migration { 

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up() { 
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'tgl_pengajuan' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'nama_jalan' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'latitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'longitude' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'keterangan' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'user_input' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => FALSE,
                'null' => TRUE
            ),
            'flag_verifikasi' => array(
                'type' => 'VARCHAR',
                'constraint' => '1',
                'null' => TRUE
            ),
            'tgl_verifikasi' => array(
                'type' => 'DATETIME',
                'null' => TRUE
            ),
            'user_update' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => FALSE,
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
            ),
            
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pengajuan');
        $this->db->query('ALTER TABLE `pengajuan` ADD FOREIGN KEY(`user_input`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
        $this->db->query('ALTER TABLE `pengajuan` ADD FOREIGN KEY(`user_update`) REFERENCES users (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
    }

    public function down()
    {
        $this->dbforge->drop_table('master_jalan');
    }

}