<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Files extends CI_Controller
{
    public $error=array();
    public $file_name,$file_tmp_Name,$file_size,$file_type,$filename,$extension,$system_name,$final_name,$path;
    public $sub_name_error;
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
    
    // fnction index
    public function index()
    {
        // $_SESSION["current_path"]=$this->get_current_path();
        // $this->error=array();
        $dir_current=explode("application/uploads/".$_SESSION["id"]."/",$_SESSION["current_path"]);
        $get_current_directory_files=$dir_current[1];
        if(!isset($_SESSION["error"]))
        {
            $this->error["error"]=0;
        }
        else
        {
            $this->error["error"]=$_SESSION["error"];
            unset($_SESSION['error']);
        }
        
        if(isset($_SESSION["sub_name"]))
        {
            $this->sub_name_error=$_SESSION["sub_name"];
            unset($_SESSION['sub_name']);
        }
        else
        {
            $this->sub_name_error=NULL;
        }
        $db_data=$this->get_db_info($_SESSION["id"]);
        $get_files=$this->dynamic_model->get_files($db_data,$get_current_directory_files);
        $files["files_info"]=$get_files;
        $files["directories"]=$this->dynamic_model->get_user_directories($_SESSION["id"]);
        // print_r($files["directories"]);
        // die();
        $files["userList"]=$this->get_users();
        $Tags=$this->get_all_tags();
        $merge=array();
        foreach($Tags as $row)
        {
            $merge=array_merge($merge,$row);
        }
        $union_tags=array_unique($merge);
        $files["Tags"]=$union_tags;
        $files["error"]=$this->error["error"];
        $files["sub_name"]=$this->sub_name_error;
        $this->load->view("show_files",$files);
    }

    // function to get current path
    // public function get_current_path()
    // {
        
    // }

    // function to set directory path to upload
    public function set_dir_path()
    {
        $_SESSION["current_path"]=$this->input->post("dir_path");
        $_SESSION["current_dir"]=$this->input->post("dir_name");
        $this->load->helper("url");
        redirect(site_url()."files");
    }

    // function to check if the user folder exists or not 
     /**if exists then return true and upload the file if not then
      * create user folder then upload the file into it.
      */
    public function make_user_dir($user_id,$sub_name)
    {
        // check if the directory
        if(!is_dir("application/uploads/".$user_id))
        {
            $dir_made=mkdir("application/uploads/".$user_id);
            if($dir_made==TRUE)
            {
                // return TRUE;
                $dir_made=mkdir("application/uploads/".$user_id."/".$sub_name);
                if($dir_made==TRUE)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            // the directory exists
            // return 1;
            if(!is_dir("application/uploads/".$user_id."/".$sub_name))
            {
                $dir_made=mkdir("application/uploads/".$user_id."/".$sub_name);
                if($dir_made==TRUE)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                return 1;
            }
        }
    }  

    // function to create sub directory
    public function sub_create()
    {
        $sub_name=$this->input->post("sub_dir_name");
        $if_user_dir=$this->make_user_dir($_SESSION["id"],$sub_name);
        if($if_user_dir==1||TRUE)
        {
            if(!is_dir("application/uploads/".$_SESSION["id"]."/".$sub_name))
            {
                $dir_make=mkdir("application/uploads/".$_SESSION["id"]."/".$sub_name);
                if($dir_make==TRUE)
                {
                    // return TRUE;
                    $this->load->helper('url');
                    redirect(site_url()."files");
                }
                else
                {
                    // return FALSE;
                    echo "sub directory could not be created";
                    die();
                }
            }
            else
            {
                $_SESSION["sub_name"]="the directory already exists";
                $this->load->helper('url');
                redirect(site_url()."files");
            }
        }
    }

    // function to upload files
    // function to upload files in the users 
    public function upload_files()
    {
        $upload_path=$this->input->post("current_set_path");
        $upload_dir_name=$this->input->post("upload_dir_name");
        $version=1;
        $db_data=$this->get_db_info($_SESSION["id"]);
        $username=$db_data["username"];
        $this->file_name=$_FILES['upload_file']['name'];
        $this->file_type=$_FILES['upload_file']['type'];
        $this->file_tmp_name=$_FILES['upload_file']['tmp_name'];
        $this->file_size=$_FILES['upload_file']['size'];
        $this->file_size = number_format($this->file_size / 1048576, 2) . ' MB';
        
        $if_dir=$this->make_user_dir($_SESSION["id"],$username);
        if($if_dir==1||TRUE)
        {
            // $this->path=
            $this->path=$upload_path."/".$this->filename[0].$this->system_name;
            // print_r($this->path);
            // die();
        }
        else
        {
            echo "directory could not be made";
            die();
        }
        
        // check if the file exists or not
        $if_exists=$this->dynamic_model->check_file($this->file_name,$db_data,$version);
        // print_r($if_exists);
        // die();
        if(!empty($if_exists))
        {
            $this->final_name=$if_exists;
            // print_r($this->final_name."hello");
            // die();
        }
        // print_r($this->final_name);
        //     die();
        // else
        // {
        //     $this->filename = explode(".", $this->file_name);
        //     // print_r($filename);
        //     // die();
        //     $this->extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        //     $this->system_name=time().".".$this->extension;
        // }
        // print_r($file_name);
        $this->filename = explode(".", $this->file_name);
        // // print_r($filename);
        // // die();
        // $this->file_size = number_format($this->file_size / 1048576, 2) . ' MB';
        $this->extension = pathinfo($this->file_name, PATHINFO_EXTENSION);
        $this->system_name=time().".".$this->extension;
        // if(preg_match('/image/',$file_type))
        // {
        //     $file_type="image";
        // }
        // else if(preg_match('/video/',$file_type))
        // {
        //     $file_type="video";
        // }
        // else if(preg_match('/audio/',$file_type))
        // {
        //     $file_type="audio";
        // }
        // $caption=$this->input->post('caption');
        // $this->path="application/uploads/".$_SESSION["id"]."/".$this->filename[0].$this->system_name;
        // "application/uploads/".$_SESSION["id"]

        $config['upload_path']          = $upload_path;
        $config['allowed_types']        = 'gif|jpg|jpeg|png|mov|mp4|mp3|doc|txt';
        $config['max_size']             = 128000000;
        $config['file_name']            = $this->filename[0].$this->system_name;
        $config['max_width']            = 1024;
        $config['max_height']           = 1024;
        $config['min_height']           = 100;
        $config['min_width']            = 100;
        $config['detect_mime']          =TRUE;
        $config['mod_mime_fix']         =FALSE;
        $config['remove_spaces']        =FALSE;
        $config['overwrite']            =FALSE;
        $config['file_ext_tolower']     =FALSE;
        

        $this->load->library('upload', $config);
        // move_uploaded_file($file_tmp_Name, $path)
        // ALTER TABLE `files` ADD `upload_dir` VARCHAR(50) NOT NULL AFTER `name`; 
        if($this->upload->do_upload('upload_file'))
        {
            $insert_file=array("path"=>$this->path,"name"=>$this->final_name,"upload_dir"=>$upload_dir_name,"extension"=>$this->extension,
                                "size"=>$this->file_size,"system_name"=>$this->system_name);
            $add_file=$this->dynamic_model->add_file($db_data,$insert_file);
            if($add_file==1)
            {
                $this->load->helper('url');
                redirect(site_url()."files");
            } 
            else
            {
                echo "file not inserted in database";
            }                   
            // $this->load->helper('url');
            // $ar["path"]=$path;
            // $this->load->view("show_files",$ar);
        }
        else
        {
            // $this->error = array('error' => $this->upload->display_errors());
            $this->error = $this->upload->display_errors();
            // $this->view_gallery($_SESSION['id']);
            // echo "upload error";
            // print_r($error);
            $_SESSION["error"]=$this->error;
            $this->load->helper('url');
            redirect(site_url()."files");
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

    // function to get user lists
    public function get_users()
    {
        // 
        $data=$this->blogs_model->get_users();
        // if($data!==null)
        // {
            return $data;
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