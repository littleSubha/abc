<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!');

class MenuController extends CI_Controller{
    function __construct(){ 

        parent::__construct();
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('USM_USNM');
        $this->user_id=$this->session->userdata('USM_USID');
        $this->menu_id=$this->session->userdata('MNM_FRNM');
        $this->system_name=gethostname();
        $this->load->model('MenuModel','menu',true); 

    }  
    // Inner page with menu

    function menu_group_list(){
        $page_data['menu_data']=$this->menu->get_menuType_data()->result();
        $page_data['title'] ="Menu Group";
        $page_data['page_name'] ="menu/menu_group_list";
        $this->load->view('backend/index',$page_data);
    } 
    function menu_group_form(){
        $page_data['title'] ="Menu Group";
        $page_data['page_name'] ="menu/menu_group_form";
        $this->load->view('backend/index',$page_data);
    } 
    function menu_group_add(){ 
        $this->form_validation->set_rules('MNT_TPNM','Menu Name','trim|required|is_unique[MNU_TYP.MNT_TPNM]'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            
            $page_data['title'] ="Menu Group";
            $page_data['page_name'] ="menu/menu_group_form";
            $this->load->view('backend/index',$page_data);

        }else{
            $MNT_TPCD =get_pk_id('MNU_TYP','MNT_TPCD');
            $insert_data=[
                'MNT_TPCD'         =>$MNT_TPCD,
                'MNT_TPNM'         =>ucwords(clean_input($this->input->post('MNT_TPNM'))), 

                'MNT_USCD'       =>1,    //$this->login_id,
                'MNT_CHTP'       =>'Created',
                'MNT_CHTM'       =>system_date(),
                'MNT_CHUI'       =>get_ip(),
                'MNT_CHWI'       =>$this->system_name,
            ]; 
            $response=data_insert('MNU_TYP',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Menu Created Successfully.");
                redirect('menu_group_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('menu_group_form','refresh');
            }
          
        }
    }
    function menu_group_edit($MNT_TPCD){
        $page_data['menu_data']=$this->menu->get_menuType_data($MNT_TPCD)->row();
        $page_data['title'] ="Menu Group Edit";
        $page_data['page_name'] ="menu/menu_group_edit";
        $this->load->view('backend/index',$page_data);
    }
    function menu_group_update($MNT_TPCD){ 
        $this->form_validation->set_rules('MNT_TPNM','Menu Name','trim|required'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            
            $page_data['title'] ="Menu Group Edit";
            $page_data['page_name'] ="menu/menu_group_edit";
            $this->load->view('backend/index',$page_data);

        }else{ 
            //duplicate check 
            $MNT_TPNM=clean_input($this->input->post('MNT_TPNM'));
            $is_uniq=check_uniq_value('MNU_TYP','MNT_TPNM',$MNT_TPNM,"MNT_CANC=1 AND  MNT_TPCD != $MNT_TPCD");  
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('menu_group_edit/'.$MNT_TPCD,'refresh');
            }else{ 
                $update_data=[
                    'MNT_TPCD'       =>$MNT_TPCD,
                    'MNT_TPNM'       =>ucwords(clean_input($this->input->post('MNT_TPNM'))), 

                    'MNT_USCD'       =>$this->login_id,
                    'MNT_CHTP'       =>'Updated',
                    'MNT_CHTM'       =>system_date(),
                    'MNT_CHUI'       =>get_ip(),
                    'MNT_CHWI'       =>$this->system_name,
                ];  
                $result= data_update('MNU_TYP','MNT_TPCD', $update_data);
                if($result){
                    $this->session->set_flashdata('msg',"Menu Updated  Successfully.");
                    redirect('menu_group_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('menu_group_edit/'.$MNT_TPCD ,'refresh');
                }
            }
        }
    }
    function menu_group_delete(){ 
        $MNT_TPCD=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'MNT_TPCD'         =>$MNT_TPCD,
 
            'MNT_USCD'       =>1,    //$this->login_id,
            'MNT_CANC'       =>2,
            'MNT_CHTP'       =>'Deleted',
            'MNT_CHTM'       =>system_date(),
            'MNT_CHUI'       =>get_ip(),
            'MNT_CHWI'       =>$this->system_name,
          ];
        $response= data_update('MNU_TYP','MNT_TPCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    } 

    //sub menu page
    function sub_menu_list(){
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['title'] ="Sub Menu Group";
        $page_data['page_name'] ="menu/sub_menu_list";
        $this->load->view('backend/index',$page_data);
    } 
    function sub_menu_form(){ 
        $page_data['menu_data']=get_table_data('MNU_TYP','MNT_TPCD,MNT_TPNM',"MNT_CANC=1")->result();
        $page_data['title'] ="Sub Menu Group";
        $page_data['page_name'] ="menu/sub_menu_form";
        $this->load->view('backend/index',$page_data);
    } 
    function sub_menu_add(){ 
        $this->form_validation->set_rules('MNM_TPCD','Menu Name','trim|required');
        $this->form_validation->set_rules('MNM_MNNM','Menu Name','trim|required');
        $this->form_validation->set_rules('MNM_SEQU','Sub Menu Name','trim|required'); 
        
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            $page_data['menu_data']=get_table_data('MNU_TYP','MNT_TPCD,MNT_TPNM',"MNT_CANC=1")->result();
            $page_data['title'] ="Sub Menu Group";
            $page_data['page_name'] ="menu/sub_menu_form";
            $this->load->view('backend/index',$page_data);

        }else{
            $MNM_MNCD =get_pk_id('MNU_MST','MNM_MNCD');
            $MNM_FRNM="F".$MNM_MNCD;
            // $MNM_MNNM=clean_input($this->input->post('MNM_MNNM'));
            // $MNM_TPCD=clean_input($this->input->post('MNM_TPCD'));
            // $MNM_SEQU=clean_input($this->input->post('MNM_SEQU'));
            // $is_uniq=check_uniq_value('MNU_MST','MNM_MNNM',$MNM_MNNM,"MNM_CANC=1 AND MNM_TPCD != $MNM_TPCD");  
           
            // $is_uniq_seq=check_uniq_value('MNU_MST','MNM_SEQU',$MNM_SEQU,"MNM_CANC=1 AND MNM_TPCD=$MNM_TPCD");  
            // if($is_uniq > 0 ){
            //     $this->session->set_flashdata('error',"Oops!.Menu Name Duplicate Data Found.");
            //     redirect('sub_menu_form','refresh');
            // }
            // if($is_uniq_seq > 0 ){
            //     $this->session->set_flashdata('error',"Oops!.Menu Sequency Number Duplicate Data Found.");
            //     redirect('sub_menu_form','refresh');
            // }
           // if($is_uniq ==  0 && $is_uniq_seq == 0){ 
               
                $insert_data=[
                    'MNM_MNCD'         =>$MNM_MNCD,
                    'MNM_FRNM'         =>$MNM_FRNM,
                    'MNM_MNNM'         =>clean_input($this->input->post('MNM_MNNM')),
                    'MNM_SEQU'         =>clean_input($this->input->post('MNM_SEQU')), 
                    'MNM_TPCD'         =>clean_input($this->input->post('MNM_TPCD')), 

                    'MNM_USCD'       =>1,    //$this->login_id,
                    'MNM_CHTP'       =>'Created',
                    'MNM_CHTM'       =>system_date(),
                    'MNM_CHUI'       =>get_ip(),
                    'MNM_CHWI'       =>$this->system_name,
                ]; 
                 
                $response=data_insert('MNU_MST',$insert_data);
                if($response){
                    $this->session->set_flashdata('msg',"Sub Menu Created Successfully.");
                    $this->session->set_flashdata('MNM_TPCD',$MNM_TPCD);
                    redirect('sub_menu_form','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('sub_menu_form','refresh');
                }
           // }
          
        }
    
    }
    function sub_menu_edit($MNM_MNCD){
        $page_data['submenu_data']=$this->menu->get_submenu_data($MNM_MNCD)->row();
        $page_data['menu_data']=get_table_data('MNU_TYP','MNT_TPCD,MNT_TPNM',"MNT_CANC=1")->result();
        $page_data['title'] ="Sub Menu Edit";
        $page_data['page_name'] ="menu/sub_menu_edit";
        $this->load->view('backend/index',$page_data);
    } 
    function sub_menu_update($MNM_MNCD){
        $this->form_validation->set_rules('MNM_TPCD','Menu Name','trim|required');
        $this->form_validation->set_rules('MNM_MNNM','Menu Name','trim|required');
        $this->form_validation->set_rules('MNM_SEQU','Sub Menu Name','trim|required'); 
        if($this->form_validation->run() == FALSE){
            
            $page_data['submenu_data']=$this->menu->get_submenu_data($MNM_MNCD)->row();
            $page_data['menu_data']=get_table_data('MNU_TYP','MNT_TPCD,MNT_TPNM',"MNT_CANC=1")->result();
            $page_data['title'] ="Sub Menu Edit";
            $page_data['page_name'] ="menu/sub_menu_edit";
            $this->load->view('backend/index',$page_data);

        }else{  
            $MNM_MNNM=clean_input($this->input->post('MNM_MNNM'));
            $MNM_TPCD=clean_input($this->input->post('MNM_TPCD'));
            $is_uniq=check_uniq_value('MNU_MST','MNM_MNNM',$MNM_MNNM,"MNM_CANC=1 AND MNM_TPCD=$MNM_TPCD AND MNM_MNCD != $MNM_MNCD");  
            $MNM_SEQU=clean_input($this->input->post('MNM_SEQU'));
            $MNM_TPCD=clean_input($this->input->post('MNM_TPCD'));
            $is_uniq_seq=check_uniq_value('MNU_MST','MNM_SEQU',$MNM_SEQU,"MNM_CANC=1 AND MNM_TPCD=$MNM_TPCD AND MNM_MNCD != $MNM_MNCD");  
            if($is_uniq > 0 ){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('sub_menu_edit/'.$MNM_MNCD,'refresh');
            }
            if($is_uniq_seq > 0 ){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('sub_menu_edit/'.$MNM_MNCD,'refresh');
            }
            if($is_uniq ==  0 && $is_uniq_seq == 0){ 
                $MNM_FRNM="F".$MNM_MNCD;
                $update_data=[
                    'MNM_MNCD'         =>$MNM_MNCD,
                    'MNM_FRNM'         =>$MNM_FRNM,
                    'MNM_MNNM'         =>ucwords(clean_input($this->input->post('MNM_MNNM'))),
                    'MNM_SEQU'         =>clean_input($this->input->post('MNM_SEQU')), 
                    'MNM_TPCD'         =>clean_input($this->input->post('MNM_TPCD')), 

                    'MNM_USCD'       =>1,    //$this->login_id,
                    'MNM_CHTP'       =>'Updated',
                    'MNM_CHTM'       =>system_date(),
                    'MNM_CHUI'       =>get_ip(),
                    'MNM_CHWI'       =>$this->system_name,
                ];   
                $result= data_update('MNU_MST','MNM_MNCD', $update_data);
                if($result){
                    $this->session->set_flashdata('msg',"Sub Menu Updated  Successfully.");
                    redirect('sub_menu_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('sub_menu_edit/'.$MNM_MNCD ,'refresh');
                }
            }
        }
    }
    function sub_menu_delete(){
        $MNM_MNCD=clean_input($this->input->post('id')); 
        $delete_data=[  
            'MNM_MNCD'         =>$MNM_MNCD,
           
            'MNM_USCD'       =>1,    //$this->login_id,
            'MNM_CANC'       =>2,
            'MNM_CHTP'       =>'Deleted',
            'MNM_CHTM'       =>system_date(),
            'MNM_CHUI'       =>get_ip(),
            'MNM_CHWI'       =>$this->system_name,
          ];
        $response= data_update('MNU_MST','MNM_MNCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function user_category_list(){
        $page_data['userCategory_data']=$this->menu->get_user_category_data()->result();
        $page_data['title'] ="User Category List";
        $page_data['page_name'] ="menu/user_category_list";
        $this->load->view('backend/index',$page_data);
    }
    function user_category_form(){
        $page_data['title'] ="User Category Form";
        $page_data['page_name'] ="menu/user_category_form";
        $this->load->view('backend/index',$page_data);
    }
    function user_category_add(){
        $this->form_validation->set_rules('USC_CTNM','User Category Name','trim|required|is_unique[USR_CAT.USC_CTNM]'); 
        $this->form_validation->set_rules('USC_LVCD','User Category Level','trim|required'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){ 
            $page_data['title'] ="User Category Form";
            $page_data['page_name'] ="menu/user_category_form";
            $this->load->view('backend/index',$page_data);

        }else{
            $USC_CTCD =get_pk_id('USR_CAT','USC_CTCD');
            $insert_data=[
                'USC_CTCD'       =>$USC_CTCD,
                'USC_CTNM'       =>ucwords(clean_input($this->input->post('USC_CTNM'))), 
                'USC_LVCD'       =>ucwords(clean_input($this->input->post('USC_LVCD'))),

                'USC_USCD'       =>1,    //$this->login_id,
                'USC_CHTP'       =>'Created',
                'USC_CHTM'       =>system_date(),
                'USC_CHUI'       =>get_ip(),
                'USC_CHWI'       =>$this->system_name,
            ];
            
            $response=data_insert('USR_CAT',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"User Category Created Successfully.");
                redirect('user_category_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('user_category_form','refresh');
            }
          
        }
    }
    function user_category_edit($USC_CTCD){
        $page_data['userCategory_data']=$this->menu->get_user_category_data($USC_CTCD)->row();
        $page_data['title'] ="User Category List";
        $page_data['page_name'] ="menu/user_category_edit";
        $this->load->view('backend/index',$page_data);
    }
    function user_category_update($USC_CTCD){
        $this->form_validation->set_rules('USC_CTNM','User Category Name','trim|required'); 
        $this->form_validation->set_rules('USC_LVCD','User Category Level','trim|required'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){ 
            $page_data['userCategory_data']=$this->menu->get_user_category_data($USC_CTCD)->row();
            $page_data['title'] ="User Category List";
            $page_data['page_name'] ="menu/user_category_edit";
            $this->load->view('backend/index',$page_data);
        }else{ 
            //duplicate check 
            $USC_CTNM=clean_input($this->input->post('USC_CTNM'));
            $is_uniq=check_uniq_value('USR_CAT','USC_CTNM',$USC_CTNM,"USC_CANC=1 AND  USC_CTCD != $USC_CTCD");  
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('user_category_edit/'.$USC_CTCD,'refresh');
            }else{ 
                $insert_data=[
                    'USC_CTCD'       =>$USC_CTCD,
                    'USC_CTNM'       =>ucwords(clean_input($this->input->post('USC_CTNM'))), 
                    'USC_LVCD'       =>ucwords(clean_input($this->input->post('USC_LVCD'))),

                    'USC_USCD'       =>1,    //$this->login_id,
                    'USC_CHTP'       =>'Updated',
                    'USC_CHTM'       =>system_date(),
                    'USC_CHUI'       =>get_ip(),
                    'USC_CHWI'       =>$this->system_name,
                ]; 
               
                $response= data_update('USR_CAT','USC_CTCD', $insert_data);
                if($response){
                    $this->session->set_flashdata('msg',"User Category Updated  Successfully.");
                    redirect('user_category_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('user_category_edit/'.$USC_CTCD ,'refresh');
                }
             }
        }
    }
    function user_category_delete(){
        $USC_CTCD=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'USC_CTCD'       =>$USC_CTCD,
           
            'USC_USCD'       =>1,    //$this->login_id,
            'USC_CANC'       =>2,
            'USC_CHTP'       =>'Deleted',
            'USC_CHTM'       =>system_date(),
            'USC_CHUI'       =>get_ip(),
            'USC_CHWI'       =>$this->system_name,
          ];
        $response= data_update('USR_CAT','USC_CTCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function user_role_list(){
        // $USR_CTCD ='';
        // if($this->input->method() == 'get'){
        //     $USR_CTCD =$this->input->get('f');
        // }   


        //filter
        $USR_CTCD ='';
        if($this->input->method() == 'get'){
            $USR_CTCD =$this->input->get('f');
           
        }
        if(!empty($USR_CTCD)){
            $total_rows=total_record('USR_ROL','USR_CANC=1 AND USR_CTCD='.$USR_CTCD);
        }else{
            $total_rows=total_record('USR_ROL','USR_CANC=1');
        }
        $page_data['USR_CTCD']=$USR_CTCD;

        //pagination code here
        $config =[
            'base_url'=>base_url('common_list'),
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


 
        $page_data['userRole_data']=$this->menu->get_user_role_data('',$config['per_page'],$page,$USR_CTCD)->result();

        $page_data['user_category']=get_table_data('USR_CAT','USC_CTCD,USC_CTNM',"USC_CANC=1 ORDER BY USC_CTNM")->result(); 

        $page_data['title'] ="User Role List";
        $page_data['page_name'] ="menu/user_role_list";
        $this->load->view('backend/index',$page_data);
    }
    function user_role_form(){
        $page_data['title'] ="User Role Form";
        $page_data['page_name'] ="menu/user_role_form";
        $this->load->view('backend/index',$page_data);
    }
    function user_role_add(){
       
        $this->form_validation->set_rules('USR_CTCD','User Category','trim|required'); 
        $this->form_validation->set_rules('USR_MNCD','User menu','trim|required'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){ 
            $page_data['title'] ="User Category Form";
            $page_data['page_name'] ="menu/user_role_form";
            $this->load->view('backend/index',$page_data); 
        }else{
            $USR_URCD =get_pk_id('USR_ROL','USR_URCD');
            $insert_data=[
                'USR_URCD'       =>$USR_URCD,
                'USR_CTCD'       =>clean_input($this->input->post('USR_CTCD')), 
                'USR_MNCD'       =>clean_input($this->input->post('USR_MNCD')), 
 
                'USR_USCD'       =>1,    //$this->login_id,
                'USR_CHTP'       =>'Created',
                'USR_CHTM'       =>system_date(),
                'USR_CHUI'       =>get_ip(),
                'USR_CHWI'       =>$this->system_name,
            ];
           
            $response=data_insert('USR_ROL',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"User Role  Created Successfully.");
                $this->session->set_flashdata('USR_CTCD',$this->input->post('USR_CTCD'));
                redirect('user_role_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('user_role_form','refresh');
            }
          
        }
    }
    function user_role_edit($USR_URCD){
        $page_data['userRole_data']=$this->menu->get_user_role_data($USR_URCD)->row();
        $page_data['title'] ="User Role Edit";
        $page_data['page_name'] ="menu/user_role_edit";
        $this->load->view('backend/index',$page_data);
    } 
    function user_role_update($USR_URCD){
        $this->form_validation->set_rules('USR_CTCD','User Category','trim|required'); 
        $this->form_validation->set_rules('USR_MNCD','User menu','trim|required'); 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){ 
            $page_data['title'] ="User Category Edit";
            $page_data['page_name'] ="menu/user_role_edit";
            $this->load->view('backend/index',$page_data); 
        }else{ 

            $insert_data=[
                'USR_URCD'       =>$USR_URCD,
                'USR_CTCD'       =>ucwords(clean_input($this->input->post('USR_CTCD'))), 
                'USR_MNCD'       =>ucwords(clean_input($this->input->post('USR_MNCD'))), 

                'USR_USCD'       =>1,    //$this->login_id,
                'USR_CHTP'       =>'Created',
                'USR_CHTM'       =>system_date(),
                'USR_CHUI'       =>get_ip(),
                'USR_CHWI'       =>$this->system_name,
            ];
           print_r($insert_data);
            $response=data_update('USR_ROL','USR_URCD',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"User Role  Updated Successfully.");
                redirect('user_role_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('user_role_edit/'.$USR_URCD,'refresh');
            }
          
        }
    }
    function user_role_delete(){
        $USR_URCD=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'USR_URCD'       =>$USR_URCD,
             
            'USR_USCD'       =>1,    //$this->login_id,
            'USR_CANC'       =>2,
            'USR_CHTP'       =>'Created',
            'USR_CHTM'       =>system_date(),
            'USR_CHUI'       =>get_ip(),
            'USR_CHWI'       =>$this->system_name,
          ];
        $response= data_update('USR_ROL','USR_URCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function demo_dashboard(){
        $page_data['menu_type']=$this->menu->get_menuType_data()->result();
        $page_data['submenu_data']=$this->menu->get_submenu_data()->result();
        $page_data['user_data']=$this->menu->get_user_data($this->login_id)->result();
        $page_data['user_assign_menu']=$this->menu->get_user_assign_data($this->login_id)->result();
 
        $page_data['title'] ="User Role List";
        $page_data['page_name'] ="demo_dashboard";
        $this->load->view('backend/index',$page_data);
        
    }

}