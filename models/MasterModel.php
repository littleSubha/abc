<?php
if(!defined('BASEPATH')) exit('No direct script access allowed!.');

class MasterModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_userrole_data($role_id=NULL,$limit='',$page=''){
        $pagination="";
        if(!empty($role_id)){
            $condition="AND role_id=".$role_id;
        }else{
            $condition="";
           
        }
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        $sql="SELECT role_id,role_name,
        CASE
            WHEN role_type = 1 THEN 'All'
            WHEN role_type = 2 THEN 'District'
            WHEN role_type = 3 THEN 'School'
            WHEN role_type = 4 THEN 'Specified'
            ELSE ''
        END AS role_type,
        role_date,role_status,CASE WHEN  role_status=1 THEN 'Active' ELSE 'Inactive' END rolestatus 
        FROM user_role WHERE role_cancel=1  $condition $pagination";
         $query=$this->db->query($sql);//
         return $query;
    }
    function get_school_data($scm_id=null,$limit='',$page='',$scm_zone='',$scm_type=''){ 
        $condition="";
        $pagination="";
        if(!empty($scm_id)){
            $condition .=" AND scm_id=$scm_id";
        }else{
            if(!empty($scm_zone) && !empty($scm_type)){
                $condition .=" AND scm_zone=$scm_zone AND scm_type=$scm_type";
            }
            elseif(!empty($scm_type)){
                $condition=" AND scm_type=$scm_type";
            }elseif(!empty($scm_zone)){
                $condition=" AND scm_zone=$scm_zone";
            }
        }
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
      
        $sql ="SELECT scm_id,scm_name,scm_udisecode,scm_zone,scm_type,scm_hmname,scm_hmmobno,scm_incharge,scm_inchargemobno,scm_labtype,scm_hmname,scm_inchargemobno,scm_incharge,scm_distid,scm_block,scm_panchayat,scm_villageid,scm_village,scm_pincode,scm_address,scm_latitude,scm_longitude,
        CASE WHEN scm_labtype=1 THEN 'Lab' ELSE 'Lab & Class' END  labtype,
        (SELECT DSM_DSNM FROM dst_mst01 WHERE DSM_DSCD=scm_distid) as DSNM,
        (SELECT COM_CMNM FROM com_mst WHERE COM_CMCD=scm_zone) as zone_name,
        (SELECT COM_CMNM FROM com_mst WHERE COM_CMCD=scm_type) as school_type
        FROM school_mst 
        WHERE scm_status=1 
        AND scm_cancel=1 $condition ORDER BY scm_name $pagination";
       $query=$this->db->query($sql);//
       return $query;
    }
    function get_common_data($COM_CMCD=NULL,$limit='',$page='',$COM_TPCD=""){ 
        $pagination="";
        $condition='';
        if(!empty($COM_CMCD)){
            $condition .="AND COM_CMCD=$COM_CMCD";
        }else{
            if(!empty($limit)){
                $pagination.="LIMIT $limit  OFFSET $page";
            }
            if(!empty($COM_TPCD)){
                $condition .="AND COM_TPCD=$COM_TPCD";
            }
        }
     
        $sql ="SELECT COM_CMCD,COM_CMNM,COM_SYS,COM_TPCD,COM_SNAM,COM_CODE,
        (SELECT COT_TPNM FROM com_typ01  WHERE COT_TPCD=COM_TPCD) as COMMON_TYPE
        FROM com_mst 
        WHERE  COM_CANC=1 $condition ORDER BY COMMON_TYPE,COM_CMNM $pagination";
        $query=$this->db->query($sql);//
        return $query;
    }
    function get_material_data($material_id=NULL,$limit='',$page='',$COM_CMCD=""){
        $pagination="";
        $condition='';
        if(!empty($material_id)){
            $condition .=" AND material_id=$material_id";
        }else{
            if(!empty($limit)){
                $pagination.="LIMIT $limit  OFFSET $page";
            }
            if(!empty($COM_CMCD)){
                $condition .=" AND material_location=$COM_CMCD";
            }
        }

        $sql ="SELECT `material_id`, `material_location`, `material_name`, `material_resolveday`,material_ispenalty,
        CASE WHEN  material_ispenalty=1 THEN 'Yes' ELSE 'No' END ispenalty, `material_penalty`, `material_desc`, `material_date`, `material_status`,
        CASE WHEN  material_status=1 THEN 'Active' ELSE 'Inctive' END matstatus,
        (SELECT COM_CMNM FROM com_mst  WHERE COM_CMCD=material_location) as mtlocation 
        FROM `material_mst` WHERE  material_cancel=1 $condition ORDER BY mtlocation,material_name $pagination";
        $query=$this->db->query($sql);//
        return $query;
    }

    function get_vender_data($vem_id=NULL,$limit='',$page=''){
        $pagination="";
        if(!empty($vem_id)){
            $condition="AND vem_id=$vem_id";
        }else{
           $condition='';
        }
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        $sql ="SELECT vem_id,vem_userid,vem_name,vem_contno,vem_mailid,vem_username,vem_password,vem_district,vem_addr1,vem_addr2,vem_pincode,vem_status,
        CASE WHEN  vem_status=1 THEN 'Active' ELSE 'Inctive' END venstatus
        FROM vender_mst WHERE  vem_cancel=1 $condition  $pagination";
        $query=$this->db->query($sql);//
        return $query;
    
    }
    function vender_insert($insert_data,$insert_data2){
        $this->db->trans_start();
		$this->db->insert('users_mst', $insert_data);
		$this->db->insert('vender_mst', $insert_data2);
		$this->db->trans_complete();
    	return true;

    }
   
    function get_scholl_assign_data(){
        $school_ids=implode(',', get_all_vender_assigned_school_data());
        if(!empty($school_ids)){
            $sql="SELECT scm_id,scm_name,scm_udisecode FROM school_mst WHERE scm_status=1 AND scm_cancel=1 AND scm_id NOT IN ($school_ids) ORDER BY scm_name";
        }else{
            $sql="SELECT scm_id,scm_name,scm_udisecode FROM school_mst WHERE scm_status=1 AND scm_cancel=1  ORDER BY scm_name";
        }
        
        $query =$this->db->query($sql);
        return $query;
    }
    function get_vender_assign_data($ves_id=NULL,$limit='',$page=''){
        $pagination="";
        if(!empty($ves_id)){
            $condition="AND ves_id=$ves_id";
        }else{
           $condition='';
        }
        
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        
        $sql ="SELECT `ves_id`,`ves_vemid`,`ves_schid`,`ves_status`,
        (SELECT vem_name FROM vender_mst  WHERE vem_id=ves_vemid  ) as  vender_name
         FROM `vender_sch` WHERE ves_status=1 AND  ves_cancel=1 $condition $pagination";
        $query=$this->db->query($sql);//
        return $query;
    
    }
    function get_holiday_data($holiday_id=NULL){
         if(!empty($holiday_id)){
            $condition="AND holiday_id=$holiday_id";
        }else{
           $condition='';
        }
        $sql ="SELECT holiday_id, holiday_date, holiday_name,holiday_status, 
        CASE WHEN holiday_status=1 THEN 'Active' ELSE 'Inactive' END Status
        FROM holiday_mst WHERE  holiday_cancel=1 $condition  ORDER BY holiday_date ";
        $query=$this->db->query($sql);//
        return $query;
    }
    function get_country(){
        $pagination="";
        if(!empty($sum_id)){
    		$condition="AND sum_id=$sum_id";
    	}else{
			$condition="";
    	}
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        $sql="SELECT COM_COCD,COM_CONM,COM_CODE,COM_ISDC,COM_CYTP,COM_CYSR,COM_STAT,
        CASE WHEN COM_STAT=1  THEN   'Active' ELSE 'Inactive' END  Status
        FROM cou_mst   WHERE COM_CANC=1  $condition  ORDER BY COM_CONM $pagination";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_state($STM_STCD=null,$limit='',$page=''){
        $pagination="";
        if(!empty($STM_STCD)){
    		$condition="AND  STM_STCD=$STM_STCD";
    	}else{
			$condition="";
    	}
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        $sql="SELECT STM_STCD,STM_COCD,STM_STNM,
        (SELECT COM_CONM FROM cou_mst WHERE COM_COCD=STM_COCD) AS country
        FROM sta_mst WHERE STM_CANC=1  $condition ORDER BY STM_STNM  $pagination ";
        $query=$this->db->query($sql);
        return $query;
    }
    
    function get_district($DSM_DSCD=NULL,$limit='',$page='',$state_id=""){
        $pagination="";
        $condition="";
        if(!empty($DSM_DSCD)){
    		$condition .="AND DSM_DSCD=$DSM_DSCD";
    	}else{
            if(!empty($state_id)){
                $condition .=" AND DSM_STCD=$state_id ";
            }
			
    	}
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        $sql="SELECT DSM_DSCD, DSM_STCD, DSM_CODE, DSM_SHNM, DSM_DSNM,
        (SELECT STM_STNM FROM sta_mst WHERE DSM_STCD=STM_STCD) AS state
        FROM dst_mst WHERE DSM_CANC=1  $condition ORDER BY state,DSM_DSNM $pagination";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_block($BLM_BLCD=NULL,$limit='',$page='',$dist_id=''){
        $pagination="";
        $condition="";
        if(!empty($BLM_BLCD)){
    		$condition.="AND BLM_BLCD=$BLM_BLCD";
    	}
        if(!empty($dist_id)){
    		$condition.="AND BLM_DSCD=$dist_id";
    	}

        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
        $sql="SELECT BLM_BLCD, BLM_DSCD, BLM_CODE, BLM_BLNM, 
        (SELECT DSM_DSNM FROM dst_mst WHERE BLM_DSCD=DSM_DSCD)as district 
        FROM blk_mst WHERE BLM_CANC=1  $condition ORDER BY district,BLM_BLNM $pagination";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_gram_pachayata($GPM_GPCD=NULL,$limit='',$page='',$block_id=''){
        $pagination="";
        $condition="";
        if(!empty($GPM_GPCD)){
    		$condition.="AND GPM_GPCD=$GPM_GPCD";
    	}
        if(!empty($block_id)){
    		$condition.="AND GPM_BLCD=$block_id";
    	}
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        }
       
        $sql="SELECT GPM_GPCD, GPM_BLCD, GPM_CODE, GPM_GPNM,
        (SELECT BLM_BLNM FROM blk_mst WHERE  GPM_BLCD=BLM_BLCD) as block
         FROM gp_mst WHERE GPM_CANC=1  $condition ORDER BY GPM_BLCD,GPM_GPNM $pagination";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_village($VLM_VLCD=NULL,$limit='',$page='', $block_id=''){
        $pagination="";
        $condition="";
        if(!empty($VLM_VLCD)){
    		$condition.="AND VLM_VLCD=$VLM_VLCD";
    	}
        if(!empty($block_id)){
    		$condition.="AND VLM_BLCD=$block_id";
    	}
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        } 
        $sql="SELECT  VLM_VLCD, VLM_GPCD, VLM_CODE,VLM_VLNM,VLM_BLCD,
        (SELECT GPM_GPNM FROM gp_mst WHERE GPM_GPCD=VLM_GPCD) AS panchayat,
        (SELECT BLM_BLNM FROM blk_mst WHERE BLM_BLCD=VLM_BLCD) AS block_name
        FROM vlg_mst WHERE VLM_CANC=1  $condition ORDER BY block_name,VLM_VLNM  $pagination ";
        $query=$this->db->query($sql);
        return $query;
    }
    function get_locality_data($LOM_LOCD=NULL,$limit='',$page='', $village_id=''){ 
        $condition="";
        $pagination="";
        if(!empty($LOM_LOCD)){
    		$condition.="AND LOM_LOCD=$LOM_LOCD";
    	}
        if(!empty($village_id)){
    		$condition.="AND LOM_VLCD=$village_id";
    	}
        if(!empty($limit)){
            $pagination .="LIMIT $limit  OFFSET $page";
        } 
          
        $sql="SELECT LOM_LOCD,LOM_VLCD,LOM_LONM, 
        (SELECT VLM_VLNM FROM vlg_mst WHERE VLM_VLCD=LOM_VLCD) AS village
        FROM locality_mst WHERE LOM_CANC=1 $condition ORDER BY village,LOM_LONM $pagination ";
        $query=$this->db->query($sql);
        return $query;
    }

}