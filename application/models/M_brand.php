<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_brand extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_brands()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('brand_id', 'DESC');
        $query = $this->db->get('tbl_brands');
        return $query->result_array();
    }

    function get_brand_by_id($brand_id)
    {
        $this->db->where('brand_id', $brand_id);
        $query = $this->db->get('tbl_brands');
        return $query->result_array();
    }

    function get_brand_name($brand_id)
    {
        $this->db->select('brand_name');
        $this->db->where('brand_id', $brand_id);
        $result = $this->db->get('tbl_brands')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->brand_name;
        }
    }

    

    function get_brand_desc($brand_id)
    {
        $this->db->select('desc');
        $this->db->where('brand_id', $brand_id);
        $result = $this->db->get('tbl_brands')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->desc;
        }
    }

}
