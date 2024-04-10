<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Warehouse extends CI_Controller
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
        $data["page_title"] = "Warehouse List";
        $this->load->view("warehouse/_warehouse_list", $data);
    }

    function get_form_data()
    {
        $data["name"] = $this->input->post("name");
        $data["description"] = $this->input->post("description");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_warehouse->get_warehouse_by_id($update_id);
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
        $data["page_title"] = "Create warehouse";
        $this->load->view("warehouse/_add_warehouse", $data);
    }

    function save()
    {
        $data = $this->get_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $this->db->where("warehouse_id", $update_id);
            $this->db->update("tbl_warehouses", $data);
            $this->sync_quantities($update_id);

        } else {
            $this->db->insert("tbl_warehouses", $data);
            $warehouse_id = $this->db->insert_id();
            $this->sync_quantities($warehouse_id);
        }
        if ($update_id != ""):
            redirect("Warehouse");
        else:
            redirect("Warehouse/read");
        endif;
        $this->session->set_flashdata("message", "Warehouse saved successfully!");
    }

    function sync_quantities($warehouse_id)
    {
        $products = $this->M_product->get_products();
        foreach ($products as $pro) {
            $qty_exists = $this->M_move->get_warehouse_quantities($pro['product_id'],$warehouse_id);
            if (!$qty_exists) {
                $data = array(
                    "product_id" => $pro['product_id'],
                    "warehouse_id" => $warehouse_id,
                    "qty" => 0
                );
                $this->db->insert("tbl_wh_quantities", $data);
            }
        }

    }

    function delete($param="")
    {
        $data["deleted"] = 1;
        $this->db->where("warehouse_id", $param);
        $this->db->update("tbl_warehouses", $data);
        $this->session->set_flashdata("message", "Warehouse Removed Successfully!");
        redirect("Warehouse");
    }


}