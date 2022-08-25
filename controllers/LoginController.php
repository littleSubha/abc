<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!');

class LoginController extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('LoginModel','login',true);
    }
    function index(){
        $this->login();
    }
    
    function login(){
        $page_data['user_data']=get_table_data('usr_mst','USM_USNM',"USM_CANC=1")->result();
        $page_data['title'] ="Login";
        $this->load->view('login',$page_data);

    } 
    function user_login(){ 
        // $username = $this->input->post('USM_LGID');  
        // $password = $this->input->post('USM_PASS');  

        $username=clean_input($this->input->post('USM_LGID'));
        $password=md5(clean_input($this->input->post('USM_PASS'))); 
        if ($username !=='' && $password !==''){  
            $user_data=$this->login->getUserData($username,$password);
            if($user_data){  
                 
                $user_id=$user_data->USM_USID;
                $sessionData['USM_USID'] =$user_data->USM_USID; //user id
                $sessionData['USM_CTCD'] =$user_data->USM_CTCD; //
                $sessionData['USM_USNM'] =$user_data->USM_USNM;//user name
                $user_role=$this->login->getMENUDATA($user_id);

                $sessionData['userlogin'] =true;
                $this->session->set_userdata($sessionData);
                if($user_data->USM_CTCD){
                    redirect('demo_dashboard');
                }else{
                    echo "!hello";
                }
            }else{
                echo "!error";
            }
           
            //declaring session  
            // $this->session->set_userdata(array('user'=>$user));  
            // $this->load->view('welcome_view');  
        }else{  
            echo "not hello";
            // $data['error'] = 'Your Account is Invalid';  
            // $this->load->view('login_view', $data);  
        }  
    }
    function logout(){
        $this->session->unset_userdata('USM_USID');
        //$this->session->unset_userdata('MOD_ID');
        $this->session->unset_userdata('USM_USCD');
        //$this->session->set_userdata('userlogin', FALSE);
        $this->session->sess_destroy();
        $this->load->view('login');
    } 
 
    

}