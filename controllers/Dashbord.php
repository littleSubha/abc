<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!.');

class Dashbord extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->user_role=$this->session->userdata('user_role');
        $this->system_name=gethostname();
        $this->load->model('LoginModel','login',true); 
        $this->load->model('backend/DashboardModel','dashboard',TRUE);
        
    }
    function index(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
    }

    function demo_dashboard(){
        $page_data['title'] ="DEMO Dashboard";
        $page_data['page_name'] ="demo_dashboard";
        $this->load->view('backend/index',$page_data);
    }
}