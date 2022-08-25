<?php
if(!defined('BASEPATH')) exit('No direct script access allowed!.');

class CommonModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function check_user_login($username, $password){
        $sql="SELECT * FROM users_mst WHERE BINARY user_username =? AND user_password = ? AND user_cancel=?"; //AND user_status=?
        $query=$this->db->query($sql,[$username,$password,1]);
        return $query->row();
    }
    function get_country_data(){
        $sql="SELECT COM_COCD,COM_CONM FROM cou_mst WHERE COM_STAT=1 AND COM_CANC=1";
        $query=$this->db->query($sql);
        return $query;
    }

    /**  Website Page  */
    function get_banner_data(){
        $sql="SELECT banner_name FROM banner_mst WHERE  banner_status=1 AND banner_cancel=1 ORDER BY banner_order";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function get_event_data(){
        $sql=" SELECT event_id,event_title,event_name FROM event_gallery WHERE event_cancel=1  AND event_status=1  ";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function get_counter_data(){
        $sql="SELECT TOT_ADDS,TOT_USERS,TOT_ACTIVE_USERS FROM(
            (SELECT COUNT(*)AS TOT_ADDS FROM posts WHERE post_isverified=1 AND post_cancel=1) AS TOT_ADDS,
            (SELECT COUNT(*)AS TOT_USERS FROM users_mst WHERE  user_role=3 AND user_cancel=1) AS TOT_USERS,
            (SELECT COUNT(*)AS TOT_ACTIVE_USERS FROM users_mst WHERE user_role=3 AND user_cancel=1 AND is_verified=1) AS TOT_ACTIVE_USERS
        )";
        $query=$this->db->query($sql);
        return $query->row();
    }
    function get_page_details($page_type){
        $sql="SELECT page_title,page_img,page_content,page_type FROM page_details WHERE  page_cancel=1 AND page_type=$page_type";
        $query=$this->db->query($sql);
        return $query->row();
         
    }
    function get_web_setting_data(){ 
        $sql="SELECT web_name, web_regno, web_gstno, web_panno, web_mobile, web_mobilealt, web_email, web_address, web_pincode,web_admin,web_complaint,web_paymentIssue,web_Inquiry, web_headerlogo, web_footerlogo, web_ceosign, web_innerbanner  FROM web_setting   WHERE web_cancel=1   ";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_latest_postdata(){
        $sql="SELECT post_id,post_isverified,post_serviceid,post_userid,post_title,post_description,post_banner,post_date, post_categoryid,post_subcategoryid,post_status,
        CASE WHEN post_isverified=1 THEN 'Verified' ELSE 'Not Verified' END AS verify_status,
        (SELECT DSM_DSNM FROM dst_mst WHERE DSM_DSCD=post_districtid)as district,
        (SELECT GPM_GPNM FROM gp_mst WHERE GPM_GPCD=post_gpid) AS panchayat,
        (SELECT VLM_VLNM FROM vlg_mst WHERE VLM_VLCD=post_village) AS village,
        IFNULL((SELECT pov_count FROM post_visits WHERE pov_postid=post_id), 0) AS tot_visitors,
        CONCAT(post_address,',',post_pincode) AS full_address,
        CASE WHEN udm_cpmobile='' THEN 	user_mobile ELSE udm_cpmobile END  usermobile,
        CASE WHEN udm_cpmobile_alt='' THEN 	user_mobile_alt ELSE udm_cpmobile_alt END  usermobile_alt,
        CASE WHEN udm_cpemail='' THEN user_email ELSE udm_cpemail END  useremail,
        CASE WHEN udm_cpname='' THEN user_name ELSE udm_cpname END  username,
        CASE WHEN user_firmname='' THEN user_name ELSE user_firmname END  firmname,
        user_username            
        FROM  posts,users_mst,user_detail_mst WHERE  post_cancel=1 AND  post_status=1 AND post_isverified=1 AND  post_approveddate >= DATE(NOW() - INTERVAL 7 DAY)";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function get_notice_data(){
        $this->db->where('cancel',1);
        $this->db->where('status',1);
        $query =$this->db->get('notice_mst');
        $result =$query->result();
        $notice ="";
        $has =$query->num_rows();
        if($result){
            if($has === 1){
                foreach($result as $data){
                    $notice .=$data->notice;
                }
            }else{
                foreach($result as $data){
                    $notice .=$data->notice." | ";
                }
            }
            
        }
        return $notice;
    }
    function service_type_list(){
       
    }
 

    /**=========================================================================================================================================== */
    //Home Page Filter list ',GPM_GPNM,'
    function get_filter_village(){
        $sql="SELECT DISTINCT  VLM_VLCD,CONCAT(VLM_VLNM,', ',BLM_BLNM,', ',DSM_DSNM,', ',STM_STNM) AS ADDRESS 
        FROM posts,vlg_mst,blk_mst,dst_mst,sta_mst 
        WHERE post_isverified=1 AND post_status=1 AND post_cancel=1 AND 
        post_village=VLM_VLCD AND 
        post_blockid=BLM_BLCD AND 
        post_districtid=DSM_DSCD AND 
        post_stateid=STM_STCD 
        ORDER BY VLM_VLNM";
        $query=$this->db->query($sql);
        return $query->result();
    }



    //home page category wise post show
    function get_active_postdata(){
        $sql="SELECT TOTMATRIMONEY,TOTJOB,TOTSERVICE,TOTPRODUCT,TOTEDUCATION,TOTHOTEL,TOTPROPERTY,TOTRESALE FROM( 
            (SELECT COUNT(*)AS TOTMATRIMONEY FROM matrimonial_profile, users_mst WHERE mat_userid=user_id AND is_verified=1 AND user_cancel=1 AND user_status=1 AND user_expdate >=CURDATE()) AS TOTMATRIMONEY,
            (SELECT COUNT(*)AS TOTJOB FROM posts WHERE post_serviceid=2 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTJOB,
            (SELECT COUNT(*)AS TOTSERVICE FROM posts WHERE post_serviceid=3 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTSERVICE,
            (SELECT COUNT(*)AS TOTPRODUCT FROM posts WHERE post_serviceid=4 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTPRODUCT,
            (SELECT COUNT(*)AS TOTEDUCATION FROM posts WHERE post_serviceid=5 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTEDUCATION,
            (SELECT COUNT(*)AS TOTHOTEL FROM posts WHERE post_serviceid=6 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTHOTEL,
            (SELECT COUNT(*)AS TOTPROPERTY FROM posts WHERE post_serviceid=7 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTPROPERTY,
            (SELECT COUNT(*)AS TOTRESALE FROM posts WHERE post_serviceid=8 AND post_cancel=1 AND post_status=1 AND post_isverified=1  AND post_expdate >=CURDATE()) AS TOTRESALE
            )";
        $query=$this->db->query($sql);
        return $query->row();
    }

    /* ADVERTISIMENT SECTION  CURDATE()*/
    function get_post_list_data($service_id,$limit='',$page=''){
        $pagination="";
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }

        if($service_id == 1){ //Matrimonial
            $sql="";
        }else{
            $sql="SELECT post_id,post_isverified,post_serviceid,post_userid,post_title,post_description,post_banner,post_date, post_categoryid,post_subcategoryid,post_status,
            CASE WHEN post_isverified=1 THEN 'Verified' ELSE 'Not Verified' END AS verify_status,
            (SELECT DSM_DSNM FROM dst_mst WHERE DSM_DSCD=post_districtid)as district,
            (SELECT GPM_GPNM FROM gp_mst WHERE GPM_GPCD=post_gpid) AS panchayat,
            (SELECT VLM_VLNM FROM vlg_mst WHERE VLM_VLCD=post_village) AS village,
            IFNULL((SELECT pov_count FROM post_visits WHERE pov_postid=post_id), 0) AS tot_visitors,
            CONCAT(post_address,',',post_pincode) AS full_address,
            CASE WHEN udm_cpmobile='' THEN 	user_mobile ELSE udm_cpmobile END  usermobile,
            CASE WHEN udm_cpmobile_alt='' THEN 	user_mobile_alt ELSE udm_cpmobile_alt END  usermobile_alt,
            CASE WHEN udm_cpemail='' THEN user_email ELSE udm_cpemail END  useremail,
            CASE WHEN udm_cpname='' THEN user_name ELSE udm_cpname END  username,
            CASE WHEN user_firmname='' THEN user_name ELSE user_firmname END  firmname,
            user_username            
            FROM  posts,users_mst,user_detail_mst WHERE post_serviceid=$service_id AND post_cancel=1 AND  post_status=1 AND post_isverified=1 AND post_expdate >=CURDATE() AND post_userid=user_id AND user_id=udm_userid $pagination";
        }
        $query=$this->db->query($sql);
        return $query->result();
    }
    function get_post_data($service_id,$post_id){
        $com_sql="(SELECT COM_CONM FROM cou_mst WHERE COM_COCD=post_countryid) AS country,
        (SELECT service_name FROM service_type WHERE id=POST_serviceid) AS service_name,
        (SELECT STM_STNM FROM sta_mst WHERE STM_STCD=post_stateid)AS state,
        (SELECT DSM_DSNM FROM dst_mst WHERE DSM_DSCD=post_districtid)AS district,
        (SELECT BLM_BLNM FROM blk_mst WHERE BLM_BLCD=post_blockid)AS block,
        (SELECT GPM_GPNM FROM gp_mst WHERE GPM_GPCD=post_gpid) AS panchayat,
        (SELECT VLM_VLNM FROM vlg_mst WHERE VLM_VLCD=post_village) AS village,
        (SELECT LOM_LONM FROM locality_mst WHERE LOM_LOCD=post_locality) AS Locality,
        IFNULL((SELECT pov_count FROM post_visits WHERE pov_postid=post_id), 0) AS tot_visitors,
        CONCAT(post_address,',',post_pincode) AS full_address, post_address,post_pincode";

        if($service_id == 4){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_categoryid,post_subcategoryid,post_description,post_banner,post_date ";
        }
        elseif($service_id == 3){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_categoryid,post_subcategoryid,post_description,post_banner,post_date,post_Sworkingday,post_SworkhourF,post_SworkhourT,post_Sstartyear,post_Semployee";
        }
        elseif($service_id == 2){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_categoryid,post_subcategoryid,post_description,post_banner,post_date,post_Jworktype,post_Jvacancy,post_Jminsalary,post_Jmaxsalary,post_Jminexp,post_Jmaxexp";
        }
        elseif($service_id == 5){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_categoryid,post_subcategoryid,post_description,post_banner,post_date, post_Ename,post_Efees,post_Edeliverymode, post_Eduration,post_Eboard,post_Eeligibility,post_Eclassdays,post_Euniversity";
        }
        elseif($service_id == 6){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_categoryid,post_subcategoryid,post_description,post_banner,post_date, post_Hfacility, post_Hpricefrom, post_Hpriceto";
        }
        elseif($service_id == 7){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_description,post_banner,post_date,post_categoryid,post_subcategoryid, post_Pproptype, post_Parea, post_Pcarpetarea, post_Psqrate, post_Pprice, post_Pavldate, post_Pbedroom, post_Pbathroom, post_Pbalcony,post_countryid,post_stateid,post_districtid,post_blockid,post_gpid,post_village,post_address,post_pincode";
        }
        elseif($service_id == 8){
            $select_names="post_id,post_userid,post_serviceid,post_title,post_description,post_banner,post_date,post_categoryid,post_subcategoryid, post_Rbrand, post_Rmodel, post_Rpurchase, post_Rprice, post_Rfuel, post_Rkms,post_countryid,post_stateid,post_districtid,post_blockid,post_gpid,post_village,post_address,post_pincode";
        }
        $sql="SELECT $select_names , $com_sql  FROM  posts WHERE  post_cancel=1 AND post_expdate >=CURDATE() AND post_id=$post_id";
        $query=$this->db->query($sql);
        return $query->row();
    }

    /** search query */
    function get_post_list_data_search($village_id,$cat_id,$limit='',$page=''){
        $pagination="";
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
      
        $sql="SELECT post_id,post_isverified,post_serviceid,post_userid,post_title,post_description,post_banner,post_date, post_categoryid,post_subcategoryid,post_status,
        CASE WHEN post_isverified=1 THEN 'Verified' ELSE 'Not Verified' END AS verify_status,
        (SELECT DSM_DSNM FROM dst_mst WHERE DSM_DSCD=post_districtid)as district,
        (SELECT GPM_GPNM FROM gp_mst WHERE GPM_GPCD=post_gpid) AS panchayat,
        (SELECT VLM_VLNM FROM vlg_mst WHERE VLM_VLCD=post_village) AS village,
        IFNULL((SELECT pov_count FROM post_visits WHERE pov_postid=post_id), 0) AS tot_visitors,
        CONCAT(post_address,',',post_pincode) AS full_address,
        CASE WHEN udm_cpmobile='' THEN 	user_mobile ELSE udm_cpmobile END  usermobile,
        CASE WHEN udm_cpmobile_alt='' THEN 	user_mobile_alt ELSE udm_cpmobile_alt END  usermobile_alt,
        CASE WHEN udm_cpemail='' THEN user_email ELSE udm_cpemail END  useremail,
        CASE WHEN udm_cpname='' THEN user_name ELSE udm_cpname END  username,
        CASE WHEN user_firmname='' THEN user_name ELSE user_firmname END  firmname,
        user_username            
        FROM  posts,users_mst,user_detail_mst WHERE post_cancel=1 AND  post_status=1 AND post_isverified=1 AND post_expdate >=CURDATE() AND post_userid=user_id AND user_id=udm_userid AND post_village=$village_id AND post_categoryid LIKE '%$cat_id%' $pagination";
        //AND JSON_CONTAINS(post_categoryid, JSON_QUOTE('$cat_id'))
        $query=$this->db->query($sql);
        return $query->result();
    }
    function get_website_query(){
        $sql="SELECT web_id, web_name, web_phoneNo, web_email, web_msg FROM website_inquiry WHERE web_cancel=1   ";
        $query=$this->db->query($sql);
        return $query;
    }

    function get_attention_data(){
        $sql="SELECT atn_id,atn_name FROM attention  WHERE atn_cancel=1";
        $query=$this->db->query($sql);
        return $query;
    }



    /** EXCEL IMPORT AND EXPORT */
    function company_data(){
        $sql="SELECT com_companyname,CASE WHEN com_status=1 THEN 'Active' ELSE 'Inactive' END AS status FROM company_mst  
        WHERE com_cancel=1 ORDER BY com_companyname";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function block_data(){
        $sql="SELECT BLM_BLNM,(SELECT DSM_DSNM FROM dst_mst WHERE BLM_DSCD=DSM_DSCD)as district
        FROM blk_mst WHERE BLM_CANC=1 ORDER BY district,BLM_BLNM";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function village_data(){
        $sql="SELECT VLM_VLNM,BLM_BLNM,
        (SELECT DSM_DSNM FROM dst_mst WHERE BLM_DSCD=DSM_DSCD)as district
        FROM vlg_mst,blk_mst WHERE VLM_CANC=1 AND VLM_BLCD=BLM_BLCD ORDER BY district,BLM_BLNM,VLM_VLNM";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function locality_data(){
        $sql="SELECT LOM_LONM,VLM_VLNM, 
        (SELECT BLM_BLNM FROM blk_mst WHERE BLM_BLCD=VLM_BLCD) AS block
        FROM locality_mst,vlg_mst WHERE LOM_CANC=1 AND LOM_VLCD=VLM_VLCD ORDER BY block,VLM_VLNM,LOM_LONM";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function category_data(){
        $sql="SELECT category,
        CASE WHEN status=1 THEN 'Active' ELSE 'Inactive ' END  status,
        (SELECT service_name FROM service_type WHERE id=service_type) as service
        FROM categories_mst WHERE cancel=1 AND service_type=2 ORDER BY service,category";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function subcategory_data($service_id){
        $sql="SELECT category,sum_subcategory,
        CASE WHEN sum_status=1 THEN 'Active' ELSE 'Inactive' END  sum_status
        FROM  subcategory_mst,categories_mst
        WHERE sum_cancel=1  AND sum_categoryid=cat_id AND sum_categoryid=$service_id
        ORDER BY category,sum_subcategory";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function caste_data(){
        $sql="SELECT cam_castename,
        CASE WHEN cam_status=1 THEN 'Active' ELSE 'Inactive' END Status,
        (SELECT COM_CMNM FROM com_mst WHERE COM_CMCD=cam_religionid) as religion 
        FROM caste_mst WHERE cam_cancel=1 ORDER BY religion,cam_castename";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function course_data(){
        $sql="SELECT  esm_course,
        CASE WHEN esm_status=1 THEN 'Active' ELSE 'Inactive' END Status,
        (SELECT sum_subcategory FROM subcategory_mst WHERE sum_id=esm_courseid) as subcategory
        FROM education_subcourse_mst WHERE esm_cancel=1 ORDER BY subcategory,esm_course";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function subject_data(){
        $sql="SELECT subject_name,
        CASE WHEN subject_status=1 THEN 'Active' ELSE 'Inactive' END Status
        FROM subject_mst WHERE subject_cancel=1 ORDER BY subject_name";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function brand_data(){
        $sql="SELECT brand_name,
        CASE WHEN brand_status=1 THEN 'Active' ELSE 'Inactive' END Status
        FROM brand_mst WHERE brand_cancel=1 ORDER BY brand_name";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function model_data(){
        $sql="SELECT model_name,
        CASE WHEN model_status=1 THEN 'Active' ELSE 'Inactive' END Status,
        (SELECT brand_name FROM brand_mst WHERE brand_id=model_brandid) as brand_name
        FROM model_mst WHERE model_cancel=1 ORDER BY brand_name,model_name";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function subservice_data(){
        $sql="SELECT ssm_name,
        CASE WHEN ssm_status=1 THEN 'Active' ELSE 'Inactive' END Status,
        (SELECT sum_subcategory FROM subcategory_mst WHERE sum_id=ssm_sumid) AS sub_category
        FROM sub_servicemst  WHERE ssm_cancel=1 ORDER BY sub_category,ssm_name";
        $query=$this->db->query($sql);
        return $query->result();
    }
    function members_data(){
        $sql="SELECT user_joindate,user_parentid,user_username,user_name,user_firmname,user_mobile,user_rawpsw,
         CASE WHEN is_verified=1 THEN 'Verified' ELSE 'Unverified' END Status,     
        (SELECT service_name FROM service_type WHERE  id=user_serviceid) AS service_name       
        FROM users_mst WHERE user_cancel=1 AND user_ispayment=1 AND user_role=3";
        $query=$this->db->query($sql);
        return $query->result();
    }


}