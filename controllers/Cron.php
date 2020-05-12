<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('blogs_model');
        $this->load->model('dynamic_model');
        $this->load->model('cron_model');
    }

    // index function 
    public function index()
    {
        // $post_data=array("user_id"=>2,"title"=>"hello 1234 qwerty","blog_url"=>"hello-1234-qwerty-v1","content"=>"qwertyuiop");
        // $is_done=$this->cron_model->insert_in($post_data);
        // if($is_done)
        // {
        //     $file = 'cron_dir/people.txt';
        //     // Open the file to get existing content
        //     // $current = file_get_contents($file);
        //     // Append a new person to the file
        //     $current = "John Smith\n";
        //     // Write the contents back to the file
        //     file_put_contents($file, $current);
        // }
        $get_db_info=$this->cron_model->get_db_of_all();
        foreach($get_db_info as $row)
        {
            $username=$row->username;
            $db_name=$row->database_name;
            $db_hostname=$row->database_hostname;
            $db_username=$row->database_username;

            $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name,"username"=>$username);

            // to connect with user database and check leaf lock status
            $locked_posts_ids=$this->cron_model->get_posts_with_locked_status($db_data);

            
            // print_r($locked_posts_data);

            if(!empty($locked_posts_ids))
            {
                // no post is locked in all user's blog_posts table
                // die();
                // print_r($locked_posts_id);
                foreach($locked_posts_ids as $rows)
                {
                    $posts_ids=$rows->id;
                    
                    // update the locked_status and locked_user_id to 0 
                    $update_data=array("lock_status"=>0,"locked_user_id"=>0);
                    $locked_status_changed=$this->cron_model->update_locked_status($posts_ids,$db_data,$update_data);
                    //print_r($locked_status_changed);
                }
            }
            // else
            // {
            //     echo "hello<br>";
            // }
        }
    }
}
?>