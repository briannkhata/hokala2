<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Role extends CI_Controller
{
    public $menu_id;
    
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("user_login") != 1) {
            redirect(base_url(), "refresh");
        }
        $this->menu_id = $this->M_role->get_menu_id_by_name('role');
    }

    function get_menu_id() {
        return $this->menu_id;
    }
 
    function index()
    {
        $data["page_title"] = "Roles";
        $data['menu_id'] = $this->get_menu_id();
        $data['fetch_data'] = $this->M_role->get_roles();
        $this->load->view("role/_list", $data);
    }

    function view($param = "")
    {
        $data["page_title"] = "Role Permissions";
        $data['fetch_data'] = $this->M_role->get_role_by_id($param);
        $data['role_id'] = $param;
        $this->load->view("role/_view", $data);
    }

    function get_role_form_data()
    {
        $data["role_name"] = $this->input->post("role_name");
        return $data;
    }

    function get_role_db_data($update_id)
    {
        $query = $this->M_role->get_role_by_id($update_id);
        foreach ($query as $row) {
            $data["role_name"] = $row["role_name"];
        }
        return $data;
    }

    function read()
    {
        $update_id = $this->uri->segment(3);
        if (!isset($update_id)) {
            $update_id = $this->input->post("update_id", $update_id);
        }
        if (is_numeric($update_id)) {
            $data = $this->get_role_db_data($update_id);
            $data["update_id"] = $update_id;
        } else {
            $data = $this->get_role_form_data();
        }

        $data["page_title"] = "Create Role";
        $this->load->view("role/_form", $data);
    }

    function save()
    {
        $data = $this->get_role_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("role_id", $update_id);
            $this->db->update("tbl_roles", $data);
        } else {
            $this->db->insert("tbl_roles", $data);
        }
        if ($update_id != ""):
            redirect("Role");
        else:
            redirect("Role/create");
        endif;
        $this->session->set_flashdata("message", "Role saved successfully!");
    }

    function delete($param = "")
    {
        $data["deleted"] = 1;
        $this->db->where("role_id", $param);
        $this->db->update("tbl_roles", $data);
        $this->session->set_flashdata("message", "Role Removed Successfully!");
        redirect("Role");
    }


    function save_permissions()
    {
        $role_id = $this->input->post('role_id');
        $menu_ids = $this->input->post('menu_id');
        $operation_ids = $this->input->post('operation_id');

        $existing_combinations = $this->db->select('menu_id, operation_id')
            ->where('role_id', $role_id)
            ->get('tbl_permisions')
            ->result_array();

        $data = [];
        $to_remove = [];

        foreach ($existing_combinations as $existing_combination) {
            $found = false;

            foreach ($menu_ids as $menu_id) {
                foreach ($operation_ids as $operation_id) {
                    if ($existing_combination['menu_id'] == $menu_id && $existing_combination['operation_id'] == $operation_id) {
                        $found = true;
                        break 2; // break out of both loops
                    }
                }
            }

            if (!$found) {
                $to_remove[] = $existing_combination;
            }
        }

        foreach ($menu_ids as $menu_id) {
            foreach ($operation_ids as $operation_id) {
                if (!in_array(['menu_id' => $menu_id, 'operation_id' => $operation_id], $existing_combinations, true)) {
                    $data[] = array(
                        'role_id' => $role_id,
                        'menu_id' => $menu_id,
                        'operation_id' => $operation_id,
                    );
                }
            }
        }

        if (!empty($to_remove)) {
            foreach ($to_remove as $remove_combination) {
                $this->db->where($remove_combination);
                $this->db->delete('tbl_permisions');
            }
        }

        if (!empty($data)) {
            $this->db->insert_batch('tbl_permisions', $data);
            $this->session->set_flashdata("message", "Permissions saved successfully!");
        } else {
            $this->session->set_flashdata("message", "No new permissions to save.");
        }

        redirect("Role/view/" . $role_id);
    }


}
