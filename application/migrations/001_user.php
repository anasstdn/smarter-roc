<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Migration_User extends CI_Migration { 

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
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '255'
            ),
            'verified' => array(
                'type' => 'BOOLEAN',
                'default' => FALSE,
                'null' => TRUE,
            ),
            'profile_picture' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'telegram_chat_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
            ),
            'last_login' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'null' => TRUE,
            ),
            
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('username');
        $this->dbforge->create_table('users');
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }

}