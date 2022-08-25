<?php
if(!defined('BASEPATH')) exit ('No direct script access allowed!');

class LoginModel extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function getUserData($username,$password){
        $sql="SELECT * from usr_mst where USM_LGID='$username' AND USM_PASS='$password' limit 1"; //AND user_status=?
        $query=$this->db->query($sql,[$username,$password,1]);
        return $query->row();
		 
   	}
    function getMENUDATA($user_id){
        $sql="SELECT * FROM MNU_MST,USR_CAT,USR_ROL,USR_MST WHERE USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND USR_MNCD=MNM_MNCD AND USM_USID=$user_id";
        $query=$this->db->query($sql);
        return $query->result();
    }
    // function check_user_login($user_lgid, $user_psw){
    //     $sql="SELECT * FROM usr_mst WHERE  USM_CANC=1";
    //     $query=$this->db->query($sql,[$user_lgid,$user_psw,1,1]);//
    //     return $query->row();
    // }
    // function get_login_data($USM_USID =null){ 
    //     if(!empty($USM_USID)){
    //         $condition="AND USM_USID =$USM_USID ";
    //     }else{
    //        $condition='';
    //     }
    //     $sql="SELECT USM_USID,USM_USNM,USM_MBNO,USM_MAIL,USM_LGID,USM_PASS,USM_CNPS,USM_URCD,USM_DSCD,USM_BLCD,USM_SCCD,   
    //     (SELECT USC_CTNM FROM USR_CAT WHERE USC_CTCD=USM_URCD) as category_name,
    //     (SELECT DSM_SHNM FROM dst_mst01 WHERE DSM_DSCD=USM_DSCD) as District ,
    //     (SELECT BLM_BLNM FROM blk_mst01 WHERE BLM_BLCD=USM_DSCD) as block_name,
    //     (SELECT scm_name FROM school_mst WHERE scm_id=USM_BLCD) as school_name,
    //     (SELECT scm_udisecode  FROM school_mst WHERE scm_id=USM_SCCD) as school_udisecode
    //     FROM usr_mst   WHERE USM_CANC=1  $condition  ";
    //     $query=$this->db->query($sql);
    //     return $query;
    // }
}