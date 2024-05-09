<?php
defined("BASEPATH") or exit("No direct script access allowed");

class AdjustPrice extends CI_Controller
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
        $data["page_title"] = "Adjust Prices";
        $this->load->view("adjustprice/_adjustprice", $data);
    }
    function refresh_cart()
    {

        $product_id = trim($this->input->post('product_id'));

        if (!empty($product_id) && isset($product_id)) {
            $barcode = $this->M_product->get_barcode($product_id);
            $product_info = $this->M_product->get_product_by_id($product_id);
        } else {
            $barcode = trim($this->input->post('barcode'));
            $product_info = $this->M_product->get_product_by_barcode($barcode);
        }

        if (!isset($barcode)) {
            echo json_encode(array('success' => false, 'message' => 'Barcode is required!!!'));
            return;
        }

        if (!empty($product_info)) {
            $product = $product_info[0];
            $cart_items = array();
            $cart_items[] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'desc' => $product['desc'],
                'selling_price' => trim($product['selling_price'])
            ];

            $response = array(
                'success' => true,
                'cart_items' => $cart_items,
            );
            echo json_encode($response);
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }

    }


    function save_new_prices()
    {
        $productIds = $this->input->post('product_ids');
        $prices = $this->input->post('prices');

        if (!empty($productIds) && !empty($prices) && count($productIds) == count($prices)) {
            for ($i = 0; $i < count($productIds); $i++) {
                $productId = $productIds[$i];
                $data = array(
                    'selling_price' => $prices[$i]
                );
                $this->db->where('product_id', $productId);
                $this->db->update('tbl_products', $data);
            }
            $response = array('success' => true, 'message' => 'Prices updated successfully');
        } else {

            $response = array('success' => false, 'message' => 'Error: Invalid data received');
        }
        echo json_encode($response);
    }

}