<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
    public $mec;
    public $feed_blogs=array();
    public $tags=array();
    public function __construct()
    {
        // 
        parent:: __construct();
        $this->load->database();
        $this->load->driver('cache');
        $this->load->model('blogs_model');
        $this->load->model('dynamic_model');
        $this->load->helper('url');
    }

    // index function
    public function index()
    {
        // 
        if(isset($_SESSION['id']))
        {
            $data=$this->get_users();
            $feed=$this->get_blogs_for_feed();
            $this->mec=$this->memcached_class();
            $item = $this->mec->get('key');
            if($feed==0)
            {
                $i=0;
                $get_db_info=$this->blogs_model->get_db_of_all();
                foreach ($get_db_info as $row) 
                {
                    $username=$row->username;
                    $db_name=$row->database_name;
                    $db_hostname=$row->database_hostname;
                    $db_username=$row->database_username;

                    $db_data=array("db_hostname"=>$db_hostname,"db_username"=>$db_username,"db_name"=>$db_name,"username"=>$username);

                    $get_posts=$this->dynamic_model->get_all_posts($db_data);
                    if(!empty($get_posts))
                    {
                        $db_feed[$i]=$get_posts;
                    }
                    $i++;
                }
                $merge=array();
                $users["user_list"]=$data;
                $users["db_feed"]=$db_feed;
                $Tags=$this->get_all_tags();
                foreach($Tags as $row)
                {
                    $merge=array_merge($merge,$row);
                }
                $union_tags=array_unique($merge);
                $users["Tags"]=$union_tags;
                $this->load->view('home.php',$users);
            }
            else if($data==null)
            {
                echo "no users";
            }
            else
            {
                $merge=array();
                $users["user_list"]=$data;
                $users["feed"]=$feed;
                $users["key"]=$item;
                $Tags=$this->get_all_tags();
                
                // echo "<pre>";
                // print_r($Tags);

                foreach($Tags as $row)
                {
                    $merge=array_merge($merge,$row);
                }

                // echo "<pre>";
                // print_r($merge);
                $union_tags=array_unique($merge);
                // print_r($union_tags);
                // die();
                $users["Tags"]=$union_tags;
                $this->load->view('home.php',$users);
            }
        }
        else
        {
            $this->load->helper('url');
            redirect(site_url(),'login');
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

    // function to get latest post from memcached
    public function get_blogs_for_feed()
    {
        $is_memcached=$this->check_memcached();
        if($is_memcached==1)
        {
            $this->mec=$this->memcached_class();
            $item = $this->mec->get('key');
            if($this->mec->getResultCode() == Memcached::RES_SUCCESS)
            {
                // key exists
                $this->mec=$this->memcached_class();
                $get_key=$this->mec->get('key');
                if($get_key==null)
                {
                    return 0;
                }
                else
                {
                    $get_key=$get_key-1;
                    $object="posts".$get_key;
                    $this->mec=$this->memcached_class();
                    $item = $this->mec->get($object);
                    if ($this->mec->getResultCode() == Memcached::RES_SUCCESS);
                    {
                        
                        for($i=$get_key;$i>=1;$i--)
                        {
                            $this->mec=$this->memcached_class();
                            $object="posts".$i;
                            $item = $this->mec->get($object);
                            $this->feed_blogs[$i]=$item;
                        }
                        $this->mec=$this->memcached_class();
                        $data = $this->mec->get("posts");
                        $this->feed_blogs["0"]=$data;
                        return $this->feed_blogs;
                    }
                }
            }
            else
            {
                return 0;
            }
        }
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

    // function to upload files in the gallery
    public function upload_files()
    {
        $file_name=$_FILES['file']['name'];
        $file_type=$_FILES['file']['type'];
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
        $path="application/uploads/".$file_name;

        $config['upload_path']          = "application/uploads/";
        $config['allowed_types']        = 'gif|jpg|jpeg|png|mov|mp4|mp3';
        $config['max_size']             = 200000000;
        $config['max_width']            = 200;
        $config['max_height']           = 180;

        $this->load->library('upload', $config);
        if($this->upload->do_upload('file'))
        {
            
                $this->load->helper('url');
                // echo "<img src='/Applications/XAMPP/xamppfiles/htdocs/blog/".$path."'>";
                // "/Applications/XAMPP/xamppfiles/htdocs/blog/".$path;
                $ar["path"]=$path;
                $this->load->view("test",$ar);
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            // $this->view_gallery($_SESSION['id']);
            echo "upload error";
            print_r($error);
        }
    }
}

?>