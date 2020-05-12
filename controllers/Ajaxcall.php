<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Ajaxcall extends CI_Controller
{
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

    // function to get database information by id
    public function get_db_info($id)
    {
        $get_db_name=$this->blogs_model->get_db_name($id);
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

    // function to make of comment
    public function save_comment()
    {
        $data=$this->input->post();
        // echo "<pre>";
        // print_r($data);
        // die();
        $blog_url=$data["blog_url"];
        $blogger_id=$data["blogger_id"];
        $blog_post_id=$data["blog_post_id"];
        $commenter_id=$data["commenter_id"];
        $comment=$data["comment"];
        // get username from commenter id
        $get_username=$this->blogs_model->get_username($commenter_id);
        foreach($get_username as $row)
        {
            $username=$row->username;
        }
        $db_data=$this->get_db_info($blogger_id);
        $save_comment=array();
        $save_comment["blog_post_id"]=$blog_post_id;
        $save_comment["username"]=$username;
        $save_comment["content"]=$comment;
        $insert_comment=$this->dynamic_model->insert_comment($db_data,$save_comment);
        if($insert_comment==1)
        {
            $get_comment=$this->dynamic_model->get_comments($blog_post_id,$db_data);
            if(empty($get_comment))
            {
                $response="false";
                echo json_encode($response);
            }
            else
            {
                // $response["comments"]=$get_comment;
                // echo json_encode($response);
                $blog_comment["comments"]=$get_comment;
                $blog_comment["blogger_id"]=$blogger_id;
                $response=$this->load->view("ajax_save_comment",$blog_comment,TRUE);
                echo $response;
            }   
        }
    }

    // function to edit comment by ajax
    public function edit_comment()
    {
        $data=$this->input->post();
        // print_r($data);
        // die();

        // $blog_url=$data["blog_url"];
        $blogger_id=$data["blogger_id"];
        $blog_post_id=$data["blog_post_id"];
        $comment_id=$data["comment_id"];
        $edited_comment=$data["edited_comment"];

        $db_data=$this->get_db_info($blogger_id);

        $comment_data=array("content"=>$edited_comment);
        $comment_edited=$this->dynamic_model->edit_comment($db_data,$comment_id,$comment_data);

        if($comment_edited==1)
        {
            $get_comment=$this->dynamic_model->get_comments($blog_post_id,$db_data);
            if(empty($get_comment))
            {
                $response="false";
                echo json_encode($response);
            }
            else
            {
                // $response["comments"]=$get_comment;
                // echo json_encode($response);
                $blog_comment["comments"]=$get_comment;
                $blog_comment["blogger_id"]=$blogger_id;
                $response=$this->load->view("ajax_save_comment",$blog_comment,TRUE);
                echo $response;
            }    
        }
    }

    // function to get textarea for edititng comment
    public function get_comment_textarea()
    {
        $data=$this->input->post();

        $comment_id=$data["comment_id"];
        $post_id=$data["post_id"];
        $blogger_id=$data["blogger_id"];
        $num=$data["num"];

        $db_data=$this->get_db_info($blogger_id);
        $get_comment=$this->dynamic_model->get_comment_by_id($comment_id,$db_data);

        foreach($get_comment as $row)
        {
            $content=$row->content;
        }

        echo "<textarea name='data' id='edited_comment_content' class='edit_comment_content".$num."' >".$content."</textarea><br><div style='float:left' ><input type='submit' class='btn btn-info' id='submit_edited_comment' value='save' onclick='submit_edit_comment(".$num.")' ></div>
        <button class='btn btn-info' style='margin-left:5px' id='cancel_comment_edit".$num."' onclick='cancel_comment()'>Cancel</button>";
    }

    public function cancel_comment()
    {
        $data=$this->input->post();

        $blogger_id=$data["blogger_id"];
        $blog_post_id=$data["blog_post_id"];
        // $comment_id=$data["comment_id"];
        // $edited_comment=$data["edited_comment"];

        $db_data=$this->get_db_info($blogger_id);

        // $comment_data=array("content"=>$edited_comment);
        // $comment_edited=$this->dynamic_model->edit_comment($db_data,$comment_id,$comment_data);

        // if($comment_edited==1)
        // {
            $get_comment=$this->dynamic_model->get_comments($blog_post_id,$db_data);
            if(empty($get_comment))
            {
                $response="false";
                echo json_encode($response);
            }
            else
            {
                // $response["comments"]=$get_comment;
                // echo json_encode($response);
                $blog_comment["comments"]=$get_comment;
                $blog_comment["blogger_id"]=$blogger_id;
                $response=$this->load->view("ajax_save_comment",$blog_comment,TRUE);
                echo $response;
            }    
        // }

    }

    // function to replace the post versions
    public function get_post_versions()
    {
        $data=$this->input->post();
        $url=$data["posturl"];
        $blogger_id=$data["blogger_id"];
        // print_r($url);
        // die();

        $db_data=$this->get_db_info($blogger_id);

        $get_blog=$this->dynamic_model->get_blog_by_url($url,$db_data);

        $blog_data["open_blog"]=$get_blog;
        foreach($get_blog as $row)
        {
            $blog_post_id=$row->id;
            $parent_id=$row->parent_id;
            $user_id=$row->user_id;
            $blog_url=$row->blog_url;
        }
        
        $version=substr($blog_url,-2);
        preg_match_all('!\d+!', $version, $matches);
        $get_pre=$this->get_versions($parent_id,$blogger_id);
        $get_next=$this->get_next_versions($blog_post_id,$blogger_id);
        $get_tags=$this->dynamic_model->get_tags_on_post($blog_post_id,$db_data);

        $blog_data["tags"]=$get_tags;
        $blog_data["version_num"]=$matches[0][0];
        $blog_data["previous_post"]=$get_pre;
        $blog_data["next_post"]=$get_next;
        $blog_data["username"]=$db_data["username"];
        $replace=$this->load->view("ajax_post_version",$blog_data,TRUE);
        // $replace="hello";
        // $replace=json_encode($blog_data);
        echo $replace;
        // $this->load->view("post_version",$blog_data);
        // $this->load->view("post_version");
    }

    // function to get previous version 
    public function get_versions($parent_id,$user_id)
    {
        if($parent_id==0)
        {
            // $db_data=$this->get_db_info($user_id);
            // $get_username=$this->blogs_model->get_username($user_id);
            // foreach($get_username as $row)
            // {
            //     $username=$row->username;
            // }
            // $get_post=$this->dynamic_model->get_post_child($parent_id,$db_data);
            // foreach($get_post as $row)
            // {
            //     $blog_url=$row->blog_url;
            // }
            // if(isset($username)&&isset($blog_url))
            // {
                // $this->load->helper('url');
            //     // redirect(site_url().$username.'/'.$blog_url);
            //     $pre_post=site_url().$username.'/'.$blog_url;
            //     return $pre_post;
            // }
            return NULL;
        }
        else
        {
            $db_data=$this->get_db_info($user_id);
            $get_username=$this->blogs_model->get_username($user_id);
            foreach($get_username as $row)
            {
                $username=$row->username;
            }
            $get_post=$this->dynamic_model->get_post_by_id($parent_id,$db_data);
            foreach($get_post as $row)
            {
                $blog_url=$row->blog_url;
            }
            if(isset($username)&&isset($blog_url))
            {
                // $this->load->helper('url');
                // redirect(site_url().$username.'/'.$blog_url);
                // $pre_post=site_url().$username.'/'.$blog_url;
                // return $pre_post;
                return $blog_url;
            }
        }
    }

    // function to get next version 
    public function get_next_versions($post_id,$user_id)
    {
        $db_data=$this->get_db_info($user_id);
        $get_username=$this->blogs_model->get_username($user_id);
        foreach($get_username as $row)
        {
            $username=$row->username;
        }
        $get_post=$this->dynamic_model->get_post_child($post_id,$db_data);
        foreach($get_post as $row)
        {
            $blog_url=$row->blog_url;
        }
        if(isset($username)&&isset($blog_url))
        {
            // $this->load->helper('url');
            // redirect(site_url().$username.'/'.$blog_url);
            // $next_url=site_url().$username.'/'.$blog_url;
            $next_url=$blog_url;
            return $next_url;
        }
    }

    // function to get post locked status only
    public function get_post_lock_status()
    {
        $data=$this->input->post();
        $blog_post_id=$data["post_id"];
        $blogger_id=$data["blogger_id"];
        // to get database info of the original creator of the post
        $db_data=$this->get_db_info($blogger_id);
        // check to status of the post 
        $post_status=$this->dynamic_model->is_post_locked($blog_post_id,$db_data);

        $status=$post_status["check"];
        // foreach($post_status as $row)
        // {
        //     $status=$row["lock_status"];
        // }

        if($status==1)
        {
            $response="locked";
            echo json_encode($response);
        }
        else
        {
            $response="unlocked";
            echo json_encode($response);
        }
    }

    // function get blog list
    public function get_blog_list()
    {
        $data=$this->input->post();
        $all_users=$this->blogs_model->get_users();

        if(!empty($all_users))
        {
            $all_blogs["all_users"]=$all_users;
            $all_blogs["data"]=$data;
            $blog_list=$this->load->view("ajax_blog_list",$all_blogs,TRUE);
            echo $blog_list;
        }
    }
}
?>