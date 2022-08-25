<?php
if(!defined('BASEPATH')) exit('No direct script access allowed!.');
class SettingController extends CI_Controller{
    function __construct(){
		parent::__construct();
		$this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->user_role=$this->session->userdata('user_role');
        $this->system_name=gethostname();
		$this->load->model('backend/SettingModel','setting',TRUE);
 	}

    function web_setting( ){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
		$page_data['web_setting_data']=$this->setting->get_web_setting_data()->row();
		$page_data['title']='Web Setting';
        $page_data['page_name']='setting/web_setting';
        $this->load->view('backend/index',$page_data);
 
    }
    function web_setting_add($web_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
       
        $update_data=[
            'web_id'            =>$web_id,
            'web_name'          =>clean_input($this->input->post('web_name')),
            'web_regno'         =>clean_input($this->input->post('web_regno')),
            'web_gstno'         =>clean_input($this->input->post('web_gstno')),
            'web_panno'         =>clean_input($this->input->post('web_panno')),
            'web_mobile'        =>clean_input($this->input->post('web_mobile')),
            'web_mobilealt'     =>clean_input($this->input->post('web_mobilealt')),
            'web_email'         =>clean_input($this->input->post('web_email')),
            'web_address'       =>clean_input($this->input->post('web_address')),
            'web_pincode'       =>clean_input($this->input->post('web_pincode')), 
            'web_admin'         =>clean_input($this->input->post('web_admin')), 
            'web_complaint'     =>clean_input($this->input->post('web_complaint')), 
            'web_paymentIssue'  =>clean_input($this->input->post('web_paymentIssue')), 
            'web_Inquiry'       =>clean_input($this->input->post('web_Inquiry')), 
            
            'web_loginid'          =>$this->login_id,
            'web_changetype'       =>'Created',
            'web_systemdate'       =>system_date(),
            'web_systemip'         =>get_ip(),
            'web_systemname'       =>$this->system_name,
        ];
        
        $uploadPath='uploads/web_setting/'; 
        if (!file_exists($uploadPath )){
            @mkdir($uploadPath, 0777);
        }

        /**header Logo */
        $header_uplodpath=$uploadPath.'header/';
        if (!file_exists($header_uplodpath )){
            @mkdir($header_uplodpath, 0777);
        }

        $old_web_headerlogo=$this->input->post('old_web_headerlogo');
        $file_name_header = $_FILES["web_headerlogo"]["name"];
        $file_type = $_FILES["web_headerlogo"]["type"];
        $htemp_name = $_FILES["web_headerlogo"]["tmp_name"];
        //becoblue.png
        if(!empty($old_web_headerlogo) && !empty($file_name_header)){
            if(file_exists($header_uplodpath.$old_web_headerlogo)){
                unlink($header_uplodpath.$old_web_headerlogo);
            }
            // move_uploaded_file($htemp_name,$header_uplodpath.'becoblue.png');
            // $update_data['web_headerlogo']='becoblue.png';

            $fileName=image_upload2('web_headerlogo', $_FILES['web_headerlogo'], $header_uplodpath, $old_web_headerlogo);
            $update_data['web_headerlogo']=$fileName;
        }elseif(empty($old_web_headerlogo) && !empty($file_name_header)){
            if(file_exists($header_uplodpath.$file_name_header)){
                unlink($header_uplodpath.$file_name_header);
            }
            // move_uploaded_file($htemp_name,$header_uplodpath.'becoblue.png');
            // $update_data['web_headerlogo']='becoblue.png';
            $fileName=image_upload2('web_headerlogo', $_FILES['web_headerlogo'], $header_uplodpath, $old_web_headerlogo);
            $update_data['web_headerlogo']=$fileName;
        }else{
            $update_data['web_headerlogo']=$old_web_headerlogo;
           // $update_data['web_headerlogo']='becoblue.png';
        }
        
        /** Footer Logo **/      
        $footer_uplodpath=$uploadPath.'footer/';
        if (!file_exists($footer_uplodpath )){
            @mkdir($footer_uplodpath, 0777);
        }  
        $old_web_footerlogo=$this->input->post('old_web_footerlogo');
        $file_name_footer = $_FILES["web_footerlogo"]["name"];
        $file_type = $_FILES["web_footerlogo"]["type"];
        $temp_name = $_FILES["web_footerlogo"]["tmp_name"];

        if(!empty($old_web_footerlogo) && !empty($file_name_footer)){
            if(file_exists($footer_uplodpath.$old_web_footerlogo)){
                unlink($footer_uplodpath.$old_web_footerlogo);
            }
            $fileName=image_upload2('web_footerlogo', $_FILES['web_footerlogo'], $footer_uplodpath, $old_web_footerlogo);
            $update_data['web_footerlogo']=$fileName;
        }elseif(empty($old_web_footerlogo) && !empty($file_name_footer)){
            if(file_exists($footer_uplodpath.$file_name_footer)){
                unlink($footer_uplodpath.$file_name_footer);
            }
            $fileName=image_upload2('web_footerlogo', $_FILES['web_footerlogo'], $footer_uplodpath, $old_web_footerlogo);
            $update_data['web_footerlogo']=$fileName;
        }else{
            $update_data['web_footerlogo']=$old_web_footerlogo;
        } 
        

        /** CEO Signature **/
        $ceo_uplodpath=$uploadPath.'ceo_sign/';
        if (!file_exists($ceo_uplodpath )){
            @mkdir($ceo_uplodpath, 0777);
        }  
        $old_web_ceosign=$this->input->post('old_web_ceosign');
        $file_web_ceosign = $_FILES["web_ceosign"]["name"];
        $file_type = $_FILES["web_ceosign"]["type"];
        $temp_name = $_FILES["web_ceosign"]["tmp_name"];

        if(!empty($old_web_ceosign) && !empty($file_web_ceosign)){
            if(file_exists($ceo_uplodpath.$old_web_ceosign)){
                unlink($ceo_uplodpath.$old_web_ceosign);
            }
            // move_uploaded_file($temp_name,$ceo_uplodpath.'ceosign.png');
            // $update_data['web_ceosign']='ceosign.png';
            $fileName=image_upload2('web_ceosign', $_FILES['web_ceosign'], $ceo_uplodpath, $old_web_ceosign);
            $update_data['web_ceosign']=$fileName;
        }elseif(empty($old_web_ceosign) && !empty($file_web_ceosign)){
            if(file_exists($ceo_uplodpath.$file_web_ceosign)){
                unlink($ceo_uplodpath.$file_web_ceosign);
            }
            // move_uploaded_file($temp_name,$ceo_uplodpath.'ceosign.png');
            // $update_data['web_ceosign']='ceosign.png';
            $fileName=image_upload2('web_ceosign', $_FILES['web_ceosign'], $ceo_uplodpath, $old_web_ceosign);
            $update_data['web_ceosign']=$fileName;
        }else{
            $update_data['web_ceosign']=$old_web_ceosign;
            //$update_data['web_ceosign']='ceosign.png';
        } 

       
        
        /** Inner Page Banner **/
        $inner_uplodpath=$uploadPath.'inner_banner/';
        if (!file_exists($inner_uplodpath )){
            @mkdir($inner_uplodpath, 0777);
        } 
    
        $old_web_innerbanner=$this->input->post('old_web_innerbanner');
        $file_web_ceosign = $_FILES["web_innerbanner"]["name"];
        $file_type = $_FILES["web_innerbanner"]["type"];
        $temp_name = $_FILES["web_innerbanner"]["tmp_name"];

        if(!empty($old_web_innerbanner) && !empty($file_web_ceosign)){
            if(file_exists($inner_uplodpath.$old_web_innerbanner)){
                unlink($inner_uplodpath.$old_web_innerbanner);
            }
            $fileName=image_upload2('web_innerbanner', $_FILES['web_innerbanner'], $inner_uplodpath, $old_web_innerbanner);
            $update_data['web_innerbanner']=$fileName;
        }elseif(empty($old_web_innerbanner) && !empty($file_web_ceosign)){
            if(file_exists($inner_uplodpath.$file_web_ceosign)){
                unlink($inner_uplodpath.$file_web_ceosign);
            }
            $fileName=image_upload2('web_innerbanner', $_FILES['web_innerbanner'], $inner_uplodpath, $old_web_innerbanner);
            $update_data['web_innerbanner']=$fileName;
        }else{
            $update_data['web_innerbanner']=$old_web_innerbanner;
        }  
        
        $response=data_update('web_setting','web_id',$update_data);  
        if($response){
            $this->session->set_flashdata('msg'," Web setting Updated Successfully.");
            redirect('web_setting','refresh');
        }else{
            $this->session->set_flashdata('error',"Oops!. Error Occurred.");
            redirect('web_setting/','refresh');
        }
        
    }


