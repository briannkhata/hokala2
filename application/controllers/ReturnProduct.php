<?php
defined("BASEPATH") or exit("No direct script access allowed");

class ReturnProduct extends CI_Controller
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
        $data["page_title"] = "Return Product";
        $this->load->view("returnproduct/_returnproduct", $data);
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
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }

    }


    function return_products()
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
        $sale_type = "return";
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
        $data['balance'] = $total - $tendered;
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
                    'total' => -($price * $qtys[$i]),
                    'sub_total' => -$sub_total,
                    'client_id' => $client_id,
                    'sale_date' => $sale_date,
                    'shop_id' => $shop_id,
                    'user_id' => $user_id,
                    'sale_type' => $sale_type,
                );
                $this->db->insert('tbl_sale_details', $data);

                $old_qty = $this->M_product->get_shop_qty($productId, $shop_id);
                $new_qty = $old_qty + $qtys[$i];
                $this->db->where('product_id', $productId);
                $this->db->where('shop_id', $shop_id);
                $this->db->update('tbl_quantities', array('qty' => $new_qty));
            }
            $response = array('success' => true, 'message' => 'Return product done successfully');
        } else {
            $response = array('success' => false, 'message' => 'Error: Invalid data received');
        }
        echo json_encode($response);
    }






    function finish_sale()
    {
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $client_id = $this->input->post('client_id');
        $payment_type_id = $this->input->post('payment_type_id');
        $details = $this->input->post('details');
        $sale_type = $this->input->post('sale_type');
        $tendered = str_replace([',', ' '], '', $this->input->post('tendered'));

        $sub_total = $this->input->post('vat');
        $total_vat = $this->input->post('client_id');
        $total = $this->M_product->get_total_sum_cart($user_id, $client_id, $shop_id);

        $sale_date = date('Y-m-d h:m:s');
        $data['user_id'] = $user_id;
        $data['shop_id'] = $shop_id;
        $data['sale_date'] = $sale_date;
        $data['vat'] = ($sale_type == 2) ? '-' . $total_vat : $total_vat;
        $data['sub_total'] = ($sale_type == 2) ? '-' . $sub_total : $sub_total;
        $data['total'] = ($sale_type == 2) ? '-' . $total : $total;
        $data['tendered'] = $tendered;
        $data['change'] = $tendered - $total;
        $data['client_id'] = $client_id;
        $data['payment_type_id'] = $payment_type_id;
        $data['details'] = $details;
        $data['sale_type'] = $sale_type;
        $data['balance'] = ($sale_type == 2) ? '' : $total - $tendered;
        $this->db->insert('tbl_sales', $data);
        $sale_id = $this->db->insert_id();


        $products = $this->M_product->get_cart($user_id, $client_id, $shop_id);
        foreach ($products as $row) {
            $sale_detail_data['product_id'] = $row['product_id'];
            $sale_detail_data['price'] = $row['price'];
            $sale_detail_data['qty'] = $row['qty'];
            $sale_detail_data['vat'] = ($sale_type == 2) ? '-' . $row['vat'] : $row['vat'];
            $sale_detail_data['total'] = ($sale_type == 2) ? '-' . $row['total'] : $row['total'];
            $sale_detail_data['sub_total'] = ($sale_type == 2) ? '-' . $row['sub_total'] : $row['sub_total'];
            $sale_detail_data['sale_id'] = $sale_id;
            $sale_detail_data['client_id'] = $row['client_id'];
            $sale_detail_data['sale_date'] = $sale_date;
            $sale_detail_data['shop_id'] = $row['shop_id'];
            $sale_detail_data['user_id'] = $row['user_id'];
            $sale_detail_data['sale_type'] = $row['sale_type'];
            $this->db->insert('tbl_sale_details', $sale_detail_data);

            $old_qty = $this->M_product->get_shop_qty($row['product_id'], $row['shop_id']);
            $new_qty = ($sale_type == 1) ? $old_qty - $row['qty'] : ($sale_type == 2 ? $old_qty + $row['qty'] : $old_qty);
            $this->db->where('product_id', $row['product_id']);
            $this->db->where('shop_id', $row['shop_id']);
            $this->db->update('tbl_quantities', array('qty' => $new_qty));
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('client_id', $client_id);
        $this->db->delete('tbl_cart_sales');
        redirect("Sale/receipt/" . $sale_id . '/' . $client_id);
        // $receipt_data = $this->M_product->get_sales_details($user_id, $client_id, $shop_id, $sale_id);
        //return json_encode($receipt);
        //$receipt_html = $this->load->view('sale/_receipt', $receipt_data, true);
        //echo $receipt_html;

    }

}