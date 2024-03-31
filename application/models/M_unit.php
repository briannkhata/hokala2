<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_unit extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_units()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('unit_id', 'DESC');
        $query = $this->db->get('tbl_units');
        return $query->result_array();
    }

    function get_unit_by_id($unit_id)
    {
        $this->db->where('unit_id', $unit_id);
        $query = $this->db->get('tbl_units');
        return $query->result_array();
    }

    function get_unit_type($unit_id)
    {
        $this->db->select('unit_type');
        $this->db->where('unit_id', $unit_id);
        $result = $this->db->get('tbl_units')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->unit_type;
        }
    }

    function get_unit_qty($unit_id)
    {
        $this->db->select('qty');
        $this->db->where('unit_id', $unit_id);
        $result = $this->db->get('tbl_units')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->qty;
        }
    }

    function get_description($unit_id)
    {
        $this->db->select('desc');
        $this->db->where('unit_id', $unit_id);
        $result = $this->db->get('tbl_units')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->desc;
        }
    }



}
