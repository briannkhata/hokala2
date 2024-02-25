<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Donor extends CI_Controller
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
        $data["page_title"] = "Donors List";
        $data['menu_id'] = $this->M_role->get_menu_id_by_name('donor');
        $this->load->view("donor/_view", $data);
    }

    function assets($param = "")
    {
        $data["page_title"] = "Donor Assets";
        $data["fetch_data"] = $this->M_donor->get_donor_assets($param);
        $this->load->view("donor/_assets", $data);
    }

    function get_donor_form_data()
    {
        $data["donor_name"] = $this->input->post("donor_name");
        return $data;
    }

    function get_donor_db_data($update_id)
    {
        $query = $this->M_donor->get_donor_by_id($update_id);
        foreach ($query as $row) {
            $data["donor_name"] = $row["donor_name"];
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
            $data = $this->get_donor_db_data($update_id);
            $data["update_id"] = $update_id;
        } else {
            $data = $this->get_donor_form_data();
        }

        $data["page_title"] = "Create Donor";
        $this->load->view("donor/_form", $data);
    }

    function save()
    {
        $data = $this->get_donor_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("donor_id", $update_id);
            $this->db->update("tbl_donors", $data);
        } else {
            $this->db->insert("tbl_donors", $data);
        }
        if ($update_id != ""):
            redirect("Donor");
        else:
            redirect("Donor/read");
        endif;
        $this->session->set_flashdata("message", "Donor saved successfully!");
    }

    function delete($param="")
    {
        $data["deleted"] = 1;
        $this->db->where("donor_id", $param);
        $this->db->update("tbl_donors", $data);
        $this->session->set_flashdata("message", "Donor Removed Successfully!");
        redirect("Donor");
    }
}
