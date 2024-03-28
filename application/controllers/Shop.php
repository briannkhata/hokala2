<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Shop extends CI_Controller
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
        $data["page_title"] = "shop List";
        $this->load->view("shop/_shop_list", $data);
    }

   
    function get_form_data()
    {
        $data["name"] = $this->input->post("name");
        $data["description"] = $this->input->post("description");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_shop->get_shop_by_id($update_id);
        foreach ($query as $row) {
            $data["name"] = $row["name"];
            $data["description"] = $row["description"];
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
        $data["page_title"] = "Create Shop";
        $this->load->view("shop/_add_shop", $data);
    }

    function save()
    {
        $data = $this->get_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("shop_id", $update_id);
            $this->db->update("tbl_shops", $data);
        } else {
            $this->db->insert("tbl_shops", $data);
        }
        if ($update_id != ""):
            redirect("Shop");
        else:
            redirect("Shop/read");
        endif;
        $this->session->set_flashdata("message", "Shop saved successfully!");
    }

    function delete($param="")
    {
        $data["deleted"] = 1;
        $this->db->where("shop_id", $param);
        $this->db->update("tbl_shops", $data);
        $this->session->set_flashdata("message", "Shop Removed Successfully!");
        redirect("Shop");
    }


}