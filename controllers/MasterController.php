<?php
if(!defined('BASEPATH')) exit('No direct script access allowed.');

class MasterController extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->user_id=$this->session->userdata('USM_USID');
        $this->system_name=gethostname();
        $this->load->model('MasterModel','master',true);
        $this->load->model('CommonModel','common',TRUE);
    }
    function index(){
        $page_data['menu_type']=$this->menu->get_menuType_data()->result();
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['user_data']=$this->menu->get_user_data($this->login_id)->result();
        $page_data['user_assign_menu']=$this->menu->get_user_assign_data($this->login_id)->result();
 
    } 
    function common_list(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // } 
        //filter
        $COM_TPCD ='';
        if($this->input->method() == 'get'){
            $COM_TPCD =$this->input->get('f');
           
        }
        if(!empty($COM_TPCD)){
            $total_rows=total_record('com_mst','COM_CANC=1 AND COM_TPCD='.$COM_TPCD);
        }else{
            $total_rows=total_record('com_mst','COM_CANC=1');
        }
        $page_data['COM_TPCD']=$COM_TPCD;

        // //pagination code here
        // $config =[
        //     'base_url'=>base_url('common_list'),
        //     'per_page'=>'10',
        //     'total_rows'=>$total_rows,
        //     // coustum style
        //     'next_link'=>  'Next',
        //     'prev_link'=>  'Prev',
        // ];
      
        // /* This Application Must Be Used With BootStrap 3 *  */
        // $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        // $config['full_tag_close'] = '</ul>';
        // $config['num_tag_open'] = '<li class="page-item">';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        // $config['cur_tag_close'] = '</a></li>';
        // $config['next_tag_open'] = '<li class="page-item">';
        // $config['next_tagl_close'] = '</a></li>';
        // $config['prev_tag_open'] = '<li class="page-item">';
        // $config['prev_tagl_close'] = '</li>';
        // $config['first_tag_open'] = '<li class="page-item ">';
        // $config['first_tagl_close'] = '</li>';
        // $config['last_tag_open'] = '<li class="page-item">';
        // $config['last_tagl_close'] = '</a></li>';
        // $config['attributes'] = array('class' => 'page-link');
        // $config['reuse_query_string'] = true;
        // $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
        // $this->pagination->initialize($config);
        // $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        // $page_data['links']=$this->pagination->create_links();
        // '',$config['per_page'],$page,$COM_TPCD
         $page_data['common_data']=$this->master->get_common_data()->result();
        $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_list';
        $page_data['title']='Common List';
        $page_data['page_name']='common_list';
        $this->load->view('backend/index',$page_data);
    }
    function common_form(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // } 
        $page_data['common_data']=$this->master->get_common_data()->result();
        $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_list';
        $page_data['title']=' Master Add';
        $page_data['page_name']='common_form';
        $this->load->view('backend/index',$page_data);
    }
    function common_add(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $this->form_validation->set_rules('COM_TPCD','Master Type','trim|required');
        $this->form_validation->set_rules('COM_CMNM','Master Name','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            // if(!$this->session->userdata('userlogin')){
            //      redirect('home');
            // }
            $page_data['common_data']=$this->master->get_common_data()->result();
            $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='common_list';
            $page_data['title']=' Master Add';
            $page_data['page_name']='common_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $COM_CMCD =get_pk_id('com_mst','COM_CMCD');
            $insert_data=[
                'COM_CMCD'       =>$COM_CMCD,

                'COM_TPCD'       =>clean_input($this->input->post('COM_TPCD')),
                'COM_CMNM'       =>clean_input($this->input->post('COM_CMNM')),

                'COM_CHUI'       => 1,
                'COM_CHTP'       =>'Created',
                'COM_CHTM'       =>system_date(),
                'COM_CHWI'       =>get_ip(),
            ];
          
            $response=data_insert('com_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg'," Master Data Created Successfully.");
                redirect('common_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('common_form','refresh');
            }
        
        }
    }
    function common_edit($COM_CMCD){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // } 
        
        $page_data['common_data']=$this->master->get_common_data($COM_CMCD)->row();
        $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_list';
        $page_data['title']=' Master Edit';
        $page_data['page_name']='common_edit';
        $this->load->view('backend/index',$page_data);
    }
    function common_update($COM_CMCD){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // } 
        $this->form_validation->set_rules('COM_TPCD','Master Type','trim|required');
        $this->form_validation->set_rules('COM_CMNM','Master Name','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

         
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            } 
            $page_data['common_data']=$this->master->get_common_data($COM_CMCD)->row();
            $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='common_list';
            $page_data['title']=' Master Edit';
            $page_data['page_name']='common_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $update_data=[
                'COM_CMCD'       =>$COM_CMCD,

                'COM_TPCD'       =>clean_input($this->input->post('COM_TPCD')),
                'COM_CMNM'       =>clean_input($this->input->post('COM_CMNM')),

                'COM_CHUI'       => 1,
                'COM_CHTP'       =>'Modified',
                'COM_CHTM'       =>system_date(),
                'COM_CHWI'       =>get_ip(),
            ];
            $response=data_update('com_mst','COM_CMCD',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg'," Master Data Updated Successfully.");
                redirect('common_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('common_edit/'.$COM_CMCD,'refresh');
            }
            
        }
    }
    function common_deleted(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $COM_CMCD=clean_input($this->input->post('id'));
        
        $delete_data=[
            'COM_CMCD'       =>$COM_CMCD,

            'COM_CHUI'       => 1,
            'COM_CANC'       =>2,
            'COM_CHTP'       =>'Deleted',
            'COM_CHTM'       =>system_date(),
            'COM_CHWI'       =>get_ip(),
          ];
        $response= data_update('com_mst','COM_CMCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
        
    }
    function common_type_list(){ 
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
         $page_data['common_type_data']=get_table_data('com_typ01','COT_TPCD,COT_TPNM,COT_USED',"COT_CANC=1")->result();
         $page_data['main_menu']='setup';
         $page_data['menu_active']='common_type_list';
          $page_data['title']=' Common Type List';
        $page_data['page_name']='common_type_list';
        $this->load->view('backend/index',$page_data);
    }
    function common_type_form(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list'; 
        $page_data['title']='Common Type Add';
        $page_data['page_name']='common_type_form';
        $this->load->view('backend/index',$page_data);
    }
    function common_type_add(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $this->form_validation->set_rules('COT_TPNM','common Type','trim|required|is_unique[com_typ01.COT_TPNM]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['main_menu']='setup';
            $page_data['menu_active']='common_type_list';
            $page_data['title']='Common Type Add';
            $page_data['page_name']='common_type_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $COT_TPCD =get_pk_id('com_typ01','COT_TPCD');
            $insert_data=[
                'COT_TPCD'       =>$COT_TPCD,
                'COT_TPNM'       =>clean_input($this->input->post('COT_TPNM')),
                
                'COT_CHUI'       =>1,
                'COT_CHTP'       =>'Created',
                'COT_CHTM'       =>system_date(),
                'COT_CHWI'       =>get_ip(),
            ];
            
            $response=data_insert('com_typ01',$insert_data);
            if($response){
                $this->session->set_flashdata('msg'," Common Type Ddd Successfully.");
                redirect('common_type_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('common_type_form/','refresh');
            }
        
        }
    }
    function common_type_edit($COT_TPCD){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // } 
        $page_data['common_type_data']=get_table_data('com_typ01','COT_TPCD,COT_TPNM,COT_USED',"COT_CANC=1 AND COT_TPCD=".$COT_TPCD)->row();
        $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list';
        $page_data['title']=' Common Type Edit';
        $page_data['page_name']='common_type_edit';
        $this->load->view('backend/index',$page_data);
    }
     function common_type_update($COT_TPCD){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // } 
        $this->form_validation->set_rules('COT_TPNM','common Type','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            } 

        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // } 
        $page_data['common_type_data']=get_table_data('com_typ01','COT_TPCD,COT_TPNM,COT_USED',"COT_CANC=1 AND COT_TPCD=".$COT_TPCD)->row();
        $page_data['common_type']=get_table_data('com_typ01','COT_TPCD,COT_TPNM',"COT_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list';
        $page_data['title']=' Common Type Edit';
        $page_data['page_name']='common_type_edit';
        $this->load->view('backend/index',$page_data);
        }else{
            $update_data=[
                'COT_TPCD'       =>$COT_TPCD,

                'COT_TPNM'       =>clean_input($this->input->post('COT_TPNM')),
    
                'COT_CHUI'       =>1,
                'COT_CHTP'       =>'Modified',
                'COT_CHTM'       =>system_date(),
                'COT_CHWI'       =>get_ip(),
            ];
            $response=data_update('com_typ01','COT_TPCD',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg'," Common  data Updated Successfully.");
                redirect('common_type_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('common_type_edit/'.$INM_INCD,'refresh');
            }
            
        }
        
    }
    function common_type_deleted(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $COT_TPCD=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'COT_TPCD'       =>$COT_TPCD,
            'COT_CHUI'       => 1,
            'COT_CANC'       =>2,
            'COT_CHTP'       =>'Deleted',
            'COT_CHTM'       =>system_date(),
            'COT_CHWI'       =>get_ip(),
          ];
        $response= data_update('com_typ01','COT_TPCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }




    function userrole_list(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }

        $config =[
            'base_url'=>base_url('userrole_list'),
            'per_page'=>'10',
            'total_rows'=>total_record('user_role','role_cancel=1'),
            // coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
      
        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item ">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');

        // $config['reuse_query_string'] = true;
        // $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $page_data['links']=$this->pagination->create_links(); 

        $page_data['userrole_data']=$this->master->get_userrole_data('',$config['per_page'],$page)->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='userrole_list';

        $page_data['title']='User Role List';
        $page_data['page_name']='userrole_list';
        $this->load->view('backend/index',$page_data);
    }
    function userrole_form(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $page_data['main_menu']='setup';
        $page_data['menu_active']='userrole_list';

        $page_data['title']='User Role Add';
        $page_data['page_name']='userrole_form';
        $this->load->view('backend/index',$page_data);
    }
    function userrole_form_add(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $this->form_validation->set_rules('role_name','Role Name','trim|required|is_unique[user_role.role_name]');
        $this->form_validation->set_rules('role_type','Role Type ','trim|required');
 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['main_menu']='setup';
            $page_data['menu_active']='userrole_list';

            $page_data['title']='User Role Add';
            $page_data['page_name']='userrole_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $role_id =get_pk_id('user_role','role_id');
            $insert_data=[
                'role_id'           =>$role_id,
                'role_name'         =>clean_input($this->input->post('role_name')),
                'role_type'         =>clean_input($this->input->post('role_type')),
                'role_date'         =>system_date(),

                'login_id'          =>1,
                'change_type'       =>'Created',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>$this->system_name,
            ];
            $response=data_insert('user_role',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"User Role Ddd Successfully.");
                redirect('userrole_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('userrole_from/','refresh');
            }
          
        }
    }
    function userrole_edit($role_id){

        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }
        $page_data['main_menu']='setup';
        $page_data['menu_active']='userrole_list';

        $page_data['userrole_data']=$this->master->get_userrole_data($role_id)->row();
        $page_data['title']='User Role Edit';
        $page_data['page_name']='userrole_edit';
        $this->load->view('backend/index',$page_data);

    }
    function userrole_update($role_id){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }
        $this->form_validation->set_rules('role_name','Role Name','trim|required');
        $this->form_validation->set_rules('role_type','Role Type ','trim|required');
 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }
            $page_data['main_menu']='setup';
            $page_data['menu_active']='userrole_list';

            $page_data['userrole_data']=$this->master->get_userrole_data($role_id)->row();
            $page_data['title']='User Role Edit';
            $page_data['page_name']='userrole_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $role_name=clean_input($this->input->post('role_name'));
            echo $is_uniq_role_name=check_uniq_column_value('user_role','role_name',$role_name,'role_id',$role_id,'role_cancel=1');   
            if($is_uniq_role_name ==1){
                $this->session->set_flashdata('error',"This Username already exists. try anathor one.");
                redirect('userrole_edit/'.$role_id,'refresh');
            }
            $update_data=[
                'role_id'           =>$role_id,
                'role_name'         =>clean_input($this->input->post('role_name')),
                'role_type'         =>clean_input($this->input->post('role_type')),
                'role_date'         =>system_date(),

                'login_id'          =>1,
                'change_type'       =>'Modified',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>$this->system_name,
            ];
            $response=data_update('user_role','role_id',$update_data);
            if($response){
                $this->session->set_flashdata('msg',"User Role Updated Successfully.");
                redirect('userrole_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('userrole_edit/'.$role_id,'refresh');
            }
          
        }
    }
    function userrole_deleted(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $role_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'role_id'           =>$role_id,

            'login_id'          => 1,
            'role_cancel'       =>2,
            'change_type'       =>'Deleted',
            'system_date'       =>system_date(),
            'system_ip'         =>get_ip(),
          ];
        $response= data_update('user_role','role_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
        
    }
    function userrole_active(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $role_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'role_id'           =>$role_id,

            'login_id'          => 1,
            'role_status'       =>1,
            'change_type'       =>'Activated',
            'system_date'       =>system_date(),
            'system_ip'         =>get_ip(),
          ];
        $response= data_update('user_role','role_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }

    }
    function userrole_inactive(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $role_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'role_id'           =>$role_id,

            'login_id'          => 1,
            'role_status'       =>2,
            'change_type'       =>'Inactivated',
            'system_date'       =>system_date(),
            'system_ip'         =>get_ip(),
          ];
        $response= data_update('user_role','role_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    } 
    function school_list(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $scm_zone ='';
        $scm_type ='';
        if($this->input->method() == 'get'){
            $scm_zone =$this->input->get('z');
            $scm_type =$this->input->get('t');
        }

        if(!empty($scm_zone) && !empty($scm_type)){
            $total_rows=total_record('school_mst',"scm_cancel=1 AND scm_zone=$scm_zone AND scm_type=$scm_type");
        }elseif(!empty($scm_zone) && empty($scm_type)){ 
            $total_rows=total_record('school_mst',"scm_cancel=1 AND scm_zone=$scm_zone");
        }elseif(empty($scm_zone) && !empty($scm_type)){
            $total_rows=total_record('school_mst',"scm_cancel=1 AND scm_type=$scm_type");
        }else{
            $total_rows=total_record('school_mst',"scm_cancel=1");
        }
     
        $page_data['scm_zone']=$scm_zone;
        $page_data['scm_type']=$scm_type;
        //pagination code here
        $config =[
            'base_url'=>base_url('school_list'),
            'per_page'=>'10',
            'total_rows'=> $total_rows,
            // coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
      
        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item ">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['reuse_query_string'] = true;
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $page_data['links']=$this->pagination->create_links();

        $page_data['school_data']=$this->master->get_school_data('',$config['per_page'],$page,$scm_zone,$scm_type)->result();
        $page_data['school_zone']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=1 AND COM_CANC=1")->result();
        $page_data['school_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=2 AND COM_CANC=1")->result();

        $page_data['main_menu']='setup';
        $page_data['menu_active']='school_list';

        $page_data['title']='School List';
        $page_data['page_name']='school_list';
        $this->load->view('backend/index',$page_data);
    }
    function school_edit($scm_id){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // } 

        $page_data['school_data']=$this->master->get_school_data($scm_id)->row();
        $page_data['dis_data']=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_STCD=1419 AND DSM_CANC=0 UNION SELECT -1,'All' FROM dst_mst01 ORDER BY DSM_DSNM")->result();
        $page_data['school_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=2 AND COM_CANC=1")->result();
        $page_data['school_zone']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=1 AND COM_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='school_list';
        $page_data['title']='School Edit';
        $page_data['page_name']='school_edit';
        $this->load->view('backend/index',$page_data);
    }
    function school_update($scm_id){
        $this->form_validation->set_rules('scm_zone','School Zone','trim|required');
        $this->form_validation->set_rules('scm_labtype','Lab Type','trim|required');
        $this->form_validation->set_rules('scm_type','School Type','trim|required');
        $this->form_validation->set_rules('scm_name','School Name','trim|required');
        $this->form_validation->set_rules('scm_udisecode','Udise Code','trim|required');
        $this->form_validation->set_rules('scm_incharge','School Incharge','trim|required');
        $this->form_validation->set_rules('scm_inchargemobno','Incharge Mobile No','trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('scm_hmname','Headmaster Name','trim|required');
        $this->form_validation->set_rules('scm_hmmobno','Headmaster Mobile No','trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('scm_distid','District','trim|required');
        $this->form_validation->set_rules('scm_block','Block','trim|required');
        $this->form_validation->set_rules('scm_panchayat','Panchayat','trim|required');
        $this->form_validation->set_rules('scm_village','Village','trim|required');
        //$this->form_validation->set_rules('scm_address','Address','trim|required');
        $this->form_validation->set_rules('scm_pincode','Pin Code','trim|required|min_length[6]|max_length[6]');
        $this->form_validation->set_rules('scm_latitude','Latitude','trim|required');
        $this->form_validation->set_rules('scm_longitude','Longitude','trim|required');
       
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
 
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            } 
            $page_data['school_data']=$this->master->get_school_data($scm_id)->row();
            $page_data['dis_data']=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_STCD=1419 AND DSM_CANC=0 UNION SELECT -1,'All' FROM dst_mst01 ORDER BY DSM_DSNM")->result();
            $page_data['school_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=2 AND COM_CANC=1")->result();
            $page_data['school_zone']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=1 AND COM_CANC=1")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='school_list';
            $page_data['title']='School Edit';
            $page_data['page_name']='school_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $update_data=[
                'scm_id'            =>$scm_id,

                'scm_name'           =>clean_input($this->input->post('scm_name')),
                'scm_udisecode'      =>clean_input($this->input->post('scm_udisecode')),
                'scm_zone'           =>clean_input($this->input->post('scm_zone')),
                'scm_type'           =>clean_input($this->input->post('scm_type')),
                'scm_hmname'         =>clean_input($this->input->post('scm_hmname')),
                'scm_hmmobno'        =>clean_input($this->input->post('scm_hmmobno')),
                'scm_address'        =>clean_input($this->input->post('scm_address')),
                'scm_incharge'       =>clean_input($this->input->post('scm_incharge')),
                'scm_pincode'        =>clean_input($this->input->post('scm_pincode')),
                'scm_inchargemobno'  =>clean_input($this->input->post('scm_inchargemobno')),
                'scm_labtype'        =>clean_input($this->input->post('scm_labtype')),
                'scm_distid'         =>clean_input($this->input->post('scm_distid')),
                'scm_block'          =>clean_input($this->input->post('scm_block')),
                'scm_panchayat'      =>clean_input($this->input->post('scm_panchayat')),
                'scm_village'        =>clean_input($this->input->post('scm_village')),
                'scm_latitude'       =>clean_input($this->input->post('scm_latitude')),
                'scm_longitude'      =>clean_input($this->input->post('scm_longitude')),
                'scm_isupdate'       =>1,

 
                'scm_loginid'          =>1,
                'scm_changetype'       =>'Modified',
                'scm_systemdate'       =>system_date(),
                'scm_systemip'         =>get_ip(),
                'scm_systemname '      =>$this->system_name,
            ];
           $response=data_update('school_mst','scm_id',$update_data);
       
            if($response){
                $this->session->set_flashdata('msg',"School Details Updated Successfully.");
                redirect('school_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('school_edit/'.$INM_INCD,'refresh');
            }
             
        }

    }  


   


    function material_list(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $COM_CMCD ='';
        if($this->input->method() == 'get'){
            $COM_CMCD =$this->input->get('f');
           
        }
        if(!empty($COM_CMCD)){
            $total_rows=total_record('material_mst','material_cancel=1 AND material_location='.$COM_CMCD);
        }else{
            $total_rows=total_record('material_mst','material_cancel=1');
        }
        $page_data['COM_CMCD']=$COM_CMCD;
        //pagination code here
        $config =[
            'base_url'=>base_url('material_list'),
            'per_page'=>'10',
            'total_rows'=>$total_rows,
            // coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
      
        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item ">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        $config['reuse_query_string'] = true;
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $page_data['links']=$this->pagination->create_links();

        $page_data['material_data']=$this->master->get_material_data('',$config['per_page'],$page,$COM_CMCD)->result();
        $page_data['complain_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=6 AND COM_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='material_list';
        $page_data['title']=' Equipment List';
        $page_data['page_name']='material_list';
        $this->load->view('backend/index',$page_data);
    }
    function material_form(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $page_data['complain_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=6 AND COM_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='material_list';
        $page_data['title']=' Equipment Add';
        $page_data['page_name']='material_form';
        $this->load->view('backend/index',$page_data);
    }
    function material_add(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $this->form_validation->set_rules('material_location','Equipment Location','trim|required');
        $this->form_validation->set_rules('material_name','Equipment Name','trim|required');
        $this->form_validation->set_rules('material_resolveday','Resolve Days','trim|required');
        $this->form_validation->set_rules('material_ispenalty','Is Penalty Calculation?','trim|required');
     
        if($this->input->post('material_ispenalty') == 1){
            $this->form_validation->set_rules('material_penalty','Penalty Amount','trim|required');
        }
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['complain_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=6 AND COM_CANC=1")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='material_list';
            $page_data['title']=' Equipment Add';
            $page_data['page_name']='material_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $material_id =get_pk_id('material_mst','material_id');
            $insert_data=[
                'material_id'               =>$material_id,
                'material_name'             =>clean_input($this->input->post('material_name')),
                'material_location'         =>clean_input($this->input->post('material_location')),
                'material_resolveday'       =>clean_input($this->input->post('material_resolveday')),
                'material_ispenalty'        =>clean_input($this->input->post('material_ispenalty')),
                'material_penalty'          =>clean_input($this->input->post('material_penalty')),
                'material_desc'             =>clean_input($this->input->post('material_desc')),
                'material_date'             =>system_date(),
                
                'material_loginid'          =>1,
                'material_changetype'       =>'Created',
                'material_systemdate'       =>system_date(),
                'material_systemip'         =>get_ip(),
                'material_systemname'       =>$this->system_name,
            ];
            
            $response=data_insert('material_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg'," Equipment Add Successfully.");
                redirect('material_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('material_form/','refresh');
            }
        
        }
    
    }
    function material_edit($material_id){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $page_data['material_data']=$this->master->get_material_data($material_id)->row();
        $page_data['complain_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=6 AND COM_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='material_list';
        $page_data['title']=' Equipment Edit';
        $page_data['page_name']='material_edit';
        $this->load->view('backend/index',$page_data);
    }
    function material_update($material_id){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $this->form_validation->set_rules('material_location','Equipment Location','trim|required');
        $this->form_validation->set_rules('material_name','Equipment Name','trim|required');
        $this->form_validation->set_rules('material_resolveday','Resolve Days','trim|required');
        $this->form_validation->set_rules('material_ispenalty','Is Penalty Calculation?','trim|required');
     
        if($this->input->post('material_ispenalty') == 1){
            $this->form_validation->set_rules('material_penalty','Penalty Amount','trim|required');
        }

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['material_data']=$this->master->get_material_data($material_id)->row();
            $page_data['complain_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=6 AND COM_CANC=1")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='material_list';
            $page_data['title']=' Equipment Edit';
            $page_data['page_name']='material_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $update_data=[ 
                'material_id'               =>$material_id,
                'material_name'             =>clean_input($this->input->post('material_name')),
                'material_location'         =>clean_input($this->input->post('material_location')),
                'material_resolveday'       =>clean_input($this->input->post('material_resolveday')),
                'material_ispenalty'        =>clean_input($this->input->post('material_ispenalty')),
                'material_penalty'          =>clean_input($this->input->post('material_penalty')),
                'material_desc'             =>clean_input($this->input->post('material_desc')),
                
                'material_loginid'          =>1,
                'material_changetype'       =>'Modified',
                'material_systemdate'       =>system_date(),
                'material_systemip'         =>get_ip(),
                'material_systemname'       =>$this->system_name,

            ];
           

            $response=data_update('material_mst','material_id',$update_data);
            if($response){
                $this->session->set_flashdata('msg',"Equipment Updated Successfully.");
                redirect('material_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('material_edit/'.$material_id,'refresh');
            }
        
        }
    }
    function material_deleted(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $material_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'material_id'               =>$material_id,

            'material_loginid'          =>1,
            'material_cancel'           =>2,
            'material_changetype'       =>'Deleted',
            'material_systemdate'       =>system_date(),
            'material_systemip'         =>get_ip(),
            'material_systemname'       =>$this->system_name,

             
          ];
        $response= data_update('material_mst','material_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function material_active(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $material_id=clean_input($this->input->post('id'));
        $delete_data=[
            'material_id'               =>$material_id,
 
            'material_loginid'          =>1,
            'material_status'           =>1,
            'material_changetype'       =>'Activated',
            'material_systemdate'       =>system_date(),
            'material_systemip'         =>get_ip(),
            'material_systemname'       =>$this->system_name,
        ];
        $response= data_update('material_mst', 'material_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function material_inactive(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $material_id=clean_input($this->input->post('id'));
        $delete_data=[
            'material_id'               =>$material_id,
 
            'material_loginid'          =>1,
            'material_status'           =>2,
            'material_changetype'       =>'Inctivated',
            'material_systemdate'       =>system_date(),
            'material_systemip'         =>get_ip(),
            'material_systemname'       =>$this->system_name,
        ];
        $response= data_update('material_mst', 'material_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }


    /** Vender */
    function vender_list(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $config =[
            'base_url'=>base_url('vender_list'),
            'per_page'=>'10',
            'total_rows'=>total_record('vender_mst','vem_cancel=1'),
            // coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
      
        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item ">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        // $config['reuse_query_string'] = true;
        // $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $page_data['links']=$this->pagination->create_links();
 
        $page_data['vender_data']=$this->master->get_vender_data('',$config['per_page'],$page)->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='vender_list';
        $page_data['title']='Implementing Agency List';
        $page_data['page_name']='vender_list';
        $this->load->view('backend/index',$page_data);
    }
    function vender_form(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // } 
        $page_data['dis_data']=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_STCD=1419 AND DSM_CANC=0 UNION SELECT -1,'All' FROM dst_mst01 ORDER BY DSM_DSNM")->result(); 
        $page_data['main_menu']='setup';
        $page_data['menu_active']='vender_list';
        $page_data['title']='Implementing Agency Add';
        $page_data['page_name']='vender_form';
        $this->load->view('backend/index',$page_data);
    }
    function vender_add(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $this->form_validation->set_rules('vem_name','Implementing Agency Name','trim|required|is_unique[vender_mst.vem_name]');
        $this->form_validation->set_rules('vem_contno','Mobile No','trim|required|min_length[10]|max_length[10]|is_unique[vender_mst.vem_contno]');
        $this->form_validation->set_rules('vem_mailid','Email-Id','trim|required|is_unique[vender_mst.vem_mailid]');
        $this->form_validation->set_rules('vem_username','Username','trim|required|is_unique[vender_mst.vem_username]');
        $this->form_validation->set_rules('vem_password','User Password','trim|required');
        $this->form_validation->set_rules('vem_district','District','trim|required');
        $this->form_validation->set_rules('vem_addr1','Locality','trim|required');
        //$this->form_validation->set_rules('vem_addr2','Address (Area and Street)','trim|required');
        $this->form_validation->set_rules('vem_pincode','Pin Code','trim|required|min_length[6]|max_length[6]');
         
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['dis_data']=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_STCD=1419 AND DSM_CANC=0 UNION SELECT -1,'All' FROM dst_mst01 ORDER BY DSM_DSNM")->result(); 
            $page_data['main_menu']='setup';
            $page_data['menu_active']='vender_list';
            $page_data['title']='Implementing Agency Add';
            $page_data['page_name']='vender_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $user_id =get_pk_id('users_mst','user_id');
            $insert_data=[
                'user_id'            =>$user_id,
                'user_name'          =>clean_input($this->input->post('vem_name')),
                'user_mobile'        =>clean_input($this->input->post('vem_contno')),
                'user_email'         =>clean_input($this->input->post('vem_mailid')),
                'user_loginid'       =>clean_input($this->input->post('vem_username')),
                'user_password'      =>md5(clean_input($this->input->post('vem_password'))),
                'user_psw'           =>clean_input($this->input->post('vem_password')),
                'user_district'      =>clean_input($this->input->post('vem_district')),
                'user_addr1'         =>clean_input($this->input->post('vem_addr1')),
                'user_addr2'         =>clean_input($this->input->post('vem_addr2')),
                'user_pincode'       =>clean_input($this->input->post('vem_pincode')),
                'user_role'          =>8,
                'user_roledistrict'  =>6, //Kendujhar
                'user_macid'         =>'',
                
    
                'login_id'          =>1,
                'change_type'       =>'Created',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>$this->system_name,
            ];

            $vem_id =get_pk_id('vender_mst','vem_id');
            $insert_data2=[
                'vem_id'                 =>$vem_id,
                'vem_userid'             =>$user_id,
                'vem_name'               =>clean_input($this->input->post('vem_name')),
                'vem_contno'             =>clean_input($this->input->post('vem_contno')),
                'vem_mailid'             =>clean_input($this->input->post('vem_mailid')),
                'vem_username'           =>clean_input($this->input->post('vem_username')),
                'vem_password'           =>clean_input($this->input->post('vem_password')),
                'vem_district'           =>clean_input($this->input->post('vem_district')),
                'vem_addr1'              =>clean_input($this->input->post('vem_addr1')),
                'vem_addr2'              =>clean_input($this->input->post('vem_addr2')),
                'vem_pincode'            =>clean_input($this->input->post('vem_pincode')),
                'vem_role'               =>8,
                
                'vem_loginid'            =>1,
                'vem_changetype'         =>'Created',
                'vem_systemdate'         =>system_date(),
                'vem_systemip'           =>get_ip(),
                'vem_systemname'         =>$this->system_name,
            ];
            
            $response=$this->master->vender_insert($insert_data,$insert_data2);
            
            // $response=data_insert('vender_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Implementing Agency Add Successfully.");
                redirect('vender_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('vender_form/','refresh');
            }
        
        }

    }
    function vender_edit($vem_id){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // } 
         
        $page_data['vender_data']=$this->master->get_vender_data($vem_id)->row();
        $page_data['dis_data']=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_STCD=1419 AND DSM_CANC=0 UNION SELECT -1,'All' FROM dst_mst01 ORDER BY DSM_DSNM")->result(); 
        $page_data['main_menu']='setup';
        $page_data['menu_active']='vender_list';
        $page_data['title']='Implementing Agency Edit';
        $page_data['page_name']='vender_edit';
        $this->load->view('backend/index',$page_data);
    }
    function vender_update($vem_id){
        $this->form_validation->set_rules('vem_name','Implementing Agency Name','trim|required');
        $this->form_validation->set_rules('vem_contno','Mobile No','trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('vem_mailid','Email-Id','trim|required');
        $this->form_validation->set_rules('vem_username','Username','trim|required');
        $this->form_validation->set_rules('vem_password','User Password','trim|required');
        $this->form_validation->set_rules('vem_district','District','trim|required');
        $this->form_validation->set_rules('vem_addr1','Locality','trim|required');
        //$this->form_validation->set_rules('vem_addr2','Address (Area and Street)','trim|required');
        $this->form_validation->set_rules('vem_pincode','Pin Code','trim|required|min_length[6]|max_length[6]');
         
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
                }
            $page_data['vender_data']=$this->master->get_vender_data($vem_id)->row();
            $page_data['dis_data']=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_STCD=1419 AND DSM_CANC=0 UNION SELECT -1,'All' FROM dst_mst01 ORDER BY DSM_DSNM")->result(); 
            $page_data['main_menu']='setup';
            $page_data['menu_active']='vender_list';
            $page_data['title']='Implementing Agency Edit';
            $page_data['page_name']='vender_edit';
            $this->load->view('backend/index',$page_data);
         }else{
            $vem_contno=clean_input($this->input->post('vem_contno'));
            $vem_mailid=clean_input($this->input->post('vem_mailid'));
            $vem_username=clean_input($this->input->post('vem_username'));
            $is_uniq_mob=check_uniq_column_value('vender_mst','vem_contno',$vem_contno,'vem_id',$vem_id,'vem_cancel=1');
            $is_uniq_email=check_uniq_column_value('vender_mst','vem_mailid',$vem_mailid,'vem_id',$vem_id,'vem_cancel=1');
            $is_uniq_login=check_uniq_column_value('vender_mst','vem_username',$vem_username,'vem_id',$vem_id,'vem_cancel=1');
            if($is_uniq_mob ==1){
                $this->session->set_flashdata('error',"This Mobile No. already exists. try anathor one.");
                redirect('vender_edit/'.$vem_id,'refresh');
            }
            if($is_uniq_email ==1){
                $this->session->set_flashdata('error',"This Email already exists. try anathor one.");
                redirect('vender_edit/'.$vem_id,'refresh');
            }
            if($is_uniq_login ==1){
                $this->session->set_flashdata('error',"This Username already exists. try anathor one.");
                redirect('vender_edit/'.$vem_id,'refresh');
            }
            if($is_uniq_email == 0 && $is_uniq_mob == 0 && $is_uniq_login == 0){
                $update_data=[
                    'user_id'            =>clean_input($this->input->post('vem_userid')),
                    'user_name'          =>clean_input($this->input->post('vem_name')),
                    'user_mobile'        =>clean_input($this->input->post('vem_contno')),
                    'user_email'         =>clean_input($this->input->post('vem_mailid')),
                    'user_loginid'       =>clean_input($this->input->post('vem_username')),
                    'user_password'      =>md5(clean_input($this->input->post('vem_password'))),
                    'user_psw'           =>clean_input($this->input->post('vem_password')),
                    'user_district'      =>clean_input($this->input->post('vem_district')),
                    'user_addr1'         =>clean_input($this->input->post('vem_addr1')),
                    'user_addr2'         =>clean_input($this->input->post('vem_addr2')),
                    'user_pincode'       =>clean_input($this->input->post('vem_pincode')),
                    'user_role'          =>8,
                    'user_roledistrict'  =>6, //Kendujhar
                    'user_macid'         =>'',
                    
        
                    'login_id'          =>1,
                    'change_type'       =>'Modified',
                    'system_date'       =>system_date(),
                    'system_ip'         =>get_ip(),
                    'system_name'       =>$this->system_name,
                ];
                

                $update_data2=[
                    'vem_id'                 =>$vem_id,
                    'vem_userid'             =>clean_input($this->input->post('vem_userid')),
                    'vem_name'               =>string_ucword(clean_input($this->input->post('vem_name'))),
                    'vem_contno'             =>clean_input($this->input->post('vem_contno')),
                    'vem_mailid'             =>clean_input($this->input->post('vem_mailid')),
                    'vem_username'           =>clean_input($this->input->post('vem_username')),
                    'vem_password'           =>clean_input($this->input->post('vem_password')),
                    'vem_district'           =>clean_input($this->input->post('vem_district')),
                    'vem_addr1'              =>clean_input($this->input->post('vem_addr1')),
                    'vem_addr2'              =>clean_input($this->input->post('vem_addr2')),
                    'vem_pincode'            =>clean_input($this->input->post('vem_pincode')),
                    'vem_role'               =>8,
                    
                    'vem_loginid'           =>1,
                    'vem_changetype'        =>'Modified',
                    'vem_systemdate'        =>system_date(),
                    'vem_systemip'          =>get_ip(),
                    'vem_systemname'        =>$this->system_name,
                ];
                $response=data_update('vender_mst','vem_id',$update_data2);
                $response11=data_update('users_mst','user_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Implementing Agency Updated Successfully.");
                    redirect('vender_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('vender_edit/'.$vem_id,'refresh');
                }

            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('vender_edit/'.$vem_id,'refresh');
            }
           
             
        }

    }
    function vender_deleted(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $vem_id=clean_input($this->input->post('id'));
        $delete_data=[  
            'vem_id'            =>$vem_id,

            'vem_loginid'       =>1,
            'vem_cancel'        =>2,
            'vem_changetype'    =>'Deleted',
            'vem_systemdate'    =>system_date(),
            'vem_systemip'      =>get_ip(),
            'vem_systemname'    =>$this->system_name, 
        ];

        $response= data_update('vender_mst','vem_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function vender_active(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $vem_id=clean_input($this->input->post('id'));
        $delete_data=[  
            'vem_id'            =>$vem_id,

            'vem_loginid'       =>1,
            'vem_status'        =>1,
            'vem_changetype'    =>'Activated',
            'vem_systemdate'    =>system_date(),
            'vem_systemip'      =>get_ip(),
            'vem_systemname'    =>$this->system_name, 
        ];

        $response= data_update('vender_mst','vem_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function vender_inactive(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $vem_id=clean_input($this->input->post('id'));
        $delete_data=[  
            'vem_id'            =>$vem_id,

            'vem_loginid'       =>1,
            'vem_status'        =>2,
            'vem_changetype'    =>'Activated',
            'vem_systemdate'    =>system_date(),
            'vem_systemip'      =>get_ip(),
            'vem_systemname'    =>$this->system_name, 
        ];

        $response= data_update('vender_mst','vem_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }


    function vender_assign_list(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
          
        $config =[
            'base_url'=>base_url('vender_assign_list'),
            'per_page'=>'3',
            'total_rows'=>total_record('vender_sch','ves_cancel=1'),
            // coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
      
        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item ">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['attributes'] = array('class' => 'page-link');
        // $config['reuse_query_string'] = true;
        // $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $page_data['links']=$this->pagination->create_links();
 
       // $page_data['vender_data']=$this->master->get_vender_data()->result();
        
        $page_data['vender_assign_data']=$this->master->get_vender_assign_data('',$config['per_page'],$page)->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='vender_assign_list';
        $page_data['title']='Agency School Assignment List';
        $page_data['page_name']='vender_assign_list';
        $this->load->view('backend/index',$page_data);
    }
    function vender_assign_form(){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $page_data['school_data']=$this->master->get_scholl_assign_data()->result();
        $page_data['vender_data']=get_table_data('vender_mst','vem_id,vem_name',"vem_status=1 AND vem_cancel=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='vender_assign_list';
        $page_data['title']='Agency School Assignment Add';
        $page_data['page_name']='vender_assign_form';
        $this->load->view('backend/index',$page_data);

    }
    function vender_assign_add(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $this->form_validation->set_rules('ves_vemid','Implementing Agency Name','trim|required');
        $this->form_validation->set_rules('ves_schid[]','School Name','trim|required');
        //$this->form_validation->set_rules('vem_mailid','Vender Mail Id','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['school_data']=$this->master->get_scholl_assign_data()->result();
            $page_data['vender_data']=get_table_data('vender_mst','vem_id,vem_name',"vem_status=1 AND vem_cancel=1")->result();
            $page_data['complain_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_TPCD=6 AND COM_CANC=1")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='vender_assign_list';
            $page_data['title']='Agency School Assignment Add';
            $page_data['page_name']='vender_assign_form';
            $this->load->view('backend/index',$page_data);
        }else{
            
            $ves_id =get_pk_id('vender_sch','ves_id');
            $ves_schid    =$this->input->post('ves_schid');
            $insert_data=[
                'ves_id'               =>$ves_id,
                'ves_vemid'            =>clean_input($this->input->post('ves_vemid')),
                'ves_schid'             =>json_encode($ves_schid),
                
                'ves_loginid'          =>1,
                'ves_changetype'       =>'Created',
                'ves_systemdate'       =>system_date(),
                'ves_systemip'         =>get_ip(),
                'ves_systemname'       =>$this->system_name,
            ];
            
            $response =data_insert('vender_sch',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Implementing Agency School Assignment Linked Successfully.");
                redirect('vender_assign_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('vender_assign_form/','refresh');
            }
           
        }

    }
    function vender_assign_edit($ves_id){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $page_data['vender_assign_data']=$this->master->get_vender_assign_data($ves_id)->row();
        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_name,scm_udisecode',"scm_status=1 AND scm_cancel=1")->result();
        $page_data['vender_data']=get_table_data('vender_mst','vem_id,vem_name',"vem_status=1 AND vem_cancel=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='vender_assign_list';
        $page_data['title']='Agency School Assignment Edit';
        $page_data['page_name']='vender_assign_edit';
        $this->load->view('backend/index',$page_data);
    }
    function vender_assign_update($ves_id){
        // if(!$this->session->userdata('userlogin')){
        //      redirect('home');
        // }  
        $this->form_validation->set_rules('ves_vemid','Implementing Agency Name','trim|required');
        $this->form_validation->set_rules('ves_schid[]','School Name','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['vender_assign_data']=$this->master->get_vender_assign_data($ves_id)->row();
            $page_data['school_data']=$this->master->get_scholl_assign_data()->result();
            $page_data['vender_data']=get_table_data('vender_mst','vem_id,vem_name',"vem_status=1 AND vem_cancel=1")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='vender_assign_list';
            $page_data['title']='Agency School Assignment Edit';
            $page_data['page_name']='vender_assign_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            //$ves_id =get_pk_id('vender_sch','ves_id');
            $ves_schid    =$this->input->post('ves_schid');
            $update_data=[
                'ves_id'               =>$ves_id,
                'ves_vemid'            =>clean_input($this->input->post('ves_vemid')),
                'ves_schid'             =>json_encode($ves_schid),
                
                'ves_loginid'          =>1,
                'ves_changetype'       =>'Modified',
                'ves_systemdate'       =>system_date(),
                'ves_systemip'         =>get_ip(),
                'ves_systemname'       =>$this->system_name,
            ];
           
            $response=data_update('vender_sch','ves_id',$update_data);
            if($response){
                $this->session->set_flashdata('msg',"Agency School Assignment Linked updated Successfully.");
                redirect('vender_assign_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('vender_assign_edit/'.$ves_id,'refresh');
            }
        }
    }
    function vender_assign_deleted(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $ves_id=clean_input($this->input->post('id'));
        $delete_data=[  
        'ves_id'               =>$ves_id,

        'ves_loginid'          =>1,
        'ves_cancel'           =>2,
        'ves_changetype'       =>'Deleted',
        'ves_systemdate'       =>system_date(),
        'ves_systemip'         =>get_ip(),
        'ves_systemname'       =>$this->system_name, 
        ];

        $response= data_update('vender_sch','ves_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function holidays_list(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }   
        $page_data['holiday_data']=$this->master->get_holiday_data()->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='holidays_list';
        $page_data['title']='Holidays List';
        $page_data['page_name']='holidays_list';
        $this->load->view('backend/index',$page_data);
    }
    function holidays_form(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }   
        $page_data['main_menu']='setup';
        $page_data['menu_active']='holidays_list';
        $page_data['title']='Holidays Add';
        $page_data['page_name']='holidays_form';
        $this->load->view('backend/index',$page_data);
    }

    function holidays_add(){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $this->form_validation->set_rules('holiday_date','Date','trim|required|is_unique[holiday_mst.holiday_date]');
        $this->form_validation->set_rules('holiday_name','Holiday Name','trim|required');
        
         $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }   
            $page_data['main_menu']='setup';
            $page_data['menu_active']='holidays_list';
            $page_data['title']='Holidays Add';
            $page_data['page_name']='holidays_form';
            $this->load->view('backend/index',$page_data);

            }else{
                $holiday_id =get_pk_id('holiday_mst','holiday_id');
                $insert_data=[
                    'holiday_id'            =>$holiday_id,
                    'holiday_date'          =>system_date(clean_input($this->input->post('holiday_date'))),    
                    'holiday_name'          =>clean_input($this->input->post('holiday_name')),
                    
                    'holiday_loginid'       =>1,
                    'holiday_changetype'    =>'Created',
                    'holiday_systemdate'    =>system_date(),
                    'holiday_systemip'      =>get_ip(),
                    'holiday_systemname'    =>$this->system_name,
                ];
    
          
            $response=data_insert('holiday_mst',$insert_data);

            if($response){
                $this->session->set_flashdata('msg',"Holiday Created Successfully.");
                redirect('holidays_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('holidays_form','refresh');
            }
                 
        }

    }
    function holidays_edit($holiday_id){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }   
        $page_data['holiday_data']=$this->master->get_holiday_data($holiday_id)->row();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='holidays_list';
        $page_data['title']='Holidays Edit';
        $page_data['page_name']='holidays_edit';
        $this->load->view('backend/index',$page_data);
    }

    function holidays_update($holiday_id){
        // if(!$this->session->userdata('userlogin')){
        //     redirect('home');
        // }  
        $this->form_validation->set_rules('holiday_date','Date','trim|required');
        $this->form_validation->set_rules('holiday_name','Holiday Name','trim|required');
        
         $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }   
            $page_data['holiday_data']=$this->master->get_holiday_data($holiday_id)->row();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='holidays_list';
            $page_data['title']='Holidays Edit';
            $page_data['page_name']='holidays_edit';
            $this->load->view('backend/index',$page_data);

        }else{
            $holiday_date=system_date(clean_input($this->input->post('holiday_date')));
            $holiday_name=string_upper(clean_input($this->input->post('holiday_name')));
            $is_uniq_date=check_uniq_value('holiday_mst','holiday_date',$holiday_date, "holiday_id != $holiday_id AND holiday_cancel=1");
            $is_uniq_name=check_uniq_value('holiday_mst','holiday_name',$holiday_name, "holiday_id != $holiday_id AND holiday_cancel=1");
            if($is_uniq_date > 0 ||  $is_uniq_name > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('holidays_edit/'.$holiday_id,'refresh');
            }else{
                $insert_data=[
                    'holiday_id'            =>$holiday_id,
                    'holiday_date'          =>system_date(clean_input($this->input->post('holiday_date'))),    
                    'holiday_name'          =>clean_input($this->input->post('holiday_name')),
                    
                    'holiday_loginid'       =>1,
                    'holiday_changetype'    =>'Created',
                    'holiday_systemdate'    =>system_date(),
                    'holiday_systemip'      =>get_ip(),
                    'holiday_systemname'    =>$this->system_name,
                ];
           
                $response=data_update('holiday_mst','holiday_id',$insert_data);

                if($response){
                    $this->session->set_flashdata('msg',"Holiday Update Successfully.");
                    redirect('holidays_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('holidays_edit/'.$holiday_id,'refresh');
                }
                
            }
        }
    }
    function holidays_delete(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $holiday_id=clean_input($this->input->post('id'));
        $delete_data=[  
            'holiday_id'            =>$holiday_id,



            'holiday_loginid'       =>1,
            'holiday_cancel'        =>2,
            'holiday_changetype'    =>'Created',
            'holiday_systemdate'    =>system_date(),
            'holiday_systemip'      =>get_ip(),
            'holiday_systemname'    =>$this->system_name,

              
        ];

        $response= data_update('holiday_mst','holiday_id',$delete_data);
            if($response){
                echo json_encode(["status"=>200,]);
            }else{
                echo json_encode(["status"=>500,]);
            }
    }


	/** ====================================  Country Start =================================**/
	function country_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 

       $page_data['country_data']=$this->master->get_country()->result();
       
       $page_data['title']='Country List';
       $page_data['page_name']='master_setup/country_list';
       $this->load->view('backend/index',$page_data);
   }
  
   function country_edit($COM_COCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $page_data['country_data']=$this->master->get_country($COM_COCD)->row();
       $page_data['title']='Country Edit';
       $page_data['page_name']='master_setup/country_edit';
       $this->load->view('backend/index',$page_data);
   }
   function country_update($COM_COCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }           
       $this->form_validation->set_rules('COM_CONM','Country Name ','trim|required');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){

           $page_data['country_data']=$this->master->get_country($COM_COCD)->row();
           $page_data['title']='Country Edit';
           $page_data['page_name']='master_setup/country_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{
           $COM_CONM=string_ucword(clean_input($this->input->post('COM_CONM')));
           $is_uniq=check_uniq_value('cou_mst','COM_CONM',$COM_CONM,"COM_CANC=1 AND COM_COCD != $COM_COCD");  
           if($is_uniq > 0){
               $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
               redirect('country_edit/'.$COM_COCD,'refresh');
           }else{ 
               $update_data=[
                   'COM_COCD'                	=>$COM_COCD,  
                   'COM_CONM'                  =>string_ucword(clean_input($this->input->post('COM_CONM'))), 

                   'COM_CHUI'          		=>$this->login_id,
                   'COM_CHTP'       			=>'Modified',
                   'COM_CHTM'       			=>system_date(),
                   'COM_CHWI'         			=>get_ip(),
               ];
               $response=data_update('cou_mst','COM_COCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"Country Updated Successfully.");
                   redirect('country_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('country_edit/'.$COM_COCD,'refresh');
               }
           }
       }
   }
     /**State Name */
   function state_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 

       $country_id ='';
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
       }

       if(!empty($country_id) ){
           $total_rows=total_record('sta_mst',"STM_CANC=1 AND STM_COCD=$country_id");
       }else{
           $total_rows=total_record('sta_mst','STM_CANC=1');
       }
       $page_data['country_id']=$country_id;

       //pagination code here
       $config =[
           'base_url'=>base_url('state_list'),
           'per_page'=>'100',
           'total_rows'=>$total_rows,
           // coustum style
           'next_link'=>  'Next',
           'prev_link'=>  'Prev',
       ];

       /* This Application Must Be Used With BootStrap 3 *  */
       $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
       $config['full_tag_close'] = '</ul>';
       $config['num_tag_open'] = '<li class="page-item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
       $config['cur_tag_close'] = '</a></li>';
       $config['next_tag_open'] = '<li class="page-item">';
       $config['next_tagl_close'] = '</a></li>';
       $config['prev_tag_open'] = '<li class="page-item">';
       $config['prev_tagl_close'] = '</li>';
       $config['first_tag_open'] = '<li class="page-item ">';
       $config['first_tagl_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tagl_close'] = '</a></li>';
       $config['attributes'] = array('class' => 'page-link');
       $config['reuse_query_string'] = true;
       $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);   

       $this->pagination->initialize($config);
       $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
       $page_data['links']=$this->pagination->create_links(); 
    
       $page_data['state_data']=$this->master->get_state('',$config['per_page'],$page,$country_id)->result();
       
       $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();
        $page_data['title']='State List';
       $page_data['page_name']='master_setup/state_list';
       $this->load->view('backend/index',$page_data);
   }
   function state_edit($STM_STCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
       $page_data['state_data']=$this->master->get_state($STM_STCD)->row();
        $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();
        $page_data['title']='State Edit';
       $page_data['page_name']='master_setup/state_edit';
       $this->load->view('backend/index',$page_data);
   }
   function state_update($STM_STCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
        
       $this->form_validation->set_rules('STM_COCD','Country ','trim|required');
       $this->form_validation->set_rules('STM_STNM','State ','trim|required');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['state_data']=$this->master->get_state($STM_STCD)->row();
           $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();
           $page_data['title']='State Edit';
           $page_data['page_name']='master_setup/state_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{ 

           $STM_COCD=clean_input($this->input->post('STM_COCD'));
           $STM_STNM=string_ucword(clean_input($this->input->post('STM_STNM')));
           $is_uniq=check_uniq_value('sta_mst','STM_STNM',$STM_STNM,"STM_CANC=1 AND STM_COCD=$STM_COCD AND STM_STCD != $STM_STCD");  
           if($is_uniq > 0){
               $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
               redirect('state_edit/'.$STM_STCD,'refresh');
           }else{
               $update_data=[
                   'STM_STCD'                	=>$STM_STCD,  
                   'STM_COCD'                  =>clean_input($this->input->post('STM_COCD')), 
                   'STM_STNM'                  =>string_ucword(clean_input($this->input->post('STM_STNM'))),

                   'STM_CHUI'          		=>$this->login_id,
                   'STM_CHTP'       			=>'Modified',
                   'STM_CHTM'       			=>system_date(),
                   'STM_CHWI'         			=>get_ip(),
               ];
               $response=data_update('sta_mst','STM_STCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"State Updated Successfully.");
                   redirect('state_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('state_edit/'.$STM_STCD,'refresh');
               }
           }
           
       }
   }
   /**district Name */
   function district_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $country_id ='';
       $state_id ='';
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
           $state_id =$this->input->get('s');
       }

       if(!empty($country_id) && !empty($state_id)){
           $total_rows=total_record('dst_mst',"DSM_CANC=1 AND DSM_STCD=$state_id");
       }else{
           $total_rows=total_record('dst_mst','DSM_CANC=1');
       }
       $page_data['country_id']=$country_id;
       $page_data['state_id']=$state_id;

       $config =[
           'base_url'=>base_url('district_list'),
           'per_page'=>'100',
           'total_rows'=>$total_rows,
           // coustum style
           'next_link'=>  'Next',
           'prev_link'=>  'Prev',
       ];

       /* This Application Must Be Used With BootStrap 3 *  */
       $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
       $config['full_tag_close'] = '</ul>';
       $config['num_tag_open'] = '<li class="page-item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
       $config['cur_tag_close'] = '</a></li>';
       $config['next_tag_open'] = '<li class="page-item">';
       $config['next_tagl_close'] = '</a></li>';
       $config['prev_tag_open'] = '<li class="page-item">';
       $config['prev_tagl_close'] = '</li>';
       $config['first_tag_open'] = '<li class="page-item ">';
       $config['first_tagl_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tagl_close'] = '</a></li>';
       $config['attributes'] = array('class' => 'page-link');
         $config['reuse_query_string'] = true;
       $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        

       $this->pagination->initialize($config);
       $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
       $page_data['links']=$this->pagination->create_links(); 

       $page_data['district_data']=$this->master->get_district('',$config['per_page'],$page,$state_id)->result();
       $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();

        $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['title']='District List';
       $page_data['page_name']='master_setup/district_list';
       $this->load->view('backend/index',$page_data);
   }
   function district_form(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['title']='District Add';
       $page_data['page_name']='master_setup/district_form';
       $this->load->view('backend/index',$page_data);
   }
   function district_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
        
       $this->form_validation->set_rules('DSM_STCD','State name ','trim|required');
       $this->form_validation->set_rules('DSM_DSNM','District name ','trim|required|is_unique[dst_mst.DSM_DSNM]');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['title']='District Add';
           $page_data['page_name']='master_setup/district_form';
           $this->load->view('backend/index',$page_data);
       }else{        
           $DSM_DSCD=get_pk_id('dst_mst','DSM_DSCD');  
           $data_insert=[ 
               'DSM_DSCD'                	=>$DSM_DSCD, 
               'DSM_STCD'                  =>clean_input($this->input->post('DSM_STCD')),  
               'DSM_DSNM'                  =>string_ucword(clean_input($this->input->post('DSM_DSNM'))), 

               'DSM_CHUI'          		=>$this->login_id,
               'DSM_CHTP'       			=>'Created',
               'DSM_CHTM'       			=>system_date(),
               'DSM_CHWI'         			=>get_ip(),
               
           ];
            $response=data_insert ('dst_mst',$data_insert);  
           if($response){
               $this->session->set_flashdata('msg',"District Created Successfully.");
               redirect('district_form','refresh');
           }else{
               $this->session->set_flashdata('error',"Oops!. Error Occurred.");
               redirect('district_form','refresh');
           }
       }
   }

   function district_edit($DSM_DSCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 

       $page_data['district_data']=$this->master->get_district($DSM_DSCD)->row();
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['title']='District Edit';
       $page_data['page_name']='master_setup/district_edit';
       $this->load->view('backend/index',$page_data);
   }
   function district_update($DSM_DSCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
        
       $this->form_validation->set_rules('DSM_STCD','State name ','trim|required');
       $this->form_validation->set_rules('DSM_DSNM','District name ','trim|required');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['district_data']=$this->master->get_district($DSM_DSCD)->row();
           
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['title']='District Edit';
           $page_data['page_name']='master_setup/district_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $DSM_STCD=clean_input($this->input->post('DSM_STCD'));
           $DSM_DSNM=string_ucword(clean_input($this->input->post('DSM_DSNM')));
           $is_uniq=check_uniq_value('dst_mst','DSM_DSNM',$DSM_DSNM,"DSM_CANC=1 AND DSM_STCD=$DSM_STCD AND DSM_DSCD != $DSM_DSCD");  
           if($is_uniq > 0){
               $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
               redirect('district_edit/'.$DSM_DSCD,'refresh');
           }else{            
               $update_data=[
                   'DSM_DSCD'                	=>$DSM_DSCD, 
                   'DSM_STCD'                  =>clean_input($this->input->post('DSM_STCD')),  
                   'DSM_DSNM'                  =>string_ucword(clean_input($this->input->post('DSM_DSNM'))), 

                   'DSM_CHUI'          		=>$this->login_id,
                   'DSM_CHTP'       			=>'Modified',
                   'DSM_CHTM'       			=>system_date(),
                   'DSM_CHWI'         			=>get_ip(),
                   
               ];
           
               $response=data_update('dst_mst','DSM_DSCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"District Updated Successfully.");
                   redirect('district_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('district_edit/'.$DSM_DSCD,'refresh');
               }
           }
       }
   }
   
   /**Block Name */
   function block_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $country_id ='';
       $state_id ='';
       $dist_id='';
       $nrow=100;
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
           $state_id =$this->input->get('s');
           $dist_id=$this->input->get('d');
           $nrow=$this->input->get('nrow');
       }

       if(!empty($country_id) && !empty($state_id) && !empty($dist_id)){
           $total_rows=total_record('blk_mst',"BLM_CANC=1 AND BLM_DSCD=$dist_id");
       }else{
           $total_rows=total_record('blk_mst','BLM_CANC=1');
       }
       $page_data['country_id']=$country_id;
       $page_data['state_id']=$state_id;
       $page_data['dist_id']=$dist_id;
       $page_data['nrow']=$nrow;

       $config =[
           'base_url'=>base_url('block_list'),
           'per_page'=>'100',
           'total_rows'=>$total_rows,
           // coustum style
           'next_link'=>  'Next',
           'prev_link'=>  'Prev',
       ];

       /* This Application Must Be Used With BootStrap 3 *  */
       $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
       $config['full_tag_close'] = '</ul>';
       $config['num_tag_open'] = '<li class="page-item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
       $config['cur_tag_close'] = '</a></li>';
       $config['next_tag_open'] = '<li class="page-item">';
       $config['next_tagl_close'] = '</a></li>';
       $config['prev_tag_open'] = '<li class="page-item">';
       $config['prev_tagl_close'] = '</li>';
       $config['first_tag_open'] = '<li class="page-item ">';
       $config['first_tagl_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tagl_close'] = '</a></li>';
       $config['attributes'] = array('class' => 'page-link');
         $config['reuse_query_string'] = true;
       $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        

       $this->pagination->initialize($config);
       $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
       $page_data['links']=$this->pagination->create_links(); 

        //$page_data['gram_pachayata_data']=$this->master->get_gram_pachayata('',$config['per_page'],$page)->result();
       $page_data['block_data']=$this->master->get_block('',$config['per_page'],$page,$dist_id)->result();
       $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();

       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
          $page_data['title']='Block List';
       $page_data['page_name']='master_setup/block_list';
       $this->load->view('backend/index',$page_data);
   } 
   function block_form(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 

       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['title']='Block Add';
       $page_data['page_name']='master_setup/block_form';
       $this->load->view('backend/index',$page_data);
   }
   function block_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  

       $this->form_validation->set_rules('state_id','Select State','trim|required');
       $this->form_validation->set_rules('BLM_DSCD','Select District ','trim|required');
       $this->form_validation->set_rules('BLM_BLNM','Block name ','trim|required|is_unique[blk_mst.BLM_BLNM]');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['title']='Block Add';
           $page_data['page_name']='master_setup/block_form';
           $this->load->view('backend/index',$page_data);
        
       }else{
           $BLM_BLCD=get_pk_id('blk_mst','BLM_BLCD');
           $data_insert=[
               'BLM_BLCD'                	=>$BLM_BLCD,  
               'BLM_DSCD'                  =>clean_input($this->input->post('BLM_DSCD')), 
               'BLM_BLNM'                  =>string_ucword(clean_input($this->input->post('BLM_BLNM'))),
               'BLM_CANC'                  =>1,
               'BLM_CHUI'          		=>$this->login_id,
               'BLM_CHTP'       			=>'Created',
               'BLM_CHTM'       			=>system_date(),
               'BLM_CHWI'         			=>get_ip(),
               
           ];
           
           $response=data_insert('blk_mst',$data_insert);  
           if($response){
               $this->session->set_flashdata('msg',"Block Add Successfully.");
               redirect('block_form','refresh');
           }else{
               $this->session->set_flashdata('error',"Oops!. Error Occurred.");
               redirect('block_form','refresh');
           }
       }
   }
   function block_edit($BLM_BLCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $page_data['block_data']=$this->master->get_block($BLM_BLCD)->row();
       $page_data['district_data']=get_table_data('dst_mst','DSM_DSCD,DSM_SHNM,DSM_DSNM',"DSM_CANC=1 ORDER BY DSM_DSNM")->result();
       $page_data['title']='Block Edit';
       $page_data['page_name']='master_setup/block_edit';
       $this->load->view('backend/index',$page_data);
   }
   
   function block_update($BLM_BLCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
        
       $this->form_validation->set_rules('BLM_DSCD','District name ','trim|required');
       $this->form_validation->set_rules('BLM_BLNM','Block name ','trim|required');
       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['block_data']=$this->master->get_block($BLM_BLCD)->row();
           $page_data['district_data']=get_table_data('dst_mst','DSM_DSCD,DSM_SHNM,DSM_DSNM',"DSM_CANC=1 ORDER BY DSM_DSNM")->result();
           $page_data['title']='Block Edit';
           $page_data['page_name']='master_setup/block_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $BLM_DSCD=clean_input($this->input->post('BLM_DSCD'));
           $BLM_BLNM=string_ucword(clean_input($this->input->post('BLM_BLNM')));
           $is_uniq=check_uniq_value('blk_mst','BLM_BLNM',$BLM_BLNM,"BLM_CANC=1 AND BLM_DSCD=$BLM_DSCD AND BLM_BLCD != $BLM_BLCD");  
           if($is_uniq > 0){
               $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
               redirect('block_edit/'.$BLM_BLCD,'refresh');
           }else{
                $update_data=[
                   'BLM_BLCD'                	=>$BLM_BLCD,  
                   'BLM_DSCD'                  =>clean_input($this->input->post('BLM_DSCD')), 
                   'BLM_BLNM'                  =>string_ucword(clean_input($this->input->post('BLM_BLNM'))),

                   'BLM_CHUI'          		=>$this->login_id,
                   'BLM_CHTP'       			=>'Modified',
                   'BLM_CHTM'       			=>system_date(),
                   'BLM_CHWI'         			=>get_ip(),
                   
               ];
               $response=data_update('blk_mst','BLM_BLCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"Block Updated Successfully.");
                   redirect('block_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('block_edit/'.$BLM_BLCD,'refresh');
              }
           }
       }
   }
   
   function block_delete(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $BLM_BLCD=clean_input($this->input->post('id'));
       $delete_data=[
           'BLM_BLCD'                  =>$BLM_BLCD, 

           'BLM_CHTP'          		=>'Deleted',
           'BLM_CHUI'          		=>$this->login_id,
           'BLM_CANC'       			=>2,
           'BLM_CHTM'       			=>system_date(),
           'BLM_CHWI'         			=>get_ip(),
       ];
       $response= data_update('blk_mst', 'BLM_BLCD',$delete_data);
       if($response){
           echo json_encode(["status"=>200,]);
       }else{
           echo json_encode(["status"=>500,]);
       }
   }
   /**Block Name  End*/
   /**gram Pachayat start */ 
   function panchayat_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $country_id ='';
       $state_id ='';
       $dist_id='';
       $block_id='';
      
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
           $state_id =$this->input->get('s');
           $dist_id=$this->input->get('d');
           $block_id=$this->input->get('b');
       }

       if(!empty($country_id) && !empty($state_id) && !empty($dist_id) && !empty($block_id)){
           $total_rows=total_record('gp_mst',"GPM_CANC=1 AND GPM_BLCD=$block_id");
       }else{
           $total_rows=total_record('gp_mst','GPM_CANC=1');
       }
       $page_data['country_id']=$country_id;
       $page_data['state_id']=$state_id;
       $page_data['dist_id']=$dist_id;
       $page_data['block_id']=$block_id;

       $config =[
           'base_url'=>base_url('panchayat_list'),
           'per_page'=>'100',
           'total_rows'=>$total_rows,
           // coustum style
           'next_link'=>  'Next',
           'prev_link'=>  'Prev',
       ];
       /* This Application Must Be Used With BootStrap 3 *  */
       $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
       $config['full_tag_close'] = '</ul>';
       $config['num_tag_open'] = '<li class="page-item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
       $config['cur_tag_close'] = '</a></li>';
       $config['next_tag_open'] = '<li class="page-item">';
       $config['next_tagl_close'] = '</a></li>';
       $config['prev_tag_open'] = '<li class="page-item">';
       $config['prev_tagl_close'] = '</li>';
       $config['first_tag_open'] = '<li class="page-item ">';
       $config['first_tagl_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tagl_close'] = '</a></li>';
       $config['attributes'] = array('class' => 'page-link');
         $config['reuse_query_string'] = true;
       $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        

       $this->pagination->initialize($config);
       $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
       $page_data['links']=$this->pagination->create_links(); 

        $page_data['gram_pachayata_data']=$this->master->get_gram_pachayata('',$config['per_page'],$page,$block_id)->result();
        $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();

       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
         $page_data['title']='Panchayat List';
       $page_data['page_name']='master_setup/panchayat_list';
       $this->load->view('backend/index',$page_data);
   }
   function panchayat_form(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $country_id ='';
       $state_id ='';
       $dist_id='';
       $block_id='';
      
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
           $state_id =$this->input->get('s');
           $dist_id=$this->input->get('GPM_BLCD');
           $block_id=$this->input->get('b');
       }

       if(!empty($country_id) && !empty($state_id) && !empty($dist_id) && !empty($block_id)){
           $total_rows=total_record('gp_mst',"GPM_CANC=1 AND GPM_BLCD=$block_id");
       }else{
           $total_rows=total_record('gp_mst','GPM_CANC=1');
       }
       $page_data['country_id']=$country_id;
       $page_data['state_id']=$state_id;
       $page_data['dist_id']=$dist_id;
       $page_data['block_id']=$block_id;

       $page_data['gram_pachayata_data']=$this->master->get_gram_pachayata()->result();
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['block_data']=get_table_data('blk_mst','BLM_BLCD,BLM_DSCD,BLM_BLNM',"BLM_CANC=1 ORDER BY BLM_CODE")->result();
        
       $page_data['title']='Panchayat Edit';
       $page_data['page_name']='master_setup/panchayat_form';
       $this->load->view('backend/index',$page_data);


   }
   function panchayat_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
        
       $this->form_validation->set_rules('GPM_BLCD','Block name ','trim|required');
       $this->form_validation->set_rules('GPM_GPNM','Panchayat name ','trim|required|is_unique[gp_mst.GPM_GPCD]');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){

           $page_data['gram_pachayata_data']=$this->master->get_gram_pachayata()->row();
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['block_data']=get_table_data('blk_mst','BLM_BLCD,BLM_DSCD,BLM_BLNM',"BLM_CANC=1 ORDER BY BLM_CODE")->result();
        
           $page_data['title']='Panchayat Edit';
           $page_data['page_name']='master_setup/panchayat_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{
           $update_data=[
               'GPM_GPCD'                	=>$GPM_GPCD,  
               'GPM_BLCD'                  =>clean_input($this->input->post('GPM_BLCD')),  
               'GPM_GPNM'                  =>string_ucword(clean_input($this->input->post('GPM_GPNM'))),
               'GPM_CHUI'          		=>$this->login_id,
               'GPM_CHTP'       			=>'Modified',
               'GPM_CHTM'       			=>system_date(),
               'GPM_CHWI'         			=>get_ip(),
           ];
           $response=data_update('gp_mst',$update_data);  
           if($response){
               $this->session->set_flashdata('msg',"Panchayat Updated Successfully.");
               redirect('panchayat_list','refresh');
           }else{
               $this->session->set_flashdata('error',"Oops!. Error Occurred.");
               redirect('panchayat_edit/'.$GPM_GPCD,'refresh');
           }
       }
   }
   function panchayat_edit($GPM_GPCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 

       $page_data['gram_pachayata_data']=$this->master->get_gram_pachayata($GPM_GPCD)->row();
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['block_data']=get_table_data('blk_mst','BLM_BLCD,BLM_DSCD,BLM_BLNM',"BLM_CANC=1 ORDER BY BLM_CODE")->result();
        
       $page_data['title']='Panchayat Edit';
       $page_data['page_name']='master_setup/panchayat_edit';
       $this->load->view('backend/index',$page_data);
   }
   function panchayat_update($GPM_GPCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
        
       $this->form_validation->set_rules('GPM_BLCD','Block name ','trim|required');
       $this->form_validation->set_rules('GPM_GPNM','Panchayat name ','trim|required');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){

           $page_data['gram_pachayata_data']=$this->master->get_gram_pachayata()->row();
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['block_data']=get_table_data('blk_mst','BLM_BLCD,BLM_DSCD,BLM_BLNM',"BLM_CANC=1 ORDER BY BLM_CODE")->result();
        
           $page_data['title']='Panchayat Edit';
           $page_data['page_name']='master_setup/panchayat_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $GPM_BLCD=clean_input($this->input->post('GPM_BLCD'));
           $GPM_GPNM=string_ucword(clean_input($this->input->post('GPM_GPNM')));
           $is_uniq=check_uniq_value('gp_mst','GPM_GPNM',$GPM_GPNM,"GPM_CANC=1 AND GPM_BLCD=$GPM_BLCD AND GPM_GPCD != $GPM_GPCD");  
           if($is_uniq > 0){
               $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
               redirect('panchayat_edit/'.$GPM_GPCD,'refresh');
           }else{
               $update_data=[
                   'GPM_GPCD'                	=>$GPM_GPCD,  
                   'GPM_BLCD'                  =>clean_input($this->input->post('GPM_BLCD')),  
                   'GPM_GPNM'                  =>string_ucword(clean_input($this->input->post('GPM_GPNM'))),
                   'GPM_CHUI'          		=>$this->login_id,
                   'GPM_CHTP'       			=>'Modified',
                   'GPM_CHTM'       			=>system_date(),
                   'GPM_CHWI'         			=>get_ip(),
               ];
               $response=data_update('gp_mst','GPM_GPCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"Panchayat Updated Successfully.");
                   redirect('panchayat_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('panchayat_edit/'.$GPM_GPCD,'refresh');
               }
           }
       }
   }

   /**gram Pachayat End */

   /* Village */
   function village_list(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $country_id ='';
       $state_id ='';
       $dist_id='';
       $block_id='';
       //$gp_id='';
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
           $state_id =$this->input->get('s');
           $dist_id=$this->input->get('d');
           $block_id=$this->input->get('b');
           //$gp_id=$this->input->get('g');
       }

       if(!empty($country_id) && !empty($state_id) && !empty($dist_id) && !empty($block_id)){
           $total_rows=total_record('vlg_mst',"VLM_CANC=1 AND VLM_BLCD=$block_id");
       }else{
           $total_rows=total_record('vlg_mst','VLM_CANC=1');
       }
       $page_data['country_id']=$country_id;
       $page_data['state_id']=$state_id;
       $page_data['dist_id']=$dist_id;
       $page_data['block_id']=$block_id;
       //$page_data['gp_id']=$gp_id;

       $config =[
           'base_url'=>base_url('village_list'),
           'per_page'=>'250',
           'total_rows'=>$total_rows,
           //coustum style
           'next_link'=>  'Next',
           'prev_link'=>  'Prev',
       ];

       /* This Application Must Be Used With BootStrap 3 *  */
       $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
       $config['full_tag_close'] = '</ul>';
       $config['num_tag_open'] = '<li class="page-item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
       $config['cur_tag_close'] = '</a></li>';
       $config['next_tag_open'] = '<li class="page-item">';
       $config['next_tagl_close'] = '</a></li>';
       $config['prev_tag_open'] = '<li class="page-item">';
       $config['prev_tagl_close'] = '</li>';
       $config['first_tag_open'] = '<li class="page-item ">';
       $config['first_tagl_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tagl_close'] = '</a></li>';
       $config['attributes'] = array('class' => 'page-link');
         $config['reuse_query_string'] = true;
       $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        

       $this->pagination->initialize($config);
       $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
       $page_data['links']=$this->pagination->create_links(); 

       $page_data['village_data']=$this->master->get_village('',$config['per_page'],$page,$block_id)->result();
       
       $page_data['country_data'] =$this->common->get_country_data()->result();
       $page_data['title']='Village List';
       $page_data['page_name']='master_setup/village_list';
       $this->load->view('backend/index',$page_data);
   }
   function  village_form(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['title']='Village Add';
       $page_data['page_name']='master_setup/village_form';
       $this->load->view('backend/index',$page_data);
   }
   function village_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
       $this->form_validation->set_rules('state_id','Select State','trim|required');
        $this->form_validation->set_rules('district_id','Select District','trim|required');
       $this->form_validation->set_rules('VLM_BLCD','Select Block','trim|required');
       $this->form_validation->set_rules('VLM_VLNM','Village Name','trim|required|is_unique[vlg_mst.VLM_VLNM]');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['title']='Village Add';
           $page_data['page_name']='master_setup/village_form';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $VLM_VLCD=get_pk_id('vlg_mst','VLM_VLCD');
           $data_insert=[
               'VLM_VLCD'                	=>$VLM_VLCD,  
               'VLM_BLCD'                  =>clean_input($this->input->post('VLM_BLCD')), 
               'VLM_VLNM'                  =>string_ucword(clean_input($this->input->post('VLM_VLNM'))), 

               'VLM_CHUI'          		=>$this->login_id,
               'VLM_CHTP'       			=>'Created',
               'VLM_CHTM'       			=>system_date(),
               'VLM_CHWI'         			=>get_ip(),
               
           ];
         
           $response=data_insert('vlg_mst',$data_insert);  
           if($response){
               $this->session->set_flashdata('msg',"Village Created Successfully.");
               redirect('village_list','refresh');
           }else{
               $this->session->set_flashdata('error',"Oops!. Error Occurred.");
               redirect('village_edit','refresh');
           }
       }
   } 
   function village_edit($VLM_VLCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
       $page_data['village_data']=$this->master->get_village($VLM_VLCD)->row();
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
       $page_data['title']='Village Edit';
       $page_data['page_name']='master_setup/village_edit';
       $this->load->view('backend/index',$page_data);
   }
   function village_update($VLM_VLCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
        
       $this->form_validation->set_rules('VLM_BLCD','Block Name ','trim|required');
       $this->form_validation->set_rules('VLM_VLNM','Village Name ','trim|required');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){

           $page_data['village_data']=$this->master->get_village($VLM_VLCD)->row();
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
           $page_data['title']='Village Edit';
           $page_data['page_name']='master_setup/village_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $VLM_BLCD=clean_input($this->input->post('VLM_BLCD'));
           $VLM_VLNM=string_ucword(clean_input($this->input->post('VLM_VLNM')));
           $is_uniq=check_uniq_value('vlg_mst','VLM_VLNM',$VLM_VLNM,"VLM_CANC=1 AND VLM_BLCD=$VLM_BLCD AND VLM_VLCD != $VLM_VLCD");  
          if($is_uniq > 0){
              $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
              redirect('village_edit/'.$VLM_VLCD,'refresh');
          }else{
               $update_data=[
                   'VLM_VLCD'                	=>$VLM_VLCD,  
                   'VLM_BLCD'                  =>clean_input($this->input->post('VLM_BLCD')), 
                   'VLM_VLNM'                  =>string_ucword(clean_input($this->input->post('VLM_VLNM'))), 

                   'VLM_CHUI'          		=>$this->login_id,
                   'VLM_CHTP'       			=>'Modified',
                   'VLM_CHTM'       			=>system_date(),
                   'VLM_CHWI'         			=>get_ip(),
                   
               ]; 
               $response=data_update('vlg_mst','VLM_VLCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"Village Updated Successfully.");
                   redirect('village_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('village_edit/'.$VLM_VLCD,'refresh');
               }
           }
       }
   }
   function village_delete(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $VLM_VLCD=clean_input($this->input->post('id'));
       $delete_data=[
           'VLM_VLCD'                  =>$VLM_VLCD,

           'VLM_CANC'                  =>2,
           'VLM_CHUI'          		=>$this->login_id,
           'VLM_CHTP'       			=>'Deleted',
           'VLM_CHTM'       			=>system_date(),
           'VLM_CHWI'         			=>get_ip(),
       ];
       $response= data_update('vlg_mst', 'VLM_VLCD',$delete_data);
       if($response){
           echo json_encode(["status"=>200,]);
       }else{
           echo json_encode(["status"=>500,]);
       }
   }


   /***Locality  */
   function locality_list(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $country_id ='';
       $state_id ='';
       $dist_id='';
       $block_id='';
       $village_id='';
       if($this->input->method() == 'get'){
           $country_id =$this->input->get('c');
           $state_id =$this->input->get('s');
           $dist_id=$this->input->get('d');
           $block_id=$this->input->get('b');
           $village_id=$this->input->get('v');
       }

       if(!empty($country_id) && !empty($state_id) && !empty($dist_id) && !empty($block_id) && !empty($village_id)){
           $total_rows=total_record('locality_mst',"LOM_CANC=1 AND LOM_VLCD=$village_id");
       }else{
           $total_rows=total_record('locality_mst','LOM_CANC=1');
       }
       $page_data['country_id']=$country_id;
       $page_data['state_id']=$state_id;
       $page_data['dist_id']=$dist_id;
       $page_data['block_id']=$block_id;
       $page_data['village_id']=$village_id;

       $config =[
           'base_url'=>base_url('locality_list'),
           'per_page'=>'100',
           'total_rows'=>$total_rows,
           //coustum style
           'next_link'=>  'Next',
           'prev_link'=>  'Prev',
       ];

       /* This Application Must Be Used With BootStrap 3 *  */
       $config['full_tag_open'] = '<ul class="pagination pagination-sm m-0 float-right">';
       $config['full_tag_close'] = '</ul>';
       $config['num_tag_open'] = '<li class="page-item">';
       $config['num_tag_close'] = '</li>';
       $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
       $config['cur_tag_close'] = '</a></li>';
       $config['next_tag_open'] = '<li class="page-item">';
       $config['next_tagl_close'] = '</a></li>';
       $config['prev_tag_open'] = '<li class="page-item">';
       $config['prev_tagl_close'] = '</li>';
       $config['first_tag_open'] = '<li class="page-item ">';
       $config['first_tagl_close'] = '</li>';
       $config['last_tag_open'] = '<li class="page-item">';
       $config['last_tagl_close'] = '</a></li>';
       $config['attributes'] = array('class' => 'page-link');
         $config['reuse_query_string'] = true;
       $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);        

       $this->pagination->initialize($config);
       $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
       $page_data['links']=$this->pagination->create_links(); 

       
       $page_data['country_data']=get_table_data('cou_mst','COM_COCD,COM_CONM',"COM_CANC=1 ORDER BY COM_CONM")->result();

       $page_data['loclality_data'] =$this->master->get_locality_data('',$config['per_page'],$page,$village_id)->result();
       $page_data['title']='Locality  List';
       $page_data['page_name']='master_setup/locality_list';
       $this->load->view('backend/index',$page_data);
   }
   function locality_form(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();

       $page_data['title']='Locality Add';
       $page_data['page_name']='master_setup/locality_form';
       $this->load->view('backend/index',$page_data);
   }
   function locality_add(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $this->form_validation->set_rules('LOM_VLCD','village  Name','trim|required');
       $this->form_validation->set_rules('LOM_LONM','Locality Name','trim|required|is_unique[locality_mst.LOM_LONM]');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();

           $page_data['title']='Locality Add';
           $page_data['page_name']='master_setup/locality_form';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $LOM_LOCD=get_pk_id('locality_mst','LOM_LOCD');
           $data_insert=[
               'LOM_LOCD'                	=>$LOM_LOCD,  
               'LOM_VLCD'                  =>clean_input($this->input->post('LOM_VLCD')), 
               'LOM_LONM'                  =>string_ucword(clean_input($this->input->post('LOM_LONM'))), 

               'LOM_CHUI'          		=>$this->login_name,
               'LOM_CHTP'       			=>'Created',
               'LOM_CHTM'       			=>system_date(),
               'LOM_CHWI'         			=>get_ip(),
               
           ]; 
            
           $response=data_insert('locality_mst',$data_insert);  
           if($response){
               $this->session->set_flashdata('msg',"Locality Created Successfully.");
               redirect('locality_list','refresh');
           }else{
               $this->session->set_flashdata('error',"Oops!. Error Occurred.");
               redirect('locality_form','refresh');
           }
       }
       
      
   }
   function locality_edit($LOM_LOCD){      
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       }  
       $page_data['loclality_data']=$this->master->get_locality_data($LOM_LOCD)->row();

       $page_data['title']='Locality Edit';
       $page_data['page_name']='master_setup/locality_edit';
       $this->load->view('backend/index',$page_data);
   }
   function locality_update($LOM_LOCD){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $this->form_validation->set_rules('LOM_VLCD','village  Name','trim|required');
       $this->form_validation->set_rules('LOM_LONM','Locality Name','trim|required');
       
       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
       if($this->form_validation->run() == FALSE){
           $page_data['village_data']=get_table_data('vlg_mst','VLM_VLCD,VLM_VLNM',"VLM_CANC=1 ORDER BY VLM_VLNM")->result();
           $page_data['loclality_data']=$this->master->get_locality_data($LOM_LOCD)->row();
           $page_data['title']='Locality Edit';
           $page_data['page_name']='master_setup/locality_edit';
           $this->load->view('backend/index',$page_data);
      
       }else{ 
           $LOM_VLCD=clean_input($this->input->post('LOM_VLCD'));
           $LOM_LONM=string_ucword(clean_input($this->input->post('LOM_LONM')));
           $is_uniq=check_uniq_value('locality_mst','LOM_LONM',$LOM_LONM,"LOM_VLCD=$LOM_VLCD  AND LOM_CANC=1 AND LOM_LOCD !=$LOM_LOCD");              
           if($is_uniq > 0){
               $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
               redirect('locality_edit/'.$LOM_LOCD,'refresh');
           }else{
               $update_data=[
                   'LOM_LOCD'                	=>$LOM_LOCD,  
                   'LOM_VLCD'                  =>clean_input($this->input->post('LOM_VLCD')), 
                   'LOM_LONM'                  =>string_ucword(clean_input($this->input->post('LOM_LONM'))), 

                   'LOM_CHUI'          		=>$this->login_name,
                   'LOM_CHTP'       			=>'Updated',
                   'LOM_CHTM'       			=>system_date(),
                   'LOM_CHWI'         			=>get_ip(),
                   
               ]; 
               
               $response=data_update('locality_mst','LOM_LOCD',$update_data);  
               if($response){
                   $this->session->set_flashdata('msg',"Locality Update Successfully.");
                   redirect('locality_list','refresh');
               }else{
                   $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                   redirect('locality_edit/'.$LOM_LOCD,'refresh');
               }
           }
       }
   }

   function locality_delete(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
           redirect('login');
       } 
       $LOM_LOCD=clean_input($this->input->post('id'));
       $delete_data=[
           'LOM_LOCD'                  =>$LOM_LOCD, 

           'LOM_CANC'       			=>2,
           'LOM_CHTP'       			=>'Deleted',
           'LOM_CHUI'          		=>$this->login_name,            
           'LOM_CHTM'       			=>system_date(),
           'LOM_CHWI'         			=>get_ip(),
       ];
       $response= data_update('locality_mst', 'LOM_LOCD',$delete_data);
       if($response){
           echo json_encode(["status"=>200,]);
       }else{
           echo json_encode(["status"=>500,]);
       }
   }
   /** ====================================  Country Close =================================**/




   
 
