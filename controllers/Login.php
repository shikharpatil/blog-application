<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function __construct()
    {
        // 
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('blogs_model');
        if(isset($_SESSION['id']))
        {
            $this->load->helper('url');
            redirect(site_url().'home');
        }
    }

    // index function
    public function index($is_user="")
    {
        // show login form
        if(isset($is_user))
        {
            $error['is_user']=$is_user;
            $this->load->view('login_form.php',$error);
        }
        else
        {
            $this->load->view('login_form.php');
        }
    }

    // function to get login details and verify user
    public function verify_user()
    {
        // getting the user details for login by post method
        $username=$this->input->post('username');
        $password=$this->input->post('password');
        // load model to verify user
        $is_user=$this->blogs_model->verify_user($username,$password);
        // check if verify user returns true or not
        if($is_user==!null)
        {
            // set session id
            // $get_id=$this->blogs_model->get_user_id();
            // if user verified redirect to home page
            foreach($is_user as $row)
            {
                $id=$row->id;
            }
            $_SESSION['id']=$id;
            $_SESSION['current_path']="application/uploads/".$_SESSION["id"];
            $this->load->helper('url');
            redirect(site_url().'home');
        }
        else
        {
            // if user not verified send error
            // echo "user not verified";
            $this->index($is_user);
            // print_r($is_user);
            // echo  "username or password invalid";
        }
        
    }

    public function verify_login()
    {
        $data=$this->input->post();
        // $data=json_decode($data);
        $username=$data["username"];
        $password=$data["password"];
        // print_r($data);
        // die();
        // getting the user details for login by post method
        // $username=$this->input->post('username');
        // $password=$this->input->post('password');
        // load model to verify user
        $is_user=$this->blogs_model->verify_user($username,$password);
        // check if verify user returns true or not
        if($is_user==!null)
        {
            // print_r($is_user);
            // die();
            // set session id
            // $get_id=$this->blogs_model->get_user_id();
            // if user verified redirect to home page
            foreach($is_user as $row)
            {
                $id=$row->id;
            }
            $_SESSION['id']=$id;
            $_SESSION["username"]=$username;
            $_SESSION['current_path']="application/uploads/".$_SESSION["id"]."/".$username;
            $response="login";
            echo json_encode($response);
            // $this->load->helper('url');
            // redirect(site_url().'home');
        }
        else
        {
            // if user not verified send error
            // echo "user not verified";
            // $this->index($is_user);
            // print_r($is_user);
            $response="login fail";
            echo json_encode($response);
            // echo  "username or password invalid";
        }
        
    }
    
}

?>