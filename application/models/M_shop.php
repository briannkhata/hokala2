<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_shop extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_shops()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('shop_id', 'DESC');
        $query = $this->db->get('tbl_shops');
        return $query->result_array();
    }

    function get_shop_by_id($shop_id)
    {
        $this->db->where('shop_id', $shop_id);
        $query = $this->db->get('tbl_shops');
        return $query->result_array();
    }

    function get_shop_name($shop_id)
    {
        $this->db->select('name');
        $this->db->where('shop_id', $shop_id);
        $result = $this->db->get('tbl_shops')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }

    function get_shop_description($shop_id)
    {
        $this->db->select('shop');
        $this->db->where('shop_id', $shop_id);
        $result = $this->db->get('tbl_shops')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->description;
        }
    }

    function get_qty($product_id)
    {
        $this->db->select('SUM(qty) as total_qty');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_quantities')->row();

        if ($result == NULL) {
            return 0;
        } else {
            return $result->total_qty;
        }
    }
    function get_qty1($shop_id, $product_id)
    {
        $this->db->select('qty');
        $this->db->where('shop_id', $shop_id);
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_quantities')->row();
        if ($result == NULL) {
            return 0;
        } else {
            return $result->qty;
        }
    }



}
