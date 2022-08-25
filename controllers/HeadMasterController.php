
<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!.');

class HeadMasterController extends CI_Controller{
    function __construct(){
        parent::__construct(); 
		$this->ip = getenv("REMOTE_ADDR");
		$this->ststem_date=date('Y-m-d');
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('USM_USNM');
        $this->user_id=$this->session->userdata('USM_USID');
        $this->menu_id=$this->session->userdata('MNM_FRNM');
        $this->system_name=gethostname();
        $this->load->model('MenuModel','menu',true); 
    } 
    function F11(){
        
        if(!$this->session->userdata('userlogin')){
            redirect('/index');
        }
        $page_data['menu_type']=$this->menu->get_menuType_data()->result();
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['user_data']=$this->menu->get_user_data($this->login_id)->result();
        $page_data['user_assign_menu']=$this->menu->get_user_assign_data($this->login_id)->result();
 
 
        $page_data['title']='School';
        $page_data['page_name']='menu_info/school';
        $this->load->view('backend/index',$page_data);
    }
    function F5(){
        
        if(!$this->session->userdata('userlogin')){
            redirect('/index');
        }
        $page_data['menu_type']=$this->menu->get_menuType_data()->result();
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['user_data']=$this->menu->get_user_data($this->login_id)->result();
        $page_data['user_assign_menu']=$this->menu->get_user_assign_data($this->login_id)->result();
 
 
        $page_data['title']='School';
        $page_data['page_name']='menu_info/school';
        $this->load->view('backend/index',$page_data);
    }
    function F20(){
        
        if(!$this->session->userdata('userlogin')){
            redirect('/index');
        }
        $page_data['menu_type']=$this->menu->get_menuType_data()->result();
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['user_data']=$this->menu->get_user_data($this->login_id)->result();
        $page_data['user_assign_menu']=$this->menu->get_user_assign_data($this->login_id)->result();
 
 
        $page_data['title']='School';
        $page_data['page_name']='menu_info/school';
        $this->load->view('backend/index',$page_data);
    }
    function F29(){
        
        if(!$this->session->userdata('userlogin')){
            redirect('/index');
        }
        $page_data['menu_type']=$this->menu->get_menuType_data()->result();
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['user_data']=$this->menu->get_user_data($this->login_id)->result();
        $page_data['user_assign_menu']=$this->menu->get_user_assign_data($this->login_id)->result();
 
 
        $page_data['title']='School';
        $page_data['page_name']='menu_info/school';
        $this->load->view('backend/index',$page_data);
    }

}