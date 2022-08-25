<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!.');

class ErrorController extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        if(!$this->session->userdata('userlogin')){
            redirect('/admin');
        }
        $page_data['title']='Home';
        $page_data['page_name']='error_404';
        $this->load->view('backend/index',$page_data);
    }
    function index2(){
        $page_data['title']='Home';
        $page_data['page_name']='error_404';
        $this->load->view('index',$page_data);
    }
}