    function web_setting_update($web_id){
        $uploadPath='uploads/web_setting/'; 
        if (!file_exists($uploadPath )){
            @mkdir($uploadPath, 0777);
        }
        /**header Logo */
        $old_web_headerlogo=$this->input->post('old_web_headerlogo');
        $file_name_header = $_FILES["web_headerlogo"]["name"];
        $file_type = $_FILES["web_headerlogo"]["type"];
        $temp_name = $_FILES["web_headerlogo"]["tmp_name"];

        $fileName=image_upload2('web_headerlogo', $_FILES['web_headerlogo'], $uploadPath, $old_web_headerlogo);
        $update_data['web_headerlogo']=$fileName;
    }
    function page_details(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  

	    $page_data['page_details_data']=$this->setting->get_page_details()->result();
 
		$page_data['title']='Page details List';
        $page_data['page_name']='setting/page_details_list';
        $this->load->view('backend/index',$page_data);

    }
	function page_details_form(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  

		$page_data['page_details_data']=$this->setting->get_page_details()->result();
        $page_data['page_type_data']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=21  ORDER BY COM_CMNM ")->result();
 
        $page_data['title']='Page Details Add';
        $page_data['page_name']='setting/page_details_form';
        $this->load->view('backend/index',$page_data);

    }	
    function page_details_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_type =$this->input->post('page_type');
        $this->form_validation->set_rules('page_type','Page Types','trim|required|is_unique[page_details.page_type]');
        $this->form_validation->set_rules('page_title','Page Title','trim|required');
        $this->form_validation->set_rules('page_content','Content','trim|required');

