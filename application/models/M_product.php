<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_product extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_products()
    {
        $this->db->where('deleted', 0);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_expiring_products()
    {
        $current_date = date('Y-m-d');
        $expiry_date = date('Y-m-d', strtotime('+2 weeks'));
        $this->db->where('deleted', 0);
        $this->db->where('expiry_date >=', $current_date);
        $this->db->where('expiry_date <=', $expiry_date);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_expired_products()
    {
        $yesterday_date = date('Y-m-d', strtotime('-1 day'));
        $this->db->where('deleted', 0);
        $this->db->where('expiry_date <=', $yesterday_date);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_new_products()
    {
        $current_date = date('Y-m-d');
        $two_weeks_from_now_date = date('Y-m-d', strtotime('+2 weeks'));
        $this->db->where('deleted', 0);
        $this->db->where('date_added >=', $current_date);
        $this->db->where('date_added <=', $two_weeks_from_now_date);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_products_running_low()
    {
        $this->db->where('deleted', 0);
        $this->db->where('expiry_date >', date('Y-m-d'));
        $this->db->where('qty < reorder_level');
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_depleted_products()
    {
        $this->db->where('deleted', 0);
        $this->db->where('expiry_date >', date('Y-m-d'));
        $this->db->where('qty <= 0');
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_qty1($product_id)
    {
        $this->db->select('qty');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_products');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return 0;
        }
    }

    function get_qty($product_id)
    {
        $this->db->select('qty');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_quantities');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return 0;
        }
    }

    function get_prouct_in_cart($product_id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_cart')->result_array();
        return $query;
    }

    function get_cart_id_by_product_id($product_id)
    {
        $this->db->select('cart_id');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_cart');
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
        $query = $this->db->get('tbl_cart');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return '';
        }
    }

    function get_cart_price($cart_id)
    {
        $this->db->select('price');
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('tbl_cart');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->price;
        } else {
            return '';
        }
    }

    function get_total_sum_cart()
    {
        $this->db->select_sum('total');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $result = $this->db->get('tbl_cart')->row();
        return $result->total ?? 0;
    }

    function get_total_vat_cart()
    {
        $this->db->select_sum('vat');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $result = $this->db->get('tbl_cart')->row();
        return $result->vat ?? 0;
    }


    function get_products_by_centre_id($centre_id)
    {
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'no');
        $this->db->where('audit_state', 'av');
        $this->db->where('centre_id', $centre_id);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_product_by_barcode_centre($barcode, $centre_id)
    {
        $this->db->where('deleted', 0);
        $this->db->where('barcode', $barcode);
        //$this->db->where('centre_id', $centre_id);
        $this->db->where('dispose_state', 'no');
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_product_by_cart_id($cart_id)
    {
        $this->db->where('cart_id', $cart_id);
        $this->db->from('tbl_cart');
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_cart()
    {
        return $this->db->select('*')->from('tbl_cart')->where('user_id', $this->session->userdata('user_id'))->order_by('cart_id', 'desc')->get()->result_array();
    }




    function get_product_by_barcode($barcode)
    {
        $this->db->where('deleted', 0);
        $this->db->where('barcode', $barcode);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_price($product_id)
    {
        $this->db->select('selling_price');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_products');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->selling_price;
        } else {
            return 0;
        }
    }

    function get_products_by_category($category_id)
    {
        $this->db->where('deleted', 0);
        $this->db->where('category_id', $category_id);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_products()
    {
        $this->db->where('deleted', 0);
        $this->db->from('tbl_products');
        $this->db->order_by('product_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }





    function check_category_existance($cat_name)
    {
        $this->db->where('category_name', $cat_name);
        $query = $this->db->get('tbl_categories');
        return $query->num_rows();
    }


    function get_pending_disposal()
    {
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'pending');
        $this->db->order_by('product_id', 'DESC');
        $query = $this->db->get('tbl_products');
        return $query->result_array();
    }





    function get_cost_price($product_id)
    {
        $this->db->select('cost_price');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->cost_price;
        }
    }

    function get_deleted_or_not($product_id)
    {
        $this->db->select('deleted');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->deleted;
        }
    }

    function get_barcode($product_id)
    {
        $this->db->select('barcode');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->barcode;
        }
    }

    function get_name($product_id)
    {
        $this->db->select('name');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }


    function get_product_by_id($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_products');
        return $query->result_array();
    }


}
