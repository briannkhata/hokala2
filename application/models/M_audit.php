<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_audit extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    var $table = "tbl_audit_transactions";
    var $select_column = array("auditID", "first_name", "audit_date");
    var $order_column = array(null, "auditID", null);

    function get_paused_items(){
      $this->db->where(array('tbl_audit_transactions.audit_status' => 'Paused'));
      $this->db->from('tbl_audit_transactions');
      $this->db->join('tbl_users', 'tbl_users.user_id = tbl_audit_transactions.user_ID', 'LEFT');
      $this->db->order_by('auditID', 'DESC');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_finished_items(){
        $this->db->where(array('tbl_audit_transactions.audit_status' => 'Finished'));
        $this->db->from('tbl_audit_transactions');
        $this->db->join('tbl_users', 'tbl_users.user_id = tbl_audit_transactions.user_ID', 'LEFT');
        $this->db->order_by('auditID', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
      }



  

    function make_audit_finished_datatables()
    {
        $this->make_audit_finished_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('audit_status', 'Finished');
        $query = $this->db->get();
        return $query->result();
    }


    function get_audit_by_id($cat_id)
    {
        $this->db->where('auditID', $cat_id);
        $query = $this->db->get('tbl_audit_transactions');
        return $query->result_array();
    }

    public function count_audit_total_assets($cat_id)
    {
        $this->db->where('asset_status', 'active');
        $this->db->where('dispose_state', 'no');
        $this->db->where('asset_category', $cat_id);
        $this->db->from('tbl_asset_register');
        return $this->db->count_all_results();
    }


}
