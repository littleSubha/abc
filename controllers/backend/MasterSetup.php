<?php
if(!defined('BASEPATH')) exit('No direct script access allowed!.');

class MasterSetup extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->user_role=$this->session->userdata('user_role');
        $this->system_name=gethostname();
		$this->load->model('backend/MasterSetupModel','master',TRUE);
        $this->load->model('CommonModel','common',TRUE);
	}
	function index(){
		$this->service_type_list();
	}
	function service_type_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
		$page_data['servicetype_data']=$this->master->service_type_list()->result();
		$page_data['title']='Service Type List';
        $page_data['page_name']='master_setup/service_type_list';
        $this->load->view('backend/index',$page_data);
	}
	function service_type_edit($id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 

		$page_data['servicetype_data']=$this->master->service_type_list($id)->row();
		$page_data['title']='Service Type Edit';
        $page_data['page_name']='master_setup/service_type_edit';
        $this->load->view('backend/index',$page_data);
	}
	function service_type_update($id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        
		$this->form_validation->set_rules('service_name','Service Name','trim|required');
		$this->form_validation->set_rules('display_order','Display Order','trim|required');
		$this->form_validation->set_rules('join_single_amount','Single Post Amount (INR)','trim|required');
		$this->form_validation->set_rules('join_single_duration','Single Post Duration (In Days)','trim|required');
		if($id !=1){
            $this->form_validation->set_rules('join_multiple_amount','Multiple  Post Amount (INR)','trim|required');
            $this->form_validation->set_rules('join_multiple_duration','Multiple  Post Duration (In Days)','trim|required');
            $this->form_validation->set_rules('renew_multiple_amount','Multiple  Post Amount (INR)','trim|required');
		    $this->form_validation->set_rules('renew_multiple_duration','Multiple  Post Duration (In Days)','trim|required');
        }
		$this->form_validation->set_rules('renew_single_amount','Single Post Amount (INR)','trim|required');
		$this->form_validation->set_rules('renew_single_duration','Single Post Duration (In Days)','trim|required');
		
		$this->form_validation->set_rules('gst','GST (%)','trim|required');
		//$this->form_validation->set_rules('single_image_limit','Single Post Image Limit','trim|required');
		//$this->form_validation->set_rules('multiple_image_limit','Multiple Post image Limit','trim|required');
		

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
        	$page_data['servicetype_data']=$this->master->service_type_list($id)->row();
			$page_data['title']='Service Type Edit';
        	$page_data['page_name']='master_setup/service_type_edit';
        	$this->load->view('backend/index',$page_data);
        }else{
        	/** check service type */
  			$service_name=string_ucword(clean_input($this->input->post('service_name')));
  			$count =check_uniq_value('service_type','service_name', $service_name,"id<>$id AND cancel=1");
            if($count > 0){
                $this->session->set_flashdata('error','Service Name Already Exist! Please Change Service Name');
                redirect('service_type_edit/'.$id,'refresh');
                exit;
            }

        	/** check display order */
	        $order=$this->input->post('display_order');
	        $old_banner_order=$this->input->post('old_display_order');
	        if($order != $old_banner_order){
	            $count =check_uniq_value('service_type','display_order', $order);
	            if($count >0){
	                $this->session->set_flashdata('error','Display Order Already Exist! Please Change Order');
	                redirect('service_type_edit/'.$id,'refresh');
	                exit;
	            }
	        }
	       
	        $update_data=[
	            'id'                		=>$id, 
	            'service_name'             	=>string_ucword(clean_input($this->input->post('service_name'))), 
  				'display_order'             =>clean_input($this->input->post('display_order')), 
  				'join_single_amount'        =>clean_input($this->input->post('join_single_amount')), 
  				'join_single_duration'      =>clean_input($this->input->post('join_single_duration')), 
  				'join_multiple_amount'      =>clean_input($this->input->post('join_multiple_amount')), 
  				'join_multiple_duration'    =>clean_input($this->input->post('join_multiple_duration')), 
  				'renew_single_amount'       =>clean_input($this->input->post('renew_single_amount')), 
  				'renew_single_duration'     =>clean_input($this->input->post('renew_single_duration')), 
  				'renew_multiple_amount'		=>clean_input($this->input->post('renew_multiple_amount')), 
  				'renew_multiple_duration'	=>clean_input($this->input->post('renew_multiple_duration')), 
  				'gst'            			=>clean_input($this->input->post('gst')), 
  				'single_image_limit'        =>clean_input($this->input->post('single_image_limit')), 
  				'multiple_image_limit'      =>clean_input($this->input->post('multiple_image_limit')), 

  				'status'					=>1,
  				'cancel'					=>1,
	            'loginid'          			=>$this->login_id,
	            'changetype'       			=>'Modified',
	            'systemdate'       			=>system_date(),
	            'systemip'         			=>get_ip(),
	            'systemname'       			=>$this->system_name,
	        ];
	       
	        $response=data_update('service_type','id',$update_data);  
	        if($response){
	            $this->session->set_flashdata('msg',"Service Type Updated Successfully.");
	            redirect('service_type_list','refresh');
	        }else{
	            $this->session->set_flashdata('error',"Oops!. Error Occurred.");
	            redirect('service_type_edit/'.$id,'refresh');
	        }
			
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
 
 
    /**=================== Category & Subcategory Close ==============**/
	function categories($service_type,$action,$cat_id=null){
        
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        if($service_type == 1){
            $service="Matrimony";
        }elseif($service_type == 2){
            $service="Job";
        }elseif($service_type == 3){
            $service="Service";
        }elseif($service_type == 4){
            $service="Product";
        }elseif($service_type == 5){
            $service="Education";
        }elseif($service_type == 6){
            $service="Hotel";
        }elseif($service_type == 7){
            $service="Property";
        }elseif($service_type == 8){
            $service="Re-Sale";
        }
        $page_data['service_type'] =$service_type;
        $page_data['action'] =$action;

        /*
        $total_rows=total_record('categories_mst','cancel=1 AND status=1');
        $config =[
            'base_url'=>base_url('categories/'.$service_type.'/list'),
            'per_page'=>'15',
            'total_rows'=>$total_rows,
            //coustum style
            'next_link'=>  'Next',
            'prev_link'=>  'Prev',
        ];
        */
        /* This Application Must Be Used With BootStrap 3 *  */
        /*
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
        */
		if($action == 'list'){
			$page_data['category_data']=$this->master->get_category_data($service_type)->result();
			$page_data['title']=$service.'   Category List';
	        $page_data['page_name']='master_setup/category_list';
	        $this->load->view('backend/index',$page_data);
		}

		if($action == 'add'){
			$page_data['service_types']=get_table_data('service_type','service_name,id',"status=1 AND cancel=1 AND id=$service_type ORDER BY service_name")->result();
 			$page_data['title']=$service.' Category Add';
        	$page_data['page_name']='master_setup/category_form';
        	$this->load->view('backend/index',$page_data);
		}

		if($action == 'save'){
			$this->form_validation->set_rules('service_type','Service Type','trim|required|is_unique[categories_mst.service_type]');
	        $this->form_validation->set_rules('category','Category','trim|required|is_unique[categories_mst.Category]');//callback_check_duplicate
	 
	        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
	        if($this->form_validation->run() == FALSE){
	            $page_data['service_type'] =$service_type;
	            $page_data['service_types']=get_table_data('service_type','service_name,id',"status=1 AND cancel=1 AND id=$service_type ORDER BY service_name")->result();
	            $page_data['title']=$service.'   Category Add';
	            $page_data['page_name']='master_setup/category_form';
	            $this->load->view('backend/index',$page_data);
	        }else{
	         
	            $id = get_pk_id('categories_mst','cat_id');
	            $insert_data=[
	                'cat_id'               =>$id, 
	                'service_type'         =>clean_input($this->input->post('service_type')), 
	                'category'             =>clean_input($this->input->post('category')), 
	                 
	                'loginid'               =>$this->login_id,
	                'changetype'            =>'Created',
	                'systemdate'            =>system_date(),
	                'systemip'              =>get_ip(),
	                'systemname'            =>$this->system_name,
	            ];
	             
	            $response=data_insert('categories_mst',$insert_data); 
	            if($response){
	                $this->session->set_flashdata('msg',"Category Created Successfully.");
	                redirect('categories/'.$service_type.'/add','refresh');
	            }else{
	                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
	                redirect('categories/'.$service_type.'/'.$action,'refresh');
	            } 
	        }
		}

		if($action == 'edit'){
			$page_data['category_data']=$this->master->get_category_data($service_type,$cat_id)->row();
			$page_data['service_types']=get_table_data('service_type','service_name,id',"status=1 AND cancel=1 AND id=$service_type ORDER BY service_name")->result();
 			$page_data['title']=$service.'  Category Edit';
        	$page_data['page_name']='master_setup/category_edit';
        	$this->load->view('backend/index',$page_data);
		}

		if($action == 'update'){
			$this->form_validation->set_rules('service_type','Service Type','trim|required');
	        $this->form_validation->set_rules('category','Category','trim|required');//callback_check_duplicate
	 
	        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
	        if($this->form_validation->run() == FALSE){
	        	$page_data['category_data']=$this->master->get_category_data($service_type,$cat_id)->row();
				$page_data['service_types']=get_table_data('service_type','service_name,id',"status=1 AND cancel=1 AND id=$service_type ORDER BY service_name")->result();
	 			$page_data['title']='Category Edit';
	        	$page_data['page_name']='master_setup/category_edit';
	        	$this->load->view('backend/index',$page_data);
	        }else{
                $service_type=clean_input($this->input->post('service_type'));
                $category_name=clean_input($this->input->post('category'));
                $is_uniq=check_uniq_value('categories_mst','category',$category_name,"service_type=$service_type  AND cancel=1 AND cat_id !=$cat_id");              
                if($is_uniq > 0){
                    $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                    redirect('categories/'.$service_type.'/'.$action.'/'.$cat_id,'refresh');
                }else{
                    $update_data=[
                        'cat_id'                =>$cat_id, 
                        'service_type'          =>clean_input($this->input->post('service_type')), 
                        'category'              =>clean_input($this->input->post('category')), 
                        
                        'loginid'               =>$this->login_id,
                        'changetype'            =>'Modified',
                        'systemdate'            =>system_date(),
                        'systemip'              =>get_ip(),
                        'systemname'            =>$this->system_name,
                    ];
                    
                    $response=data_update('categories_mst','cat_id',$update_data);  
                    if($response){
                        $this->session->set_flashdata('msg',"Category Updated Successfully.");
                        redirect('categories/'.$service_type.'/list','refresh');
                    }else{
                        $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                        redirect('categories/'.$service_type.'/'.$action.'/'.$cat_id,'refresh');
                    }
                }
	        }
		}
	}
	  

	/* function check_duplicate(){ 
           $type = $this->input->post('type');// get first name
           $srm_schoolid = $this->input->post('srm_schoolid');// get last name
           $duplicate_school_report =get_table_data('school_report_mst','COUNT(*) as TOT',"srm_status=1 AND srm_cancel=1 AND srm_type=$type AND srm_schoolid=$srm_schoolid")->row();
           $num = $duplicate_school_report->TOT;
           if ($num > 0) {
               $this->session->set_flashdata('error',"Oops!. School Report Already exists!.");
               return FALSE;
           } else {
               return TRUE;
           }
       }
    */

	
	function category_active(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $cat_id=clean_input($this->input->post('id'));
        $active_data=[
			'cat_id'             =>$cat_id, 

			'status'	     =>1,
            'loginid'        =>$this->login_id,
            'changetype'     =>'Activated',
            'systemdate'     =>system_date(),
            'systemip'       =>get_ip(),
            'systemname'     =>$this->system_name, 
        ];
        $response= data_update('categories_mst', 'cat_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
	}
	function category_inactive(){ 
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $cat_id=clean_input($this->input->post('id'));
        $active_data=[
			'cat_id'            =>$cat_id, 

			'status'			=>2,
            'loginid'           =>$this->login_id,
            'changetype'       	=>'Inactivated',
            'systemdate'       	=>system_date(),
            'systemip'         	=>get_ip(),
            'systemname'       	=>$this->system_name, 
        ];
        $response= data_update('categories_mst', 'cat_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
	}
    function Category_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $cat_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'cat_id'            =>$cat_id, 
 
            'loginid'           =>$this->login_id,
            'cancle'            =>2,
            'changetype'       	=>'Deleted',
            'systemdate'       	=>system_date(),
            'systemip'         	=>get_ip(),
            'systemname'       	=>$this->system_name, 
 
          ];
        $response= data_update('categories_mst','cat_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }



	/*
	function subcategories($category,$action,$sum_id=null){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
		$page_data['category'] =$category;
        $page_data['action'] =$action;

		if($action == 'list'){
			$page_data['subcategory_data']=$this->master->get_subcategory_data($category)->result();
			$page_data['title']='Sub Category List';
	        $page_data['page_name']='master_setup/subcategory_list';
	        $this->load->view('backend/index',$page_data);
		}
		if($action == 'add'){
			$page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 AND cat_id=$category ORDER BY category")->result();
 			$page_data['title']='Sub Category Add';
	        $page_data['page_name']='master_setup/subcategory_form';
	        $this->load->view('backend/index',$page_data);
		}
	}
    */
	function subcategory_list($service_type){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        //filter
        $sum_categoryid ='';
        if($this->input->method() == 'get'){
            $sum_categoryid =$this->input->get('c');
        }
        if(!empty($sum_categoryid)){
            $total_rows=total_record('subcategory_mst','sum_cancel=1 AND sum_categoryid='.$sum_categoryid);
        }else{
            $total_rows=$this->master->get_tot_record($service_type);
        }
        $page_data['sum_categoryid']=$sum_categoryid;
		$config =[
            'base_url'=>base_url('subcategory_list/'.$service_type),
            'per_page'=>'800',
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
        $page_data['links']=$this->pagination->create_links();
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        
		
		$page_data['subcategory_data']=$this->master->get_subcategory_data('',$service_type,$config['per_page'],$page,$sum_categoryid)->result(); //$config['per_page'],$page
 		$page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 AND service_type=$service_type ORDER BY category")->result();

        if($service_type == 1){
            $service="Matrimony";
        }elseif($service_type == 2){
            $service="Job";
        }elseif($service_type == 3){
            $service="Service";
        }elseif($service_type == 4){
            $service="Product";
        }elseif($service_type == 5){
            
            $service="Education";
        }elseif($service_type == 6){
            $service="Hotel";
        }elseif($service_type == 7){
            $service="Property";
        }elseif($service_type == 8){
            $service="Re-Sale";
        }
        $page_data['service_type']=$service_type;
		$page_data['title']= $service.' Sub Category List';
        $page_data['page_name']='master_setup/subcategory_list';
        $this->load->view('backend/index',$page_data);
	}
	function subcategory_form($service_type){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['service_type']=$service_type;
        if($service_type == 1){
            $service="Matrimony";
        }elseif($service_type == 2){
            $service="Job";
        }elseif($service_type == 3){
            $service="Service";
        }elseif($service_type == 4){
            $service="Product";
        }elseif($service_type == 5){
            $service="Education";
        }elseif($service_type == 6){
            $service="Hotel";
        }elseif($service_type == 7){
            $service="Property";
        }elseif($service_type == 8){
            $service="Re-Sale";
        }

       // $page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 ORDER BY category")->result();

 		$page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 AND service_type=$service_type ORDER BY category")->result();
  		$page_data['title']=$service.' Sub Category Add';
        $page_data['page_name']='master_setup/subcategory_form';
        $this->load->view('backend/index',$page_data);
	}
	function subcategory_add($service_type){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['service_type']=$service_type;
        if($service_type == 1){
            $service="Matrimony";
        }elseif($service_type == 2){
            $service="Job";
        }elseif($service_type == 3){
            $service="Service";
        }elseif($service_type == 4){
            $service="Product";
        }elseif($service_type == 5){
            $service="Education";
        }elseif($service_type == 6){
            $service="Hotel";
        }elseif($service_type == 7){
            $service="Property";
        }elseif($service_type == 8){
            $service="Re-Sale";
        }

		$this->form_validation->set_rules('sum_categoryid','Category','trim|required');
		$this->form_validation->set_rules('sum_subcategory','Sub Category','trim|required|is_unique[subcategory_mst.sum_subcategory]');
  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            $page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 AND service_type=$service_type ORDER BY category")->result();
 			$page_data['title']=$service.' Sub Category Add';
        	$page_data['page_name']='master_setup/subcategory_form';
        	$this->load->view('backend/index',$page_data);
        }else{
		 
			$sum_id = get_pk_id('subcategory_mst','sum_id');
			$insert_data=[
	            'sum_id'                		=>$sum_id, 
				'sum_categoryid'               =>clean_input($this->input->post('sum_categoryid')),
 				'sum_subcategory'               =>string_ucword(clean_input($this->input->post('sum_subcategory'))), 
				  
	            'sum_loginid'          			=>$this->login_id,
	            'sum_changetype'       			=>'Created',
	            'sum_systemdate'       			=>system_date(),
	            'sum_systemip'         			=>get_ip(),
	            'sum_systemname'       			=>$this->system_name,
	        ];
			
			
			$response=data_insert('subcategory_mst',$insert_data);  
	        if($response){
	            $this->session->set_flashdata('msg',"Subcategory Created Successfully.");
	            redirect('subcategory_form/'.$service_type,'refresh');
	        }else{
	            $this->session->set_flashdata('error',"Oops!. Error Occurred.");
	            redirect('subcategory_form/'.$service_type,'refresh');
	        }
		}
	}
	function subcategory_edit($service_type,$sum_id){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['service_type']=$service_type;
        if($service_type == 1){
            $service="Matrimony";
        }elseif($service_type == 2){
            $service="Job";
        }elseif($service_type == 3){
            $service="Service";
        }elseif($service_type == 4){
            $service="Product";
        }elseif($service_type == 5){
            $service="Education";
        }elseif($service_type == 6){
            $service="Hotel";
        }elseif($service_type == 7){
            $service="Property";
        }elseif($service_type == 8){
            $service="Re-Sale";
        }
		$page_data['subcategory_data']=$this->master->get_subcategory_data($sum_id)->row();
        $page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 AND service_type=$service_type ORDER BY category")->result();
  		$page_data['title']=$service.' Sub Category Edit';
        $page_data['service_type']=$service_type;
        $page_data['page_name']='master_setup/subcategory_edit';
        $this->load->view('backend/index',$page_data);
	}
	function subcategory_update($service_type,$sum_id){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['service_type']=$service_type;
        if($service_type == 1){
            $service="Matrimony";
        }elseif($service_type == 2){
            $service="Job";
        }elseif($service_type == 3){
            $service="Service";
        }elseif($service_type == 4){
            $service="Product";
        }elseif($service_type == 5){
            $service="Education";
        }elseif($service_type == 6){
            $service="Hotel";
        }elseif($service_type == 7){
            $service="Property";
        }elseif($service_type == 8){
            $service="Re-Sale";
        }

		$this->form_validation->set_rules('sum_categoryid','Category','trim|required');
		$this->form_validation->set_rules('sum_subcategory','Sub Category','trim|required');
  
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
			$page_data['subcategory_data']=$this->master->get_subcategory_data($sum_id)->row();
            $page_data['category_data']=get_table_data('categories_mst','category,cat_id',"status=1 AND cancel=1 AND service_type=$service_type ORDER BY category")->result();
 			$page_data['title']=$service.' Sub Category Edit';
        	$page_data['page_name']='master_setup/subcategory_edit';
        	$this->load->view('backend/index',$page_data);
        }else{
            $sum_categoryid=clean_input($this->input->post('sum_categoryid'));
            $value=string_ucword(clean_input($this->input->post('sum_subcategory')));
            $is_uniq=check_uniq_value('subcategory_mst','sum_subcategory', $value,"sum_categoryid=$sum_categoryid AND sum_id != $sum_id AND sum_cancel=1");           
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('subcategory_edit/'.$service_type.'/'.$sum_id,'refresh');
            }else{
                $update_data=[
                    'sum_id'                		=>$sum_id, 
                    'sum_categoryid'                =>clean_input($this->input->post('sum_categoryid')),
                    'sum_subcategory'               =>string_ucword(clean_input($this->input->post('sum_subcategory'))), 
                    
                    'sum_loginid'          			=>$this->login_id,
                    'sum_changetype'       			=>'Modified',
                    'sum_systemdate'       			=>system_date(),
                    'sum_systemip'         			=>get_ip(),
                    'sum_systemname'       			=>$this->system_name,
                ];
                
                $response=data_update('subcategory_mst','sum_id',$update_data);  
                if($response){
                    $this->session->set_flashdata('msg',"Subcategory Updated Successfully.");
                    redirect('subcategory_list/'.$service_type,'refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('subcategory_edit/'.$service_type.'/'.$sum_id,'refresh');
                }
            }
		}
	}
    function subcategory_active(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $sum_id=clean_input($this->input->post('id'));
        $active_data=[
			'sum_id'                		=>$sum_id, 
			  
			'sum_status'					=>1,
			'sum_loginid'          			=>$this->login_id,
			'sum_changetype'       			=>'Activated',
			'sum_systemdate'       			=>system_date(),
			'sum_systemip'         			=>get_ip(),
			'sum_systemname'       			=>$this->system_name,
        ];
        $response= data_update('subcategory_mst', 'sum_id',$active_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
	}
	function subcategory_inactive(){
		 if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $sum_id=clean_input($this->input->post('id'));
        $inactive_data=[
			'sum_id'                		=>$sum_id, 
			 
			'sum_status'					=>2,
			'sum_loginid'          			=>$this->login_id,
			'sum_changetype'       			=>'Inactivated',
			'sum_systemdate'       			=>system_date(),
			'sum_systemip'         			=>get_ip(),
			'sum_systemname'       			=>$this->system_name,
        ];
        $response= data_update('subcategory_mst', 'sum_id',$inactive_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
	}
    /**=================== Category & Subcategory Close ==============**/

    /**=================== Common Master Data Statrt ==============**/
	function common_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
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
        //pagination code here
        $config =[
            'base_url'=>base_url('common_list'),
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

        $page_data['common_data']=$this->master->get_common_data('',$config['per_page'],$page,$COM_TPCD)->result();
        $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_list';
        $page_data['title']=' Master List';
        $page_data['page_name']='master_setup/common_list';
        $this->load->view('backend/index',$page_data);
    }
    function common_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_list';
        $page_data['title']=' Master Add';
        $page_data['page_name']='master_setup/common_form';
        $this->load->view('backend/index',$page_data);
    }
    function common_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('COM_TPCD','Master Type','trim|required');
        $this->form_validation->set_rules('COM_CMNM','Master Name','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('login');
            }
            $page_data['common_data']=$this->master->get_common_data()->result();
            $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='common_list';
            $page_data['title']=' Master Add';
            $page_data['page_name']='master_setup/common_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $COM_TPCD=clean_input($this->input->post('COM_TPCD'));
            $value=string_upper(clean_input($this->input->post('COM_CMNM')));
            $is_uniq=check_uniq_value('com_mst','COM_CMNM', $value,"COM_TPCD = $COM_TPCD AND COM_CANC=1");

            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('common_edit/'.$COM_CMCD,'refresh');
            }else{
                $COM_CMCD =get_pk_id('com_mst','COM_CMCD');
                $insert_data=[
                    'COM_CMCD'       =>$COM_CMCD,

                    'COM_TPCD'       =>clean_input($this->input->post('COM_TPCD')),
                    'COM_CMNM'       =>string_upper(clean_input($this->input->post('COM_CMNM'))),

                    'COM_CHUI'       => $this->login_id,
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
    }
    function common_edit($COM_CMCD){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        
        $page_data['common_data']=$this->master->get_common_data($COM_CMCD)->row();
        $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_list';
        $page_data['title']=' Master Edit';
        $page_data['page_name']='master_setup/common_edit';
        $this->load->view('backend/index',$page_data);
    }
    function common_update($COM_CMCD){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('COM_TPCD','Master Type','trim|required');
        $this->form_validation->set_rules('COM_CMNM','Master Name','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

         
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            } 
            $page_data['common_data']=$this->master->get_common_data($COM_CMCD)->row();
            $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1 ORDER BY COT_TPNM")->result();
            $page_data['main_menu']='setup';
            $page_data['menu_active']='common_list';
            $page_data['title']=' Master Edit';
            $page_data['page_name']='master_setup/common_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $value=string_upper(clean_input($this->input->post('COM_CMNM')));
            $is_uniq=check_uniq_value('com_mst','COM_CMNM', $value,"COM_CMCD != $COM_CMCD AND COM_CANC=1");
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('common_edit/'.$COM_CMCD,'refresh');
            }else{
                $update_data=[
                    'COM_CMCD'       =>$COM_CMCD,
                    'COM_TPCD'       =>clean_input($this->input->post('COM_TPCD')),
                    'COM_CMNM'       =>string_upper(clean_input($this->input->post('COM_CMNM'))),
                    'COM_CHUI'       => $this->login_id,
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
    }
    function common_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $COM_CMCD=clean_input($this->input->post('id'));
        
        $delete_data=[
            'COM_CMCD'       =>$COM_CMCD,

            'COM_CHUI'       => $this->login_id,
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
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        
        $page_data['common_type_data']=get_table_data('com_typ','COT_TPCD,COT_TPNM,COT_USED',"COT_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list';
        $page_data['title']=' Master Group List';
        $page_data['page_name']='master_setup/common_type_list';
        $this->load->view('backend/index',$page_data);
    }
    function common_type_form(){
        if(!$this->session->userdata('userlogin')){
             redirect('login');
        }
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list'; 
        $page_data['title']='Master Group Add';
        $page_data['page_name']='master_setup/common_type_form';
        $this->load->view('backend/index',$page_data);
    }
    function common_type_add(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('COT_TPNM','common Type','trim|required|is_unique[com_typ.COT_TPNM]');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('login');
            }
            $page_data['main_menu']='setup';
            $page_data['menu_active']='common_type_list';
            $page_data['title']='Master Group Add';
            $page_data['page_name']='master_setup/common_type_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $COT_TPCD =get_pk_id('com_typ','COT_TPCD');
            $insert_data=[
                'COT_TPCD'       =>$COT_TPCD,
                'COT_TPNM'       =>string_ucword(clean_input($this->input->post('COT_TPNM'))),
                
                'COT_CHUI'       =>$this->login_id,
                'COT_CHTP'       =>'Created',
                'COT_CHTM'       =>system_date(),
                'COT_CHWI'       =>get_ip(),
            ];
            
            $response=data_insert('com_typ',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Master Group Created Successfully.");
                redirect('common_type_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('common_type_form','refresh');
            }
        
        }
    }
    function common_type_edit($COT_TPCD){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['common_type_data']=get_table_data('com_typ','COT_TPCD,COT_TPNM,COT_USED',"COT_CANC=1 AND COT_TPCD=".$COT_TPCD)->row();
        $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list';
        $page_data['title']=' Master Group Edit';
        $page_data['page_name']='master_setup/common_type_edit';
        $this->load->view('backend/index',$page_data);
    }
    function common_type_update($COT_TPCD){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $this->form_validation->set_rules('COT_TPNM','common Type','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('login');
            } 

        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['common_type_data']=get_table_data('com_typ','COT_TPCD,COT_TPNM,COT_USED',"COT_CANC=1 AND COT_TPCD=".$COT_TPCD)->row();
        $page_data['common_type']=get_table_data('com_typ','COT_TPCD,COT_TPNM',"COT_CANC=1")->result();
        $page_data['main_menu']='setup';
        $page_data['menu_active']='common_type_list';
        $page_data['title']='Master Group Edit';
        $page_data['page_name']='master_setup/common_type_edit';
        $this->load->view('backend/index',$page_data);
        
        }else{
            $value=string_ucword(clean_input($this->input->post('COT_TPNM')));
            $is_uniq=check_uniq_value('com_typ','COT_TPNM', $value,"COT_TPCD != $COT_TPCD AND COT_CANC=1");
            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('common_type_edit/'.$COT_TPCD,'refresh');
            }else{
                $update_data=[
                    'COT_TPCD'       =>$COT_TPCD,
                    'COT_TPNM'       =>string_ucword(clean_input($this->input->post('COT_TPNM'))),
        
                    'COT_CHUI'       => $this->login_id,
                    'COT_CHTP'       =>'Modified',
                    'COT_CHTM'       =>system_date(),
                    'COT_CHWI'       =>get_ip(),
                ];
                $response=data_update('com_typ','COT_TPCD',$update_data);
            
                if($response){
                    $this->session->set_flashdata('msg'," Master  Group  Updated Successfully.");
                    redirect('common_type_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('common_type_edit/'.$COT_TPCD,'refresh');
                }
            }
            
        }
        
    }
    function common_type_deleted(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $COT_TPCD=clean_input($this->input->post('id'));
        
        $delete_data=[ 
            'COT_TPCD'       =>$COT_TPCD,
            'COT_CHUI'       => $this->login_id,
            'COT_CANC'       =>2,
            'COT_CHTP'       =>'Deleted',
            'COT_CHTM'       =>system_date(),
            'COT_CHWI'       =>get_ip(),
          ];
        $response= data_update('com_typ','COT_TPCD',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }

    /**=================== Common Master Data Close ==============**/

    function company_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  

        $config =[
            'base_url'=>base_url('company_list'),
            'per_page'=>'100',
            'total_rows'=>total_record('company_mst','com_cancel=1'),
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
  
        $page_data['company_data']=$this->master->get_company_data('',$config['per_page'],$page)->result();
        $page_data['title']='Company List';
        $page_data['page_name']='master_setup/company_list';
        $this->load->view('backend/index',$page_data);
    }
    function company_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['common_type_data']=get_table_data('subcategory_mst','sum_id,sum_categoryid,sum_subcategory',"sum_cancel=1")->result();
        $page_data['title']='Company Add';
        $page_data['page_name']='master_setup/company_form';
        $this->load->view('backend/index',$page_data);
    }
    function company_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   

        $this->form_validation->set_rules('com_companyname','Company Name','trim|required|is_unique[company_mst.com_companyname]');
 
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            $page_data['title']='Company Add';
            $page_data['page_name']='master_setup/company_form';
            $this->load->view('backend/index',$page_data);

        }else{
            $com_id =get_pk_id('company_mst','com_id');
            $insert_data=[
                'com_id'               =>$com_id,
                'com_companyname'      =>string_upper(clean_input($this->input->post('com_companyname'))),
 
                'com_loginid'          => $this->login_id,
                'com_changetype'       =>'Created',
                'com_systemdate'       =>system_date(),
                'com_systemip'         =>get_ip(),
                'com_systemname'       =>$this->system_name,
            ];
         
            $response=data_insert('company_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg'," Company Created Successfully.");
                redirect('company_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('company_form','refresh');
            }
        }
    }
    function company_edit($com_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        $page_data['company_data']=$this->master->get_company_data($com_id)->row();
        $page_data['title']='Company Edit';
        $page_data['page_name']='master_setup/company_edit';
        $this->load->view('backend/index',$page_data);
    }
    function company_update($com_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $this->form_validation->set_rules('com_companyname','Company Name','trim|required'); 

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            $page_data['company_data']=$this->master->get_company_data($com_id)->row();
             $page_data['title']='Company Edit';
            $page_data['page_name']='master_setup/company_form';
            $this->load->view('backend/index',$page_data);

        }else{
        
            $com_companyname=string_upper(clean_input($this->input->post('com_companyname')));
            $is_uniq=check_uniq_value('company_mst','com_companyname', $com_companyname,"com_cancel=1 AND com_id !=$com_id");

            if($is_uniq > 0){
                $this->session->set_flashdata('error',"Oops!. Duplicate Data Found.");
                redirect('company_edit/'.$com_id,'refresh');
            }else{
                $insert_data=[
                    'com_id'       =>$com_id,

                    'com_companyname'      =>string_upper(clean_input($this->input->post('com_companyname'))),

                    'com_loginid'          => $this->login_id,
                    'com_changetype'       =>'Modified',
                    'com_systemdate'       =>system_date(),
                    'com_systemip'         =>get_ip(),
                    'com_systemname'       =>$this->system_name,
                ];
                    $response=data_update('company_mst','com_id',$insert_data);
                if($response){
                    $this->session->set_flashdata('msg',"Company Updated Successfully.");
                    redirect('company_list','refresh');
                }else{
                    $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                    redirect('comppany_edit/'.$com_id,'refresh');
                }
            }
        }
    }

    function company_delete(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $com_id=clean_input($this->input->post('id'));
        $delete_data=[
            'com_id'       =>$com_id,

            'com_loginid'          => $this->login_id,
            'com_cancel'           =>2,
            'com_changetype'       =>'Deleted',
            'com_systemdate'       =>system_date(),
            'com_systemip'         =>get_ip(),
            'com_systemname'       =>$this->system_name,
          ];
        $response= data_update('company_mst','com_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }

    function company_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $com_id=clean_input($this->input->post('id'));
        $delete_data=[
            'com_id'       =>$com_id,

            'com_loginid'          => $this->login_id,
            'com_status'           =>1,
            'com_changetype'       =>'Deleted',
            'com_systemdate'       =>system_date(),
            'com_systemip'         =>get_ip(),
            'com_systemname'       =>$this->system_name,
          ];
        $response= data_update('company_mst','com_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function company_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $com_id=clean_input($this->input->post('id'));
        $delete_data=[
            'com_id'       =>$com_id,

            'com_loginid'          => $this->login_id,
            'com_status'           =>2,
            'com_changetype'       =>'Deleted',
            'com_systemdate'       =>system_date(),
            'com_systemip'         =>get_ip(),
            'com_systemname'       =>$this->system_name,
          ];
        $response= data_update('company_mst','com_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }

    function reward_list(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
 
        $page_data['reward_data']=$this->master->get_reward_data()->result();
        $page_data['title']='Commision Price';
        $page_data['title_s']='Single Commision Price';
        $page_data['title_m']='Multiple Commision Price';
        $page_data['page_name']='master_setup/reward_list';
        $this->load->view('backend/index',$page_data);
    }
    function reward_single_edit($id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $page_data['reward_data']=$this->master->get_reward_data($id)->row();
        $page_data['title']='Commision Price Edit';
        $page_data['title_s']='Single Commision Price Edit';
        $page_data['page_name']='master_setup/reward_single_edit';
        $this->load->view('backend/index',$page_data);
    }
    
    function  single_reward_update($commision_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
        // $this->form_validation->set_rules('join_single_amount',' Price','trim|required');
        $this->form_validation->set_rules('comision_level_one','Label 1 ','trim|required');
        $this->form_validation->set_rules('comision_level_two','Label 2','trim|required');
        $this->form_validation->set_rules('comision_level_three','Label 3','trim|required');
        $this->form_validation->set_rules('comision_level_four','Label 4','trim|required');
        $this->form_validation->set_rules('comision_level_five','Label 5 ','trim|required');
        $this->form_validation->set_rules('comision_level_one_renew','Renew Label 1 ','trim|required');
        $this->form_validation->set_rules('comision_level_two_renew','Renew Label 2','trim|required');
        $this->form_validation->set_rules('comision_level_three_renew','Renew Label 3 ','trim|required');
        $this->form_validation->set_rules('comision_level_four_renew','Renew Label 4 ','trim|required');
        $this->form_validation->set_rules('comision_level_five_renew','Renew Label 5 ','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('login');
            }
            $page_data['reward_data']=$this->master->get_reward_data($commision_id)->row();
            $page_data['title']='Commision Price Edit';
            $page_data['title_s']='Single Commision Price Edit';
            $page_data['page_name']='master_setup/reward_single_edit';
            
            $this->load->view('backend/index',$page_data);
        }else{
            $update_data=[
                'commision_id'       =>$commision_id,
                'comision_level_one'   =>clean_input($this->input->post('comision_level_one')),
                'comision_level_two'   =>clean_input($this->input->post('comision_level_two')),
                'comision_level_three'   =>clean_input($this->input->post('comision_level_three')),
                'comision_level_four'   =>clean_input($this->input->post('comision_level_four')),
                'comision_level_five'   =>clean_input($this->input->post('comision_level_five')),
                'comision_level_one_renew'   =>clean_input($this->input->post('comision_level_one_renew')),
                'comision_level_two_renew'   =>clean_input($this->input->post('comision_level_two_renew')),
                'comision_level_three_renew'   =>clean_input($this->input->post('comision_level_three_renew')),
                'comision_level_four_renew'   =>clean_input($this->input->post('comision_level_four_renew')),
                'comision_level_five_renew'   =>clean_input($this->input->post('comision_level_five_renew')),
            ];
             
            $response=data_update('commision_level','commision_id',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg'," Single Commision Price Updated Successfully.");
                redirect('reward_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('reward_single_edit/'.$commision_id,'refresh');
            }
            
        }
     
    }

    function reward_multiple_edit($commision_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $page_data['reward_data']=$this->master->get_reward_data($commision_id)->row();
        $page_data['title']='Commision Price Edit';
        $page_data['title_m']='Multiple Commision Price Edit';
        $page_data['page_name']='master_setup/reward_multiple_edit';
        $this->load->view('backend/index',$page_data);
    }
    function  multiple_reward_update($commision_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
    
        // $this->form_validation->set_rules('join_multiple_amount','price','trim|required');
        $this->form_validation->set_rules('mcomision_level_one','Label 1 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_two','Label 2 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_three','Label 3 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_four','Label 4 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_five','Label 5 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_one_renew','Renew Label 1 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_two_renew','Renew Label 2 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_three_renew','Renew Label 3 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_four_renew','Renew Label 4 ','trim|required');
        $this->form_validation->set_rules('mcomision_level_five_renew','Renew Label 5 ','trim|required');
        
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                 redirect('login');
            }
            $page_data['reward_data']=$this->master->get_reward_data($commision_id)->row();
            $page_data['title']='Commision Price';
            $page_data['title_m']='Multiple Commision Price';
            $page_data['page_name']='master_setup/reward_multiple_edit';
        
            $this->load->view('backend/index',$page_data);
        }else{ 
            $update_data=[
                'commision_id'              =>$commision_id,
                'mcomision_level_one'         =>clean_input($this->input->post('mcomision_level_one')),
                'mcomision_level_two'         =>clean_input($this->input->post('mcomision_level_two')),
                'mcomision_level_three'       =>clean_input($this->input->post('mcomision_level_three')),
                'mcomision_level_four'        =>clean_input($this->input->post('mcomision_level_four')),
                'mcomision_level_five'        =>clean_input($this->input->post('mcomision_level_five')),
                'mcomision_level_one_renew'   =>clean_input($this->input->post('mcomision_level_one_renew')),
                'mcomision_level_two_renew'   =>clean_input($this->input->post('mcomision_level_two_renew')),
                'mcomision_level_three_renew' =>clean_input($this->input->post('mcomision_level_three_renew')),
                'mcomision_level_four_renew'  =>clean_input($this->input->post('mcomision_level_four_renew')),
                'mcomision_level_five_renew'  =>clean_input($this->input->post('mcomision_level_five_renew')),
            ];
             
            $response=data_update('commision_level','commision_id',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg'," Multiple Commision Price Updated Successfully.");
                redirect('reward_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('reward_multiple_edit/'.$commision_id,'refresh');
            }
            
        }
    }
    
    function user(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }  
 
        $page_data['user_data']=$this->master->get_user_data()->result();

        $page_data['title']='User List' ; 
        $page_data['page_name']='master_setup/user';
        $this->load->view('backend/index',$page_data);
    }
    function user_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
      
        $page_data['country_data'] =$this->master->get_country()->result();
        $page_data['user_role']=get_table_data('user_role','role_name,role_id',"role_cancel=1 ANd role_id=2")->result();

        $page_data['title']='User Add'; 
        $page_data['page_name']='master_setup/user_from';
        $this->load->view('backend/index',$page_data);
    }
    function user_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $this->form_validation->set_rules('user_username','Full Name','trim|required');
        $this->form_validation->set_rules('user_name','User Name','trim|required');
        $this->form_validation->set_rules('user_email','User Email Id','trim|required');
        $this->form_validation->set_rules('user_mobile','User Mobail','trim|required');
        $this->form_validation->set_rules('user_password','User Password','trim|required');
        $this->form_validation->set_rules('user_role','User Role','trim|required');
        $this->form_validation->set_rules('user_country','Country','trim|required');
        $this->form_validation->set_rules('user_state','Country','trim|required');
        $this->form_validation->set_rules('user_district','Country','trim|required');
        $this->form_validation->set_rules('user_block','Block','trim|required');
        $this->form_validation->set_rules('user_village','village','trim|required');
        $this->form_validation->set_rules('user_address','User Address','trim|required');
        $this->form_validation->set_rules('user_pincode','Pin Code','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            $page_data['country_data'] =$this->master->get_country()->result();
            $page_data['user_role']=get_table_data('user_role','role_name,role_id',"role_cancel=1 ANd role_id=2")->result();
            $page_data['title']='User  Add';
            $page_data['page_name']='master_setup/user_from';
            $this->load->view('backend/index',$page_data);
        }else{

            $user_id =get_pk_id('users_mst','user_id');
            $user_password=clean_input($this->input->post('user_password'));
            $insert_data=[
                'user_id'           =>$user_id,
                'user_name'         =>string_ucword(clean_input($this->input->post('user_name'))),
                'user_username'     =>clean_input($this->input->post('user_username')),
                'user_email'        =>clean_input($this->input->post('user_email')),
                'user_mobile'       =>clean_input($this->input->post('user_mobile')),
                'user_password'     =>md5($user_password),
                'user_rawpsw'       =>$user_password,
                'user_role'         =>clean_input($this->input->post('user_role')),
                'user_country'      =>clean_input($this->input->post('user_country')),
                'user_state'        =>clean_input($this->input->post('user_state')),
                'user_district'     =>clean_input($this->input->post('user_district')),
                'user_block'        =>clean_input($this->input->post('user_block')),
                'user_village'      =>clean_input($this->input->post('user_village')),
                'user_address'      =>clean_input($this->input->post('user_address')),
                'user_pincode'      =>clean_input($this->input->post('user_pincode')),
 
                'user_login'        => $this->login_id,
                'change_type'       =>'Created',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>gethostname(),
            ]; 
            $response=data_insert('users_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg'," User Created Successfully.");
                redirect('user','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('user','refresh');
            }
        }
        
    }
    function user_edit($user_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $page_data['user_data']=$this->master->get_user_data($user_id)->row();
        $page_data['country_data'] =$this->master->get_country()->result();
        $page_data['user_role']=get_table_data('user_role','role_name,role_id',"role_cancel=1 ANd role_id=2")->result();

        $page_data['title']='User Edit'; 
        $page_data['page_name']='master_setup/user_edit';
        $this->load->view('backend/index',$page_data);
    }
    function user_update($user_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $this->form_validation->set_rules('user_username','Full Name','trim|required');
        $this->form_validation->set_rules('user_name','User Name','trim|required');
        $this->form_validation->set_rules('user_email','User Email Id','trim|required');
        $this->form_validation->set_rules('user_mobile','User Mobail','trim|required');
        $this->form_validation->set_rules('user_password','User Password','trim|required');
        $this->form_validation->set_rules('user_role','User Role','trim|required');
        $this->form_validation->set_rules('user_country','Country','trim|required');
        $this->form_validation->set_rules('user_state','Country','trim|required');
        $this->form_validation->set_rules('user_district','Country','trim|required');
        $this->form_validation->set_rules('user_block','Block','trim|required');
        $this->form_validation->set_rules('user_village','village','trim|required');
        $this->form_validation->set_rules('user_address','User Address','trim|required');
        $this->form_validation->set_rules('user_pincode','Pin Code','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>'); 
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }
            $page_data['user_data']=$this->master->get_user_data($user_id)->row();
            $page_data['country_data'] =$this->master->get_country()->result();
            $page_data['user_role']=get_table_data('user_role','role_name,role_id',"role_cancel=1 ANd role_id=2")->result();
    
            $page_data['title']='User Edit'; 
            $page_data['page_name']='master_setup/user_edit';
            $this->load->view('backend/index',$page_data);
        }else{
            $user_password=clean_input($this->input->post('user_password'));
            $update_data=[
                'user_id'           =>$user_id,
                'user_name'         =>string_ucword(clean_input($this->input->post('user_name'))),
                'user_username'     =>clean_input($this->input->post('user_username')),
                'user_email'        =>clean_input($this->input->post('user_email')),
                'user_mobile'       =>clean_input($this->input->post('user_mobile')),
                'user_password'     =>md5($user_password),
                'user_rawpsw'       =>$user_password,
                'user_role'         =>clean_input($this->input->post('user_role')),
                'user_country'      =>clean_input($this->input->post('user_country')),
                'user_state'        =>clean_input($this->input->post('user_state')),
                'user_district'     =>clean_input($this->input->post('user_district')),
                'user_block'        =>clean_input($this->input->post('user_block')),
                'user_village'           =>clean_input($this->input->post('user_village')),
                'user_address'      =>clean_input($this->input->post('user_address')),
                'user_pincode'      =>clean_input($this->input->post('user_pincode')),
 
                'user_login'        => $this->login_id,
                'change_type'       =>'Modified',
                'system_date'       =>system_date(),
                'system_ip'         =>get_ip(),
                'system_name'       =>gethostname(),
            ];  
            $response=data_update('users_mst','user_id',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg'," User Updated Successfully.");
                redirect('user','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('user/'.$user_id,'refresh');
            }
        }
        
    }
    function menu_group(){ 
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }   
        $page_data['menugroup_data']=$this->master->get_menugroup_data()->result(); 
        $page_data['title']= 'Menu Group List'; 
        $page_data['page_name']='master_setup/menu_group';
        $this->load->view('backend/index',$page_data);
    }
    function menu_group_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }    
        $page_data['title']= 'Menu Group Add'; 
        $page_data['menutype_data']=get_table_data('menu_type_mst','menutype_id,menutype_name',"menutype_status=1 ORDER BY menutype_order")->result(); 
        $page_data['page_name']='master_setup/menu_group_form';
        $this->load->view('backend/index',$page_data);

    }
    function menu_group_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }    
        $this->form_validation->set_rules('menugroup_name','Menu Title ','trim|required');
        $this->form_validation->set_rules('menugroup_menus[]','Menu Name','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }   
            $page_data['title']= 'Menu Group Add';
            $page_data['menutype_data']=get_table_data('menu_type_mst','menutype_id,menutype_name',"menutype_status=1 ORDER BY menutype_order")->result(); 
            //$page_data['menu_data']=get_table_data('menu_mst,menu_type_mst','menu_id,menu_name,menutype_name,menu_typeid',"menu_status=1 AND menu_typeid=menutype_id ORDER BY menu_typeid,menu_name")->result();
            $page_data['page_name']='master_setup/menu_group_form';
            $this->load->view('backend/index',$page_data);
        }else{
            $menugroup_id =get_pk_id('menugroup_mst','menugroup_id'); 
            $insert_data=[
                'menugroup_id'       =>$menugroup_id,
                'menugroup_name'     =>clean_input($this->input->post('menugroup_name')),
                'menugroup_menus'    =>json_encode($this->input->post('menugroup_menus')),
            ];
            $response=data_insert('menugroup_mst',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"Menu Group Created Successfully.");
                redirect('menu_group_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('menu_group_form','refresh');
            }
               
        }
           
    }
    function menu_group_edit($menugroup_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }    
        $page_data['menugroup_data']=$this->master->get_menugroup_data($menugroup_id)->row(); 
        $page_data['title']= 'Menu Group Edit'; 
        $page_data['menutype_data']=get_table_data('menu_type_mst','menutype_id,menutype_name',"menutype_status=1 ORDER BY menutype_order")->result(); 
        $page_data['page_name']='master_setup/menu_group_edit';
        $this->load->view('backend/index',$page_data);
    }
    function menu_group_update($menugroup_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }    
        $this->form_validation->set_rules('menugroup_name','Menu Title ','trim|required');
        $this->form_validation->set_rules('menugroup_menus[]','Menu Name','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }   
            $page_data['title']= 'Menu Group Edit';
            $page_data['menutype_data']=get_table_data('menu_type_mst','menutype_id,menutype_name',"menutype_status=1 ORDER BY menutype_order")->result(); 
            //$page_data['menu_data']=get_table_data('menu_mst,menu_type_mst','menu_id,menu_name,menutype_name,menu_typeid',"menu_status=1 AND menu_typeid=menutype_id ORDER BY menu_typeid,menu_name")->result();
            $page_data['page_name']='master_setup/menu_group_form';
            $this->load->view('backend/index',$page_data);
        }else{ 
            $update_data=[
                'menugroup_id'       =>$menugroup_id,
                'menugroup_name'     =>clean_input($this->input->post('menugroup_name')),
                'menugroup_menus'    =>json_encode($this->input->post('menugroup_menus')),
            ];
            $response=data_update('menugroup_mst','menugroup_id',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg'," Menu Group  Updated Successfully.");
                redirect('menu_group','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('menu_group/'.$user_id,'refresh');
            }
               
        }
    }
    function menu_group_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $menugroup_id=clean_input($this->input->post('id'));
        $data=[

            'menugroup_id'       =>$menugroup_id, 
			'menugroup_status'	 =>1,

            ];
        $response= data_update('menugroup_mst', 'menugroup_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function menu_group_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $menugroup_id=clean_input($this->input->post('id'));
        $data=[

            'menugroup_id'       =>$menugroup_id, 
			'menugroup_status'	 =>2,

            ];
        $response= data_update('menugroup_mst', 'menugroup_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function menu_group_delete(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $menugroup_id=clean_input($this->input->post('id'));
        
        $delete_data=[ 
             
            'menugroup_id'       =>$menugroup_id, 
			'menugroup_cancel'	 =>2,
          ];
        $response= data_update('menugroup_mst','menugroup_id',$delete_data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function user_menu_assign(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['user_menu_assign_data']=$this->master->get_usermenu_assign_data()->result(); 
        $page_data['title']= 'User Menu Assign'; 
        $page_data['page_name']='master_setup/user_menu_assign';
        $this->load->view('backend/index',$page_data);
    }
    function user_menu_assign_form(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['users_data']=get_table_data('users_mst','user_name,user_id',"user_role=2 AND user_cancel=1 AND user_status=1")->result();
        $page_data['menugroup_data']=get_table_data('menugroup_mst','menugroup_id,menugroup_name',"menugroup_status=1 AND menugroup_cancel=1")->result();
        $page_data['title']= 'User Menu Assign Add'; 
        $page_data['page_name']='master_setup/user_menu_assign_form';
        $this->load->view('backend/index',$page_data);
    }
    function user_menu_assign_add(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }    
        $this->form_validation->set_rules('uml_userid','User Name','trim|required|is_unique[user_menu_link.uml_userid]');
        $this->form_validation->set_rules('uml_menugpid[]','Menu Group','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }   
            $page_data['users_data']=get_table_data('users_mst','user_name,user_id',"user_role=2 AND user_cancel=1 AND user_status=1")->result();
            $page_data['menugroup_data']=get_table_data('menugroup_mst','menugroup_id,menugroup_name',"menugroup_status=1 AND menugroup_cancel=1")->result();
            $page_data['title']= 'User Menu Assign Add'; 
            $page_data['page_name']='master_setup/user_menu_assign_form';
            $this->load->view('backend/index',$page_data);
        }else{ 
            $uml_id  =get_pk_id('user_menu_link','uml_id'); 
            $insert_data=[
                'uml_id'         =>$uml_id ,
                'uml_userid'     =>clean_input($this->input->post('uml_userid')),
                'uml_menugpid'   =>json_encode($this->input->post('uml_menugpid')),
            ];
            $response=data_insert('user_menu_link',$insert_data);
            if($response){
                $this->session->set_flashdata('msg',"User Menu Assigned Successfully.");
                redirect('menu_assign_form','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('menu_assign_form','refresh');
            }
        }
    }
    function user_menu_assign_edit($uml_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['user_menu_assign_data']=$this->master->get_usermenu_assign_data($uml_id)->row(); 

        $page_data['users_data']=get_table_data('users_mst','user_name,user_id',"user_role=2 AND user_cancel=1 AND user_status=1")->result();
        $page_data['menugroup_data']=get_table_data('menugroup_mst','menugroup_id,menugroup_name',"menugroup_status=1 AND menugroup_cancel=1")->result();
        $page_data['title']= 'User Menu Assign Add'; 
        $page_data['page_name']='master_setup/user_menu_assign_edit';
        $this->load->view('backend/index',$page_data);
    }
    function  user_menu_assign_update($uml_id){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }    
        $this->form_validation->set_rules('uml_userid','User Name','trim|required');
        $this->form_validation->set_rules('uml_menugpid[]','Menu Group','trim|required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if($this->form_validation->run() == FALSE){ 
            if(!$this->session->userdata('userlogin')){
                redirect('login');
            }   
            $page_data['user_menu_assign_data']=$this->master->get_usermenu_assign_data($uml_id)->row(); 
            $page_data['users_data']=get_table_data('users_mst','user_name,user_id',"user_role=2 AND user_cancel=1 AND user_status=1")->result();
            $page_data['menugroup_data']=get_table_data('menugroup_mst','menugroup_id,menugroup_name',"menugroup_status=1 AND menugroup_cancel=1")->result();
            $page_data['title']= 'User Menu Assign Add'; 
            $page_data['page_name']='master_setup/user_menu_assign_edit';
            $this->load->view('backend/index',$page_data);
        }else{ 
            $update_data=[
                'uml_id'         =>$uml_id ,
                'uml_userid'     =>clean_input($this->input->post('uml_userid')),
                'uml_menugpid'   =>json_encode($this->input->post('uml_menugpid')),
            ];
            $response=data_update('user_menu_link','uml_id',$update_data);
        
            if($response){
                $this->session->set_flashdata('msg',"User Menu Updated Successfully.");
                redirect('menu_assign','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('menu_assign_edit/'.$uml_id,'refresh');
            }
            
        }
    }
    function user_menu_assign_active(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $uml_id=clean_input($this->input->post('id'));
        $data=[

            'uml_id'       =>$uml_id, 
			'uml_status'   =>1,

            ];
        $response= data_update('user_menu_link', 'uml_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }


    function user_menu_assign_inactive(){
         if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $uml_id=clean_input($this->input->post('id'));
        $data=[

            'uml_id'       =>$uml_id, 
			'uml_status'   =>2,

            ];
        $response= data_update('user_menu_link', 'uml_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }










}

    