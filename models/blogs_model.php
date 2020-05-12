<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class blogs_model extends CI_Model 
{
    public $db_dynamic;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('dynamic_db');
        $this->load->dbforge();
    }

    // verify user 
    public function verify_user($username,$password)
    {
        // print_r($username);
        // print_r($password);
        // die();
        // 
        // $this->db->where("username",$username);
        // $this->db->where("password",$password);
        // $query=$this->db->get("users");
        // $result=$query->num_rows();
        // return $result;
        $query_get="SELECT `id` FROM `users` WHERE username='$username' AND password='$password' ";
        $query = $this->db->query($query_get);
        return $query->result();
        // if($result==1)
        // {

        // }
    }

    //// function to get database of all users
    public function get_db_of_all()
    {
        $query_db="SELECT `username`,`database_name`,`database_hostname`,`database_username` FROM `users`";
        $query= $this->db->query($query_db);
        return $query->result();
    }

    // register user
    public function register_user($user_data)
    {
        // 
        return $this->db->insert("users",$user_data);
    }

    // create database for new user
    public function create_db($db_name)
    {
        // 
        $is_created=$this->dbforge->create_database($db_name);
        if($is_created==true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // create table in the dynamic database
    // public function create_tbl($db_data)
    // {
    //     $db_connection=$this->dynamic_db->setDatabaseForUser($db_data);
    //     $this->db_dynamic=$this->load->database($db_connection,true);
    //     // $query_table="CREATE TABLE `$db_name`.`blog_content` ( `id` INT(11) NOT NULL AUTO_INCREMENT , 
    //     // `content` VARCHAR(5000) NOT NULL , 
    //     // `path` VARCHAR(500) NOT NULL , 
    //     // `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
    //     // $query = $this->db_dynamic->query($query_table);
    //     // return $query->result();
    //     $fields = array(
    //         'id' => array(
    //                 'type' => 'INT',
    //                 'constraint' => 11,
    //                 'unsigned' => TRUE,
    //                 'auto_increment' => TRUE
    //         ),
    //         'content' => array(
    //                 'type' => 'VARCHAR',
    //                 'constraint' => '5000'
    //         ),
    //         'path' => array(
    //                 'type' =>'VARCHAR',
    //                 'constraint' => '500'
    //         ),
    //         'date_time' => array(
    //                 'type' => 'TIMESTAMP',
    //                 'null' => FALSE,
    //                 'default'=>'CURRENT_TIMESTAMP'
    //         ),
    //     );
    //     $this->dbforge->add_field($fields);
    //     $this->dbforge->add_key('id',true);
    //     $is_created=$this->dbforge->create_table('blog_content');
    //     if($is_created==true)
    //     {
    //         return true;
    //     }
    //     else
    //     {
    //         return false;
    //     }
    // }

    // get users list for home page
    public function get_users()
    {
        // 
        $this->db->select("id,username");
        $this->db->from("users");
        $query=$this->db->get();
        return $result=$query->result();
    }

    // function to get posts from user blogs
    public function get_post()
	{
		// 
		$query_get="SELECT `id`,`content`, `path`,`date_time` FROM `blog_content` ";
		$query = $this->db->query($query_get);
        return $query->result();
    }

    // function to get database information by id
    public function get_db_info_by_id($id)
    {
        $get_db_name=$this->get_db_name($id);
        if($get_db_name!==null)
        {
            foreach($get_db_name as $row)
            {
                $username=$row->username;
                $db_name=$row->database_name;
                $db_hostname=$row->database_hostname;
                $db_username=$row->database_username;
            }
            $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name,"username"=>$username);
            return $db_data;
        }
        else
        {
            return FALSE;
        }
    }
    
    // function to get database name from id
    public function get_db_name($id)
    {
        $query_db="SELECT `username`,`database_name`,`database_hostname`,`database_username` FROM `users` WHERE id=$id";
        $query= $this->db->query($query_db);
        return $query->result();
    }

    // function to check user exists or not
    public function user_exists($username)
    {
        // 
        $query_get="SELECT `id` FROM `users` WHERE username='$username' ";
        $query=$this->db->query($query_get);
        return $query->result();
    }

    // function to get username
    public function get_username($commenter_id)
    {
        $query_get="SELECT `username` FROM `users` WHERE id='$commenter_id' ";
        $query=$this->db->query($query_get);
        return $query->result();
    }
}

?>