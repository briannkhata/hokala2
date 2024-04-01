<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Payment_type extends CI_Controller
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
        $data["page_title"] = "Payment_type List";
        $this->load->view("payment_type/_payment_type_list", $data);
    }

   
    function get_form_data()
    {
        $data["payment_type"] = $this->input->post("payment_type");
        $data["details"] = $this->input->post("details");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_payment_type->get_payment_type_by_id($update_id);
        foreach ($query as $row) {
            $data["payment_type"] = $row["payment_type"];
            $data["details"] = $row["details"];
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
        $data["page_title"] = "Create payment_type";
        $this->load->view("payment_type/_add_payment_type", $data);
    }

    function save()
    {
        $data = $this->get_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("payment_type_id", $update_id);
            $this->db->update("tbl_payment_types", $data);
        } else {
            $this->db->insert("tbl_payment_types", $data);
        }
        if ($update_id != ""):
            redirect("Payment_type");
        else:
            redirect("Payment_type/read");
        endif;
        $this->session->set_flashdata("message", "payment_type saved successfully!");
    }

    function delete($param="")
    {
        $data["deleted"] = 1;
        $this->db->where("payment_type_id", $param);
        $this->db->update("tbl_payment_types", $data);
        $this->session->set_flashdata("message", "Payment_type Removed Successfully!");
        redirect("Payment_type");
    }


}