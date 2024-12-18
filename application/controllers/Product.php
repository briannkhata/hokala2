<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('CIQrCode');
        if ($this->session->userdata("user_login") != 1) {
            redirect(base_url(), "refresh");
        }
    }

    function index()
    {
        $data["page_title"] = "Product List";
        $this->load->view("product/_product_list", $data);
    }

    function get_form_data()
    {
        $data["name"] = $this->input->post("name");
        $data["barcode"] = $this->input->post("barcode");
        $data["category_id"] = $this->input->post("category_id");
        $data["desc"] = $this->input->post("desc");
        $data["brand_id"] = $this->input->post("brand_id");
        $data["selling_price"] = $this->input->post("selling_price");
        $data["unit_id"] = $this->input->post("unit_id");
        $data["reorder_level"] = $this->input->post("reorder_level");
        $data["expiry_date"] = $this->input->post("expiry_date");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_product->get_product_by_id($update_id);
        foreach ($query as $row) {
            $data["name"] = $row["name"];
            $data["barcode"] = $row["barcode"];
            $data["category_id"] = $row["category_id"];
            $data["selling_price"] = $row["selling_price"];
            $data["brand_id"] = $row["brand_id"];
            $data["unit_id"] = $row["unit_id"];
            $data["reorder_level"] = $row["reorder_level"];
            $data["expiry_date"] = $row["expiry_date"];
            $data["desc"] = $row["desc"];
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
        $data["page_title"] = "Create Product";
        $this->load->view("product/_add_product", $data);
    }

    function generateBarcode($barcode_number)
    {
        $barcode_path = './assets/images/qrcode/';
        if (!is_dir($barcode_path)) {
            mkdir($barcode_path, 0777, true);
        }

        // Define the barcode image name and full path
        $barcode_image_name = $barcode_number . '.png';
        $barcode_full_path = $barcode_path . $barcode_image_name;

        // CIQRCode configuration
        $config = [
            'cacheable' => true,
            'cachedir' => './application/cache/',
            'errorlog' => './application/logs/',
            'quality' => true,
            'size' => 1024,
            'black' => [224, 255, 255], // Light Cyan
            'white' => [70, 130, 180]  // Steel Blue
        ];
        $this->ciqrcode->initialize($config);

        // Barcode generation parameters
        $params = [
            'data' => $barcode_number,
            'level' => 'H',
            'size' => 10,
            'savename' => $barcode_full_path
        ];
        $this->ciqrcode->generate($params);

        return [
            'barcode' => $barcode_number,
            'barcode_image' => $barcode_full_path
        ];
    }


    function save()
    {
        $data = $this->get_form_data();
        $barcode_number = $data["barcode"];
        $barcode_details = $this->generateBarcode($barcode_number);
        $data['barcode'] = $barcode_details['barcode'];
        $data['barcode_image'] = $barcode_details['barcode_image'];

        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $data["modified_by"] = $this->session->userdata("user_id");
            $data["modified_date"] = date("Y-m-d");
            $this->db->where("product_id", $update_id);
            $this->db->update("tbl_products", $data);

            $this->sync_quantities_by_shop($update_id);
        } else {

            $this->db->insert("tbl_products", $data);
            $product_id = $this->db->insert_id();
            $this->sync_quantities_by_shop($product_id);
        }

        $this->session->set_flashdata("message", "Product saved successfully!");
        if ($update_id != ""):
            redirect("Product");
        else:
            redirect("Product/read");
        endif;
    }

    function delete($param = "")
    {
        $data["deleted"] = 1;
        $data["deleted_by"] = $this->session->userdata("user_id");
        $data["date_deleted"] = date("Y-m-d");
        $this->db->where("product_id", $param);
        $this->db->update("tbl_products", $data);
        $this->session->set_flashdata("message", "Product Removed!");
        redirect("Product");
    }

    function sync_quantities_by_shop($product_id)
    {
        $shops = $this->M_shop->get_shops();
        foreach ($shops as $shop) {
            $qty_exists = $this->M_move->get_shop_quantities($product_id, $shop['shop_id']);
            if (!$qty_exists) {
                $data = array(
                    "product_id" => $product_id,
                    "shop_id" => $shop['shop_id'],
                    "qty" => 0
                );
                $this->db->insert("tbl_quantities", $data);
            }
        }

        $whs = $this->M_warehouse->get_warehouses();
        foreach ($whs as $wh) {
            $qty_exists = $this->M_move->get_warehouse_quantities($product_id, $wh['warehouse_id']);
            if (!$qty_exists) {
                $data = array(
                    "product_id" => $product_id,
                    "warehouse_id" => $wh['warehouse_id'],
                    "qty" => 0
                );
                $this->db->insert("tbl_wh_quantities", $data);
            }
        }
    }
    function search_product()
    {
        $barcode = $this->input->post('barcode');
        $results = $this->M_product->searchProducts($barcode);
        echo json_encode($results);
    }

    function get_address()
    {
        $results = $this->M_user->get_shop_address();
        echo json_encode($results);
    }

}