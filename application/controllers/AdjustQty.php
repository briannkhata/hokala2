<?php
defined("BASEPATH") or exit("No direct script access allowed");

class AdjustQty extends CI_Controller
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
        $data["page_title"] = "Adjust Quantities";
        $this->load->view("adjustqty/_adjustqty", $data);
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
                'shop_id' => $product['shop_id'],
                'desc' => $product['desc'],
                'selling_Qty' => trim($product['selling_Qty'])
            ];

            $response = array(
                'success' => true,
                'cart_items' => $cart_items,
            );
            echo json_encode($response);
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not Found'));
        }

    }


    function save_new_qty()
    {
        $productIds = $this->input->post('product_ids');
        $qtys = $this->input->post('qty');
        $warehouse_id = $this->input->post('warehouse_id');
        $shop_id = $this->input->post('shop_id');

        if (!isset($shop_id) && !isset($warehouse_id)) {
            $response = array('success' => false, 'message' => 'Error: destination is required');
            echo json_encode($response);
            return;
        }

        if (!empty($productIds) && !empty($qtys) && count($productIds) == count($qtys)) {
            for ($i = 0; $i < count($productIds); $i++) {
                $productId = $productIds[$i];
                $qty = $qtys[$i];

                if (isset($warehouse_id) && !isset($shop_id)) {
                    $data['qty'] = $this->M_move->get_warehouse_qty($productId, $warehouse_id) + $qty;
                    $this->db->where('product_id', $productId);
                    $this->db->where('warehouse_id', $warehouse_id);
                    $this->db->update('tbl_wh_quantities', $data);
                } elseif (!isset($warehouse_id) && isset($shop_id)) {
                    $data['qty'] = $this->M_move->get_shop_qty($productId, $shop_id) + $qty;
                    $this->db->where('product_id', $productId);
                    $this->db->where('shop_id', $shop_id);
                    $this->db->update('tbl_quantities', $data);
                } else {
                    $response = array('success' => true, 'message' => 'Choose Destination');
                }
            }
            $response = array('success' => true, 'message' => 'Quantities Updated successfully');
        } else {

            $response = array('success' => false, 'message' => 'Error: Invalid Data');
        }
        echo json_encode($response);
    }

}