        if($page_type == 238 || $page_type ==239 ){
            if ($_FILES['page_img']['name'] == "" ) {
                $this->form_validation->set_rules('page_img','Image' ,'trim|required');
            }
        }
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            $page_data['page_details_data']=$this->setting->get_page_details()->result();
            $page_data['page_type_data']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=21  ORDER BY COM_CMNM ")->result();
     
            $page_data['title']='Page Details Add';
            $page_data['page_name']='setting/page_details_form';
            $this->load->view('backend/index',$page_data);
        }else{

            $page_id =get_pk_id('page_details','page_id');
            $insert_data=[
                'page_id'                 =>$page_id,
                'page_type'               => clean_input($this->input->post('page_type')),
                'page_title'              => string_ucword(clean_input($this->input->post('page_title'))),
                'page_content'            => $this->input->post('page_content'),
                
                'page_loginid'            =>$this->login_id,
                'page_changetype'         =>'Created',
                'page_systemdate'         =>system_date(),
                'page_systemip'           =>get_ip(),
                'page_systemname'         =>$this->system_name,
            ];
            $uploadPath='uploads/web_setting/page_details/'; 
            if (!file_exists($uploadPath )){
                @mkdir($uploadPath, 0777);
            }
 
            $old_page_img=$this->input->post('old_page_img');
            $file_name_header = $_FILES["page_img"]["name"];
            $file_type = $_FILES["page_img"]["type"];
            $temp_name = $_FILES["page_img"]["tmp_name"];

          
            if($page_type == 238 || $page_type ==239 ){
                $fileName=image_upload2('page_img', $_FILES['page_img'], $uploadPath, $old_page_img);
                $insert_data['page_img']=$fileName;
            }else{
                $update_data['page_img']='';
            }
            $response=data_insert('page_details',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"About us add  Successfully.");
                redirect('page_details','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('page_details','refresh');
            }
        }
    }
    function page_details_edit($page_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  

        $page_data['page_details_data']=$this->setting->get_page_details($page_id)->row();
        $page_data['page_type_data']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=21 ORDER BY COM_CMNM")->result();

        $page_data['title']='Page Details Edit';
        $page_data['page_name']='setting/page_details_edit';
        $this->load->view('backend/index',$page_data);

    }

    function page_details_update($page_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_type =$this->input->post('page_type');
        $this->form_validation->set_rules('page_type','Page Types','trim|required');
        $this->form_validation->set_rules('page_title','Page Title','trim|required');
        $this->form_validation->set_rules('page_content','Content','trim|required');
        if($page_type == 238 || $page_type ==239 ){
            if ($_FILES['page_img']['name'] == "" && $_POST['old_page_img'] =="" ) {
                $this->form_validation->set_rules('page_img','Image' ,'trim|required');
            }
        }
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            $page_data['page_details_data']=$this->setting->get_page_details($page_id)->row();
            $page_data['page_type_data']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=21 ORDER BY COM_CMNM")->result();
    
            $page_data['title']='Page Details Edit';
            $page_data['page_name']='setting/page_details_edit';
            $this->load->view('backend/index',$page_data);
        }else{  
            $page_type=clean_input($this->input->post('page_type'));
            $page_title=clean_input($this->input->post('page_title'));
            $page_content=string_ucword(clean_input($this->input->post('page_content')));
            $is_uniq=check_uniq_value('page_details','page_type',$page_type,"page_cancel=1 AND page_id !=$page_id");
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('page_details_edit/'.$page_id,'refresh');
            }else{
                $update_data=[
                    'page_id'                 =>$page_id,
                    'page_type'               => clean_input($this->input->post('page_type')),
                    'page_title'              => string_ucword(clean_input($this->input->post('page_title'))),
                    'page_content'            =>$this->input->post('page_content'),
                    
                    'page_loginid'            =>$this->login_id,
                    'page_changetype'         =>'Modified',
                    'page_systemdate'         =>system_date(),
                    'page_systemip'           =>get_ip(),
                    'page_systemname'         =>$this->system_name,
                ];
                $uploadPath='uploads/web_setting/page_details/'; 
                if (!file_exists($uploadPath )){
                    @mkdir($uploadPath, 0777);
                }
 
                $old_page_img=$this->input->post('old_page_img');
                $file_name_header = $_FILES["page_img"]["name"];

                if(!empty($old_page_img) && !empty($file_name_header)){
                    if(file_exists($uploadPath.$old_page_img)){
                        unlink($uploadPath.$old_page_img);
                    }
                    $fileName=image_upload2('page_img', $_FILES['page_img'], $uploadPath, $old_page_img);
                    $update_data['page_img']=$fileName;
                }elseif(empty($old_page_img) && !empty($file_name_header)){
                    if(file_exists($uploadPath.$file_name_header)){
                        unlink($uploadPath.$file_name_header);
                    }
                    $fileName=image_upload2('page_img', $_FILES['page_img'], $uploadPath, $old_page_img);
                    $update_data['page_img']=$fileName;
                }else{
                    $update_data['page_img']=$old_page_img;
                }

                // if($page_type != 238 || $page_type !=239 ){
                //     $update_data['page_img']='';
                // }
               
                $response=data_update('page_details','page_id',$update_data);
            
                if($response){
                    $this->session->set_flashdata('msg',"Page Data  Updated Successfully.");
                    redirect('page_details','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('page_details_edit/'.$page_id,'refresh');
                }
            }
        }
    } 
    /**  banner */
    function banner_list(){
        if(!$this->session->userdata('userlogin')){
             redirect('home');
        }
        $page_data['banner_data']=$this->setting->get_banner_data()->result();
 
		$page_data['title']='Banner List';
        $page_data['page_name']='setting/banner_list';
        $this->load->view('backend/index',$page_data);
     
    }
    function banner_form(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
  
        $page_data['title']='Banner Add';
        $page_data['page_name']='setting/banner_form';
        $this->load->view('backend/index',$page_data);
    }
    function banner_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
  
        if ($_FILES['banner_name']['name'] == "" && empty($_POST['old_banner_name']) ) {
            $this->form_validation->set_rules('banner_name','Banner Photo','trim|required');
        }
        $this->form_validation->set_rules('banner_order','Banner Order','trim|required|is_unique[banner_mst.banner_order]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            
            $page_data['title']='Banner Add';
            $page_data['page_name']='setting/banner_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $banner_id =get_pk_id('banner_mst','banner_id');
            $insert=[
                'banner_id'               =>$banner_id, 
                'banner_order'            =>clean_input($this->input->post('banner_order')), 

                'banner_loginid'          =>$this->login_id,
                'banner_changetype'       =>'Created',
                'banner_systemdate'       =>system_date(),
                'banner_systemip'         =>get_ip(),
                'banner_systemname'       =>$this->system_name,
            ];
            $uploadPath='uploads/web_setting/banners/'; 
             if (!file_exists($uploadPath)){
                @mkdir($uploadPath, 0777,true);
            }
            $banner_name=$_FILES['banner_name']['name'];
            
            $old_banner_name=clean_input($this->input->post('old_banner_name'));
            if ($_FILES['banner_name']['name'] != "" && $_FILES['banner_name']['error'] ===0) {
                if (file_exists($uploadPath.$banner_name)){
                    unlink($uploadPath.$banner_name);
                }
                $fileName=image_upload2('banner_name', $_FILES['banner_name'], $uploadPath, $old_banner_name);
                $insert['banner_name']= $fileName;
            }
            $response=data_insert('banner_mst',$insert);
            if($response){
                $this->session->set_flashdata('msg',"Banner Created Successfully.");
                redirect('banner_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('banner_form/','refresh');
            }
        }

    }
    function banner_edit($banner_id){
        if(!$this->session->userdata('userlogin')){
             redirect('login');
        }
        $page_data['banner_data']=$this->setting->get_banner_data($banner_id)->row();
        $page_data['title']='Banner Edit';
        $page_data['page_name']='setting/banner_edit';
        $this->load->view('backend/index',$page_data);
    }
    function banner_update($banner_id){
        if(!$this->session->userdata('userlogin')){
             redirect('login');
        }
        /** check order */
        $order=$this->input->post('banner_order');
        $old_banner_order=$this->input->post('old_banner_order');
        if($order != $old_banner_order){
            $count =check_uniq_value('banner_mst','banner_order', $order);
            if($count >0){
                $this->session->set_flashdata('error','Banner Order Already Exist! Please change Order');
                redirect('banner_edit/'.$banner_id,'refresh');
            }
        }
       
        $update_data=[
            'banner_id'               =>$banner_id, 
            'banner_order'            =>clean_input($this->input->post('banner_order')), 

            'banner_loginid'          =>$this->login_id,
            'banner_changetype'       =>'Modified',
            'banner_systemdate'       =>system_date(),
            'banner_systemip'         =>get_ip(),
            'banner_systemname'       =>$this->system_name,
        ];

        $uploadPath='uploads/web_setting/banners/'; 
        /** check Web Banner old banner remove and new add */
        
        $image_obj=$_FILES["banner_name"];
        $old_banner_name=$this->input->post('old_banner_name');
        $file_name = $_FILES["banner_name"]["name"];
        $file_type = $_FILES["banner_name"]["type"];
        $temp_name = $_FILES["banner_name"]["tmp_name"];
        
        if(!empty($old_banner_name) && !empty($file_name)){
            if(file_exists($uploadPath.$old_banner_name)){
                unlink($uploadPath.$old_banner_name);
            }
            $fileName=image_upload2('banner_name', $_FILES['banner_name'], $uploadPath, $old_banner_name);
            $update_data['banner_name']=$fileName;
        }elseif(empty($old_banner_name) && !empty($file_name)){
            $fileName=image_upload2('banner_name', $_FILES['banner_name'], $uploadPath, $old_banner_name);
            $update_data['banner_name']=$fileName;
        }else{
            $update_data['banner_name']=$old_banner_name;
        }

        $response=data_update('banner_mst','banner_id',$update_data);  
        if($response){
            $this->session->set_flashdata('msg',"Banner Updated Successfully.");
            redirect('banner_list','refresh');
        }else{
            $this->session->set_flashdata('error',"Oops!. Error Occurred.");
            redirect('banner_edit/'.$banner_id,'refresh');
        }
        
    }
    function banner_delete(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $banner_id=clean_input($this->input->post('id'));
        
        $delete_data=[
            'banner_id'            =>$banner_id,
            
            'banner_loginid'          =>$this->login_id,
            'banner_cancel'           =>2,
            'banner_changetype'       =>'Deleted',
            'banner_systemdate'       =>system_date(),
            'banner_systemip'         =>get_ip(),
            'banner_systemname'       =>$this->system_name,
        ];
        $response= data_update('banner_mst','banner_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function banner_active(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $banner_id=clean_input($this->input->post('id'));        
        $delete_data=[
            'banner_id'            =>$banner_id,
            
            'banner_loginid'          =>$this->login_id,
            'banner_status'           =>1,
            'banner_changetype'       =>'Activated',
            'banner_systemdate'       =>system_date(),
            'banner_systemip'         =>get_ip(),
            'banner_systemname'       =>$this->system_name,
        ];
        $response= data_update('banner_mst','banner_id',$delete_data);
         if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function banner_inactive(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $banner_id=clean_input($this->input->post('id'));
        
        $delete_data=[
            'banner_id'               =>$banner_id,
            
            'banner_loginid'          =>$this->login_id,
            'banner_status'           =>2,
            'banner_changetype'       =>'Inactivated',
            'banner_systemdate'       =>system_date(),
            'banner_systemip'         =>get_ip(),
            'banner_systemname'       =>$this->system_name,
 

          ];
        $response= data_update('banner_mst','banner_id',$delete_data);
         if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }

    //configuration
    function configuration(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['title']='System Configuration ';
        $page_data['page_name']='setting/configuration';
        $this->load->view('backend/index',$page_data);
    }
    function configuration_add(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->setting->update_system_settings();
        $this->session->set_flashdata('msg',"configuration Updated  Successfully.");
        redirect('configuration','refresh');
            //UPDATE `config_mst` SET `config_value`='Becoblue' WHERE config_key='system_name'
        // $response=data_update('config_mst','config_id',$update);
        //    if($response){
        //        $this->session->set_flashdata('msg',"configuration Update  Successfully.");
        //        redirect('configuration','refresh');
        //    }else{
        //        $this->session->set_flashdata('error',"Oops!. Error Occurred.");
        //        redirect('configuration','refresh');
        //    }



    }

    function notice(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['notice_data']=$this->setting->get_notification_data()->result();

        $page_data['title']='Notice List';
        $page_data['page_name']='setting/notice';
        $this->load->view('backend/index',$page_data);
    }
    function notice_form(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['title']='Notice Add';
        $page_data['page_name']='setting/notice_form';
        $this->load->view('backend/index',$page_data);
    }
    function  notice_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
       
        $this->form_validation->set_rules('notice','Notice Title','trim|required');
        $this->form_validation->set_rules('from_time','Form To','trim|required');
        $this->form_validation->set_rules('to_time','To Time','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
           if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
            $page_data['title']='Notice Add';
            $page_data['page_name']='setting/notice_form';
            $this->load->view('backend/index',$page_data);
        }else{ 
            $notice_id=get_pk_id('notice_mst','notice_id'); 
            $insert_data=[
                'notice_id'         =>$notice_id ,
                'notice'            =>clean_input($this->input->post('notice')),
                'from_time'         =>date('Y-m-d H:i', strtotime($this->input->post('from_time'))),
                'to_time'           =>date('Y-m-d H:i', strtotime($this->input->post('to_time'))),

                'login_id'          =>$this->login_id,
                'change_type'       =>'Created',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>$this->system_name,
            ];
         
            $response=data_insert('notice_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Notice Created Successfully.");
                redirect('notice','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('notification_form','refresh');
            }
        }
    }
    function notice_edit($notice_id){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['notice_data']=$this->setting->get_notification_data($notice_id)->row();
        $page_data['title']='Notice Edit';
        $page_data['page_name']='setting/notice_edit';
        $this->load->view('backend/index',$page_data);
    }
    function notice_update($notice_id){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        
        $this->form_validation->set_rules('notice','Notice Title','trim|required');
        $this->form_validation->set_rules('from_time','Form Time','trim|required');
        $this->form_validation->set_rules('to_time','To Time ','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
            if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
                redirect('login');
            } 
            $page_data['notice_data']=$this->setting->get_notification_data($notice_id)->row();
            $page_data['title']='notice Edit';
            $page_data['page_name']='setting/notice_edit';
            $this->load->view('backend/index',$page_data);
        }else{ 
            $update_data=[
                'notice_id'         =>$notice_id ,
                'notice'            =>clean_input($this->input->post('notice')),
                'from_time'         =>date('Y-m-d H:i', strtotime($this->input->post('from_time'))),
                'to_time'           =>date('Y-m-d H:i', strtotime($this->input->post('to_time'))),

                'login_id'          =>$this->login_id,
                'change_type'       =>'Modified',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>$this->system_name,
            ];
            
            $response=data_update('notice_mst','notice_id',$update_data);  
            if($response){
                $this->session->set_flashdata('msg',"Notice Updated Successfully.");
                redirect('notice','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('notice_edit/'.$notice_id,'refresh');
            }
        }
    }
    function notice_delete(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $notice_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'notice_id'         =>$notice_id ,

            'login_id'          =>$this->login_id,
            'cancel'            =>2,
            'change_type'       =>'Deleted',
            'system_date'       =>system_date(),
            'system_ip'         =>get_ip(),
            'system_name'       =>$this->system_name,
        ];
        $response= data_update('notice_mst','notice_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function notice_active(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $notice_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'notice_id'         =>$notice_id ,
            'login_id'          =>$this->login_id,
            'status'            =>1,
            'change_type'       =>'Activated',
            'system_date'       =>system_date(),
            'system_ip'         =>get_ip(),
            'system_name'       =>$this->system_name,
        ];
        $response= data_update('notice_mst','notice_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function notice_inactive(){ 
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $notice_id=clean_input($this->input->post('id'));        
        $delete_data=[  
            'notice_id'          =>$notice_id, 
            'login_id'          =>$this->login_id,
            'status'            =>2,
            'change_type'       =>'Inactivated',
            'system_date'       =>system_date(),
            'system_ip'         =>get_ip(),
            'system_name'       =>$this->system_name,
        ];
        $response= data_update('notice_mst','notice_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function attention_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['attention_data']=$this->setting->get_attention_data()->result();

        $page_data['title']='Attention  List';
        $page_data['page_name']='setting/attention_list';
        $this->load->view('backend/index',$page_data);
    }

    function attention(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
 
        $page_data['title']='Attention Add';
        $page_data['page_name']='setting/attention';
        $this->load->view('backend/index',$page_data);
    }
    function attention_add(){ 
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
      
        $this->form_validation->set_rules('atn_name','Attention','trim|required|is_unique[attention.atn_name]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
           if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
            $page_data['title']='Attention Add';
            $page_data['page_name']='setting/attention';
            $this->load->view('backend/index',$page_data);
        }else{ 
           
            $atn_id=get_pk_id('attention','atn_id'); 
            $insert_data=[
                'atn_id'         =>$atn_id ,
                'atn_name'            =>clean_input($this->input->post('atn_name')),
                 
                'atn_loginId'          =>$this->login_id,
                'atn_changeType'       =>'Created',
                'atn_systemDate'       =>system_date(),
                'atn_systemIp'         =>get_ip(),
                'atn_systemName'       =>$this->system_name,
            ];
          
            $response=data_insert('attention',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Attention Created Successfully.");
                redirect('attention_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('notification_form','refresh');
            }
        }
    }
    function attention_edit($atm_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['attention_data']=$this->setting->get_attention_data($atm_id)->row();

        $page_data['title']='Attention Edit';
        $page_data['page_name']='setting/attention_edit';
        $this->load->view('backend/index',$page_data);

    }
    function attention_update($atn_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
      
        $this->form_validation->set_rules('atn_name','Attention','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
           if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
            $page_data['title']='Attention Add';
            $page_data['page_name']='setting/attention_edit';
            $this->load->view('backend/index',$page_data);
        }else{   
            $update_data=[
                'atn_id'               =>$atn_id ,
                'atn_name'             =>clean_input($this->input->post('atn_name')),
                 
                'atn_loginId'          =>$this->login_id,
                'atn_changeType'       =>'Modified',
                'atn_systemDate'       =>system_date(),
                'atn_systemIp'         =>get_ip(),
                'atn_systemName'       =>$this->system_name,
            ];
            
            $response=data_update('attention','atn_id',$update_data);
            if($response){
                $this->session->set_flashdata('msg',"Attention Updated Successfully.");
                redirect('attention_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('notification_edit/'.$atn_id,'refresh');
            }
        }
    }
    function attention_delete(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $atn_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'atn_id'               =>$atn_id ,
              
            'atn_loginId'          =>$this->login_id,
            'atn_cancel'           =>2,
            'atn_changeType'       =>'Deleted',
            'atn_systemDate'       =>system_date(),
            'atn_systemIp'         =>get_ip(),
            'atn_systemName'       =>$this->system_name, 
             
            ];
        $response= data_update('attention','atn_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
       /**  Image Gallery */
    function event_gallery_list(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $config =[
            'base_url'=>base_url('event_gallery_list'),
            'per_page'=>'10',
            'total_rows'=>total_record('event_gallery','event_cancel=1'),
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


        $page_data['gallery_data']=$this->setting->get_gallery_data('',$config['per_page'],$page)->result();
        
        $page_data['main_menu']='wepapp';
        $page_data['menu_active']='event_gallery_list';
        $page_data['title']='Event Gallery List';
        $page_data['page_name']='setting/event_gallery_list';
        $this->load->view('backend/index',$page_data);
    }
    function event_gallery_form(){
        if(!$this->session->userdata('userlogin')){
             redirect('home');
        }
        // $page_data['school_data']=get_table_data('school_mst','scm_id,scm_name,scm_udisecode',"scm_status=1 AND scm_cancel=1 ORDER BY scm_name")->result();
        $page_data['main_menu']='wepapp';
        $page_data['menu_active']='event_gallery_list';
        $page_data['title']='Event Gallery Add';
        $page_data['page_name']='setting/event_gallery_form';
        $this->load->view('backend/index',$page_data);
    }
    function event_gallery_add(){
   
        if(!$this->session->userdata('userlogin')){
             redirect('home');
        }
        if ($_FILES['event_name']['name'] == "" &&  $_FILES['event_name']['error'] != 0 ) {
            $this->form_validation->set_rules('event_name','Image Name','trim|required');
        }
         $this->form_validation->set_rules('event_title','Image Title ','trim|required');
  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 

        
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            } 
            $page_data['gallery_data']=$this->setting->get_gallery_data()->result();
  
            $page_data['main_menu']='wepapp';
            $page_data['menu_active']='event_gallery_list';
            $page_data['title']='Event Gallery  Add';
            $page_data['page_name']='setting/event_gallery_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $event_id =get_pk_id('event_gallery','event_id'); 
            $insert_data =[
                'event_id'               =>$event_id,
                'event_title'            =>clean_input($this->input->post('event_title')),
  
                'event_loginid'          =>$this->login_id,
                'event_changetype'       =>'Created',
                'event_systemdate'       =>system_date(),
                'event_systemip'         =>get_ip(),
                'event_systemname'       =>$this->system_name,
            ];
            $uploadPath='uploads/event_gallery/';

            if (!file_exists($uploadPath)){
                @mkdir($uploadPath, 0777,true);
            }
            $img_name=$_FILES['event_name']['name'];
            
            $old_event_name=clean_input($this->input->post('old_event_name'));
            if ($_FILES['event_name']['name'] != "" && $_FILES['event_name']['error'] ===0) {
                if (file_exists($uploadPath.$img_name)){
                    unlink($uploadPath.$img_name);
                 }
                $fileName=image_upload2('event_name', $_FILES['event_name'], $uploadPath, $old_event_name);
                $insert_data['event_name']= $fileName;
            }
        
            $response=data_insert('event_gallery',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Image Gallery Created Successfully.");
                redirect('event_gallery_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('event_gallery_form/','refresh');
            }
        }
    }
    function event_gallery_edit($event_id){
        
        if(!$this->session->userdata('userlogin')){
             redirect('home');
        }
         $page_data['gallery_data']=$this->setting->get_gallery_data($event_id)->row();
 
        $page_data['main_menu']='wepapp';
        $page_data['menu_active']='event_gallery_list';
        $page_data['title']='Event Gallery Edit';
        $page_data['page_name']='setting/event_gallery_edit';
        $this->load->view('backend/index',$page_data);
    }
    function event_gallery_update($event_id){
        if(!$this->session->userdata('userlogin')){
             redirect('home');
        }
         $this->form_validation->set_rules('event_title','Image Title ','trim|required');

        if ($_FILES['event_name']['name'] == "" && empty($_POST['old_event_name']) ) {
            $this->form_validation->set_rules('event_name','Image','trim|required');
        }

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('home');
            }
            $page_data['gallery_data']=$this->setting->get_gallery_data($event_id)->row(); 
            $page_data['main_menu']='wepapp';
            $page_data['menu_active']='event_gallery_list';
            $page_data['title']='Event Gallery Edit';
            $page_data['page_name']='event_gallery_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $update_data =[
                'event_id'               =>$event_id,
                'event_title'            =>clean_input($this->input->post('event_title')),
  
                'event_loginid'          =>$this->login_id,
                'event_changetype'       =>'Created',
                'event_systemdate'       =>system_date(),
                'event_systemip'         =>get_ip(),
                'event_systemname'       =>$this->system_name,
            ];
            $uploadPath='uploads/event_gallery/';

            $old_event_name=$this->input->post('old_event_name');
            $file_name = $_FILES["event_name"]["name"];
            $file_type = $_FILES["event_name"]["type"];
            $temp_name = $_FILES["event_name"]["tmp_name"];

            if(!empty($old_event_name) && !empty($file_name)){
                if(file_exists($uploadPath.$old_event_name)){
                    unlink($uploadPath.$old_event_name);
                }
                $fileName=image_upload2('event_name', $_FILES['event_name'], $uploadPath, $old_event_name);
                $update_data['event_name']=$fileName;
            }elseif(empty($old_event_name) && !empty($file_name)){
                if(file_exists($uploadPath.$file_name)){
                    unlink($uploadPath.$file_name);
                }
                $fileName=image_upload2('event_name', $_FILES['event_name'], $uploadPath, $old_event_name);
                $update_data['event_name']=$fileName;
            }else{
                $update_data['event_name']=$old_event_name;
            }
          
            $response=data_update('event_gallery','event_id',$update_data);  
            if($response){
                $this->session->set_flashdata('msg',"Image Gallery Updated Successfully.");
                redirect('event_gallery_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('event_gallery_edit/'.$event_id,'refresh');
            }
        }
    }
    function event_gallery_delete(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $event_id=clean_input($this->input->post('id'));
        
        $delete_data=[
            'event_id'                =>$event_id,
            
            'event_loginid'          =>$this->login_id,
            'event_cancel'           =>2,
            'event_changetype'       =>'Deleted',
            'event_systemdate'       =>system_date(),
            'event_systemip'         =>get_ip(),
            'event_systemname'       =>$this->system_name,

          ];
        $response= data_update('event_gallery','event_id',$delete_data);
         if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function event_gallery_active(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $event_id=clean_input($this->input->post('id'));
        
        $delete_data=[
            'event_id'               =>$event_id,
            
            'event_loginid'          =>$this->login_id,
            'event_status'           =>1,
            'event_changetype'       =>'Activated',
            'event_systemdate'       =>system_date(),
            'event_systemip'         =>get_ip(),
            'event_systemname'       =>$this->system_name,

          ];
        $response= data_update('event_gallery','event_id',$delete_data);
         if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function event_gallery_inactive(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
        }
        $img_id=clean_input($this->input->post('id'));
        
        $delete_data=[
            'event_id'                =>$img_id,
            
            'event_loginid'          =>$this->login_id,
            'event_status'           =>2,
            'event_changetype'       =>'Inactivated',
            'event_systemdate'       =>system_date(),
            'event_systemip'         =>get_ip(),
            'event_systemname'       =>$this->system_name,

          ];
        $response= data_update('event_gallery','event_id',$delete_data);
         if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }

    }



}















 







