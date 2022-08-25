<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!');

class UserController extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->system_name=gethostname();
        $this->load->model('UsersModel','user',true);

    }
     
    function user_list(){
        $USC_CTCD ='';
        if($this->input->method() == 'get'){
            $USC_CTCD =$this->input->get('f');
           
        }
         
        $user_category=get_table_data('USR_CAT','USC_CTCD,USC_CTNM',"USC_CANC=1")->result(); 
        $page_data['userCategory_data']=$this->user->get_user_data()->result();
        $page_data['user_data']=$this->user->get_user_data()->result();

        $page_data['title'] ="User List";
        $page_data['page_name'] ="user/user_list";
        $this->load->view('backend/index',$page_data);
    }
    function user_form(){
      //  $page_data['userRole_data']=$this->user->get_user_role_data()->result();
      $page_data['userRole_data']=get_table_data('usr_cat','USC_CTCD,USC_CTNM',"USC_CANC=1 ORDER BY USC_CTNM")->result(); 
        $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result();
        $page_data['title'] ="User Form";
        $page_data['page_name'] ="user/user_form";
        $this->load->view('backend/index',$page_data);
    }
    function user_add(){
        $this->form_validation->set_rules('USM_USNM','User  Name','trim|required'); 
        $this->form_validation->set_rules('USM_MBNO','User Mobile Number','trim|required|is_unique[usr_mst.USM_MBNO]'); 
        $this->form_validation->set_rules('USM_MAIL','User Mail Id','trim|required|is_unique[usr_mst.USM_MAIL]'); 
        $this->form_validation->set_rules('USM_LGID','User Login Id','trim|required|is_unique[usr_mst.USM_LGID]'); 
        $this->form_validation->set_rules('USM_PASS','User Password','trim|required|is_unique[usr_mst.USM_PASS]'); 
        $this->form_validation->set_rules('USM_CNPS','User Confirm  Password','trim|required'); 
        $this->form_validation->set_rules('USM_CTCD','User Role Id','trim|required'); 
        $this->form_validation->set_rules('USM_DSCD','District Id','trim|required'); 
        $this->form_validation->set_rules('USM_BLCD','Block Id','trim|required'); 
        $this->form_validation->set_rules('USM_SCCD','School Id','trim|required');  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){ 
            //$page_data['userRole_data']=$this->user->get_user_role_data()->result(); 
            $page_data['userRole_data']=get_table_data('usr_cat','USC_CTCD,USC_CTNM',"USC_CANC=1 ORDER BY USC_CTNM")->result();
            $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
            $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result();
            $page_data['title'] ="User Form";
            $page_data['page_name'] ="user/user_form";
            $this->load->view('backend/index',$page_data); 

        }else{
            $USM_USID =get_pk_id('usr_mst','USM_USID');
            $insert_data=[
                'USM_USID'       =>$USM_USID,
                'USM_USNM'       =>ucwords(clean_input($this->input->post('USM_USNM'))), 
                'USM_MBNO'       =>ucwords(clean_input($this->input->post('USM_MBNO'))),
                'USM_MAIL'       =>ucwords(clean_input($this->input->post('USM_MAIL'))),
                'USM_LGID'       =>ucwords(clean_input($this->input->post('USM_LGID'))),
                'USM_PASS'       =>md5(ucwords(clean_input($this->input->post('USM_PASS')))),
                'USM_CNPS'       =>ucwords(clean_input($this->input->post('USM_CNPS'))),
                'USM_CTCD'       =>ucwords(clean_input($this->input->post('USM_CTCD'))),
                'USM_DSCD'       =>ucwords(clean_input($this->input->post('USM_DSCD'))),
                'USM_BLCD'       =>ucwords(clean_input($this->input->post('USM_BLCD'))),
                'USM_SCCD'       =>ucwords(clean_input($this->input->post('USM_SCCD'))),
                'USM_USCD'       =>ucwords(clean_input($this->input->post('USM_USCD'))),
               

                'USM_USCD'       =>1,    //$this->login_id,
                'USM_CHTP'       =>'Created',
                'USM_CHTM'       =>system_date(),
                'USM_CHUI'       =>get_ip(),
                'USM_CHWI'       =>$this->system_name,
            ]; 
            $response=data_insert('usr_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"User  Created Successfully.");
                redirect('user_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('user_form','refresh');
            }
          
        }
    }

    function user_edit($USM_USID){
        $page_data['user_data']=$this->user->get_user_data($USM_USID)->row();

        //$page_data['userRole_data']=$this->user->get_user_role_data()->result();  
        $page_data['userRole_data']=get_table_data('usr_cat','USC_CTCD,USC_CTNM',"USC_CANC=1 ORDER BY USC_CTNM")->result();
        $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result();
        $page_data['title'] ="User Edit";
        $page_data['page_name'] ="user/user_edit";
        $this->load->view('backend/index',$page_data);
    } 
    function user_update($USM_USID){
        $this->form_validation->set_rules('USM_USNM','User  Name','trim|required'); 
        $this->form_validation->set_rules('USM_MBNO','User Mobile Number','trim|required'); 
        $this->form_validation->set_rules('USM_MAIL','User Mail Id','trim|required'); 
        $this->form_validation->set_rules('USM_LGID','User Login Id','trim|required'); 
        $this->form_validation->set_rules('USM_PASS','User Password','trim|required'); 
        $this->form_validation->set_rules('USM_CNPS','User Category Name','trim|required'); 
        $this->form_validation->set_rules('USM_CTCD','User Role Id','trim|required'); 
        $this->form_validation->set_rules('USM_DSCD','District Id','trim|required'); 
        $this->form_validation->set_rules('USM_BLCD','Block Id','trim|required'); 
        $this->form_validation->set_rules('USM_SCCD','School Id','trim|required');  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){  
            $page_data['user_data']=$this->user->get_user_data($USM_USID)->row();
            $page_data['userRole_data']=get_table_data('usr_cat','USC_CTCD,USC_CTNM',"USC_CANC=1 ORDER BY USC_CTNM")->result();
            $page_data['state_data']=get_table_data('sta_mst','STM_STCD,STM_SHNM,STM_STNM',"STM_CANC=1 ORDER BY STM_STNM")->result();
            $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result();
            $page_data['title'] ="User Edit";
            $page_data['page_name'] ="user/user_edit";
            $this->load->view('backend/index',$page_data);  
        }else{ 
            $user_mobile=clean_input($this->input->post('USM_MBNO'));
            $user_email=clean_input($this->input->post('USM_MAIL'));
            $user_lgid=clean_input($this->input->post('USM_LGID'));
            $is_uniq_mobile=check_uniq_value('usr_mst','USM_MBNO',$user_mobile,"USM_CANC=1 AND  USM_USID != $USM_USID"); 
            $is_uniq_email=check_uniq_value('usr_mst','USM_MAIL',$user_email,"USM_CANC=1 AND  USM_USID != $USM_USID"); 
            $is_uniq_lgid=check_uniq_value('usr_mst','USM_LGID',$user_lgid,"USM_CANC=1 AND  USM_USID != $USM_USID"); 
            if($is_uniq_mobile >0 ){
                $this->session->set_flashdata('error'," OPPS! Duplicate Mobile number  found.");
                redirect('user_edit/'.$USM_USID,'refresh');
            }
            if($is_uniq_email >0 ){
                $this->session->set_flashdata('error'," OPPS! Duplicate Email Id found.");
                redirect('user_edit/'.$USM_USID,'refresh');
            }
            if($is_uniq_lgid >0 ){
                $this->session->set_flashdata('error'," OPPS! Duplicate LoginId found.");
                redirect('user_edit/'.$USM_USID,'refresh');
            }
            if($is_uniq_mobile == 0 && $is_uniq_email == 0  && $is_uniq_lgid == 0){
                $update_data=[
                    'USM_USID'       =>$USM_USID,
                    'USM_USNM'       =>ucwords(clean_input($this->input->post('USM_USNM'))), 
                    'USM_MBNO'       =>ucwords(clean_input($this->input->post('USM_MBNO'))),
                    'USM_MAIL'       =>ucwords(clean_input($this->input->post('USM_MAIL'))),
                    'USM_LGID'       =>ucwords(clean_input($this->input->post('USM_LGID'))),
                    'USM_PASS'       =>md5((clean_input($this->input->post('USM_PASS')))),
                    'USM_CNPS'       =>ucwords(clean_input($this->input->post('USM_CNPS'))),
                    'USM_CTCD'       =>ucwords(clean_input($this->input->post('USM_CTCD'))),
                    'USM_DSCD'       =>ucwords(clean_input($this->input->post('USM_DSCD'))),
                    'USM_BLCD'       =>ucwords(clean_input($this->input->post('USM_BLCD'))),
                    'USM_SCCD'       =>ucwords(clean_input($this->input->post('USM_SCCD'))),
                    'USM_USCD'       =>ucwords(clean_input($this->input->post('USM_USCD'))),
                

                    'USM_USCD'       =>1,    //$this->login_id,
                    'USM_CHTP'       =>'Updated',
                    'USM_CHTM'       =>system_date(),
                    'USM_CHUI'       =>get_ip(),
                    'USM_CHWI'       =>$this->system_name,
                ]; 
            
                $result= data_update('usr_mst','USM_USID', $update_data);
                if($result){
                    $this->session->set_flashdata('msg'," User Updated  Successfully.");
                    redirect('user_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('user_edit/'.$USM_USID ,'refresh');
                }
            }
          
        }
    }
    function user_delete(){
        $USM_USID=clean_input($this->input->post('id')); 
        $delete_data=[  
            'USM_USID'       =>$USM_USID,
           
            'USM_USCD'       =>1,    //$this->login_id,
            'USM_CANC'       =>2,
            'USM_CHTP'       =>'Updated',
            'USM_CHTM'       =>system_date(),
            'USM_CHUI'       =>get_ip(),
            'USM_CHWI'       =>$this->system_name,
          ];
        $response= data_update('usr_mst','USM_USID',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function teacher_list(){ 
        $page_data['teacher']=$this->user->get_teacher_data()->result();
        $page_data['title'] ="Teachers  List";
        $page_data['page_name'] ="user/teacher_list";
        $this->load->view('backend/index',$page_data);
    }
    function teacher_form(){ 
        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result(); 
        $page_data['common_class']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=1 AND COM_TPCD=1  ORDER BY COM_CMNM")->result(); 
        $page_data['common_designation']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COM_TPCD=6 AND COT_TPCD=6  ORDER BY COM_CMNM")->result(); 

        $page_data['common_subject']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=2 AND  COM_TPCD=2 ORDER BY COM_CMNM")->result(); 
        $page_data['title'] ="Teacher Profile";
        $page_data['page_name'] ="user/teacher_form";
        $this->load->view('backend/index',$page_data);
    }
    function teacher_add(){ 
        $this->form_validation->set_rules('tem_name','Teacher Name','trim|required'); 
        $this->form_validation->set_rules('tem_fathername','Teacher Fater Name','trim|required'); 
        $this->form_validation->set_rules('tem_dob','Teacher Dob','trim|required'); 
        $this->form_validation->set_rules('tem_email','Teacher Email Id','trim|required'); 
        $this->form_validation->set_rules('tem_mob','Teacher Mobail Number','trim|required'); 
        $this->form_validation->set_rules('tem_designation_id','Teacher  Designation','trim|required'); 
        $this->form_validation->set_rules('tem_scm_id','School Name','trim|required');  
        $this->form_validation->set_rules('tem_address','Teacher Address','trim|required'); 


        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){  
            $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result(); 
            $page_data['common_class']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=1 AND COM_TPCD=1  ORDER BY COM_CMNM")->result(); 
            $page_data['common_designation']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=6 AND COM_TPCD=6  ORDER BY COM_CMNM")->result(); 

            $page_data['common_subject']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=2 AND  COM_TPCD=2 ORDER BY COM_CMNM")->result(); 
            $page_data['title'] ="Teacher Profile Add";
            $page_data['page_name'] ="user/teacher_form";
            $this->load->view('backend/index',$page_data);
        }else{ 
           
           $tem_id =get_pk_id('teacher_mst','tem_id');
            $insert_data=[
                'tem_id'=>$tem_id,

                'tem_scm_id'=>clean_input($this->input->post('tem_scm_id')),
                'tem_name'=>clean_input($this->input->post('tem_name')),
                'tem_designation_id'=>clean_input($this->input->post('tem_designation_id')),
                'tem_fathername'=>clean_input($this->input->post('tem_fathername')),
                'tem_dob'=>clean_input($this->input->post('tem_dob')),
                'tem_email'=>clean_input($this->input->post('tem_email')),
                'tem_mob'=>ucwords(clean_input($this->input->post('tem_mob'))),
                'tem_address'=>ucwords(clean_input($this->input->post('tem_address'))), 

                'tem_loginid'          =>1,    //$this->login_id,
                'tem_changetype'       =>'Inserted',
                'tem_systemdate'       =>system_date(),
                'tem_systemip'         =>get_ip(),
                'tem_systemname'       =>$this->system_name,

            ]; 
            $response=data_insert('teacher_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Teacher   Created Successfully.");
                redirect('teacher_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('teacher_form','refresh');
            }
          
        }
    }
    function teacher_edit($tem_id){
        $page_data['teacher']=$this->user->get_teacher_data($tem_id)->row();

        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result(); 
        $page_data['common_class']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=1 AND COM_TPCD=1  ORDER BY COM_CMNM")->result(); 
        $page_data['common_designation']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=6 AND COM_TPCD=6  ORDER BY COM_CMNM")->result(); 

        $page_data['common_subject']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=2 AND  COM_TPCD=2 ORDER BY COM_CMNM")->result(); 
        $page_data['title'] ="Teacher Profile Edit";
        $page_data['page_name'] ="user/teacher_edit";
        $this->load->view('backend/index',$page_data);
    }
    function teacher_update($tem_id){
 
        $this->form_validation->set_rules('tem_name','Teacher Name','trim|required'); 
        $this->form_validation->set_rules('tem_fathername','Teacher Fater Name','trim|required'); 
        $this->form_validation->set_rules('tem_dob','Teacher Dob','trim|required'); 
        $this->form_validation->set_rules('tem_email','Teacher Email Id','trim|required'); 
        $this->form_validation->set_rules('tem_mob','Teacher Mobail Number','trim|required'); 
        $this->form_validation->set_rules('tem_designation_id','Teacher  Designation','trim|required'); 
        $this->form_validation->set_rules('tem_scm_id','School Name','trim|required');  
        $this->form_validation->set_rules('tem_address','Teacher Address','trim|required'); 


        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){  
            $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result(); 
            $page_data['common_class']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=1 AND COM_TPCD=1  ORDER BY COM_CMNM")->result(); 
            $page_data['common_designation']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=6 AND COM_TPCD=6  ORDER BY COM_CMNM")->result(); 

            $page_data['common_subject']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=2 AND  COM_TPCD=2 ORDER BY COM_CMNM")->result(); 
            $page_data['title'] ="Teacher Update";
            $page_data['page_name'] ="user/teacher_edit";
            $this->load->view('backend/index',$page_data);
        }else{ 
  
            $update_data=[
                'tem_id'            =>$tem_id,

                'tem_scm_id'        =>clean_input($this->input->post('tem_scm_id')),
                'tem_name'          =>clean_input($this->input->post('tem_name')),
                'tem_designation_id'=>clean_input($this->input->post('tem_designation_id')),
                'tem_fathername'    =>clean_input($this->input->post('tem_fathername')),
                'tem_dob'           =>clean_input($this->input->post('tem_dob')),
                'tem_email'         =>clean_input($this->input->post('tem_email')),
                'tem_mob'           =>clean_input($this->input->post('tem_mob')),
                'tem_address'       =>clean_input($this->input->post('tem_address')), 

                'tem_loginid'       =>1,    //$this->login_id,
                'tem_changetype'    =>'Update',
                'tem_systemdate'    =>system_date(),
                'tem_systemip'      =>get_ip(),
                'tem_systemname'    =>$this->system_name,

            ]; 
            // $response=data_insert('teacher_mst',$insert_data);
            $response=data_update('teacher_mst','tem_id', $update_data);

            if($response){
                $this->session->set_flashdata('msg',"Teacher   Created Successfully.");
                redirect('teacher_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('teacher_edit/'.$tem_id,'refresh');
            }
          
        }
    }
    function teacher_cls_list(){
        $page_data['title'] ="Teacher Class Assignd List";
        $page_data['page_name'] ="user/teacher_cls_list";
        $this->load->view('backend/index',$page_data);
    }
    function teacher_cls_form(){
        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result(); 
        $page_data['common_class']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=1 AND COM_TPCD=1  ORDER BY COM_CMNM")->result();  
        $page_data['Teacher_name']=$this->user->get_teacher_nameDesignation()->result();

        $page_data['title'] ="Teacher Class Assignd  List";
        $page_data['page_name'] ="user/teacher_cls_form";
        $this->load->view('backend/index',$page_data);
    }
    function teacher_cls_add(){
        echo "<pre>";
        print_r($_POST);
    }
    function student_list(){
        $page_data['title'] ="Student List";
        $page_data['page_name'] ="user/stude nt_list";
        $this->load->view('backend/index',$page_data);
    }
    function student_form(){
        $page_data['school_data']=get_table_data('school_mst','scm_id,scm_udisecode,scm_name',"scm_cancel=1 ORDER BY scm_udisecode")->result(); 
        $page_data['common_subject']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=2 AND  COM_TPCD=2 ORDER BY COM_CMNM")->result(); 
        $page_data['common_class']=get_table_data('com_mst,com_typ01','COT_TPCD,COM_CMCD,COM_CMNM,COM_TPCD',"COM_CANC=1 AND COT_TPCD=1 AND COM_TPCD=1  ORDER BY COM_CMNM")->result(); 
        $page_data['title'] ="Student Form";
        $page_data['page_name'] ="user/teacher_cls_form";
        $this->load->view('backend/index',$page_data);
    }
   function student_add(){
    echo "hello";
   }




//ajax part
function teacher_name_ajax(){
    $USM_SCCD=$_POST['USM_SCCD'];
   
     if(!empty($USM_SCCD)){
        
      //$district=$this->user->get_teacher_nameDesignation($USM_SCCD)->result();
        
        $district=get_table_data('teacher_mst','tem_id, tem_scm_id, tem_name, tem_designation_id',"tem_scm_id=$USM_SCCD AND tem_cancel=1")->result(); 
        if($district){
            $html='<option value="">Select Teacher Name</option>';
            foreach($district as $data){
                 $html.='<option value="'.$data->tem_id.'">'.$data->tem_name.'-'.$data->designation.'</option>';
            }
             echo $html;
            
        }else{
            $html='<option value="" >  Teacher Name Not Founds</option>';
            echo $html;
        } 
     }
}

}