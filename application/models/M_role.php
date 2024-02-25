<?php
defined("BASEPATH") or exit("No direct script access allowed");

class M_role extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_roles()
    {
        $this->db->where("deleted", 0);
        $this->db->order_by("role_id", "DESC");
        $query = $this->db->get("tbl_roles");
        return $query->result_array();
    }

    function get_role_by_id($role_id)
    {
        $this->db->where('role_id', $role_id);
        $query = $this->db->get('tbl_roles');
        return $query->result_array();
    }

    function get_asset_role_name($id)
    {
        $this->db->select('role_name');
        $this->db->where('role_id', $id);
        $result = $this->db->get('tbl_roles')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->role_name;
        }
    }

    function get_role($role_id)
    {
        $this->db->select('role_name');
        $this->db->where('role_id', $role_id);
        $result = $this->db->get('tbl_roles')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->role_name;
        }
    }

    function get_permission_id($role_id, $menu_id, $operation_id)
    {
        $this->db->select('permision_id');
        $this->db->where('role_id', $role_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->where('operation_id', $operation_id);
        $result = $this->db->get('tbl_permisions')->row();
        return ($result) ? $result->permision_id : "";
    }
    

    function get_menu_from_permission($role_id,$menu_id)
    {
        $this->db->select('menu_id');
        $this->db->where('role_id', $role_id);
        $this->db->where('menu_id', $menu_id);
        $result = $this->db->get('tbl_permisions')->row();
        return $result->menu_id ?? "";
    }

    function get_operation_id($permision_id)
    {
        $this->db->select('operation_id');
       // $this->db->where('role_id', $role_id);
        //$this->db->where('menu_id', $menu_id);
        $this->db->where('permision_id', $permision_id);
        $result = $this->db->get('tbl_permisions')->row();
        return ($result) ? $result->operation_id : "";
    }

    function check_permission($menu_id,$role_id)
    {
        $this->db->select('*');
        $this->db->where('role_id', $role_id);
        $this->db->where('menu_id', $menu_id);
        $result = $this->db->get('tbl_permisions')->result_array();
        return ($result) ? 1 : 0;
    }

    function get_role_operations($menu_id,$role_id)
    {
        $this->db->select('*');
        $this->db->where('role_id', $role_id);
        $this->db->where('menu_id', $menu_id);
        $this->db->group_by('operation_id');
        $result = $this->db->get('tbl_permisions')->result_array();
        return $result;
    }

    function get_menu_operations($menu_id)
    {
        $this->db->select('*');
        $this->db->where('menu_id', $menu_id);
        $result = $this->db->get('tbl_operations')->result_array();
        return $result;
    }

    function get_menu_id_by_name($menu)
    {
        $this->db->select('menu_id');
        $this->db->where('name', $menu);
        $result = $this->db->get('tbl_menus')->row();
        return $result->menu_id ?? "";
    }

    function get_menu_by_id($menu_id)
    {
        $this->db->select('name');
        $this->db->where('menu_id', $menu_id);
        $result = $this->db->get('tbl_menus')->row();
        return $result->name ?? "";
    }

    function get_operation_by_id($operation_id)
    {
        $this->db->select('operation');
        $this->db->where('operation_id', $operation_id);
        $result = $this->db->get('tbl_ops')->row();
        return $result->operation ?? "";
    }

    function get_operation_icon($operation_id)
    {
        $this->db->select('operation');
        $this->db->where('operation_id', $operation_id);
        $result = $this->db->get('tbl_ops')->row();
        return $result->icon ?? "";
    }
    
}
