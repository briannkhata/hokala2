<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_warehouse extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_warehouses()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('warehouse_id', 'DESC');
        $query = $this->db->get('tbl_warehouses');
        return $query->result_array();
    }

    function get_warehouse_by_id($warehouse_id)
    {
        $this->db->where('warehouse_id', $warehouse_id);
        $query = $this->db->get('tbl_warehouses');
        return $query->result_array();
    }

    function get_warehouse_name($warehouse_id)
    {
        $this->db->select('name');
        $this->db->where('warehouse_id', $warehouse_id);
        $result = $this->db->get('tbl_warehouses')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }

    function get_warehouse_description($warehouse_id)
    {
        $this->db->select('description');
        $this->db->where('warehouse_id', $warehouse_id);
        $result = $this->db->get('tbl_warehouses')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->description;
        }
    }

    function get_qty($product_id) {
        $this->db->select('SUM(qty) as total_qty'); 
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_wh_quantities')->row();
      
        if ($result == NULL) {
          return 0;
        } else {
          return $result->total_qty;
        }
      }

    function get_qty1($warehouse_id, $product_id)
    {
        $this->db->select('qty');
        $this->db->where('warehouse_id', $warehouse_id);
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_wh_quantities')->row();
        if ($result == NULL) {
            return 0;
        } else {
            return $result->qty;
        }
    }

}
