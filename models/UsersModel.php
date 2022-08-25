<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!');

class UsersModel extends CI_Model{
    function __construct(){
        parent::__construct();
    } 
    function get_country(){ 
        if(!empty($sum_id)){
    		$condition="AND sum_id=$sum_id";
    	}else{
			$condition="";
    	} 
        $sql="SELECT COM_COCD,COM_CONM,COM_CODE,COM_ISDC,COM_CYTP,COM_CYSR,COM_STAT,
        CASE WHEN COM_STAT=1  THEN   'Active' ELSE 'Inactive' END  Status
        FROM cou_mst   WHERE COM_CANC=1  $condition  ORDER BY COM_CONM ";
        $query=$this->db->query($sql);
        return $query;
    }
    
    function get_state($STM_STCD=null){ 
        if(!empty($STM_STCD)){
    		$condition="AND  STM_STCD=$STM_STCD";
    	}else{
			$condition="";
    	}
         
        $sql="SELECT STM_STCD,STM_COCD,STM_STNM,
        (SELECT COM_CONM FROM cou_mst WHERE COM_COCD=STM_COCD) AS country
        FROM sta_mst WHERE STM_CANC=1  $condition ORDER BY STM_STNM  ";
        $query=$this->db->query($sql);
        return $query;
    }
    
    function get_district($DSM_DSCD=NULL){ 
        $condition="";
        if(!empty($DSM_DSCD)){
    		$condition .="AND DSM_DSCD=$DSM_DSCD";
    	}else{
            if(!empty($state_id)){
                $condition .=" AND DSM_STCD=$state_id ";
            }
			
    	} 
        $sql="SELECT DSM_DSCD, DSM_STCD, DSM_CODE, DSM_SHNM, DSM_DSNM,
        (SELECT STM_STNM FROM sta_mst WHERE DSM_STCD=STM_STCD) AS state
        FROM dst_mst01 WHERE DSM_CANC=1  $condition ORDER BY state,DSM_DSNM $pagination";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_block($BLM_BLCD=NULL){ 
        $condition="";
        if(!empty($BLM_BLCD)){
    		$condition.="AND BLM_BLCD=$BLM_BLCD";
    	}
        if(!empty($dist_id)){
    		$condition.="AND BLM_DSCD=$dist_id";
    	} 
        $sql="SELECT BLM_BLCD, BLM_DSCD, BLM_CODE, BLM_BLNM, 
        (SELECT DSM_DSNM FROM dst_mst WHERE BLM_DSCD=DSM_DSCD)as district 
        FROM blk_mst01 WHERE BLM_CANC=1  $condition ORDER BY district,BLM_BLNM $pagination";
        $query=$this->db->query($sql);
        return $query;
    }
   
    function get_user_role_data($USR_URCD=null){
        if(!empty($USR_URCD)){
            $condition="AND USR_URCD=$USR_URCD";
        }else{
           $condition='';
        }
        $sql="SELECT USR_URCD,USR_CTCD,USR_MNCD,
        (SELECT USC_CTNM FROM USR_CAT WHERE USC_CTCD=USR_CTCD) as category_name,
        (SELECT MNM_MNNM FROM mnu_mst WHERE MNM_MNCD=USR_MNCD) as menu_name
        FROM  USR_ROL WHERE  USR_CANC=1 $condition ORDER BY  USR_URCD"; 
        $query=$this->db->query($sql);//
        return $query;
    } 
    function get_user_data($USM_USID =null){ 
        if(!empty($USM_USID)){
            $condition="AND USM_USID =$USM_USID ";
        }else{
           $condition='';
        }
        $sql="SELECT USM_USID,USM_USNM,USM_MBNO,USM_MAIL,USM_LGID,USM_PASS,USM_CNPS,USM_CTCD,USM_DSCD,USM_BLCD,USM_SCCD,   
        (SELECT USC_CTNM FROM USR_CAT WHERE USC_CTCD=USM_CTCD) as category_name,
        (SELECT DSM_DSNM FROM dst_mst01 WHERE DSM_DSCD=USM_DSCD) as District ,
        (SELECT BLM_BLNM FROM blk_mst01 WHERE BLM_BLCD=USM_BLCD) as block_name,
        (SELECT scm_name FROM school_mst WHERE scm_id=USM_BLCD) as school_name,
        (SELECT scm_udisecode  FROM school_mst WHERE scm_id=USM_SCCD) as school_udisecode
        FROM usr_mst   WHERE USM_CANC=1  $condition  ";
        $query=$this->db->query($sql);
        return $query;
    }

    function get_teacher_data($tem_id=null){
        if(!empty($tem_id)){
    		$condition="AND tem_id=$tem_id";
    	}else{
			$condition="";
    	} 
        $sql="SELECT tem_id, tem_scm_id, tem_name, tem_designation_id, tem_fathername, tem_dob, tem_email, tem_mob, tem_address,
        (SELECT scm_udisecode FROM school_mst WHERE scm_id=tem_scm_id) as school_usdise,
        (SELECT scm_name FROM school_mst WHERE scm_id=tem_scm_id) as school_name
         FROM teacher_mst WHERE tem_cancel=1 $condition Order By tem_scm_id,tem_name  ";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_teacher_nameDesignation($USM_SCCD=''){
        if(!empty($sum_id)){
    		$condition="AND sum_id=$sum_id";
    	}else{
			$condition="";
    	}  
        $sql="SELECT tem_id, tem_scm_id, tem_name, tem_designation_id,
        (SELECT COM_CMNM FROM com_mst WHERE COM_CMCD=tem_designation_id) as designation
        FROM teacher_mst,school_mst  WHERE scm_id=tem_scm_id  
        AND tem_cancel=1   
        $condition Order By tem_scm_id,tem_name"; 
        $query=$this->db->query($sql);
        return $query;
    }

    
}