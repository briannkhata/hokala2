<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_move extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_shop_qty($product_id, $shop_id)
    {
        $this->db->select('qty');
        $this->db->where('product_id', $product_id);
        $this->db->where('shop_id', $shop_id);
        $query = $this->db->get('tbl_quantities');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return 0;
        }
    }

    function get_shop_quantities($product_id, $shop_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('shop_id', $shop_id);
        $query = $this->db->get('tbl_quantities');
        return $query->num_rows() > 0;
    }

    function get_warehouse_quantities($product_id, $warehouse_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('warehouse_id', $warehouse_id);
        $query = $this->db->get('tbl_wh_quantities');
        return $query->num_rows() > 0;
    }

    function get_warehouse_qty($product_id, $warehouse_id)
    {
        $this->db->select('qty');
        $this->db->where('product_id', $product_id);
        $this->db->where('warehouse_id', $warehouse_id);
        $query = $this->db->get('tbl_wh_quantities');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return 0;
        }
    }

    function get_product_in_cart($product_id, $user_id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_cart_move')->result_array();
        return $query;
    }

    function get_cart_id_by_product_id($product_id, $user_id)
    {
        $this->db->select('cart_id');
        $this->db->where('product_id', $product_id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('tbl_cart_move');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->cart_id;
        } else {
            return '';
        }
    }

    function get_cart_qty($cart_id)
    {
        $this->db->select('qty');
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('tbl_cart_move');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return 0;
        }
    }

    function searchProducts($barcode)
    {
        $this->db->select('product_id, barcode, name, `desc`');
        $this->db->from('tbl_products');
        $this->db->like('barcode', $barcode);
        $this->db->where('deleted', 0);
        $query = $this->db->get();
        $results = $query->result_array();
        if (empty($results)) {
            $allmovesQuery = $this->db->get('tbl_products');
            return $allmovesQuery->result_array();
        }
        return $results;
    }

    function get_product_by_cart_id($cart_id)
    {
        $this->db->where('cart_id', $cart_id);
        $this->db->from('tbl_cart_move');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cart($user_id)
    {
        return $this->db
            ->select('*')
            ->from('tbl_cart_move')
            ->where('user_id', $user_id)
            ->order_by('cart_id')
            ->get()
            ->result_array();
    }

    function get_product_by_barcode($barcode)
    {
        $this->db->where('deleted', 0);
        $this->db->where('barcode', $barcode);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

}