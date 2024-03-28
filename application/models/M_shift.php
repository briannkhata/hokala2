<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_shift extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_shifts()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('shift_id', 'DESC');
        $query = $this->db->get('tbl_shifts');
        return $query->result_array();
    }

    function get_shift_by_id($shift_id)
    {
        $this->db->where('shift_id', $shift_id);
        $query = $this->db->get('tbl_shifts');
        return $query->result_array();
    }

    function get_shift_name($shift_id)
    {
        $this->db->select('shift');
        $this->db->where('shift_id', $shift_id);
        $result = $this->db->get('tbl_shifts')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }

    function get_start_time($shift_id)
    {
        $this->db->select('shift');
        $this->db->where('shift_id', $shift_id);
        $result = $this->db->get('tbl_shifts')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->start_time;
        }
    }

    function get_end_time($shift_id)
    {
        $this->db->select('shift');
        $this->db->where('shift_id', $shift_id);
        $result = $this->db->get('tbl_shifts')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->end_time;
        }
    }
    function get_current_shift()
    {
        $current_time = date('Y-m-d H:i:s');
        $this->db->select('shift_id');
        $this->db->where('start_time >=', $current_time);
        $this->db->where('end_time<=', $current_time);
        $result = $this->db->get('tbl_shifts')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->shift_id;
        }
    }



}
