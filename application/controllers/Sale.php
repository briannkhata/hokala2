<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Sale extends CI_Controller
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
        $data["page_name"] = "pos";
        $data["page_title"] = "Point of Sale | " . strtoupper($this->M_user->get_name($this->session->userdata('user_id')));
        $this->load->view("sale/_sale", $data);
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
                'barcode' => $product['barcode'],
                'selling_price' => trim($product['selling_price'])
            ];

            $response = array(
                'success' => true,
                'cart_items' => $cart_items,
            );
            echo json_encode($response);
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product Not Found'));
        }

    }

    function sale_products()
    {
        $productIds = $this->input->post('product_ids');
        $qtys = $this->input->post('qtys');
        $vats = $this->input->post('vats');

        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $client_id = $this->input->post('client_id');
        $details = $this->input->post('details');
        $sub_total = $this->input->post('sub_total');
        $total_vat = $this->input->post('total_vat');
        $payment_type_id = $this->input->post('payment_type_id');
        $details = $this->input->post('details');
        $total = $this->input->post('total_bill');
        $sale_type = "shop-sale";
        $tendered = str_replace([',', ' '], '', $this->input->post('tendered'));

        $sale_date = date('Y-m-d h:m:s');
        $data['user_id'] = $user_id;
        $data['shop_id'] = $shop_id;
        $data['sale_date'] = $sale_date;
        $data['vat'] = $total_vat;
        $data['sub_total'] = $sub_total;
        $data['total'] = $total;
        $data['tendered'] = $tendered;
        $data['change'] = $tendered - $total;
        $data['client_id'] = $client_id;
        $data['payment_type_id'] = $payment_type_id;
        $data['details'] = $details;
        $data['sale_type'] = $sale_type;
        $data['balance'] = 0;
        $this->db->insert('tbl_sales', $data);
        $sale_id = $this->db->insert_id();

        if (!empty($productIds) && !empty($qtys) && count($productIds) == count($qtys) && !empty($vats) && count($productIds) == count($vats)) {
            for ($i = 0; $i < count($productIds); $i++) {
                $productId = $productIds[$i];
                $price = $this->M_product->get_price($productId);
                $data = array(
                    'sale_id' => $sale_id,
                    'price' => $price,
                    'qty' => $qtys[$i],
                    'vat' => $vats[$i],
                    'product_id' => $productId,
                    'total' => ($price * $qtys[$i]),
                    'sub_total' => $sub_total,
                    'client_id' => $client_id,
                    'sale_date' => $sale_date,
                    'shop_id' => $shop_id,
                    'user_id' => $user_id,
                    'sale_type' => $sale_type,
                    'payment_type_id' => $payment_type_id,
                );
                $this->db->insert('tbl_sale_details', $data);

                $old_qty = $this->M_product->get_shop_qty($productId, $shop_id);
                $new_qty = $old_qty - $qtys[$i];
                $this->db->where('product_id', $productId);
                $this->db->where('shop_id', $shop_id);
                $this->db->update('tbl_quantities', array('qty' => $new_qty));
            }
            $result = $this->M_product->get_sales_details_for_receipt($user_id, $sale_id);
            $response = array('success' => true, 'message' => 'Sale done successfully', 'data' => $result);
        } else {
            $response = array('success' => false, 'message' => 'Error: Invalid data received');
        }
        echo json_encode($response);
    }

    function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $maxIndex = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $maxIndex)];
        }

        return $randomString;
    }


    function sale_pause()
    {
        $productIds = $this->input->post('product_ids');
        $qtys = $this->input->post('qtys');
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $client_id = $this->input->post('client_id');
        $date_paused = date('Y-m-d h:m:s');
        $session_id = $this->generateRandomString(8);

        if (!empty($productIds) && !empty($qtys) && count($productIds) == count($qtys)) {
            for ($i = 0; $i < count($productIds); $i++) {
                $productId = $productIds[$i];
                $price = $this->M_product->get_price($productId);
                $data = array(
                    'product_id' => $productId,
                    'client_id' => $client_id,
                    'qty' => $qtys[$i],
                    'price' => $price,
                    'shop_id' => $shop_id,
                    'user_id' => $user_id,
                    'date_paused' => $date_paused,
                    'session_id' => $session_id,
                );
                $this->db->insert('tbl_cart_sales', $data);
            }
            $response = array('success' => true, 'message' => 'Pausing Sale successfully');
        } else {
            $response = array('success' => false, 'message' => 'Error: Invalid data received');
        }
        echo json_encode($response);
    }

    function synch_sales_to_mra()
    {

    }

    function process()
    {
        $barcode = $this->input->post('barcode');
        if ($barcode) {
            $this->load->model('Barcode_model');
            $result = $this->M_product->getProductByBarcode($barcode);

            if ($result) {
                echo "Product Found: " . $result->product_name;
            } else {
                echo "No product found with this barcode.";
            }
        } else {
            echo "Please scan a barcode.";
        }
    }

    function delete_cart()
    {
        $session_id = $this->input->post('session_id');
        $this->db->where("session_id", $session_id);
        $this->db->delete("tbl_cart_sales");
        $response = array('success' => true, 'message' => 'deleting paused sale done successfully');
        echo json_encode($response);
    }


    function activate_terminal()
    {

    }

    function confirm_activation()
    {

    }

    function download_products()
    {

    }

    function submit_sales()
    {

    }


}