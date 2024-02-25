<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    function get_sales_by_date($start_date, $end_date)
    {
        $start_date_formatted = date('Y-m-d', strtotime($start_date));
        $end_date_formatted = date('Y-m-d', strtotime($end_date));
        $this->db->select('tbl_sale_details.*, tbl_products.barcode,tbl_products.name,tbl_products.desc,tbl_products.product_id');
        $this->db->from('tbl_sale_details');
        $this->db->join('tbl_products', 'tbl_sale_details.product_id = tbl_products.product_id', 'inner');
        $this->db->where('sale_date >=', $start_date_formatted);
        $this->db->where('sale_date <=', $end_date_formatted);
        $query = $this->db->get();
        if ($query) {
            return $query->result_array();
        } else {
            return array();
        }
    }


    function get_inventory_report()
    {
        $this->db->where('deleted', 0);
        $query = $this->db->get('tbl_products');
        return $query->result_array();
    }


}
