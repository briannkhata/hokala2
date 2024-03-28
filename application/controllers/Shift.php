<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Shift extends CI_Controller
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
        $data["page_title"] = "Shifts List";
        $this->load->view("shift/_shift_list", $data);
    }

   
    function get_form_data()
    {
        $data["name"] = $this->input->post("name");
        $data["start_time"] = $this->input->post("start_time");
        $data["end_time"] = $this->input->post("end_time");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_shift->get_shift_by_id($update_id);
        foreach ($query as $row) {
            $data["name"] = $row["name"];
            $data["start_time"] = $row["start_time"];
            $data["end_time"] = $row["end_time"];
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
        $data["page_title"] = "Create shift";
        $this->load->view("shift/_add_shift", $data);
    }

    function save()
    {
        $data = $this->get_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("shift_id", $update_id);
            $this->db->update("tbl_shifts", $data);
        } else {
            $this->db->insert("tbl_shifts", $data);
        }
        if ($update_id != ""):
            redirect("Shift");
        else:
            redirect("Shift/read");
        endif;
        $this->session->set_flashdata("message", "Shift saved successfully!");
    }

    function delete($param="")
    {
        $data["deleted"] = 1;
        $this->db->where("shift_id", $param);
        $this->db->update("tbl_shifts", $data);
        $this->session->set_flashdata("message", "Shift Removed Successfully!");
        redirect("Shift");
    }


}