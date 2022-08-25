<?php
if(!defined('BASEPATH')) exit('No direct script access allowed!.');

class PostCategory extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->system_name=gethostname();
		$this->load->model('backend/PostCategoryModel','postcategory',TRUE);
	}
	
	function sub_service_list(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        //filter
        $ssm_sumid ='';
        if($this->input->method() == 'get'){
            $ssm_sumid =$this->input->get('s');
        }
        if(!empty($ssm_sumid)){
            $total_rows=total_record('sub_servicemst','ssm_cancel=1 AND ssm_sumid='.$ssm_sumid);
        }else{
            $total_rows=total_record('sub_servicemst','ssm_cancel=1');
        }
        $page_data['ssm_sumid']=$ssm_sumid;

		$config =[
            'base_url'=>base_url('sub_service_list'),
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

	  
		$page_data['sub_service_data']=$this->postcategory->get_sub_service('',$config['per_page'],$page,$ssm_sumid)->result();
        $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"sum_cancel=1  AND sum_categoryid=3 ORDER BY sum_subcategory")->result();

		$page_data['title']='Sub Service List';
        $page_data['page_name']='post_category/sub_service_list';
        $this->load->view('backend/index',$page_data);
	}
	function sub_service_form(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
		$page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"sum_cancel=1  AND sum_categoryid=3 ORDER BY sum_subcategory")->result();
		$page_data['title']='Sub Service Add';
        $page_data['page_name']='post_category/sub_service_form';
        $this->load->view('backend/index',$page_data);
	}
    function sub_service_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $this->form_validation->set_rules('ssm_sumid','Service','trim|required');
        $this->form_validation->set_rules('ssm_name','Sub Service','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
           if(!$this->session->userdata('userlogin')){
                redirect('home');
           }

           $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"sum_cancel=1  AND sum_categoryid=3 ORDER BY sum_subcategory")->result();

           $page_data['main_menu']='setup';
            $page_data['title']='Sub Service Add';
           $page_data['page_name']='post_category/sub_service_form';
           $this->load->view('backend/index',$page_data);
        }else{
           $ssm_id =get_pk_id('sub_servicemst','ssm_id');
           $insert_data=[
                'ssm_id'                 =>$ssm_id,
                'ssm_sumid'              => clean_input($this->input->post('ssm_sumid')),
                'ssm_name'               => string_ucword(clean_input($this->input->post('ssm_name'))),
               
                'ssm_loginid'           =>$this->login_id,
                'ssm_changetype'       	=>'Created',
                'ssm_systemdate'       	=>system_date(),
                'ssm_systemip'         	=>get_ip(),
                'ssm_systemname'       	=>$this->system_name,
           ];
    
           $response=data_insert('sub_servicemst',$insert_data);
           if($response){
               $this->session->set_flashdata('msg',"Subservices Created Successfully.");
               redirect('sub_service_form','refresh');
           }else{
               $this->session->set_flashdata('error',"Oops!. Error Occurred.");
               redirect('sub_service_form','refresh');
           }
       
       }
    }
    function sub_service_edit($ssm_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['sub_service_data']=$this->postcategory->get_sub_service($ssm_id)->row();
		$page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"sum_cancel=1  AND sum_categoryid=3 ORDER BY sum_subcategory")->result();
		$page_data['title']='Sub Service Edit';
        $page_data['page_name']='post_category/sub_service_edit';
        $this->load->view('backend/index',$page_data);
    }
    function sub_service_update($ssm_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $this->form_validation->set_rules('ssm_sumid','Service','trim|required');
        $this->form_validation->set_rules('ssm_name','Sub Service ','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
           if(!$this->session->userdata('userlogin')){
                redirect('home');
           }
           $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"sum_cancel=1  AND sum_categoryid=3 ORDER BY sum_subcategory")->result();
           $page_data['sub_service_data']=$this->postcategory->get_sub_service($ssm_id)->row();	
           $page_data['title']='Sub Service Edit';
           $page_data['page_name']='post_category/sub_service_edit';
           $this->load->view('backend/index',$page_data);
        }else{
            $ssm_sumid= clean_input($this->input->post('ssm_sumid'));
            $value=string_ucword(clean_input($this->input->post('ssm_name')));
            $is_uniq =check_uniq_value('sub_servicemst','ssm_name', $value,"ssm_sumid=$ssm_sumid AND ssm_id != $ssm_id AND ssm_cancel=1");

            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('sub_service_edit/',$ssm_id,'refresh');
            }else{
                $update_data=[
                    'ssm_id'                 =>$ssm_id,
                    'ssm_sumid'              => clean_input($this->input->post('ssm_sumid')),
                    'ssm_name'               => string_ucword(clean_input($this->input->post('ssm_name'))),
                
                    'ssm_loginid'           =>$this->login_id,
                    'ssm_changetype'       	=>'Modified',
                    'ssm_systemdate'       	=>system_date(),
                    'ssm_systemip'         	=>get_ip(),
                    'ssm_systemname'       	=>$this->system_name, 
                ];
            
                $response=data_update('sub_servicemst','ssm_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Sub Service Updated Successfully.");
                    redirect('sub_service_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('sub_service_edit/',$ssm_id,'refresh');
                }
            }
       
       }
    }
    function sub_service_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $ssm_id=clean_input($this->input->post('id'));
        $active_data=[
			'ssm_id'                =>$ssm_id, 

			'ssm_status'			=>1,
            'ssm_loginid'           =>$this->login_id,
            'ssm_changetype'       	=>'Activated',
            'ssm_systemdate'       	=>system_date(),
            'ssm_systemip'         	=>get_ip(),
            'ssm_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('sub_servicemst', 'ssm_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function sub_service_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $ssm_id=clean_input($this->input->post('id'));
        $inactive_data=[
			'ssm_id'                =>$ssm_id, 

			'ssm_status'			=>2,
            'ssm_loginid'           =>$this->login_id,
            'ssm_changetype'       	=>'Inactivated',
            'ssm_systemdate'       	=>system_date(),
            'ssm_systemip'         	=>get_ip(),
            'ssm_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('sub_servicemst', 'ssm_id',$inactive_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function sub_service_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $ssm_id=clean_input($this->input->post('id'));
        
        $delete_data=[

            'ssm_id'                =>$ssm_id, 

			'ssm_cancel'			=>2,
            'ssm_loginid'           =>$this->login_id,
            'ssm_changetype'       	=>'deleted',
            'ssm_systemdate'       	=>system_date(),
            'ssm_systemip'         	=>get_ip(),
            'ssm_systemname'       	=>$this->system_name, 
              
          ];
        $response= data_update('sub_servicemst','ssm_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }


    /***************CAST ******************** */
	function cast_list(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        //filter
        $cam_religionid ='';
        if($this->input->method() == 'get'){
           $cam_religionid =$this->input->get('r');
        }
        if(!empty($cam_religionid)){
            $total_rows=total_record('caste_mst','cam_cancel=1 AND cam_religionid='.$cam_religionid);
        }else{
            $total_rows=total_record('caste_mst','cam_cancel=1');
        }
        $page_data['cam_religionid']=$cam_religionid;

		$config =[
            'base_url'=>base_url('cast_list'),
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

	  
		$page_data['cast_data']=$this->postcategory->get_cast('',$config['per_page'],$page,$cam_religionid)->result();
        $page_data['common_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();

		$page_data['title']='Caste List';
        $page_data['page_name']='post_category/cast_list';
        $this->load->view('backend/index',$page_data);
	}
	function cast_form(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['common_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
		$page_data['title']='Caste Add';
        $page_data['page_name']='post_category/cast_form';
        $this->load->view('backend/index',$page_data);
	}
    function cast_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $this->form_validation->set_rules('cam_religionid','Religion','trim|required');
        $this->form_validation->set_rules('cam_castename','Caste','trim|required|is_unique[caste_mst.cam_castename]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }
            $page_data['common_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
            $page_data['title']='Caste Add';
            $page_data['page_name']='post_category/cast_form';
            $this->load->view('backend/index',$page_data);
        }else{
           $cam_id =get_pk_id('caste_mst','cam_id');
           $insert_data=[
               'cam_id'                 =>$cam_id,
               'cam_religionid'         => clean_input($this->input->post('cam_religionid')),
               'cam_castename'          => string_ucword(clean_input($this->input->post('cam_castename'))),
               
               'cam_loginid'            =>$this->login_id,
               'cam_changetype'         =>'Created',
               'cam_systemdate'         =>system_date(),
               'cam_systemip'           =>get_ip(),
               'cam_systemname'         => $this->system_name
           ];
           
            $response=data_insert('caste_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Caste Created Successfully.");
                redirect('cast_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('cast_form','refresh');
            }
       
       }
    }
    function cast_edit($cam_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['cast_data']=$this->postcategory->get_cast($cam_id)->row();
        $page_data['common_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();

		$page_data['title']='Caste Edit';
        $page_data['page_name']='post_category/cast_edit';
        $this->load->view('backend/index',$page_data);
    }
    function cast_update($cam_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
       	$this->form_validation->set_rules('cam_religionid','Religion','trim|required');
       	$this->form_validation->set_rules('cam_castename','Caste','trim|required');

       	$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
       	if($this->form_validation->run() == FALSE){
           	if(!$this->session->userdata('userlogin')){
                redirect('home');
           	}
           $page_data['cast_data']=$this->postcategory->get_cast($cam_id)->row();
           $page_data['common_type']=get_table_data('com_mst','COM_CMCD,COM_TPCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
           $page_data['title']='Caste Edit';
           $page_data['page_name']='post_category/cast_edit';
           $this->load->view('backend/index',$page_data);
        }else{
            $cam_religionid=clean_input($this->input->post('cam_religionid'));
            $cam_castename=string_ucword(clean_input($this->input->post('cam_castename')));
            $is_uniq=check_uniq_value('caste_mst','cam_castename',$cam_castename,"cam_cancel=1 AND cam_religionid=$cam_religionid AND cam_id != $cam_id");  
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('cast_edit/'.$cam_id,'refresh');
            }else{
                $update_data=[
                    'cam_id'                  =>$cam_id,
                    'cam_religionid'          => clean_input($this->input->post('cam_religionid')),
                    'cam_castename'           => string_ucword(clean_input($this->input->post('cam_castename'))),
                    
                    'cam_loginid'            =>$this->login_id,
                    'cam_changetype'         =>'Modified',
                    'cam_systemdate'         =>system_date(),
                    'cam_systemip'           =>get_ip(),
                    'cam_systemname'         => $this->system_name
                
                ];         
                $response=data_update('caste_mst','cam_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Caste Updated Successfully.");
                    redirect('cast_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('cast_edit/'.$cam_id,'refresh');
                }
            }
        }
    }
    function cast_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $cam_id=clean_input($this->input->post('id'));
        
        $delete_data=[
            'cam_id'                 =>$cam_id,

            'cam_loginid'            =>$this->login_id,
            'cam_cancel'             =>2,
            'cam_changetype'         =>'Deleted',
            'cam_systemdate'         =>system_date(),
            'cam_systemip'           =>get_ip(),
            'cam_systemname'         => $this->system_name
          ];
        $response= data_update('caste_mst','cam_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function cast_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $cam_id=clean_input($this->input->post('id'));
        $active_data=[
            'cam_id'                 =>$cam_id,

			'cam_status'			=>1,
            'cam_loginid'           =>$this->login_id,
            'cam_changetype'       	=>'Activated',
            'cam_systemdate'       	=>system_date(),
            'cam_systemip'         	=>get_ip(),
            'cam_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('caste_mst', 'cam_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function cast_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $cam_id=clean_input($this->input->post('id'));
        $active_data=[
            'cam_id'                 =>$cam_id,

			'cam_status'			=>2,
            'cam_loginid'           =>$this->login_id,
            'cam_changetype'       	=>'Inactivated',
            'cam_systemdate'       	=>system_date(),
            'cam_systemip'         	=>get_ip(),
            'cam_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('caste_mst', 'cam_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }

    
    /*************** SUB CAST ******************** */
    function sub_cast_list(){ 
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
            
        $page_data['sub_cast_data']=$this->postcategory->get_sub_cast()->result();
        $page_data['religion_data']=get_table_data('com_mst','COM_CMCD,COM_TPCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();

        $page_data['title']='Sub Caste List';
        $page_data['page_name']='post_category/sub_cast_list';
        $this->load->view('backend/index',$page_data);
    }
    function sub_cast_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
 
        $page_data['religion_data']=get_table_data('com_mst','COM_CMCD,COM_TPCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
		$page_data['title']='Sub Caste Add';
        $page_data['page_name']='post_category/sub_cast_form';
        $this->load->view('backend/index',$page_data);
    }
    function sub_cast_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $this->form_validation->set_rules('sum_regid','Religion','trim|required');
        $this->form_validation->set_rules('sum_castid','Caste','trim|required');
        $this->form_validation->set_rules('sum_name','Sub Caste Name','trim|required|is_unique[subcaste_mst.sum_name]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }
            $page_data['religion_data']=get_table_data('com_mst','COM_CMCD,COM_TPCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
            $page_data['title']='Sub Caste Add';
            $page_data['page_name']='post_category/sub_cast_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $sum_id =get_pk_id('subcaste_mst','sum_id');
            $insert_data=[
               'sum_id'                  =>$sum_id,
               'sum_regid'               => clean_input($this->input->post('sum_regid')),
               'sum_castid'              => clean_input($this->input->post('sum_castid')),
               'sum_name'                => string_ucword(clean_input($this->input->post('sum_name'))),
               
               'sum_loginid'            =>$this->login_id,
               'sum_changetype'         =>'Created',
               'sum_systemdate'         =>system_date(),
               'sum_systemip'           =>get_ip(),
               'sum_systemname'         =>$this->system_name,
            ];

            $response=data_insert('subcaste_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Sub Caste Created Successfully.");
                redirect('sub_cast_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('sub_cast_form','refresh');
            }
        }
 	   
    }
    function sub_cast_edit($sum_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        
        $page_data['sub_cast_data']=$this->postcategory->get_sub_cast($sum_id)->row();
        $page_data['religion_data']=get_table_data('com_mst','COM_CMCD,COM_TPCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
       
		$page_data['title']='Sub Caste Edit';
        $page_data['page_name']='post_category/sub_cast_edit';
        $this->load->view('backend/index',$page_data);

    }
    function sub_cast_update($sum_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $this->form_validation->set_rules('sum_regid','Religion','trim|required');
        $this->form_validation->set_rules('sum_castid','Caste','trim|required');
        $this->form_validation->set_rules('sum_name','Sub Caste Name','trim|required');
 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }
            $page_data['sub_cast_data']=$this->postcategory->get_sub_cast($sum_id)->row();
            $page_data['religion_data']=get_table_data('com_mst','COM_CMCD,COM_TPCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=8 ORDER BY COM_CMNM")->result();
           
            $page_data['title']='Sub Caste Edit';
            $page_data['page_name']='post_category/sub_cast_edit';
            $this->load->view('backend/index',$page_data);
          
        }else{

            $sum_regid=clean_input($this->input->post('sum_regid'));
            $sum_castid=clean_input($this->input->post('sum_castid'));
            $sum_name=string_ucword(clean_input($this->input->post('sum_name')));
            $is_uniq=check_uniq_value('subcaste_mst','sum_name', $sum_name,"sum_regid=$sum_regid AND sum_castid=$sum_castid AND sum_cancel=1 AND sum_id !=$sum_id");
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('sub_cast_edit/'.$sum_id,'refresh');
            }else{

                $update_data=[
                    'sum_id'                 =>$sum_id,
                    'sum_regid'              => clean_input($this->input->post('sum_regid')),
                    'sum_castid'             => clean_input($this->input->post('sum_castid')),
                    'sum_name'               => string_ucword(clean_input($this->input->post('sum_name'))),
                    
                    
                    'sum_loginid'            =>$this->login_id,
                    'sum_changetype'         =>'Modified',
                    'sum_systemdate'         =>system_date(),
                    'sum_systemip'           =>get_ip(),
                    'sum_systemname'         =>$this->system_name,
                ];
             
                $response=data_update('subcaste_mst','sum_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Sub Caste Updated Successfully.");
                    redirect('sub_cast_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('sub_cast_edit/'.$sum_id,'refresh');
                }
            }
        
        }
    }
    function sub_cast_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $sum_id=clean_input($this->input->post('id'));
        $active_data=[
            'sum_id'                 =>$sum_id,

			'sum_status'			=>1,
            'sum_loginid'           =>$this->login_id,
            'sum_changetype'       	=>'Activated',
            'sum_systemdate'       	=>system_date(),
            'sum_systemip'         	=>get_ip(),
            'sum_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('subcaste_mst', 'sum_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function sub_cast_Inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $sum_id=clean_input($this->input->post('id'));
        $active_data=[
            'sum_id'                 =>$sum_id,

			'sum_status'			=>2,
            'sum_loginid'           =>$this->login_id,
            'sum_changetype'       	=>'Inactivated',
            'sum_systemdate'       	=>system_date(),
            'sum_systemip'         	=>get_ip(),
            'sum_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('subcaste_mst', 'sum_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function sub_cast_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $sum_id=clean_input($this->input->post('id'));
        $active_data=[
            'sum_id'                 =>$sum_id,

            'sum_loginid'           =>$this->login_id,
            'sum_cancel'            =>2,           
            'sum_changetype'       	=>'Deleted',
            'sum_systemdate'       	=>system_date(),
            'sum_systemip'         	=>get_ip(),
            'sum_systemname'       	=>$this->system_name, 
        ];
        $response= data_update('subcaste_mst', 'sum_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }



    /***************brand ******************** */
    function brand_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        /*** Pagination Code Start */
        $uri_segment=2;
        $total_rows =total_record('brand_mst','brand_cancel=1'); 
        $per_page_item=15;
        $url=base_url('brand_list');//.'/'.$this->uri->segment(2);
        $page =$this->uri->segment(2,0);    
        
        $config=pagintaion($total_rows, $per_page_item,$url,$uri_segment); 
        $this->pagination->initialize($config);	    
        $page_data['links']=$this->pagination->create_links();
        /** Pagination Code StarCloset */

        $page_data['brand_data']=$this->postcategory->get_brand('',$per_page_item,$page)->result();
        $page_data['title']='Brand List';
        $page_data['page_name']='post_category/brand_list';
        $this->load->view('backend/index',$page_data);
    }
    function brand_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 

        $page_data['title']='Brand Add';
        $page_data['page_name']='post_category/brand_form';
        $this->load->view('backend/index',$page_data);
    }
    function brand_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $this->form_validation->set_rules('brand_name','Brand','trim|required|is_unique[brand_mst.brand_name]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }
            $page_data['title']='Brand Add';
            $page_data['page_name']='post_category/brand_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $brand_id =get_pk_id('brand_mst','brand_id');
            $insert_data=[
                'brand_id'          =>$brand_id,
                'brand_name'         =>string_upper(clean_input($this->input->post('brand_name'))),
                
                'brand_loginid'      =>$this->login_id,
                'brand_changetype'   =>'Created',
                'brand_systemdate'   =>system_date(),
                'brand_systemip'     =>get_ip(),
                'brand_systemname'   =>$this->system_name
            ];
           
            $response=data_insert('brand_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Brand Created Successfully.");
                redirect('brand_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('brand_form/','refresh');
            }
        
        }
    }
    function brand_edit($brand_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['brand_data']=$this->postcategory->get_brand($brand_id)->row();
        $page_data['menu_active']='brand_list';
        $page_data['title']=' Brand Edit';
        $page_data['page_name']='post_category/brand_edit';
        $this->load->view('backend/index',$page_data);
    }
    function brand_update($brand_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('brand_name','Brand Name','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            } 
            $page_data['brand_data']=$this->postcategory->get_brand($brand_id)->row();
            $page_data['title']='Brand Edit';
            $page_data['page_name']='post_category/brand_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $brand_name=string_upper(clean_input($this->input->post('brand_name')));
            $is_uniq=check_uniq_value('brand_mst','brand_name', $brand_name,"brand_id !=$brand_id AND brand_cancel=1");

            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('brand_edit/'.$brand_id,'refresh');
            }else{
                
                $update_data=[
                    'brand_id'           =>$brand_id,
                    'brand_name'         =>string_upper(clean_input($this->input->post('brand_name'))),

                    'brand_loginid'      =>$this->login_id,
                    'brand_changetype'   =>'Modified',
                    'brand_systemdate'   =>system_date(),
                    'brand_systemip'     =>get_ip(),
                    'brand_systemname'   =>$this->system_name
                ];
            
                $response=data_update('brand_mst','brand_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Brand Updated Successfully.");
                    redirect('brand_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('brand_edit/'.$brand_id,'refresh');
                }
            }
            
        }
        
    }
    function brand_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $brand_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'brand_id'       =>$brand_id,
             
            'brand_loginid'      =>$this->login_id,
            'brand_cancel'       =>2,
            'brand_changetype'   =>'Deleted',
            'brand_systemdate'   =>system_date(),
            'brand_systemip'     =>get_ip(),
            'brand_systemname'   =>$this->system_name

          ];
        $response= data_update('brand_mst','brand_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function brand_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $brand_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'brand_id'       =>$brand_id,
             
            'brand_loginid'      =>$this->login_id,
            'brand_status'       =>1,
            'brand_changetype'   =>'Active',
            'brand_systemdate'   =>system_date(),
            'brand_systemip'     =>get_ip(),
            'brand_systemname'   =>$this->system_name

          ];
        $response= data_update('brand_mst','brand_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function brand_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $brand_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'brand_id'       =>$brand_id,
             
            'brand_loginid'      =>$this->login_id,
            'brand_status'       =>2,
            'brand_changetype'   =>'Inactive',
            'brand_systemdate'   =>system_date(),
            'brand_systemip'     =>get_ip(),
            'brand_systemname'   =>$this->system_name

          ];
        $response= data_update('brand_mst','brand_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }

    /****************Model ***********************************/
    function model_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        //filter
        $model_brandid ='';
        if($this->input->method() == 'get'){
           $model_brandid =$this->input->get('b');
        }
        if(!empty($model_brandid)){
            $total_rows=total_record('model_mst','model_cancel=1 AND model_brandid='.$model_brandid);
        }else{
            $total_rows=total_record('model_mst','model_cancel=1');
        }
        $page_data['model_brandid']=$model_brandid;

        $config =[
            'base_url'=>base_url('model_list'),
            'per_page'=>'100',
            'total_rows'=>$total_rows,
            // coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
        $config['uri_segment'] =2;
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

        $page_data['model_data']=$this->postcategory->get_model('',$config['per_page'],$page,$model_brandid)->result();
        $page_data['brand_name_data']=get_table_data('brand_mst','brand_id,brand_name,brand_sumid',"brand_cancel=1  ORDER BY brand_name")->result();
        $page_data['title']='Model List';
        $page_data['page_name']='post_category/model_list';
        $this->load->view('backend/index',$page_data);
    }
    function model_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['brand_name']=get_table_data('brand_mst','brand_id,brand_name',"brand_cancel=1  ORDER BY brand_name")->result();

        $page_data['title']='Model Add';
        $page_data['page_name']='post_category/model_form';
        $this->load->view('backend/index',$page_data);
    }
    function model_add(){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
       }  
       $this->form_validation->set_rules('model_brandid','Brand name','trim|required');
       $this->form_validation->set_rules('model_name','Modal Name ','trim|required|is_unique[model_mst.model_name]');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
       if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }
           $page_data['brand_name']=get_table_data('brand_mst','brand_id,brand_name',"brand_cancel=1  ORDER BY brand_name")->result();
           $page_data['title']='Model Add';
           $page_data['page_name']='post_category/model_form';
           $this->load->view('backend/index',$page_data);
       }else{
           $model_id =get_pk_id('model_mst','model_id');
           $insert_data=[
               'model_id'                     =>$model_id,
               'model_brandid'                =>clean_input($this->input->post('model_brandid')),
               'model_name'                   =>string_ucword(clean_input($this->input->post('model_name'))),
               
               'model_loginid'                =>$this->login_id,
               'model_changetype'             =>'Created',
               'model_systemdate'             =>system_date(),
               'model_systemip'               =>get_ip(),
               'model_systemname'             =>$this->system_name,
           ];

            $response=data_insert('model_mst',$insert_data);
            if($response){
               $this->session->set_flashdata('msg',"Model Created Successfully.");
               redirect('model_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('model_form/','refresh');
            }
       
       }
    }
    function model_edit($model_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['model_data']=$this->postcategory->get_model($model_id)->row();
        $page_data['brand_name']=get_table_data('brand_mst','brand_id,brand_name',"brand_cancel=1 ORDER BY brand_name")->result();
        $page_data['title']='Model Edit';
        $page_data['page_name']='post_category/model_edit';
        $this->load->view('backend/index',$page_data);
    }
    function model_update($model_id){
        if(!$this->session->userdata('userlogin')){
            redirect('home');
       }  
       $this->form_validation->set_rules('model_brandid','Brand name','trim|required');
       $this->form_validation->set_rules('model_name','Modal Name ','trim|required');

       $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
       if($this->form_validation->run() == FALSE){
           if(!$this->session->userdata('userlogin')){
                redirect('home');
           }
           $page_data['model_data']=$this->postcategory->get_model($model_id)->row();
           $page_data['brand_name']=get_table_data('brand_mst','brand_id,brand_name',"brand_cancel=1 ORDER BY brand_name")->result();
  
           $page_data['title']='Model Edit';
           $page_data['page_name']='post_category/model_edit';
           $this->load->view('backend/index',$page_data);
        }else{
            $brand_id=clean_input($this->input->post('model_brandid'));
            $model_name=string_ucword(clean_input($this->input->post('model_name')));
            $is_uniq=check_uniq_value('model_mst','model_name', $model_name,"model_brandid=$brand_id AND model_id !=$model_id AND model_cancel=1");
            
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('model_edit/'.$model_id,'refresh');
            }else{
                $update_data=[
                'model_id'                     =>$model_id,
                'model_brandid'                =>clean_input($this->input->post('model_brandid')),
                'model_name'                   =>string_ucword(clean_input($this->input->post('model_name'))),
                
                'model_loginid'                =>$this->login_id,
                'model_changetype'             =>'Modified',
                'model_systemdate'             =>system_date(),
                'model_systemip'               =>get_ip(),
                'model_systemname'             =>$this->system_name,
                ];
            
                $response=data_update('model_mst','model_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Model Updated Successfully.");
                    redirect('model_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('model_edit/'.$model_id,'refresh');
                }
            }
        }
    }
    function model_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $model_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'model_id'                     =>$model_id,
             
            'model_loginid'                =>$this->login_id,
            'model_cancel'                 =>2,
            'model_changetype'             =>'Deleted',
            'model_systemdate'             =>system_date(),
            'model_systemip'               =>get_ip(),
            'model_systemname'             =>$this->system_name,

          ];
        $response= data_update('model_mst','model_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    
    }
    function model_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $model_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'model_id'                     =>$model_id,
             
            'model_loginid'                =>$this->login_id,
            'model_status'                 =>1,
            'model_changetype'             =>'Active',
            'model_systemdate'             =>system_date(),
            'model_systemip'               =>get_ip(),
            'model_systemname'             =>$this->system_name,

          ];
        $response= data_update('model_mst','model_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    
    }
    function model_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $model_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'model_id'                     =>$model_id,
             
            'model_loginid'                =>$this->login_id,
            'model_status'                 =>2,
            'model_changetype'             =>'Inactive',
            'model_systemdate'             =>system_date(),
            'model_systemip'               =>get_ip(),
            'model_systemname'             =>$this->system_name,

          ];
        $response= data_update('model_mst','model_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    
    }

    /****************Subourse ***********************************/
    function course_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
      
        //filter
        $esm_courseid ='';
        if($this->input->method() == 'get'){
            $esm_courseid =$this->input->get('c');
        }
        if(!empty($esm_courseid)){
           $total_rows=total_record('education_subcourse_mst','esm_cancel=1 AND esm_courseid='.$esm_courseid);
        }else{
            $total_rows=total_record('education_subcourse_mst','esm_cancel=1');
        }
        $page_data['esm_courseid']=$esm_courseid;

		$config =[
            'base_url'=>base_url('course_list'),
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

        $page_data['corse_list_data']=$this->postcategory->get_sub_course('',$config['per_page'],$page,$esm_courseid)->result();
        $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"  sum_cancel=1  AND sum_categoryid=15  ORDER BY sum_subcategory")->result();
        $page_data['title']='Sub Course List';
        $page_data['page_name']='post_category/course_list';
        $this->load->view('backend/index',$page_data);
    }
    function course_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"  sum_cancel=1  AND sum_categoryid=15  ORDER BY sum_subcategory")->result();
        $page_data['title']='Sub Course Add';
        $page_data['page_name']='post_category/course_form';
        $this->load->view('backend/index',$page_data);
    }
    function course_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('esm_courseid',' Class Name','trim|required');
        $this->form_validation->set_rules('esm_course','Sub Course Name ','trim|required|is_unique[education_subcourse_mst.esm_course]');
 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            } 
            $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"  sum_cancel=1  AND sum_categoryid=15  ORDER BY sum_subcategory")->result();
            $page_data['title']='Sub Course Add';
            $page_data['page_name']='post_category/course_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $esm_id=get_pk_id('education_subcourse_mst','esm_id');
            $insert_data=[
                'esm_id'          =>$esm_id,
                'esm_courseid'    =>clean_input($this->input->post('esm_courseid')),
                'esm_course'      =>string_ucword(clean_input($this->input->post('esm_course'))),

                'esm_loginid'     =>$this->login_id,
                'esm_changetype'  =>'Created',
                'esm_systemdate'  =>system_date(),
                'esm_systemip'    =>get_ip(),
                'esm_systemname'  =>$this->system_name,

            ];
          
            $response=data_insert('education_subcourse_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Sub Course  Created Successfully.");
                redirect('course_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('course_form','refresh');
            }
        }
    }
    function course_edit($esm_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }          
        $page_data['corse_list_data']=$this->postcategory->get_sub_course($esm_id)->row(); 
        $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"  sum_cancel=1  AND sum_categoryid=15  ORDER BY sum_subcategory")->result();

        $page_data['title']='Sub Course Edit';
        $page_data['page_name']='post_category/course_edit';
        $this->load->view('backend/index',$page_data);
    }
    function course_update($esm_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('esm_courseid',' Class Name','trim|required');
        $this->form_validation->set_rules('esm_course','Sub Course Name ','trim|required');
 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            } 
            $page_data['corse_list_data']=$this->postcategory->get_sub_course($esm_id)->row();
            $page_data['sub_category_data']=get_table_data('subcategory_mst','sum_id,sum_subcategory',"  sum_cancel=1  AND sum_categoryid=15  ORDER BY sum_subcategory")->result();
            $page_data['title']='Sub Course Edit';
            $page_data['page_name']='post_category/course_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $esm_courseid=clean_input($this->input->post('esm_courseid'));
            $esm_course=string_ucword(clean_input($this->input->post('esm_course')));
            $is_uniq=check_uniq_value('education_subcourse_mst','esm_course', $esm_course,"esm_courseid=$esm_courseid AND esm_id !=$esm_id AND esm_cancel=1");
 
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('course_edit/'.$esm_id,'refresh');
            }else{

                $insert_data=[
                    'esm_id'          =>$esm_id,
                    'esm_courseid'    =>clean_input($this->input->post('esm_courseid')),
                    'esm_course'      =>string_ucword(clean_input($this->input->post('esm_course'))),

                    'esm_loginid'     =>$this->login_id,
                    'esm_changetype'  =>'Modified',
                    'esm_systemdate'  =>system_date(),
                    'esm_systemip'    =>get_ip(),
                    'esm_systemname'  =>$this->system_name,
                ];
            
                $response=data_update('education_subcourse_mst','esm_id',$insert_data);
                if($response){
                    $this->session->set_flashdata('msg',"Sub Course Updated Successfully.");
                    redirect('course_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('course_edit/'.$esm_id,'refresh');
                }
            }
        }
    }
    function course_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $esm_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'esm_id'          =>$esm_id,
             
            'esm_loginid'     =>$this->login_id,
            'esm_status'	  =>1,
            'esm_changetype'  =>'Activated',
            'esm_systemdate'  =>system_date(),
            'esm_systemip'    =>get_ip(),
            'esm_systemname'  =>$this->system_name,
  
          ];
        $response= data_update('education_subcourse_mst','esm_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function course_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $esm_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'esm_id'                 =>$esm_id,
             
            'esm_loginid'     =>$this->login_id,
            'esm_status'	  =>2,
            'esm_changetype'  =>'Inactivated',
            'esm_systemdate'  =>system_date(),
            'esm_systemip'    =>get_ip(),
            'esm_systemname'  =>$this->system_name,
  
          ];
        $response= data_update('education_subcourse_mst','esm_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function course_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $esm_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'esm_id'          =>$esm_id,
             
            'esm_loginid'     =>$this->login_id,
            'esm_cancel'      =>2,
            'esm_changetype'  =>'Deleted',
            'esm_systemdate'  =>system_date(),
            'esm_systemip'    =>get_ip(),
            'esm_systemname'  =>$this->system_name,
  
          ];
        $response= data_update('education_subcourse_mst','esm_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    /**Subject */
    function subject_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        
        $config =[
            'base_url'=>base_url('subject_list'),
            'per_page'=>'100',
            'total_rows'=>total_record('subject_mst','subject_cancel=1'),
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

        $page_data['subject_data']=$this->postcategory->get_subject_data('',$config['per_page'],$page)->result();
        $page_data['title']='Subject List';
        $page_data['page_name']='post_category/subject_list';
        $this->load->view('backend/index',$page_data);
    }
    function subject_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
         $page_data['title']='Subject Add';
        $page_data['page_name']='post_category/subject_form';
        $this->load->view('backend/index',$page_data);
    }

    function subject_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('subject_name',' Subject Name','trim|required|is_unique[subject_mst.subject_name]');
  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            } 
        
            $page_data['title']='Subject Add';
            $page_data['page_name']='post_category/subject_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $subject_id=get_pk_id('subject_mst','subject_id');
            $insert_data=[
                'subject_id'          =>$subject_id,
                'subject_name'        =>string_ucword(clean_input($this->input->post('subject_name'))),
                
                'subject_loginid'     =>$this->login_id,
                'subject_changetype'  =>'Created',
                'subject_systemdate'  =>system_date(),
                'subject_systemip'    =>get_ip(),
                'subject_systemname'  =>$this->system_name,

            ];
            
            $response=data_insert('subject_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Subject Created Successfully.");
                redirect('subject_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('subject_form','refresh');
            }
        }
    }
    function subject_edit($subject_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['subject_data']=$this->postcategory->get_subject_data($subject_id)->row();
        $page_data['title']='Subject Edit';
        $page_data['page_name']='post_category/subject_edit';
        $this->load->view('backend/index',$page_data);
    }

    function subject_update($subject_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('subject_name',' Subject Name','trim|required');
  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('home');
            }             
            $page_data['subject_data']=$this->postcategory->get_subject_data($subject_id)->row();
            $page_data['title']='Subject Edit';
            $page_data['page_name']='post_category/subject_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $subject_name=string_ucword(clean_input($this->input->post('subject_name')));
            $is_uniq=check_uniq_value('subject_mst','subject_name',$subject_name, "subject_id !=$subject_id AND subject_cancel=1");
 
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('subject_edit/'.$subject_id,'refresh');
            }else{            
                $update_data=[
                    'subject_id'          =>$subject_id,
                    'subject_name'        =>string_ucword(clean_input($this->input->post('subject_name'))),
                    
                    'subject_loginid'     =>$this->login_id,
                    'subject_changetype'  =>'Updated',
                    'subject_systemdate'  =>system_date(),
                    'subject_systemip'    =>get_ip(),
                    'subject_systemname'  =>$this->system_name,
                ];
             
                $response=data_update('subject_mst','subject_id',$update_data);
                if($response){
                    $this->session->set_flashdata('msg',"Subject Updated Successfully.");
                    redirect('subject_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('subject_edit/'.$subject_id,'refresh');
                }
            }
        }
    }
    function subject_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $subject_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'subject_id'          =>$subject_id,
                 
            'subject_loginid'     =>$this->login_id,
            'subject_status'      =>1,
            'subject_changetype'  =>'Activated',
            'subject_systemdate'  =>system_date(),
            'subject_systemip'    =>get_ip(),
            'subject_systemname'  =>$this->system_name,
  
          ];
        $response= data_update('subject_mst','subject_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function subject_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $subject_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'subject_id'          =>$subject_id,
                 
            'subject_loginid'     =>$this->login_id,
            'subject_status'      =>2,
            'subject_changetype'  =>'Inactivated',
            'subject_systemdate'  =>system_date(),
            'subject_systemip'    =>get_ip(),
            'subject_systemname'  =>$this->system_name,
  
          ];
        $response= data_update('subject_mst','subject_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function subject_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $subject_id=clean_input($this->input->post('id'));
        
        $delete_data=[  
            'subject_id'          =>$subject_id,
                 
            'subject_loginid'     =>$this->login_id,
            'subject_cancel'      =>2,
            'subject_changetype'  =>'Deleted',
            'subject_systemdate'  =>system_date(),
            'subject_systemip'    =>get_ip(),
            'subject_systemname'  =>$this->system_name,
  
          ];
        $response= data_update('subject_mst','subject_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }




}