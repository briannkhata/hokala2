<?php
defined("BASEPATH") or exit("No direct script access allowed");

class M_period extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_periods()
    {
        $this->db->where("deleted", 0);
        $this->db->order_by("period_id", "DESC");
        $query = $this->db->get("tbl_periods");
        return $query->result_array();
    }

    function get_period_by_id($period_id)
    {
        $this->db->where('period_id', $period_id);
        $query = $this->db->get('tbl_periods');
        return $query->result_array();
    }

    function get_title($period_id)
    {
        $this->db->select('title');
        $this->db->where('period_id', $period_id);
        $result = $this->db->get('tbl_periods')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->title;
        }
    }

    function get_start_month($period_id)
    {
        $this->db->select('start_month');
        $this->db->where('period_id', $period_id);
        $result = $this->db->get('tbl_periods')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->start_month;
        }
    }

    function get_start_month_numerical($period_id)
    {
        $this->db->select('start_month_numerical');
        $this->db->where('period_id', $period_id);
        $result = $this->db->get('tbl_periods')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->start_month_numerical;
        }
    }
}
