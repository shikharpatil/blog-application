<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller
{
    public $result;

    public function __construct()
    {
        // 
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->driver('cache');
        $this->load->model('blogs_model');
        $this->load->model('dynamic_model');
        if(!isset($_SESSION['id']))
        {
            $this->load->helper('url');
            redirect(site_url().'/login');
        }
    }

    public function do_search()
    {
        $keyword=$this->input->post("search_keyword");
        // print_r($keyword);
        // die();
        // function call to get all the database info
        $get_db_info=$this->blogs_model->get_db_of_all();
        
        foreach ($get_db_info as $row) 
        {
            $i=0;
            $username=$row->username;
            $db_name=$row->database_name;
            $db_hostname=$row->database_hostname;
            $db_username=$row->database_username;

            $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name,"username"=>$username);

            $get_result=$this->dynamic_model->search_by_keyword($db_data,$keyword);
            if($get_result!==0)
            {
                $this->result[$username]=$get_result;
                // $this->result[$username."posts"]=;
                // print_r($get_result);
                // die();
                // $search_result["results"]=$get_result;
                // $search_result["userList"]=$this->get_users();
                // $search_result["search_keyword"]=$keyword;
                // $this->load->view("search_results",$search_result);
            }
            // else
            // {
            //     // $result[$i]=$get_result;
            //     // $search_result["results"]=$get_result;
            //     // $search_result["userList"]=$this->get_users();
            //     // $search_result["search_keyword"]=$keyword;
            //     // $this->load->view("search_results",$search_result);
            //     // $db_feed[$i]=$get_tag;
            //     // print_r($get_result);
            //     // die();
            // }
            // s$i=$i+2;
        }
        if(empty($this->result))
        {
            $search_result["results"]="";
            $search_result["userList"]=$this->get_users();
            $search_result["search_keyword"]=$keyword;
            $this->load->view("search_results",$search_result);
        }
        else
        {
            $search_result["results"]=$this->result;
            // $search_result["username"]=$this->result_usernames;
            $search_result["userList"]=$this->get_users();
            $search_result["search_keyword"]=$keyword;
            $this->load->view("search_results",$search_result);
        }
    }

    // function to get all posts from tagging
    public function tag($tag)
    {
        // $keyword=$this->input->get();
        $keyword=$tag;
        // print_r($keyword);
        // die();
        // function call to get all the database info
        $get_db_info=$this->blogs_model->get_db_of_all();
        
        foreach ($get_db_info as $row) 
        {
            $i=0;
            $username=$row->username;
            $db_name=$row->database_name;
            $db_hostname=$row->database_hostname;
            $db_username=$row->database_username;

            $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name,"username"=>$username);

            $get_result=$this->dynamic_model->search_by_keyword($db_data,$keyword);
            if($get_result!==0)
            {
                $this->result[$username]=$get_result;
                // $this->result[$username."posts"]=;
                // print_r($get_result);
                // die();
                // $search_result["results"]=$get_result;
                // $search_result["userList"]=$this->get_users();
                // $search_result["search_keyword"]=$keyword;
                // $this->load->view("search_results",$search_result);
            }
            // else
            // {
            //     // $result[$i]=$get_result;
            //     // $search_result["results"]=$get_result;
            //     // $search_result["userList"]=$this->get_users();
            //     // $search_result["search_keyword"]=$keyword;
            //     // $this->load->view("search_results",$search_result);
            //     // $db_feed[$i]=$get_tag;
            //     // print_r($get_result);
            //     // die();
            // }
            // s$i=$i+2;
        }
        if(empty($this->result))
        {
            $search_result["results"]="";
            $search_result["userList"]=$this->get_users();
            $search_result["search_keyword"]=$keyword;
            $Tags=$this->get_all_tags();
            $merge=array();
            foreach($Tags as $row)
            {
                $merge=array_merge($merge,$row);
            }
            $union_tags=array_unique($merge);
            $search_result["Tags"]=$union_tags;
            $this->load->view("search_results",$search_result);
        }
        else
        {
            $search_result["results"]=$this->result;
            // $search_result["username"]=$this->result_usernames;
            $search_result["userList"]=$this->get_users();
            $search_result["search_keyword"]=$keyword;
            $Tags=$this->get_all_tags();
            $merge=array();
            foreach($Tags as $row)
            {
                $merge=array_merge($merge,$row);
            }
            $union_tags=array_unique($merge);
            $search_result["Tags"]=$union_tags;
            $this->load->view("search_results",$search_result);
        }
    }

    // function to get user lists
    public function get_users()
    {
        // 
        $userList=$this->blogs_model->get_users();
        // if($data!==null)
        // {
            return $userList;
        // }
    }

    // function to get all tags for sidw widget
    public function get_all_tags()
    {
        $get_db_info=$this->blogs_model->get_db_of_all();
        $i=0;
        foreach ($get_db_info as $row)
        {
            $username=$row->username;
            $db_name=$row->database_name;
            $db_hostname=$row->database_hostname;
            $db_username=$row->database_username;

            $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name,"username"=>$username);

            // get all tags from the all database
            $get_tags_by_user=$this->dynamic_model->get_all_tags($db_data);
            
            if(!empty($get_tags_by_user))
            {
                // 
                $this->tags[$i]=$get_tags_by_user;
            }
            $i++;
            // print_r($get_tags_by_user);
        }
        // echo "<pre>";
        // print_r($this->tags);
        // $union = array_unique($this->tags);
        return $this->tags;
    }
}
?>