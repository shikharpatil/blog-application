<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_db 
{
    public $CI;
    public function __construct()
    {
        // parent::__constuct();
        // $this->load->database();
        $this->CI =& get_instance();
        // $this->CI->load->model('dynamic_model');
    }

    // function for dynamic database connection
    public function setDatabaseForUser($db_data)
    {
        // 
        // $db2['dynamic_db'] = array(
        //     'dsn'	=> '',
        //     'hostname' => $db_data["db_hostname"],
        //     'username' => $db_data["db_username"],
        //     'password' => '',
        //     'database' => $db_data["db_name"],
        //     'dbdriver' => 'mysqli',
        //     'dbprefix' => '',
        //     'pconnect' => FALSE,
        //     'db_debug' => (ENVIRONMENT !== 'production'),
        //     'cache_on' => FALSE,
        //     'cachedir' => '',
        //     'char_set' => 'utf8',
        //     'dbcollat' => 'utf8_general_ci',
        //     'swap_pre' => '',
        //     'encrypt' => FALSE,
        //     'compress' => FALSE,
        //     'stricton' => FALSE,
        //     'failover' => array(),
        //     'save_queries' => TRUE
        // );
        $config['hostname'] = $db_data["db_hostname"];
        $config['username'] = $db_data["db_username"];
        $config['password'] = '';
        $config['database'] = $db_data["db_name"];
        $config['dbdriver'] = 'mysqli';
        $config['dbprefix'] = '';
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';
        $db2=$this->CI->load->database($config);
        return $db2;
        // $db_dynamic=$this->CI->load->database('dynamic_db',true);
        // $this->CI->load->model('dynamic_model');
        // $db_dynamic=$this->CI->dynamic_model->create_tbl($db2);

        // if($db_dynamic==true)
        // return TRUE;
        // else
        // return FALSE;
    }
}
?>