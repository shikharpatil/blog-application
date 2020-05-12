<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class cron_model extends CI_Model
{
    public $db_dynamic;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // function to insert a row 
    public function insert_in($post_data)
    {
        return $this->db->insert("blog_posts",$post_data);
    }

    // function to get database of all users
    public function get_db_of_all()
    {
        $query_db="SELECT `username`,`database_name`,`database_hostname`,`database_username` FROM `users`";
        $query= $this->db->query($query_db);
        return $query->result();
    }

    // function to initialize dynamic database
    public function get_database($db_data)
    {
        $config['hostname'] = 'localhost';
        $config['username'] = 'root';
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
        $this->db_dynamic=$this->load->database($config,TRUE);
        return $this->db_dynamic;
    }

    // function to get post id of the locked_user_id where locked status is 1
    public function  get_posts_with_locked_status($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        // $this->db_dynamic->select("id,lock_status,locked_user_id,locked_timestamp");
        // $this->db_dynamic->from("blog_posts");
        // $this->db_dynamic->where("lock_status",1);
        // $query=$this->db_dynamic->get();

        // return $query->result();
        $query_get="SELECT `id` FROM blog_posts WHERE lock_status=1 AND locked_timestamp < DATE_SUB(NOW(), INTERVAL 1 HOUR);";
        $query= $this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to update the locked_status and locked_user_id 
    public function update_locked_status($posts_id,$db_data,$update_data)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        // $query_get="";
        $this->db_dynamic->where("id",$posts_id);
        return $this->db_dynamic->update("blog_posts",$update_data);
    }
}
?>