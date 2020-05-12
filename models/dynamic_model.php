<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dynamic_model extends CI_Model
{
    public $db_dynamic;
    public $name=array();
    public $version_num;
    public function __construct()
    {
        parent::__construct();
        // $this->load->database();
        // $this->load->library('dynamic_db');
        // $this->db_dynamic=$this->dynamic_db->setDatabaseForUser($db_data);
        // $this->db_dynamic=$this->db;

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
    // create table function
    public function create_tbl($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $db_name=$db_data["db_name"];

        // $query_table="CREATE TABLE `$db_name`.`blog_posts` ( `id` INT(11) NOT NULL AUTO_INCREMENT ,
        // `user_id` INT(11) NOT NULL ,
        // `parent_id` INT(11) DEFAULT 0,
        // `title` VARCHAR(150) NOT NULL ,
        // `blog_url` VARCHAR(400) NOT NULL , 
        // `content` VARCHAR(5000) NOT NULL ,  
        // `created_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
        $query_table="CREATE TABLE `$db_name`.`blog_posts` (
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `parent_id` int(11) DEFAULT 0,
            `title` varchar(150) NOT NULL,
            `blog_url` varchar(400) NOT NULL,
            `content` varchar(5000) NOT NULL,
            `created_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
            `lock_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 is locked',
            `locked_user_id` int(11) NOT NULL DEFAULT 0,
            `edited_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
            `locked_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $query = $this->db_dynamic->query($query_table);
        // return $query->result();
        return $query;
        // CREATE TABLE `froala_editor`.`blog_posts` ( `id` INT(11) NOT NULL AUTO_INCREMENT , 
        // `user_id` INT(11) NOT NULL , 
        // `title` VARCHAR(150) NOT NULL , 
        // `blog_url` VARCHAR(400) NOT NULL , 
        // `content` VARCHAR(5000) NOT NULL , 
        // `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB; 
    }

    // function to create comments table
    public function create_comments_table($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $db_name=$db_data["db_name"];

        $query_comments="CREATE TABLE `$db_name`.`comments` ( `id` INT(11) NOT NULL AUTO_INCREMENT , 
        `blog_post_id` INT(11) NOT NULL , `username` VARCHAR(50) NOT NULL , 
        `content` VARCHAR(500) NOT NULL , `date_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
        PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
        $query = $this->db_dynamic->query($query_comments);
        if($query==1)
        {
            $created=$this->create_tags_table($db_data);
            if($created==1)
            {
                return $created;
            }
            else
            {
                return 0;
            }
        }
        // return $query;
    }

    // function to create tags table and post_tag_ids table
    public function create_tags_table($db_data)
    {
        //
        $this->db_dynamic=$this->get_database($db_data);
        $db_name=$db_data["db_name"];
        $query_tags="CREATE TABLE `$db_name`.`tags` ( `id` INT(11) NOT NULL AUTO_INCREMENT , 
        `name` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; "; 
        $query = $this->db_dynamic->query($query_tags);
        //  $query;
        if($query==1)
        {
            $post_tag_created=$this->create_post_tag_ids_table($db_data);
            if($post_tag_created==1)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }

    // function to create post_tag_ids table
    public function create_post_tag_ids_table($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $db_name=$db_data["db_name"];
        $query_post_tags="CREATE TABLE `$db_name`.`post_tag_ids` ( `id` INT(11) NOT NULL AUTO_INCREMENT , 
        `blog_post_id` INT(11) NOT NULL , 
        `tag_id` INT(11) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; ";
        $query = $this->db_dynamic->query($query_post_tags);
        // return $query;
        if($query==1)
        {
            $files_table=$this->create_files_table($db_data);
            if($files_table==1)
            {
                return 1;
            }
            else
            {
                return 0;
            }
        }
    }

    // function to create files table for each user
    public function create_files_table($db_data)
    {
        // ALTER TABLE `files` ADD `upload_dir` VARCHAR(50) NOT NULL AFTER `name`; 
        $this->db_dynamic=$this->get_database($db_data);
        $db_name=$db_data["db_name"];
        $query_files="CREATE TABLE `$db_name`.`files` ( `id` INT(11) NOT NULL AUTO_INCREMENT , 
        `path` VARCHAR(1000) NOT NULL , `name` VARCHAR(500) NOT NULL ,
        `upload_dir` VARCHAR(50) NOT NULL , `extension` VARCHAR(20) NOT NULL , `size` VARCHAR(100) NOT NULL , 
        `system_name` VARCHAR(500) NOT NULL , `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB; "; 
        $query = $this->db_dynamic->query($query_files);
        if($query==1)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
    
    // get posts form user's database table WHERE `parent_id` IS NOT NULL
    public function get_posts($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        // $query_get="SELECT `id`,`user_id`,`parent_id`,`title`,`blog_url`,`content`,`date_time` FROM `blog_posts` ";
        $query_get="SELECT * FROM `blog_posts` ";
		$query = $this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to get post by id
	public function get_post_by_id($blog_id,$db_data)
	{
        // 
        $this->db_dynamic=$this->get_database($db_data);
		$query_get="SELECT * FROM `blog_posts` WHERE id='$blog_id'";
		$query = $this->db_dynamic->query($query_get);
        return $query->result();
    }

    // functio to get next versions
    public function get_post_child($post_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT * FROM `blog_posts` WHERE parent_id='$post_id'";
		$query = $this->db_dynamic->query($query_get);
        return $query->result();   
    }
    
    // function to add blog post to database
    public function add_blog($data,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        return $this->db_dynamic->insert("blog_posts",$data);
    }

    // function to move blog post to database
    public function move_post($data,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        return $this->db_dynamic->insert("blog_posts",$data);
    }

    // function to update blog 
    public function update_content($update_blog,$db_data)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        // $id=$update_blog["id"];
		//  $this->db_dynamic->where("id",$id);
       return $this->db_dynamic->insert("blog_posts",$update_blog);
    }

    // function to delete a blog
    public function delete_blog($blog_id,$db_data)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->where('id', $blog_id);
        return $this->db_dynamic->delete('blog_posts');
    }

    // get the latest blog
    public function get_current_blog($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT * FROM `blog_posts` ORDER BY id DESC LIMIT 1";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // get blog by url
    public function get_blog_by_url($url,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT * FROM `blog_posts` WHERE blog_url='$url'";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // functio to check if log title exists or not
    public function check_title($db_data,$title)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `title` FROM `blog_posts` WHERE title='$title'";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to check url
    public function check_url($db_data,$stripped_url)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `blog_url` FROM `blog_posts` WHERE blog_url='$stripped_url'";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to get all titles 
    public function get_all_urls($db_data)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `blog_url` FROM `blog_posts` ";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to get all posts for home page order by users
    public function get_all_posts($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT * FROM `blog_posts` ORDER BY id DESC LIMIT 2 ";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
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

    // function to get all comments from blog_post_id
    public function get_comments($blog_post_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `id`,`blog_post_id`,`username`,`content`,`date_time` FROM `comments` WHERE blog_post_id='$blog_post_id' ORDER BY id DESC";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to get all comments from blog_post_id
    public function get_comments_for_move($blog_post_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `id`,`blog_post_id`,`username`,`content`,`date_time` FROM `comments` WHERE blog_post_id='$blog_post_id'";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }


    // function to get comment by id
    public function get_comment_by_id($comment_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `id`,`blog_post_id`,`username`,`content`,`date_time` FROM `comments` WHERE id='$comment_id' ";
        $query=$this->db_dynamic->query($query_get);
        return $query->result();
    }

    // function to insert comments to blog
    public function insert_comment($db_data,$save_comment)
    {
        $this->db_dynamic=$this->get_database($db_data);
        return $this->db_dynamic->insert("comments",$save_comment);
    }

    // function to edit comment
    public function edit_comment($db_data,$comment_id,$comment_edited)
    {
        $this->db_dynamic=$this->get_database($db_data);
        // $id=$comment_edited["id"];
        $this->db_dynamic->where("id",$comment_id);
        return $this->db_dynamic->update("comments",$comment_edited);
    }

    // function to check status of the post is locked or not
    public function is_post_locked($blog_post_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $query_get="SELECT `lock_status`,`locked_user_id` FROM `blog_posts` WHERE id='$blog_post_id' ";
        $query=$this->db_dynamic->query($query_get);
        $status= $query->result();
        foreach($status as $row)
        {
            $check=$row->lock_status;
            $contributor=$row->locked_user_id;
        }
        $post_status=array("check"=>$check,"contributor"=>$contributor);
        return $post_status;
    }

    // function to update status after edit request if the earlier status is 0
    public function update_post_status($blog_post_id,$status_update,$db_data)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->where("id",$blog_post_id);
         return $this->db_dynamic->update("blog_posts",$status_update);
        //  if($updated_status)
        //  {
        //     //  =$this->update_edited_time($blog_post_id,$db_data);

        //  }
    }

    // function to update the edited_timestamp of the previous version of the post when latst version is created
    public function update_edited_time($blog_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->where("id",$blog_id);
        return $this->db_dynamic->update("edited_timestamp");
    }

    // function to check tags exist or not in the 
    public function check_tags($tag,$db_data)
    {
        $individual_tag=$tag["name"];
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->select("id");
        $this->db_dynamic->from("tags");
        $this->db_dynamic->where("name",$individual_tag);
        $query=$this->db_dynamic->get();

         $if_id=$query->result();
         if(!empty($if_id))
         {
            foreach($if_id as $row)
            {
                $tag_id=$row->id;
            }
            return $tag_id;
         }
         else
         {
             $is_inserted=$this->db_dynamic->insert("tags",$tag);
             if($is_inserted==1)
             {
                $this->db_dynamic->select("id");
                $this->db_dynamic->from("tags");
                $this->db_dynamic->where("name",$individual_tag);
                $query=$this->db_dynamic->get();
        
                 $get_id=$query->result();
                 if(!empty($get_id))
                {
                    foreach($get_id as $row)
                    {
                        $tag_id_insert=$row->id;
                    }
                    return $tag_id_insert;
                }
             }
         }
    }

    // function to add post_tag_ids to post_tag_ids table
    public function add_post_tag_id($tag_id,$post_id,$db_data)
    {
        $post_tag_id_data=array("blog_post_id"=>$post_id,"tag_id"=>$tag_id);
        // 
        $this->db_dynamic=$this->get_database($db_data);
        return $this->db_dynamic->insert("post_tag_ids",$post_tag_id_data);
    }

    // function to get all tags on the posts
    public function get_tags_on_post($blog_post_id,$db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->select("tag_id");
        $this->db_dynamic->from("post_tag_ids");
        $this->db_dynamic->where("blog_post_id",$blog_post_id);
        $query=$this->db_dynamic->get();
        $tag_ids=$query->result();
        if(empty($tag_ids))
        {
            return 0;
        }
        else
        {
            
            $i=0;
            foreach($tag_ids as $row)
            {
                $this->db_dynamic->select("name");
                $this->db_dynamic->from("tags");
                $this->db_dynamic->where("id",$row->tag_id);
                
                $query_name=$this->db_dynamic->get();
                $tag_name=$query_name->result();
                // print_r($tag_name);
                // die();
                foreach($tag_name as $rows)
                {
                    $this->name[$i]=$rows->name;
                }
                $i++;
            }
            return $this->name;
        }
    }

    // function to search by tags and get all the post with that tags
    public function search_by_keyword($db_data,$keyword)
    {
        $this->db_dynamic=$this->get_database($db_data);
        // search the tags from tags table and get id
        $this->db_dynamic->select("id");
        $this->db_dynamic->from("tags");
        $this->db_dynamic->where("name",$keyword);
        $query=$this->db_dynamic->get();
        $tag_id=$query->result();

        if(empty($tag_id))
        {
            return 0;
        }
        else
        {
            foreach($tag_id as $row)
            {
                $id=$row->id;
                // search me if multiple post id are there with same tags then use get post in a loop store it in the array and then return that array
                //* continue from here*/
                // search the tag id in the post_tag_ids table
            }
            $this->db_dynamic->select("blog_post_id");
            $this->db_dynamic->from("post_tag_ids");
            $this->db_dynamic->where("tag_id",$id);
            $query_post_id=$this->db_dynamic->get();
            $get_post_id=$query_post_id->result();
            $k=0;
            foreach($get_post_id as $rows)
            {
                $post_id=$rows->blog_post_id;
                $this->db_dynamic->select("*");
                $this->db_dynamic->from("blog_posts");
                $this->db_dynamic->where("id",$post_id);
                $query_post=$this->db_dynamic->get();
                $blog_post=$query_post->result();
                // return $blog_post;
                $result_posts[$k]=$blog_post;
                $k++;
            }
            return $result_posts;
            
        }
    }

    // function to get all tags from all the user's database
    public function get_all_tags($db_data)
    {
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->select("*");
        $this->db_dynamic->from("tags");
        $query_tags=$this->db_dynamic->get();
        $all_tags=$query_tags->result();
        $tags=array();
        $i=0;
        if(!empty($all_tags))
        {
            foreach($all_tags as $row)
            {
                $tags[$i]=$row->name;
                $i++;
            }
            return $tags;
        }
    }

    // function to insert file details in the database
    public function add_file($db_data,$insert_file)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        return $this->db_dynamic->insert("files",$insert_file);
    }

    // function to get all files 
    public function get_files($db_data,$get_current_directory_files)
    {
        // 
        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->select("*");
        $this->db_dynamic->from("files");
        $this->db_dynamic->where("upload_dir",$get_current_directory_files);
        $this->db_dynamic->order_by("id","DESC");
        $query_files=$this->db_dynamic->get();
        return $query_files->result();
    }

    // function to check if the file exists or not
    public function check_file($file_name,$db_data,$version)
    {
        // print_r("hello");
        // die();
        // 
        // $this->db_dynamic=$this->get_database($db_data);
        // $this->db_dynamic->select("name");
        // $this->db_dynamic->from("files");
        // $this->db_dynamic->where("name",$file_name);
        // $query_files=$this->db_dynamic->get();
        // return $query_files->result();
        $filename = explode(".", $file_name);
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $filename =$filename[0]."-v";

        $this->db_dynamic=$this->get_database($db_data);
        $this->db_dynamic->select("name");
        $this->db_dynamic->from("files");
        // $this->db_dynamic->where("name",$file_name);
        $query_files=$this->db_dynamic->get();
        $all_names=$query_files->result();
        
        $final_version=$this->check_file_versions($all_names,$filename,$version,$extension);
        // print_r($final_version);
        // die();
        if(is_numeric($final_version))
        {
            $final_name=$filename.$final_version.".".$extension;
            // print_r($final_name);
            // die();
            return $final_name;
        }
    }

    // function to check versions of the file name
    public function check_file_versions($all_names,$filename,$version,$extension)
    {
        $check_string=$filename.$version.".".$extension;
        // print_r($check_string);
        $this->version_num=$version;

        foreach($all_names as $row)
        {
            if($row->name==$check_string)
            {
                $this->version_num=$version+1;
                $version=$this->version_num;
                $this->version_num=$this->check_file_versions($all_names,$filename,$version,$extension);
            }
        }
        return $this->version_num;
    }

    // function to get user directories
    public function get_user_directories($user_id)
    {
        $path="application/uploads/".$user_id;
        $extract_path="application/uploads/".$user_id."/";
        if(is_dir($path))
        {
            $directories = glob($path . '/*' , GLOB_ONLYDIR);
            // return $directories;
            // print_r($directories);
            // echo "he";
            // die();
            if(empty($directories))
            {
                return $directories;
            }
            else
            {
                $k=0;
                foreach($directories as $row)
                {
                    $i=0;
                    $sub_name=explode($extract_path,$row);
                    // print_r($sub_name);
                    $all_sub[$i]=$sub_name[1];
                    $all_sub[$i+1]=$row;
                    $all_dir[$k]=$all_sub;
                    $k++;
                }
                // echo "<pre>";
                // print_r($all_dir);
                // die();
                return $all_dir;
            }

        }
        else
        {
            
            return 0;
        }
    }

    // function to remove data after move operation
    public function remove_post_data($post_id,$db_data)
    {
        //
        $deleted_post=$this->delete_blog($post_id,$db_data);
        if($deleted_post==1)
        {
            // remove all tags data from post_tag_ids
            $this->db_dynamic=$this->get_database($db_data);
            $this->db_dynamic->where('blog_post_id', $post_id);
            $tag_removed=$this->db_dynamic->delete('post_tag_ids');

            // remove all comments data from comments
            $this->db_dynamic=$this->get_database($db_data);
            $this->db_dynamic->where('blog_post_id', $post_id);
            $comments_removed=$this->db_dynamic->delete('comments');
        }
        return $deleted_post;
    }
}

?>