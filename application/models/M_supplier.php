<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_supplier extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_suppliers()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('supplier_id', 'DESC');
        $query = $this->db->get('tbl_suppliers');
        return $query->result_array();
    }

    function get_supplier_by_id($supplier_id)
    {
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get('tbl_suppliers');
        return $query->result_array();
    }

    function get_supplier($supplier_id)
    {
        $this->db->select('name');
        $this->db->where('supplier_id', $supplier_id);
        $result = $this->db->get('tbl_suppliers')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }


}
