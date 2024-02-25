<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_department extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    function get_departments(){
        $this->db->where('deleted',0);
        $this->db->order_by('department_id','DESC');
        $query = $this->db->get('tbl_departments');
        return $query->result_array();
    }

    function get_department_by_id($department_id){
        $this->db->where('department_id',$department_id);
        $query = $this->db->get('tbl_departments');
        return $query->result_array();
    }

    function get_department_name($department_id){
     $this->db->select('department_name');
     $this->db->where('department_id', $department_id);
     $result = $this->db->get('tbl_departments')->row();
     if ($result == NULL) {
         return "";
     } else {
         return $result->department_name;
     }
 }

 function get_centre_id($department_id){
     $this->db->select('department_name');
     $this->db->where('department_id', $department_id);
     $result = $this->db->get('tbl_centres')->row();
     if ($result == NULL) {
         return "";
     } else {
         return $result->centre_id;
     }
 }

}
