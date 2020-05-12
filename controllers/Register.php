<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
    public function __construct()
    {
        // 
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('blogs_model');
        $this->load->model('dynamic_model');
        $this->load->library('dynamic_db');
        if(isset($_SESSION['id']))
        {
            $this->load->helper('url');
            redirect(site_url().'home');
        }
        // $this->load->dbforge();
    }

    // index function
    public function index()
    {
        //
        $this->load->view('register_form');
    }

    // function to register user
    public function register_user()
    {
        // 
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        $db_hostname="localhost";
        $db_username="root";
        $db_name=$username."_blog";
        $user_data=array("username"=>$username,
        "password"=>$password,"database_name"=>$db_name,"database_hostname"=>$db_hostname,"database_username"=>$db_username);
        $is_register=$this->blogs_model->register_user($user_data);
        if($is_register==1)
        {
            //create a database
            $is_created=$this->blogs_model->create_db($db_name);
            if($is_created==true)
            {
                $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name);
                // if database created then create table
                // $db_dynamic=$this->dynamic_db->setDatabaseForUser($db_data);
                $is_table=$this->dynamic_model->create_tbl($db_data);
                if($is_table==1)
                {
                    $is_comments=$this->dynamic_model->create_comments_table($db_data);
                    if($is_comments==1)
                    {
                        $this->load->helper('url');
                        redirect(site_url().'login');
                    }
                    else
                    {
                        echo "blog_post table created not the comments";
                    }
                    // print_r($is_table);
                }
                else
                {
                    echo "table could not be created";
                }
            }

        }
        else
        {
            // not registered
            echo "not registered";
        }
    }
}

?>