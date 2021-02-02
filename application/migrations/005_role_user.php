<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migration_Role_user extends CI_Migration { 

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function up() { 
        $this->dbforge->add_field(array(
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => FALSE
            ),
            
        ));
        $this->dbforge->create_table('role_user');
    }

    public function down()
    {
        $this->dbforge->drop_table('role_user');
    }

}