<?php
defined("BASEPATH") or exit("No direct script access allowed");

class M_donor extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_donors()
    {
        $this->db->where("deleted", 0);
        $this->db->order_by("donor_id", "DESC");
        $query = $this->db->get("tbl_donors");
        return $query->result_array();
    }

    public function count_donor_total_assets($donor_id)
    {
        $this->db->where("asset_status", 0);
        $this->db->where("dispose_state", "no");
        $this->db->where("donor_id", $donor_id);
        $this->db->from("tbl_asset_register");
        return $this->db->count_all_results();
    }

    function get_donor_aasets($donor_id){
        $this->db->where('tbl_asset_register.asset_status', 'active');
        $this->db->where('tbl_asset_register.audit_state', 'av');
        $this->db->where('tbl_asset_register.dispose_state', 'no');
        $this->db->where('tbl_asset_register.donor_id', $donor_id);
        $this->db->from('tbl_asset_register');
        $this->db->order_by('asset_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_donor_by_id($donor_id)
    {
        $this->db->where('donor_id', $donor_id);
        $query = $this->db->get('tbl_donors');
        return $query->result_array();
    }

    function get_donor_assets($donor_id){  
        $this->db->where(array('asset_status'=>'active','audit_state'=>'av','donor_id'=>$donor_id));
        $this->db->from('tbl_asset_register');
        $query = $this->db->get();
        return $query->result_array(); 
    } 

    function get_asset_donor_name($id)
    {
        $this->db->select('donor_name');
        $this->db->where('donor_id', $id);
        $result = $this->db->get('tbl_donors')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->donor_name;
        }
    }
}
