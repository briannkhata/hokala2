<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_role extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function get_roles()
    {
        $this->db->where('deleted', 0);
        $this->db->order_by('role_id', 'DESC');
        $query = $this->db->get('tbl_roles');
        return $query->result_array();
    }

    function get_role_by_id($role_id)
    {
        $this->db->where('role_id', $role_id);
        $query = $this->db->get('tbl_roles');
        return $query->result_array();
    }

    function get_role_name($role_id)
    {
        $this->db->select('role');
        $this->db->where('role_id', $role_id);
        $result = $this->db->get('tbl_roles')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->role;
        }
    }

}