function district_data_ajax(){
    $stu_state=$_POST['stu_state'];
    echo $stu_state;
     if(!empty($stu_state)){
        $district=get_table_data('dst_mst01','DSM_DSCD,DSM_DSNM',"DSM_CANC=0 AND DSM_STCD=$stu_state ORDER BY DSM_DSNM")->result();
        if($district){
            $html='<option value="">Select District</option>';
            foreach($district as $data){
                 $html.='<option value="'.$data->DSM_DSCD.'">'.$data->DSM_DSNM.'</option>';
            }
             echo $html;
            
        }else{
            echo "noi data found";
        }

     }
} 

function block_data_ajax(){
    $stu_block=$_POST['stu_block'];
    if(!empty($stu_block)){
        $block=get_table_data('blk_mst01','BLM_BLCD,BLM_BLNM',"BLM_CANC=0 AND BLM_DSCD= $stu_block")->result();
        
        if($block){
            $html='<option value="">Select Block</option>';
            foreach($block as $data){
                $html.='<option value="'.$data->BLM_BLCD.'">'.$data->BLM_BLNM.'</option>';
            }
            echo $html;
            
        }else{
            echo "data not found";
        }
    }
}
function panchayat_data_ajax(){
    $stu_panchaya=$_POST['stu_panchaya'];
    if(!empty($stu_panchaya)){
        $block=get_table_data('gp_mst01','GPM_GPCD,GPM_GPNM',"GPM_CANC=0 AND GPM_BLCD= $stu_panchaya")->result();
        
        if($block){
            $html='<option value="">Select Gram PAnchayat</option>';
            foreach($block as $data){
                $html.='<option value="'.$data->GPM_GPCD.'">'.$data->GPM_GPNM.'</option>';
            }
            echo $html;
            
        }else{
            echo "data not found";
        }
    }
}





}