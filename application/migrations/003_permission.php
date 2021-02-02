<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migration_Permission extends CI_Migration { 

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
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'description' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('permissions');
    }

    public function down()
    {
        $this->dbforge->drop_table('permissions');
    }

}