<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Period extends CI_Controller
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
        $data["page_title"] = "Periods List";
        $data['menu_id'] = $this->M_role->get_menu_id_by_name('period');
        $this->load->view("period/_list", $data);
    }

    function get_period_form_data()
    {
        $data["title"] = $this->input->post("title");
        $data["start_month"] = $this->input->post("start_month");
        $data["end_month"] = $this->input->post("end_month");
        $data["num_days"] = $this->input->post("num_days");
        return $data;
    }

    function get_period_db_data($update_id)
    {
        $query = $this->M_period->get_period_by_id($update_id);
        foreach ($query as $row) {
            $data["title"] = $row['title'];
            $data["start_month"] = $row['start_month'];
            $data["end_month"] = $row['end_month'];
            $data["num_days"] = $row['num_days'];
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
            $data = $this->get_period_db_data($update_id);
            $data["update_id"] = $update_id;
        } else {
            $data = $this->get_period_form_data();
        }

        $data["page_title"] = "Create period";
        $this->load->view("period/_form", $data);
    }

    function save()
    {
        $data = $this->get_period_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("period_id", $update_id);
            $this->db->update("tbl_periods", $data);
        } else {
            $this->db->insert("tbl_periods", $data);
        }
        if ($update_id != ""):
            redirect("Period");
        else:
            redirect("Period/read");
        endif;
        $this->session->set_flashdata("message", "Period saved successfully!");
    }

    function delete($param = "")
    {
        $data["deleted"] = 1;
        $this->db->where("period_id", $param);
        $this->db->update("tbl_periods", $data);
        $this->session->set_flashdata("message", "Period Removed Successfully!");
        redirect("Period");
    }
}
