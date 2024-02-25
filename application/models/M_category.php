<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_category extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    function get_categories(){
        $this->db->where('deleted',0);
        $this->db->order_by('category_id','DESC');
        $query = $this->db->get('tbl_category');
        return $query->result_array();
    }

    function get_category_by_id($category_id){
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('tbl_category');
        return $query->result_array();
    }

    function get_category_name($category_id){
     $this->db->select('category');
     $this->db->where('category_id', $category_id);
     $result = $this->db->get('tbl_category')->row();
     if ($result == NULL) {
         return "";
     } else {
         return $result->category;
     }
 }

 function get_dep_percentage($category_id){
    $this->db->select('dep_percentage');
    $this->db->where('category_id', $category_id);
    $result = $this->db->get('tbl_category')->row();
    if ($result == NULL) {
        return "";
    } else {
        return $result->dep_percentage;
    }
}
 function count_cat_total_assets($category_id){
    $this->db->where('asset_status','active');
    $this->db->where('dispose_state','no');
    $this->db->where('category_id',$category_id);
    $this->db->from('tbl_asset_register');
    return $this->db->count_all_results();
}

}
