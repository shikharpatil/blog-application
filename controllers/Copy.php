<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Copy extends CI_Controller
{
    public $get_parent_post_id,$parent_post_data,$applied_tags_ids=array(),$new_post_id;
    public $child_post,$child_post_ids=array(),$parent_post_id=array();
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

    public function index()
    {
        $data=$this->input->post();
        $post_id=$data["post_id"];
        $user_id=$_SESSION["id"];

        // get the database info
        $db_data=$this->blogs_model->get_db_info_by_id($user_id);
        
        $new_username=$db_data["username"];
        // function call to know the post's parent
        // $parent_post_data=$this->get_parent_post($post_id,$db_data);
        $get_post_info=$this->dynamic_model->get_post_by_id($post_id,$db_data);
        foreach($get_post_info as $row)
        {
            if($row->parent_id==0)
            {
                $row->title="copy-".$row->title;
                $row->blog_url="copy-".$row->blog_url;
                // this is a parent post with no versions $get_tags=$this->dynamic_model->get_tags_on_post($blog_post_id,$db_data);
                $copy_post_data=array("user_id"=>$user_id,"parent_id"=>$row->parent_id,
                                    "title"=>$row->title,"blog_url"=>$row->blog_url,"content"=>$row->content,
                                "created_timestamp"=>$row->created_timestamp,"edited_timestamp"=>$row->edited_timestamp);
                
                $copy=$this->dynamic_model->move_post($copy_post_data,$db_data);
                if($copy==1)
                {
                    $get_blog=$this->dynamic_model->get_current_blog($db_data);

                        // get new_post_id to insert tags in new blog's post_tag_ids table 
                        foreach($get_blog as $row)
                        {
                            $this->new_post_id=$row->id;
                        }
                    $get_tags=$this->dynamic_model->get_tags_on_post($post_id,$db_data);
                    $get_comments=$this->dynamic_model->get_comments($post_id,$db_data);
                    if($get_tags!==0)
                    {
                        $k=0;
                        foreach($get_tags as $row)
                        {
                            // check if tag exists or not in tags table in blog where the post is to be moved
                            $tag=array("name"=>$row);
                            $if_tag_id=$this->dynamic_model->check_tags($tag,$db_data);
                            if($if_tag_id)
                            {
                                $this->applied_tags_ids[$k]=$if_tag_id;
                            }
                            $k++;
                        }
                        
                        // insert tags into post_tag_ids table with post_id in the new blog
                        foreach($this->applied_tags_ids as $rows)
                        {
                            $post_tag_inserted=$this->dynamic_model->add_post_tag_id($rows,$this->new_post_id,$db_data);
                        }
                    }

                    if(!empty($get_comments))
                    {
                        foreach($get_comments as $row)
                        {
                            $copy_comment["blog_post_id"]=$this->new_post_id;
                            $copy_comment["username"]=$row->username;
                            $copy_comment["content"]=$row->content;
                            $insert_comment=$this->dynamic_model->insert_comment($db_data,$copy_comment);
                        }
                    }
                }
                $response[0]="post is copied";
                $response[1]=$new_username;
                echo json_encode($response);
            }
            else
            {
                // if the post is not parent then get its parent
                //** */
                /** post with version get it's parent_post should be retrived first then the child */ 
                $all_posts=$this->dynamic_model->get_posts($db_data);
                $this->parent_post_data=$this->get_parent_post($post_id,$all_posts,$db_data);
                $i=0;
                $this->parent_post_id[$i]=$this->parent_post_data;
                $i=$i+1;
                $get_all_childs=$this->get_post_child_versions($this->parent_post_data,$all_posts,$db_data,$i);
                // print_r($this->parent_post_id[0]);
                // die();
                $get_post_info=$this->dynamic_model->get_post_by_id($this->parent_post_id[0],$db_data);
                foreach($get_post_info as $row)
                {
                    $row->title="copy-".$row->title;
                    $row->blog_url="copy-".$row->blog_url;
                    $copy_post_data=array("user_id"=>$user_id,"parent_id"=>$row->parent_id,
                                    "title"=>$row->title,"blog_url"=>$row->blog_url,"content"=>$row->content,
                                "created_timestamp"=>$row->created_timestamp,"edited_timestamp"=>$row->edited_timestamp);
                
                    $copy=$this->dynamic_model->move_post($copy_post_data,$db_data);
                    if($copy==1)
                    {
                        $get_blog=$this->dynamic_model->get_current_blog($db_data);

                            // get new_post_id to insert tags in new blog's post_tag_ids table 
                            foreach($get_blog as $row_current)
                            {
                                $this->new_post_id=$row_current->id;
                                // echo $this->new_post_id;
                                // die();
                            }
                        $get_tags=$this->dynamic_model->get_tags_on_post($this->parent_post_id[0],$db_data);
                        $get_comments=$this->dynamic_model->get_comments($this->parent_post_id[0],$db_data);
                        if($get_tags!==0)
                        {
                            $k=0;
                            foreach($get_tags as $row_tag)
                            {
                                // check if tag exists or not in tags table in blog where the post is to be moved
                                $tag=array("name"=>$row_tag);
                                $if_tag_id=$this->dynamic_model->check_tags($tag,$db_data);
                                if($if_tag_id)
                                {
                                    $this->applied_tags_ids[$k]=$if_tag_id;
                                }
                                $k++;
                            }
                            // insert tags into post_tag_ids table with post_id in the new blog
                            foreach($this->applied_tags_ids as $rows)
                            {
                                $post_tag_inserted=$this->dynamic_model->add_post_tag_id($rows,$this->new_post_id,$db_data);
                            }
                        }

                        if(!empty($get_comments))
                        {
                            foreach($get_comments as $row_comment)
                            {
                                $copy_comment["blog_post_id"]=$this->new_post_id;
                                $copy_comment["username"]=$row_comment->username;
                                $copy_comment["content"]=$row_comment->content;
                                $insert_comment=$this->dynamic_model->insert_comment($db_data,$copy_comment);
                            }
                        }
                    }
                }
                // insert all the childs of the post here
                foreach($get_all_childs as $row_id)
                {
                    // foreach($all_posts as $rows)
                    // {
                        // if($rows->id==$row_id)
                        // {
                            $get_post_info=$this->dynamic_model->get_post_by_id($row_id,$db_data);
                            foreach($get_post_info as $data)
                            {
                                $data->title="copy-".$data->title;
                                $data->blog_url="copy-".$data->blog_url;
                                // 
                                $copy_post_data=array("user_id"=>$user_id,"parent_id"=>$this->new_post_id,
                                    "title"=>$data->title,"blog_url"=>$data->blog_url,"content"=>$data->content,
                                "created_timestamp"=>$data->created_timestamp,"edited_timestamp"=>$data->edited_timestamp);
                
                                $copy=$this->dynamic_model->move_post($copy_post_data,$db_data);
                                if($copy==1)
                                {
                                    $get_blog=$this->dynamic_model->get_current_blog($db_data);

                                        // get new_post_id to insert tags in new blog's post_tag_ids table 
                                        foreach($get_blog as $row2)
                                        {
                                            $this->new_post_id=$row2->id;
                                        }
                                    $get_tags=$this->dynamic_model->get_tags_on_post($row_id,$db_data);
                                    $get_comments=$this->dynamic_model->get_comments($row_id,$db_data);
                                    if($get_tags!==0)
                                    {
                                        $k=0;
                                        foreach($get_tags as $row1)
                                        {
                                            // check if tag exists or not in tags table in blog where the post is to be moved
                                            $tag=array("name"=>$row1);
                                            $if_tag_id=$this->dynamic_model->check_tags($tag,$db_data);
                                            if($if_tag_id)
                                            {
                                                $this->applied_tags_ids[$k]=$if_tag_id;
                                            }
                                            $k++;
                                        }
                                        
                                        // insert tags into post_tag_ids table with post_id in the new blog
                                        foreach($this->applied_tags_ids as $rows3)
                                        {
                                            $post_tag_inserted=$this->dynamic_model->add_post_tag_id($rows3,$this->new_post_id,$db_data);
                                        }
                                    }

                                    if(!empty($get_comments))
                                    {
                                        foreach($get_comments as $comment_row)
                                        {
                                            $copy_comment["blog_post_id"]=$this->new_post_id;
                                            $copy_comment["username"]=$comment_row->username;
                                            $copy_comment["content"]=$comment_row->content;
                                            $insert_comment=$this->dynamic_model->insert_comment($db_data,$copy_comment);
                                        }
                                    }
                                }
                                // else
                                // {
                                //     $fail="post could not be moved";
                                //     echo json_encode($response);
                                // }
                            }
                            // 
                        // }
                    // }
                }
                $response[0]="post is copied";
                $response[1]=$new_username;
                echo json_encode($response);
            }
        }
    }

    // function to remove data from previous database
    public function remove_parent_post_data($post_id,$db_data)
    {
        $remove_from_blog=$this->dynamic_model->remove_post_data($post_id,$db_data);
        return $remove_from_blog;
    }

    // funtion to get parent of the post
    public function get_parent_post($post_id,$all_posts,$db_data)
    {
        // 
        // $get_post_info=$this->dynamic_model->get_post_by_id($post_id,$db_data);
        // here get the parent of that post
        $this->child_post=$post_id;
        
        $i=1;
        foreach($all_posts as $rows)
        {
            // echo $i;
            if($rows->id==$this->child_post)
            {
                // echo $i;
                if($rows->parent_id==0)
                {
                    // get all the data of the posts
                    $this->get_parent_post_id=$rows->id;
                    return $this->get_parent_post_id;
                }
                else
                {
                    // echo $row->id." ".$this->get_parent_post;
                    $this->get_parent_post_id=$rows->parent_id;
                    $this->get_parent_post_id=$this->get_parent_post($this->get_parent_post_id,$all_posts,$db_data);
                }
            }
            
            $i++;
        }
        // print_r($this->get_parent_post_id);
        // die();
        return $this->get_parent_post_id;
    }

    // function to get child ids of the parent post
    public function get_post_child_versions($post_id,$all_posts,$db_data,$index)
    {
        // get ids
        $this->get_parent_post_id=$post_id;
        foreach($all_posts as $row)
        {
            if($row->id==$this->get_parent_post_id)
            {
                // $this->child_post_ids[$index]=$row->id;
                // $post_id=$row->parent_id;
                // $this->child_post_ids[$indx+1]=$this->get_post_child_versions();
                foreach($all_posts as $rows)
                {
                    if($this->get_parent_post_id==$rows->parent_id)
                    {
                        $this->get_parent_post_id=$rows->id;
                        $this->child_post_ids[$index]=$rows->id;
                        $index++;
                    }
                }
            }
        }
        // print_r($this->child_post_ids);
        // die();
        return $this->child_post_ids;
    }
}
?>