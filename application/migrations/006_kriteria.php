<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migration_Kriteria extends CI_Migration { 

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
            'kriteria' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'rangking' => array(
                'type' => 'INT',
                'constraint' => 5
            ),
            
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('kriteria');
    }

    public function down()
    {
        $this->dbforge->drop_table('kriteria');
    }

}