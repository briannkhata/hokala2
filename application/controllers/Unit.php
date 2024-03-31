<?php
defined("BASEPATH") or exit("No direct script access allowed");

class unit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("user_login") != 1) {
            redirect(base_url(), "refresh");
        }
    }

    function index()
    {
        $data["page_title"] = "Unit List";
        $this->load->view("unit/_unit_list", $data);
    }

   
    function get_form_data()
    {
        $data["unit_type"] = $this->input->post("unit_type");
        $data["desc"] = $this->input->post("desc");
        $data["qty"] = $this->input->post("qty");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_unit->get_unit_by_id($update_id);
        foreach ($query as $row) {
            $data["unit_type"] = $row['unit_type'];
            $data["desc"] = $row['desc'];
            $data["qty"] = $row['qty'];
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
            $data = $this->get_db_data($update_id);
            $data["update_id"] = $update_id;
        } else {
            $data = $this->get_form_data();
        }
        $data["page_title"] = "Create Unit";
        $this->load->view("unit/_add_unit", $data);
    }

    function save()
    {
        $data = $this->get_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("unit_id", $update_id);
            $this->db->update("tbl_units", $data);
        } else {
            $this->db->insert("tbl_units", $data);
        }
        if ($update_id != ""):
            redirect("Unit");
        else:
            redirect("Unit/read");
        endif;
        $this->session->set_flashdata("message", "Unit saved successfully!");
    }

    function delete($param="")
    {
        $data["deleted"] = 1;
        $this->db->where("unit_id", $param);
        $this->db->update("tbl_units", $data);
        $this->session->set_flashdata("message", "Unit Removed Successfully!");
        redirect("Unit");
    }


}