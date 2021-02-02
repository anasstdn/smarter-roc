<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migration_Detailmasterjalan extends CI_Migration { 

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
            'master_jalan_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => FALSE,
                'null' => TRUE
            ),
            'kriteria_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => FALSE,
                'null' => TRUE
            ),
            'length' => array(
                'type' => 'FLOAT',
                'constraint' => 10,
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
        $this->dbforge->create_table('detail_master_jalan');
        $this->db->query('ALTER TABLE `detail_master_jalan` ADD FOREIGN KEY(`master_jalan_id`) REFERENCES master_jalan (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
        $this->db->query('ALTER TABLE `detail_master_jalan` ADD FOREIGN KEY(`kriteria_id`) REFERENCES kriteria (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;');
    }

    public function down()
    {
        $this->dbforge->drop_table('detail_master_jalan');
    }

}