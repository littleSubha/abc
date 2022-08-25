<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!.');

class MemberController extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('user_name');
        $this->system_name=gethostname();
        $this->user_role=$this->session->userdata('user_role');
        $this->load->model('backend/MemberModel','member',true);
        $this->load->model('user/UserModel','user',TRUE);
        $this->load->model('CommonModel','common',TRUE);
    }
    function members_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $config =[
            'base_url'=>base_url('members_list'),
            'per_page'=>'100',
            'total_rows'=>total_record('users_mst','user_cancel=1 AND is_verified=1 AND user_ispayment=1 AND user_role=3'),
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


        $page_data['profile_data'] =$this->user->get_profile_data($this->login_id);
		$page_data['members_data']=$this->member->get_members_list($config['per_page'],$page)->result();
		$page_data['title']='Member List';
        $page_data['page_name']='member/members_list';
        $this->load->view('backend/index',$page_data);
    }
    function members_approval_list(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['members_data']=$this->member->get_new_members_list()->result();
		$page_data['title']='New Members Approval List';
        $page_data['page_name']='member/members_approval_list';
        $this->load->view('backend/index',$page_data);        
    }
    
    function members_view($user_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $service_type =get_column_value('users_mst','user_serviceid',"user_id=$user_id");
        if(intval($service_type) !== 1){           
            $page_data['profile_detail_data'] =$this->user->get_profile_details_data($user_id); 
            $page_data['page_name']='member/members_view';        
        }else{
            $page_data['mat_profiledata'] =$this->user->get_matromonial_data($user_id);
            $page_data['page_name']='member/members_view2';
        }
        $page_data['profile_data'] =$this->user->get_profile_data($user_id);
        $page_data['country_data'] =$this->common->get_country_data()->result();
        $page_data['service_type']=get_table_data('service_type','id,service_name',"cancel=1  ORDER BY service_name ")->result();
        $page_data['join_type']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=7 ORDER BY COM_CMNM ")->result();
        $page_data['blood_groops']=get_table_data('com_mst','COM_CMCD,COM_CMNM',"COM_CANC=1 AND COM_TPCD=20 ORDER BY COM_CMNM ")->result();
        $page_data['members_data']=$this->member->get_new_members_data($user_id)->row();
		$page_data['title']='New Members Profile';
       
        $this->load->view('backend/index',$page_data);      
    }

    function member_verify(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $user_id=clean_input($this->input->post('id'));
        $data=[
			'user_id'                   =>$user_id, 
			'is_verified'	            =>1,
            'user_approved_by'          =>$this->login_id,
            'user_approve_date'         =>system_date(),
            'user_approve_ip'           =>get_ip(),
            'user_approve_name'         =>$this->login_name, 
            'user_approve_systemname'   =>$this->system_name,
        ];
        $response= data_update('users_mst', 'user_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function member_unverify(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $user_id=clean_input($this->input->post('id'));
        $data=[
			'user_id'                   =>$user_id, 

			'is_verified'	            =>2,
            'user_approved_by'          =>$this->login_id,
            'user_approve_date'         =>system_date(),
            'user_approve_ip'           =>get_ip(),
            'user_approve_name'         =>$this->login_name, 
            'user_approve_systemname'   =>$this->system_name,
        ];
        $response= data_update('users_mst', 'user_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function member_inactive(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $user_id=clean_input($this->input->post('id'));
        $data=[
			'user_id'                   =>$user_id, 
			'user_status'	            =>2,
            'user_approved_by'          =>$this->login_id,
            'user_approve_date'         =>system_date(),
            'user_approve_ip'           =>get_ip(),
            'user_approve_name'         =>$this->login_name, 
            'user_approve_systemname'   =>$this->system_name,
        ];
        $response= data_update('users_mst', 'user_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function member_active(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $user_id=clean_input($this->input->post('id'));
        $data=[
			'user_id'                   =>$user_id, 
			'user_status'	            =>1,
            'user_approved_by'          =>$this->login_id,
            'user_approve_date'         =>system_date(),
            'user_approve_ip'           =>get_ip(),
            'user_approve_name'         =>$this->login_name, 
            'user_approve_systemname'   =>$this->system_name,
        ];
        $response= data_update('users_mst', 'user_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function members_edit($user_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $service_type =get_column_value('users_mst','user_serviceid',"user_id=$user_id");
        // if(intval($service_type) !== 1){           
        //     $page_data['profile_detail_data'] =$this->user->get_profile_details_data($user_id); 
        //     $page_data['page_name']='member/members_edit';        
        // }else{
        //     $page_data['mat_profiledata'] =$this->user->get_matromonial_data($user_id);
        //     $page_data['page_name']='member/members_edit';
        // }
        $page_data['members_data']=$this->member->get_new_members_data($user_id)->row();
		$page_data['title']='New Members Edit';
        $page_data['page_name']='member/members_edit';
        $this->load->view('backend/index',$page_data);      
    }


    function members_update($user_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $this->form_validation->set_rules('user_name','User Name','trim|required');
        //$this->form_validation->set_rules('user_firmname',' Firm Name','trim|required');
        $this->form_validation->set_rules('user_email','User Email','trim|required');
        $this->form_validation->set_rules('user_mobile','User Mobile Number ','trim|required');

        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if($this->form_validation->run() == FALSE){
            if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
                redirect('login');
            }
            $page_data['members_data']=$this->member->get_new_members_data($user_id)->row();
            $page_data['title']='New Members Edit';
            $page_data['page_name']='member/members_edit';
            $this->load->view('backend/index',$page_data);      
        }else{ 
            $update_data=[
                'user_id'                =>$user_id,
                'user_name'              => clean_input($this->input->post('user_name')),
                'user_firmname'          => string_ucword(clean_input($this->input->post('user_firmname'))), 
                'user_email'             => clean_input($this->input->post('user_email')),
                'user_mobile'            => clean_input($this->input->post('user_mobile')),

                'change_type'       	=>'Modified',
                'system_date'       	=>system_date(),
                'system_ip'         	=>get_ip(),
                'system_name'       	=>$this->login_name, 
            ];
            
            $response=data_update('users_mst','user_id',$update_data);
            if($response){
                $this->session->set_flashdata('msg',"User Updated Successfully.");
                redirect('members_list','refresh');
            }else{
                $this->session->set_flashdata('error',"Oops!. Error Occurred.");
                redirect('members_edit/',$user_id,'refresh');
            }
        }
        
    }
    function accounts_report(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $from_date="";
        $to_date="";
        if($this->input->method() == 'get'){
            $from_date =$this->input->get('from_date');
            $to_date =$this->input->get('to_date');
            $page_data['subtitle']='SALE STATEMENT FOR THE MONTH OF - '.date('M/Y',strtotime($from_date)) .' TO ' .date('M/Y',strtotime($to_date));
        }else{
            $page_data['subtitle']='SALE STATEMENT FOR THE MONTH OF - '.date('M/Y');
        }
        $page_data['from_date']=$from_date;
        $page_data['to_date']=$to_date;
		$page_data['accounts_data']=$this->member->get_accounts_report($this->login_id, $from_date,$to_date)->result();
		$page_data['title']='Account Report';       
        $page_data['page_name']='member/accounts_report';
        $this->load->view('backend/index',$page_data);
    }
    function commision_report(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $user_id ='';
        $from_date="";
        $to_date="";
        if($this->input->method() == 'get'){
            $user_id    =$this->input->get('u');
            $from_date  =$this->input->get('from_date');
            $to_date    =$this->input->get('to_date');
            $page_data['subtitle']='COMMISION STATEMENT FOR THE MONTH OF - '.date('M/Y',strtotime($from_date)) .' TO ' .date('M/Y',strtotime($to_date));
        }else{
            $page_data['subtitle']='COMMISION STATEMENT FOR THE MONTH OF - '.date('M/Y');
        }
        $page_data['user_id'] =$user_id;
        $page_data['from_date']=$from_date;
        $page_data['to_date']=$to_date;
       
        $page_data['commision_data']=$this->member->get_commision_report($from_date,$to_date)->result();
		$page_data['title']='Commision Report';       
        $page_data['page_name']='member/commision_report';
        $this->load->view('backend/index',$page_data);
    }
    function commision_report_details($user_id,$from_date="",$to_date=""){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        if(!empty($from_date) && !empty($to_date)){
            $month=date('M/Y',strtotime($from_date)) .' TO ' .date('M/Y',strtotime($to_date)) ;
        }else{
            $month=date('M/Y');
        }
        $page_data['commision_data']=$this->member->get_commision_report_details($user_id,$from_date,$to_date)->result();
		$page_data['title']='Commision Report Details';
        $page_data['subtitle']='COMMISION STATEMENT DETAILS FOR THE MONTH OF - '.$month;
        $page_data['page_name']='member/commision_report_details';
        $this->load->view('backend/index',$page_data);
    }
    function wallet_report(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['users_data']=$this->member->get_wallet_report()->result();
		$page_data['title']='Wallet Report';
        $page_data['page_name']='member/wallet_report';
        $this->load->view('backend/index',$page_data);
    }
    function approval_report(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $approval_type ='';
        $user_id ='';
        $from_date="";
        $to_date="";
        if($this->input->method() == 'post'){
            $approval_type    =$this->input->post('approval_type');
            $user_id    =$this->input->post('user');
            $from_date  =$this->input->post('from_date');
            $to_date    =$this->input->post('to_date');
            $page_data['approval_data']=$this->member->get_approval_report($approval_type,$user_id,$from_date,$to_date)->result();
        }else{
            $page_data['approval_data']=[];
        }
        $page_data['approval_type'] =$approval_type;
        $page_data['user_id'] =$user_id;
        $page_data['from_date']=$from_date;
        $page_data['to_date']=$to_date;

      

        $page_data['users_data']=get_table_data('users_mst','user_name,user_id',"user_role IN(1,2) AND user_cancel=1 AND user_status=1")->result();
		$page_data['title']='Approval Report';
        $page_data['page_name']='member/approval_report';
        $this->load->view('backend/index',$page_data);
    }

    function userapproval_report(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $user_id ='';
        if($this->input->method() == 'post'){
            $user_id    =$this->input->post('user');
            $page_data['approval_data']=$this->member->get_user_approval_details($user_id)->row();
            $page_data['post_approval_data']=$this->member->get_user_post_approval_details($user_id)->result();
            $page_data['gallery_approval_data']=$this->member->get_user_gallery_approval_details($user_id)->result();
        }else{
            $page_data['approval_data']=[];
        }
        $page_data['user_id'] =$user_id;

        $page_data['users_data']=get_table_data('users_mst','user_name,user_username,user_id',"user_role=3 AND user_cancel=1 AND user_status=1 ORDER BY user_name")->result();
		$page_data['title']='User Approval Details';
        $page_data['page_name']='member/userapproval_report';
        $this->load->view('backend/index',$page_data);
    }


    function gallery_list(){       
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['users_data']=get_table_data('img_gallery,users_mst','user_id,user_username,CASE WHEN (user_firmname ="") THEN user_name ELSE user_firmname END firm_name',' img_cancel=1 AND img_isverified=2 AND img_userid=user_id GROUP BY user_id')->result();
		$page_data['title']='Gallery Approval';
        $page_data['page_name']='member/gallery_list';
        $this->load->view('backend/index',$page_data);    
    }
    function gallery_verified(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $img_id=clean_input($this->input->post('id'));
        $data=[
			'img_id'                =>$img_id,

 			'img_isverified'	     =>1,
            'img_approvedby'         =>$this->login_id,
            'img_approveddate'       =>system_date(),
            'img_approvedip'         =>get_ip(),
            'img_changetype'         =>'Verified',
            'img_approvedsystemname' =>$this->system_name
        ];
 
        $response= data_update('img_gallery', 'img_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function gallery_unverified(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $img_id=clean_input($this->input->post('id'));
        $data=[
			'img_id'                =>$img_id, 

			'img_isverified'	     =>2,
            'img_approvedby'         =>$this->login_id,
            'img_approveddate'       =>system_date(),
            'img_approvedip'         =>get_ip(),
            'img_changetype'         =>'Unverified',
            'img_approvedsystemname' =>$this->system_name,
        ];
        $response= data_update('img_gallery', 'img_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function gallery_deleted(){
        if(!$this->session->userdata('userlogin') && $this->session->userdata('user_role') != 3){
            redirect('login');
        } 
        $uploadPath='uploads/gallery/'.$this->login_id."/";
        $gallery_data =get_table_data('img_gallery','img_name',"img_cancel=1 AND img_id=$img_id")->row();
        if($gallery_data){
            if(file_exists($uploadPath. $gallery_data->img_name)){
                unlink($uploadPath. $gallery_data->img_name);
            }
        }   
        $update_data=[
            'img_id'                =>$img_id,
            'img_cancel'            =>2,
            'img_loginid'           =>$this->login_id,
            'img_changetype'       	=>'Deleted',
            'img_systemdate'       	=>system_date(),
            'img_systemip'         	=>get_ip(),
            'img_systemname'       	=>$this->system_name,
        ];
        $response=data_update('img_gallery','img_id',$update_data);

        // $response=data_delete_p('img_gallery','img_id',$img_id);

        $response= data_update('img_gallery', 'img_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
    function post_list(){ 
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['post_servicetypes']=get_table_data('posts','post_serviceid,post_userid,(SELECT service_name FROM service_type WHERE id=post_serviceid) AS service_name',"post_isverified=2 AND post_cancel=1 AND post_status=1 GROUP BY post_serviceid")->result();
  		$page_data['title']='Post Approval';
        $page_data['page_name']='member/post_list';
        $this->load->view('backend/index',$page_data);
    }
    function post_view($user_serviceid="",$post_id=""){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        } 
        $page_data['post_data']=$this->member->get_postdetail_data_id($user_serviceid,$post_id);
        $page_data['users_data']=get_table_data('users_mst','user_firmname'," is_verified=1 ")->result();
		$page_data['title']='Post Approval';
        $page_data['page_name']='member/post_view';
        $this->load->view('backend/index',$page_data);
        
    }
    function post_verified(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $post_id=clean_input($this->input->post('id'));
        $data=[
			'post_id'                =>$post_id,
 			'post_isverified'	      =>1,
            'post_approvedby'         =>$this->login_id,
            'post_approveddate'       =>system_date(),
            'post_approvedip'         =>get_ip(),
            'post_approvedchangetype' =>'Verified',
            'post_approvedsystemname' =>$this->system_name
        ];
 
        $response= data_update('posts', 'post_id',$data);
        if($response){
            echo json_encode(["status"=>200,]);
        }else{
            echo json_encode(["status"=>500,]);
        }
    }
  
    /** Admin to Contact */
    function members_query(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['members']=$this->member->get_all_member_messages();
        $page_data['senderid'] =$this->login_id;
        //$page_data['chats']=$this->member->get_all_messages($this->login_id);
		$page_data['title']='Members Query';
        $page_data['page_name']='member/members_query_list';
        $this->load->view('backend/index',$page_data);  
    }
    function send_message_user(){
        $message =$this->input->post('message'); 
        $userid =$this->input->post('userid'); 
        $chat_id =get_pk_id('chats','chat_id');
        $insert_data=[
            'chat_id'              =>$chat_id,
            'chat_senderid'        =>$this->login_id,
            'chat_receiverid'      =>$userid,
            'chat_message'         =>$message,
            'chat_sendatetime'     =>get_date_time(),
            'chat_senip'           =>get_ip(),
            'chat_sensysname'      =>gethostname(),
        ];
        $response =data_insert2('chats',$insert_data); //transacton table data insert
        if($response){
            echo json_encode(['status' =>200,]);
        }
    }
    function website_inquery(){
       if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['webinquiry']=get_table_data('website_inquiry','*','web_type=1')->result();
        $page_data['title']='New Website Query';
        $page_data['page_name']='member/website_inquery';
        $this->load->view('backend/index',$page_data);  
    }
    function website_inquery_view($web_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['webinquiry_data']=get_table_data('website_inquiry','*',"web_type=1 AND web_id=$web_id")->row();
        $page_data['title']='New Website Query View';
        $page_data['page_name']='member/website_inquery_view';
        $this->load->view('backend/index',$page_data);  
    }
    function contact_query(){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['webinquiry']=get_table_data('website_inquiry','*','web_type=2')->result();
        $page_data['title']='Contact Query';
        $page_data['page_name']='member/contact_query';
        $this->load->view('backend/index',$page_data);  
    }

    function contact_query_view($web_id){
        if(!$this->session->userdata('userlogin') || $this->session->userdata('user_role') == 3 ){
            redirect('login');
        }
        $page_data['webinquiry_view']=get_table_data('website_inquiry','*',"web_type=2 AND web_id=$web_id")->row();
        $page_data['title']='Contact Query View';
        $page_data['page_name']='member/contact_query_view';
        $this->load->view('backend/index',$page_data);  
    }




    

}