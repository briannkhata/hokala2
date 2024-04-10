<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_category extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_categories()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('category_id', 'DESC');
        $query = $this->db->get('tbl_category');
        return $query->result_array();
    }

    function get_category_by_id($category_id)
    {
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('tbl_category');
        return $query->result_array();
    }

    function get_category_name($category_id)
    {
        $this->db->select('category');
        $this->db->where('category_id', $category_id);
        $result = $this->db->get('tbl_category')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->category;
        }
    }

    
    function get_category_un_code($category_id)
    {
        $this->db->select('un_code');
        $this->db->where('category_id', $category_id);
        $result = $this->db->get('tbl_category')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->un_code;
        }
    }

    function get_category_desc($category_id)
    {
        $this->db->select('desc');
        $this->db->where('category_id', $category_id);
        $result = $this->db->get('tbl_category')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->desc;
        }
    }

}
