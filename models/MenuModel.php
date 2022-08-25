<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!');

class MenuModel extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->login_id=$this->session->userdata('user_id');
        $this->login_name=$this->session->userdata('USM_USNM');
        $this->user_id=$this->session->userdata('USM_USID');
        $this->user_role=$this->session->userdata('USM_CTCD');
        $this->system_name=gethostname();
        $this->load->model('MenuModel','menu',true); 
    }

    function get_menuType_data($MNT_TPCD=null){ 
        if(!empty($MNT_TPCD)){
            $condition="AND MNT_TPCD=$MNT_TPCD";
        }else{
           $condition='';
        }
        $sql="SELECT MNT_TPCD,MNT_TPNM  FROM MNU_TYP WHERE  MNT_CANC=1 $condition ORDER BY  MNT_TPCD"; 
        $query=$this->db->query($sql);//
        return $query;
    }
    function get_submenu_data($MNM_MNCD=null){
        if(!empty($MNM_MNCD)){
            $condition="AND MNM_MNCD=$MNM_MNCD";
        }else{
           $condition='';
        }
        $sql="SELECT MNM_MNCD,MNM_MNNM,MNM_SEQU,MNM_TPCD,MNM_FRNM,
        (SELECT MNT_TPNM FROM MNU_TYP WHERE MNT_TPCD=MNM_TPCD) as menu_name
        FROM  mnu_mst WHERE  MNM_CANC=1 $condition ORDER BY  MNM_TPCD "; 
        $query=$this->db->query($sql);//
        return $query;
    }
    function get_user_category_data($USC_CTCD=null){
        if(!empty($USC_CTCD)){
            $condition="AND USC_CTCD=$USC_CTCD";
        }else{
           $condition='';
        }
        $sql="SELECT USC_CTCD,USC_CTNM,USC_LVCD, 
          CASE 
            WHEN (USC_LVCD  = 1) THEN 'State Level'
            WHEN (USC_LVCD  = 2) THEN 'District Level'
            WHEN (USC_LVCD  = 3) THEN 'Block Level'
            WHEN (USC_LVCD  = 4) THEN 'School Level' 
            END AS level_name 
        FROM  USR_CAT WHERE  USC_CANC=1 $condition ORDER BY  USC_CTCD"; 
        $query=$this->db->query($sql);//
        return $query;
    }
    function get_user_role_data($USR_URCD=null,$limit='',$page='',$USR_CTCD=""){
        $condition='';
        if(!empty($USR_URCD)){
            $condition="AND USR_URCD=$USR_URCD";
        }else{
            if(!empty($USR_CTCD)){
                $condition .="AND USR_CTCD=$USR_CTCD";
            } 
        }
        $sql="SELECT USR_URCD,USR_CTCD,USR_MNCD,
        (SELECT USC_CTNM FROM USR_CAT WHERE USC_CTCD=USR_CTCD) as category_name,
        (SELECT MNM_MNNM FROM mnu_mst WHERE MNM_MNCD=USR_MNCD) as menu_name
        FROM  USR_ROL WHERE  USR_CANC=1 $condition ORDER BY  USR_URCD"; 
        $query=$this->db->query($sql);//
        return $query;
    } 
    function get_user_assign_data(){
        if(!empty($USR_URCD)){
            $condition="AND USR_URCD=$USR_URCD";
        }else{
           $condition='';
        }
        $sql="SELECT USR_URCD,USR_CTCD,USR_MNCD, 
        (SELECT USC_CTNM FROM USR_CAT WHERE USC_CTCD=USR_CTCD) as category_name,
        (SELECT MNM_MNNM FROM mnu_mst WHERE MNM_MNCD=USR_MNCD) as menu_name,
        (SELECT MNM_FRNM FROM mnu_mst WHERE MNM_MNCD=USR_MNCD) as menu_id,
        (SELECT MNM_TPCD FROM mnu_mst WHERE MNM_MNCD=USR_MNCD) as menu_type
        FROM  USR_ROL WHERE  USR_CANC=1 AND USR_CTCD=$this->user_role  $condition ORDER BY  USR_URCD"; 
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
        FROM usr_mst   WHERE USM_CANC=1  AND USM_USID=$this->user_id   $condition  ";
        $query=$this->db->query($sql);
        return $query;
    }
    function getMenuData($USM_USID){
        $query="SELECT * FROM MNU_MST,USR_CAT,USR_ROL,USR_MST WHERE USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND USR_MNCD=MNM_MNCD AND USM_USID=1";   
        $result=$this->db->query($query);
        $rows =$result->result();
        return $rows;
    }
}