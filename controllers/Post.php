<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller
{
    public $mec;
    public $post_versions=array();
    public $posts=array();
    public $parent_post;
    public $result;
    // public $result_username;
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

    // index function
    public function index()
    {
        // 
        // echo "index method running".$id;
    }

    // function to check memcached server enabled or not
    public function check_memcached()
    {
        // 
        $memcached_enabled = $this->cache->memcached->is_supported();
        if(!$memcached_enabled) 
        {  
            // echo "Memcached is not installed";  
            return 0 ;
        }
        else
        {
            // echo "Memcached is installed";
            return 1 ;
        }   
    }

    // function to enable memcached object class
    public function memcached_class()
    {
        // intialising memcached class object
        $this->mec= new Memcached();
		// $this->mec->setOption(Memcached::OPT_COMPRESSION, true);
        $this->mec->addServer('127.0.0.1',11211);
        return $this->mec; 
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

    // function to open blog
    public function open_blog($username,$url)
    {
        // 
        // echo $username." ".$url;
        // die(); 
        $is_user=$this->blogs_model->user_exists($username);
        if($is_user==null)
        {
            echo "user does not exist this";
            
        }
        else
        {
            // print_r($is_user);
            // die();
            foreach($is_user as $row)
            {
                $user_id=$row->id;
            }
        }
        // echo $user_id;
        // die();
        // get database info of the user
        $db_data=$this->get_db_info($user_id);
        if($db_data==null)
        {
            echo "user does not exist123";
        }
        else
        {
            $get_blog=$this->dynamic_model->get_blog_by_url($url,$db_data);
            if($get_blog==null)
            {
                echo "wrong url here";
            }
            else
            {
                $blog_data["open_blog"]=$get_blog;
                foreach($get_blog as $row)
                {
                    $blog_post_id=$row->id;
                    $parent_id=$row->parent_id;
                    $user_id=$row->user_id;
                    $blog_url=$row->blog_url;
                }
                // preg_match_all('!\d+\.*\d*!', $blog_url, $matches);
                $version=substr($blog_url,-2);
                preg_match_all('!\d+!', $version, $matches);
                $get_pre=$this->get_versions($parent_id,$user_id);
                $get_next=$this->get_next_versions($blog_post_id,$user_id);
                $get_tags=$this->dynamic_model->get_tags_on_post($blog_post_id,$db_data);
                // if($get_pre==NUll && $get_next==NULL)
                // {
                    
                // }
                $blog_data["tags"]=$get_tags;
                $blog_data["version_num"]=$matches[0][0];
                $blog_data["previous_post"]=$get_pre;
                $blog_data["next_post"]=$get_next;
                $blog_data["username"]=$username;
                $blog_data["userList"]=$this->get_users();
                $Tags=$this->get_all_tags();
                $merge=array();
                foreach($Tags as $row)
                {
                    $merge=array_merge($merge,$row);
                }
                $union_tags=array_unique($merge);
                $blog_data["Tags"]=$union_tags;
                $blog_data["comments"]=$this->dynamic_model->get_comments($blog_post_id,$db_data);
                $this->load->view('open_blog',$blog_data);
            }
        }
    }

    // function to check user
    public function check_user($username)
    {
        // 
        $is_user=$this->blogs_model->user_exists($username);
        if($is_user==null)
        {
            echo "user does not exist";
        }
        else
        {
            foreach($is_user as $row)
            {
                $user_id=$row->id;
            }
            // $this->load->helper('url');
            // redirect(site_url().'user/get_blogs/'.$user_id);
            $this->get_blogs($user_id);
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

    // function to check title of blog exists or not
    public function check_title($title)
    {
        $lowercase_title=strtolower($title);
        $db_data=$this->get_db_info($_SESSION['id']);
        $is_title=$this->dynamic_model->check_title($db_data,$lowercase_title);
        if(empty($is_title))
        {
            return TRUE;
        }
        else
        {
            foreach($is_title as $row)
            {
                $get_title=$row->title;
            }
            if($get_title==$title)
            {
                return FALSE;
            }
        }
    }

    // function to check url of blog exists or not
    public function check_url($stripped_url)
    {
        // $lowercase_title=strtolower($title);
        $db_data=$this->get_db_info($_SESSION['id']);
        $is_url=$this->dynamic_model->check_url($db_data,$stripped_url);
        if(empty($is_url))
        {
            return TRUE;
        }
        else
        {
            foreach($is_url as $row)
            {
                $get_url=$row->blog_url;
            }
            if($get_url==$stripped_url)
            {
                return FALSE;
            }
        }
    }

    // function to remove special character form title
    public function remove_special($title)
    {
        $string = preg_replace('/[^A-Za-z0-9-]/', ' ', $title);
        $string=rtrim($string," ");
        $string=ltrim($string," ");
        $string = str_replace(' ', '-', $string);
        // echo $string."1";
        // $string=$string."-v1";
        return $string;
    }

    // function to search titles in an array
    public function check_versions($all_urls,$stripped_url,$append_num)
    {
        $urlString=$stripped_url.$append_num;
        // 
        foreach($all_urls as $row)
        {
            if($row->blog_url==$urlString)
            {
                $append_num=$append_num+1;
                $this->check_versions($all_urls,$stripped_url,$append_num);
            }
        }
        return $append_num;
    }

    // function to create url for the title
    public function create_url($title)
    {
        // convert the title to lowercase
        $lowercase_title=strtolower($title);
        // fucntion call to remove special characters from title
        $stripped_url=$this->remove_special($lowercase_title);
        
        if($stripped_url==!null)
        {
            $is_url=$this->check_url($stripped_url);
            if($is_url==TRUE)
            {
                // echo "title does not exist123";
                // die();
                $make_url["url"]=$stripped_url;
                $make_url["title"]=$lowercase_title;
                return $make_url;
            }
            else if($is_url==FALSE)
            {
                // echo "title does exist123";
                // die();
                /** even after removing special characters from url and adding dashes
                 * to it if the url still exists then append number to it but how to know which number to add */
                // $i=0;
                // while($) 

                // get all titles in array
                $db_data=$this->get_db_info($_SESSION['id']);
                $all_urls=$this->dynamic_model->get_all_urls($db_data);
                $append_num=1;
                // $urlString=$stripped_url.$i;
                $version_url=$this->check_versions($all_urls,$stripped_url,$append_num);
                if(is_int($version_url))
                {
                    $make_url["url"]= $stripped_url.$version_url;
                    $make_url["title"]=$lowercase_title;
                    return $make_url;
                }
            }
        }
        // $url_string=str_replace(" ","-",$lowercase_title);
        // return $url_string;
        // print_r($url_string);
        // die();
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

    // function to get user blogs
    public function get_blogs($id)
    {
        // 
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
            // $db_data=array();
            $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name);
            $get_post=$this->dynamic_model->get_posts($db_data);
            // $i=0;
            // $post_id=array();
            // foreach($get_post as $row)
            // {
            //     // if($row->id==$row->parent_id)
            //     $post_id[$i]=$row->id;
            //     $i++; //start here

            // }
            // echo "<pre>";
            // print_r($post_id);
            // print_r($get_post);
            // die();
            // $post_versions=array();
            $version=array();
            // for($j=0;$j<count($post_id);$j++)
            // {
                
                foreach($get_post as $row)
                {
                    $k=0;
                    if($row->parent_id==0)
                    {
                        // this is the first parent post
                        $this->parent_post=$row->id;
                        $version["id"]=$row->id;
                        $version["user_id"]=$row->user_id;
                        $version["parent_id"]=$row->parent_id;
                        $version["title"]=$row->title;
                        $version["blog_url"]=$row->blog_url;
                        $version["content"]=$row->content;
                        $version["created_timestamp"]=$row->created_timestamp;
                        $this->post_versions[$k]=$version;
                        // print_r($this->post_versions);
                        // print_r($k);
                        // this loop will search for versions of the first parent post
                        foreach($get_post as $rows)
                        {
                            if(!empty($rows->parent_id))
                            {
                                if($rows->parent_id==$this->parent_post)
                                {
                                    $this->parent_post=$rows->id;
                                    $version["id"]=$rows->id;
                                    $version["user_id"]=$rows->user_id;
                                    $version["parent_id"]=$rows->parent_id;
                                    $version["title"]=$rows->title;
                                    $version["blog_url"]=$rows->blog_url;
                                    $version["content"]=$rows->content;
                                    $version["created_timestamp"]=$rows->created_timestamp;
                                    // if($k==1)
                                    // {
                                        $this->post_versions[$k]=$version;
                                    // }
                                    // else
                                    // {
                                        // $k++;
                                        // $this->post_versions[$k]=$version;
                                    // }
                                }
                            }
                        }
                        $this->posts[$row->id]=$this->post_versions;
                        
                    }
                    $k++;
                }
                // $this->posts[$j]=$this->post_versions;
            // }
            // print_r($this->posts);
            // die();
            if(!empty($this->posts))
            {
                $this->posts=array_reverse($this->posts);
                $data["data"]=$this->posts;
                $data["user_id"]=$id;
                $data["username"]=$username;
                $data["userList"]=$this->get_users();
                $Tags=$this->get_all_tags();
                $merge=array();
                foreach($Tags as $row)
                {
                    $merge=array_merge($merge,$row);
                }
                $union_tags=array_unique($merge);
                $data["Tags"]=$union_tags;
                $this->load->view('show_blog',$data);
            }
            else
            {
                $data["data"]=null;
                $data["user_id"]=$id;
                $data["username"]=$username;
                $data["userList"]=$this->get_users();
                $this->load->view('show_blog',$data);
            }
        }
        else
        {
            echo "database not found";
        }
    }

    // function  to save comment
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
                $response="true";
                echo json_encode($response);
            }   
        }
    }

    // function to save blog
    public function save_blog()
    {
        // 
        // $data["content"]=$this->input->post('data');
        // $data["title"]=$this->input->post('title');
        $info=$this->input->post();
        // print_r($info);
        // die();
        $title=$info["title"];
        $data["content"]=$info["content"];
        $tags["tags"]=$info["applied_tags"];
        $applied_tags=explode(",",$tags["tags"]);
        // $db_data=$this->get_db_info($_SESSION['id']);
        
        // function call to check title exists or not
        $is_title=$this->check_title($title);
        if($is_title==TRUE)
        {
            // function call to create a url for the blog
            $url=$this->create_url($title);
            $data["title"]=$url['title'];
            $url_final=$url['url']."-v1";
            $data["blog_url"]=$url_final;
            $data["user_id"]=$_SESSION["id"];
            $data["publish_status"]="published";
            // print_r($data);
            $db_data=$this->get_db_info($_SESSION['id']);
            $username=$db_data["username"];
            if($db_data==FALSE)
            {
                echo "database not found ";
            }
            else
            {
                $k=0;
                foreach($applied_tags as $row)
                {
                    // check if tag exists or not in tags table
                    $tag=array("name"=>$row);
                    $if_tag_id=$this->dynamic_model->check_tags($tag,$db_data);
                    if($if_tag_id)
                    {
                        $applied_tags_ids[$k]=$if_tag_id;
                    }
                    $k++;
                }
                $save=$this->dynamic_model->add_blog($data,$db_data);
                if($save==1)
                {
                    // get post after adding it into database and save it into memcached server
                    $get_blog=$this->dynamic_model->get_current_blog($db_data);
                    if(empty($get_blog))
                    {
                        // do not store in memcached
                        echo "do not store in memcached";
                    }
                    else
                    {
                        // get post_id to insert tags in post_tag_ids table 
                        foreach($get_blog as $row)
                        {
                            $post_id=$row->id;
                        }
                        // insert tags into post_tag_ids table with post_id
                        foreach($applied_tags_ids as $rows)
                        {
                            $post_tag_inserted=$this->dynamic_model->add_post_tag_id($rows,$post_id,$db_data);
                        }
                        // store in memcached
                        $is_memcached=$this->check_memcached();
                        if($is_memcached==0)
                        {
                            // error memcached is not ready start memcached then store the post
                        }
                        else 
                        {
                            $this->mec=$this->memcached_class();
                            $this->mec->setOption(Memcached::OPT_COMPRESSION, true);
                            $item = $this->mec->get('key');
                            if($this->mec->getResultCode() == Memcached::RES_SUCCESS)
                            {
                                // save the post into memcached
                                // call the memcached class object
                                $data["blog"]=$get_blog;
                                $data["username"]=$username;
                                $this->mec=$this->memcached_class();
                                // $this->mec->setOption(Memcached::OPT_COMPRESSION, true);
                                $item = $this->mec->get('posts');
                                if ($this->mec->getResultCode() == Memcached::RES_SUCCESS) 
                                {
                                    $this->mec=$this->memcached_class();
                                    $get_key=$this->mec->get('key');
                                    // foreach($get_key as $row)
                                    // {
                                    //     $key=$row;
                                    // }
                                    $key=$get_key;
                                    // print_r($key);
                                    // die();
                                    // item exists ($item value)
                                    $object="posts".$key;
                                    $this->mec=$this->memcached_class();
                                    $is_set=$this->mec->add($object,$data);
                                    if($is_set==TRUE)
                                    {
                                        $key=$key+1;
                                        $this->mec=$this->memcached_class();
                                        $this->mec->replace('key',$key);
                                    }
                                } 
                                else 
                                {
                                    // item does not exist ($item is probably false)
                                    
                                    $is_set=$this->mec->set('posts',$data);
                                }
                            }
                            else
                            {
                                $data["blog"]=$get_blog;
                                $data["username"]=$username;
                                $this->mec=$this->memcached_class();
                                $this->mec->setOption(Memcached::OPT_COMPRESSION, true);
                                $is_set=$this->mec->set('key',1);
                                if($is_set==1)
                                {
                                    $is_set=$this->mec->set('posts',$data);
                                }
                            }
                        }
                    }
                    // $this->load->helper('url');
                    // redirect(site_url().$username);
                    echo json_encode($username);
                }
            }
        }
        else
        {
            $response="false";
            echo json_encode($response);
        }

    }

    // function to save posts as draft
    public function save_as_drafts()
    {
        $info=$this->input->post();
        // print_r($info);
        // die();
        $title=$info["title"];
        $data["content"]=$info["content"];
        $tags["tags"]=$info["applied_tags"];
        $applied_tags=explode(",",$tags["tags"]);
        // $db_data=$this->get_db_info($_SESSION['id']);
        
        // function call to check title exists or not
        $is_title=$this->check_title($title);
        if($is_title==TRUE)
        {
            // function call to create a url for the blog
            $url=$this->create_url($title);
            $data["title"]=$url['title'];
            $url_final=$url['url']."-v1";
            $data["blog_url"]=$url_final;
            $data["user_id"]=$_SESSION["id"];
            $data["publish_status"]="draft";
            // print_r($data);
            $db_data=$this->get_db_info($_SESSION['id']);
            $username=$db_data["username"];
            if($db_data==FALSE)
            {
                echo "database not found ";
            }
            else
            {
                $k=0;
                foreach($applied_tags as $row)
                {
                    // check if tag exists or not in tags table
                    $tag=array("name"=>$row);
                    $if_tag_id=$this->dynamic_model->check_tags($tag,$db_data);
                    if($if_tag_id)
                    {
                        $applied_tags_ids[$k]=$if_tag_id;
                    }
                    $k++;
                }
                $save_as_draft=$this->dynamic_model->add_post_as_draft($data,$db_data);
                if($save_as_draft==1)
                {
                    // get post after adding it into database and save it into memcached server
                    $get_post=$this->dynamic_model->get_current_blog($db_data);
                    if(empty($get_post))
                    {
                        // do not store in memcached
                        echo "do not store in memcached";
                    }
                    else
                    {
                        // get post_id to insert tags in post_tag_ids table 
                        foreach($get_post as $row)
                        {
                            $post_id=$row->id;
                        }
                        // insert tags into post_tag_ids table with post_id
                        foreach($applied_tags_ids as $rows)
                        {
                            $post_tag_inserted=$this->dynamic_model->add_post_tag_id($rows,$post_id,$db_data);
                        }
                    }
                    // $this->load->helper('url');
                    // redirect(site_url().$username);
                    // $response="draft saved";//chenge url
                    echo json_encode($username);
                }
            }
        }
        else
        {
            $response="false";
            echo json_encode($response);
        }
    }

    // function to get all drafts
    public function get_drafts()
    {
        // get database information
        $db_data=$this->get_db_info($_SESSION["id"]);
        $username=$db_data["username"];
        // get all the drafts in the posts table
        $get_drafts=$this->dynamic_model->get_drafts_only($db_data);
        $data["data"]=$get_drafts;
        $data["user_id"]=$_SESSION["id"];
        $data["username"]=$username;
        $data["userList"]=$this->get_users();
        $Tags=$this->get_all_tags();
        $merge=array();
        foreach($Tags as $row)
        {
            $merge=array_merge($merge,$row);
        }
        $union_tags=array_unique($merge);
        $data["Tags"]=$union_tags;
        
        $this->load->view("get_drafts",$data);
    }

    // function to edit drafts
    public function edit_drafts()
    {
        $data=$this->input->post('data');
        $post_id=$this->input->post('post_id');
        $db_data=$this->get_db_info($_SESSION["id"]);
        $username=$db_data["username"];
        $update_data=array("content"=>$data);
        $update_draft=$this->dynamic_model->update_draft($db_data,$post_id,$update_data);
        if($update_draft==1)
        {
            $this->load->helper("url");
            redirect(site_url().$username."/drafts");
        }
        // print_r($data);
        // die();
    }

    // function to publish posts finally
    public function publish_post()
    {
        $data=$this->input->post();
        $post_id=$data["post_id"];
        $db_data=$this->get_db_info($_SESSION["id"]);
        $username=$db_data["username"];
        $update_data=array("publish_status"=>"published");
        $update_publish_status=$this->dynamic_model->update_draft($db_data,$post_id,$update_data);
        if($update_publish_status==1)
        {
            // $this->load->helper("url");
            // redirect(site_url().$username);
            $response[0]="Draft is published";
            $response[1]=$username;
            echo json_encode($response);
        }
    }

    // function to update blog
    public function update_blog()
    {
        // 
        $blog_id=$this->input->post("parent_id");
        // $user_id=$_SESSION['id'];
        $user_id=$this->input->post("user_id");
        $title=$this->input->post("title");
        $blog_url=$this->input->post("blog_url");
        $version=$this->input->post("version");
        $version=$version+1;
        $version="v".$version;
        $find=substr($blog_url,-2);
        $new_url=str_replace($find,$version,$blog_url);
        $content=$this->input->post("data");
        $db_data=$this->get_db_info($user_id);
        $username=$db_data["username"];
        if($db_data==FALSE)
        {
            echo "database not found ";
        }
        else
        {
            $update_blog=array("user_id"=>$user_id,"parent_id"=>$blog_id,"title"=>$title,
                                "blog_url"=>$new_url,"content"=>$content);
            $value=$this->dynamic_model->update_content($update_blog,$db_data);
            // to check post is updated or not
            if($value==1)
            {
                // update the post lock status after edit is done
                $status_update=array("lock_status"=>0,"locked_user_id"=>0); 
                $update_status=$this->dynamic_model->update_post_status($blog_id,$status_update,$db_data);
                // when new version is created then previus versions edited time should be updated
                // $update_edited_time=$this->dynamic_model->update_edited_time($blog_id,$db_data);
                $this->load->helper('url');
                redirect(site_url().$username."/".$new_url);
                // $this->get_blogs($_SESSION['id']);
            }
            else
            {
                echo "post could not be updted";
            }   
        }
    }

    // function to get delete blog
    public function delete_blog($blog_id)
    {
        // 
        $db_data=$this->get_db_info($_SESSION['id']);
        $username=$db_data["username"];
        if($db_data==FALSE)
        {
            echo "database not found to delete";
        }
        else
        {
            $del=$this->dynamic_model->delete_blog($blog_id,$db_data);
            if($del==1)
            {
                $this->load->helper('url');
                redirect(site_url().$username);
            }
        }
    }

    // to get text area by ajax
	public function get_textarea($blog_id,$num)
	{
        $db_data=$this->get_db_info($_SESSION['id']);
        $username=$db_data["username"];
        if($db_data==FALSE)
        {
            echo "database not found ";
        }
        else
        {
            $data=$this->dynamic_model->get_post_by_id($blog_id,$db_data);
            // $get["data"]=$data;
            foreach($data as $rows)
            {
                $id=$rows->id;
                $content=$rows->content;
            }
            echo "<textarea name='data' class='selector".$num."' >".$content."</textarea><br><div style='float:left' ><input type='submit' class='btn btn-info' name='save' value='save'></div>
            <a href='javascript:void(0);' id='cancel_edit".$num."' style='margin-left:5px' class='btn btn-info' onclick='cancel_draft_edit(".$num.",".$blog_id.")' >cancel</a>";
            
        }
		// 
    }
    
    // to get text area by ajax
	public function get_textarea_2($blog_id,$blogger_id)
	{
        $db_data=$this->get_db_info($blogger_id);
        $username=$db_data["username"];
        if($db_data==FALSE)
        {
            echo "database not found ";
        }
        else
        {
            $data=$this->dynamic_model->get_post_by_id($blog_id,$db_data);
            // $get["data"]=$data;
            foreach($data as $rows)
            {
                $id=$rows->id;
                $content=$rows->content;
            }
            echo "<textarea name='data' id='selector' >".$content."</textarea><br><div style='float:left'><input type='submit' class='btn btn-primary' name='save' value='save'></div>";
        }
		// 
    }
    
    // function to check the post status is locked or not
    public function is_locked($blog_post_id,$blogger_id)
    {
        // to get database info of the original creator of the post
        $db_data=$this->get_db_info($blogger_id);
        // check to status of the post 
        $post_status=$this->dynamic_model->is_post_locked($blog_post_id,$db_data);
        $check=$post_status["check"];
        $contributor=$post_status["contributor"];
        if($check==0 && $contributor==0)
        {
            // if editable then update the lock_status to locked
            $status_update=array("lock_status"=>1,"locked_user_id"=>$_SESSION["id"]); 
            $update_status=$this->dynamic_model->update_post_status($blog_post_id,$status_update,$db_data);
            if($update_status==1)
            {
                echo "editable";
            }
        }
        else if($check==1)
        {
            $get_username=$this->blogs_model->get_username($_SESSION['id']);
            foreach($get_username as $row)
            {
                $username=$row->username;
            }
            echo $username;
        }
    }

    // cancel the edit and the set th lock status to 0 and remove the user
    public function cancel_edit($blog_post_id,$blogger_id)
    {
        // to get database info of the original creator of the post
        $db_data=$this->get_db_info($blogger_id);
        $status_update=array("lock_status"=>0,"locked_user_id"=>0); 
            $update_status=$this->dynamic_model->update_post_status($blog_post_id,$status_update,$db_data);
            if($update_status==1)
            {
                $get_post=$this->dynamic_model->get_post_by_id($blog_post_id,$db_data);
                if(empty($get_post))
                {
                    echo "error 404";
                }
                else
                {
                    foreach($get_post as $row)
                    {
                        $content=$row->content;
                    }
                    echo "<p class='lead'>".$content."</p>";
                }
            }
    }

    // function to cancel draft edit
    public function cancel_draft_edit($num,$post_id)
    {
        $db_data=$this->get_db_info($_SESSION["id"]);
        $get_post=$this->dynamic_model->get_post_by_id($post_id,$db_data);
        if(empty($get_post))
        {
            echo "error 404";
        }
        else
        {
            foreach($get_post as $row)
            {
                $content=$row->content;
            }
            echo $content;
        }
    }

    // function to get upload image path
    public function upload_image()
    {
        // 
        try 
        {
			// File Route.
			$fileRoute = "application/assets/";
			//  $fileRoute= "./uploads/";
		  
			$fieldname = "file";
		  
			// Get filename.
			$filename = explode(".", $_FILES[$fieldname]["name"]);
		  
			// Validate uploaded files.
			// Do not use $_FILES["file"]["type"] as it can be easily forged.
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
		  
			// Get temp file name.
			$tmpName = $_FILES[$fieldname]["tmp_name"];
		  
			// Get mime type.
			$mimeType = finfo_file($finfo, $tmpName);
		  
			// Get extension. You must include fileinfo PHP extension.
			$extension = end($filename);
		  
			// Allowed extensions.
			$allowedExts = array("gif", "jpeg", "jpg", "png", "svg", "blob");
		  
			// Allowed mime types.
			$allowedMimeTypes = array("image/gif", "image/jpeg", "image/pjpeg", "image/x-png", "image/png", "image/svg+xml");
		  
			// Validate image.
			if (!in_array(strtolower($mimeType), $allowedMimeTypes) || !in_array(strtolower($extension), $allowedExts)) {
			  throw new \Exception("File does not meet the validation.");
			}
		  
			// Generate new random name.
			$name = sha1(microtime()) . "." . $extension;
			// $fullNamePath = dirname(__FILE__) . $fileRoute . $name;
			$fullNamePath = $fileRoute . $name;
		  
			// Check server protocol and load resources accordingly.
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off") {
			  $protocol = "https://";
			} else {
			  $protocol = "http://";
			}
		  
			// Save file in the uploads folder.
			move_uploaded_file($tmpName, $fullNamePath);
		  
			// Generate response.
			$response = new \StdClass;
            $response->link = base_url().$fileRoute . $name;
            // $response->link = "".$fileRoute . $name;
		  
			// Send response.
			echo stripslashes(json_encode($response));
		  
        } 
        catch (Exception $e) 
        {
			 // Send error response.
			 echo $e->getMessage();
			 http_response_code(404);
		}
    }
}

?>