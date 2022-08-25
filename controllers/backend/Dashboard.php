<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!.');

class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('backend/DashboardModel','dashboard',TRUE);
    }
    function index(){
        $page_data['dashboard_data'] =$this->dashboard->get_dashboard_data();
        $page_data['user_piechart'] =$this->dashboard->service_wise_user_piechart_data();
        $page_data['post_piechart'] =$this->dashboard->service_wise_post_piechart_data();
        $page_data['monthly_reports'] =$this->dashboard->monthly_wise_piechart_data();
        $page_data['title']='Dashboard';
        $page_data['page_name']='dashboard';
        $this->load->view('backend/index',$page_data);
    }
    
}