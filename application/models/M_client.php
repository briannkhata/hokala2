<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_client extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_clients()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('client_id', 'DESC');
        $query = $this->db->get('tbl_clients');
        return $query->result_array();
    }

    function get_client_by_id($client_id)
    {
        $this->db->where('client_id', $client_id);
        $query = $this->db->get('tbl_clients');
        return $query->result_array();
    }

    function get_client($client_id)
    {
        $this->db->select('name');
        $this->db->where('client_id', $client_id);
        $result = $this->db->get('tbl_clients')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }

    function get_phone($client_id)
    {
        $this->db->select('phone');
        $this->db->where('client_id', $client_id);
        $result = $this->db->get('tbl_clients')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->phone;
        }
    }


}
