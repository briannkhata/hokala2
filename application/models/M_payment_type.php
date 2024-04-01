<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_payment_type extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_payment_types()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('payment_type_id', 'ASC');
        $query = $this->db->get('tbl_payment_types');
        return $query->result_array();
    }

    function get_payment_type_by_id($payment_type_id)
    {
        $this->db->where('payment_type_id', $payment_type_id);
        $query = $this->db->get('tbl_payment_types');
        return $query->result_array();
    }

    function get_payment_type($payment_type_id)
    {
        $this->db->select('payment_type');
        $this->db->where('payment_type_id', $payment_type_id);
        $result = $this->db->get('tbl_payment_types')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->payment_type;
        }
    }

    function get_details($payment_type_id)
    {
        $this->db->select('details');
        $this->db->where('payment_type_id', $payment_type_id);
        $result = $this->db->get('tbl_payment_types')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->details;
        }
    }



}
