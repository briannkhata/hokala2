<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Receive extends CI_Controller
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
        $data["page_title"] = "POS WINDOW - RECEIVE";
        $this->load->view("receive/_pos", $data);
    }

    // function save_client()
    // {
    //     $client_id = $this->input->post('client_id');
    //     $name = $this->input->post('name');
    //     if (!empty($client_id) && empty($name)) {
    //         $client = $this->M_client->get_name($client_id) . ' | ' . $this->M_client->get_phone($client_id);
    //         $data["page_title"] = "POS WINDOW - " . $client;
    //         $this->load->view("receive/_pos", $data);
    //     }

    //     if ((!empty($client_id) || empty($client_id)) && !empty($name)) {
    //         $data['name'] = $name;
    //         $data['phone'] = $this->input->post('phone');
    //         $this->db->insert('tbl_clients', $data);
    //         $data['client_id'] = $this->db->insert_id();
    //         $client = $this->M_client->get_name($client_id) . ' | ' . $this->M_client->get_phone($client_id);
    //         $data["page_title"] = "POS WINDOW - " . $client;
    //         $this->load->view("receive/_pos", $data);

    //     }

    //     if (empty($client_id) && empty($name)) {
    //         $this->session->set_flashdata('message', 'Please select Client to proceed!!!');
    //         redirect('receive');
    //     }
    // }

    // function pos()
    // {
    //     //$client = $this->M_client->get_name($client_id) . ' | ' . $this->M_client->get_phone($client_id);
    //     //$data["page_title"] = "POS WINDOW - " . $client;
    //     $data['page_name'] = "pos";
    //     $this->load->view("receive/_pos", $data);
    // }

    function refresh_cart()
    {

        $user_id = $this->session->userdata('user_id');
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

        $vat = $this->db->get('tbl_settings')->row()->vat;
        if (!empty($product_info)) {
            $product = $product_info[0];
            $found = $this->M_receive->get_product_in_cart($product['product_id'], $user_id);
            if ($found) {
                //$unit_id = $this->M_product->get_unit_id($product['product_id']);
                //$receiveQTY = $this->M_unit->get_unit_qty($unit_id);
                $cart_id = $this->M_receive->get_cart_id_by_product_id($product['product_id'], $user_id);
                $qty = $this->M_receive->get_cart_qty($cart_id) + 1;
                $cost_price = $this->M_receive->get_cart_cost_price($cart_id);

                $total_cost = $cost_price * $qty;
                $cart_data = array(
                    'qty' => $qty,
                    'total_cost' => $total_cost
                );
                $this->db->where('cart_id', $cart_id);
                $this->db->update('tbl_cart_receive', $cart_data);

            } else {
               // $unit_id = $this->M_product->get_unit_id($product['product_id']);
               // $receiveQTY = $this->M_unit->get_unit_qty($unit_id);
                $selling_price = $this->M_product->get_price($product['product_id']);
                $qty = 1;
                $total_cost = $selling_price * $qty;
                $cart_data = array(
                    'product_id' => $product['product_id'],
                    'price' => $selling_price,
                    'qty' => $qty,
                    'cost_price' => $selling_price,
                    'total_cost' => $total_cost,
                    'user_id' => $user_id,
                );
                $this->db->insert('tbl_cart_receive', $cart_data);
            }
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }
    }

    function update_cart()
    {
        $cart_id = trim($this->input->post('cart_id'));
        $qtyNew = trim($this->input->post('qty'));
        $cost_price = trim($this->input->post('cost_price'));

        if (empty($qtyNew) || $qtyNew <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Quantity must be greater than 0!!!'));
            return;
        }

        if (empty($cost_price) || $cost_price <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Cost Price must be greater than 0'));
            return;
        }

        $product_info = $this->M_receive->get_product_by_cart_id($cart_id);
        if (!empty($product_info)) {
            $qty = $qtyNew;
            $product = $product_info[0];
            $total_cost = $cost_price * $qty;
            $cart_data = array(
                'qty' => $qty,
                'cost_price' => $cost_price,
                'total_cost' => $total_cost
            );
            $this->db->where('cart_id', $cart_id);
            $this->db->update('tbl_cart_receive', $cart_data);
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }
    }


    function delete_cart()
    {
        $cart_id = $this->input->post('cart_id');
        $this->db->where("cart_id", $cart_id);
        $this->db->delete("tbl_cart_receive");
        return;
    }

    function refreshCart()
    {
        $user_id = $this->session->userdata('user_id');
        $data['cart'] = $this->M_receive->get_cart($user_id);
        $this->load->view("receive/_load_cart", $data);
    }

    function refresh_total_bill()
    {
        $this->load->view("receive/_load_total_bill");
    }

    // function refresh_sub_total_bill()
    // {
    //     $this->load->view("receive/_load_sub_total");
    // }

    // function refresh_total_vat()
    // {
    //     $this->load->view("receive/_load_total_vat");
    // }

    function cancel()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_cart_receive');
        echo json_encode(array('success' => true, 'message' => 'Cart cleared successfully!!!'));
    }


    function finish_receive()
    {
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $client_id = $this->input->post('client_id');
        $payment_type_id = $this->input->post('payment_type_id');
        $details = $this->input->post('details');
        $products = $this->M_product->get_cart($user_id, $client_id, $shop_id);
        $data['user_id'] = $user_id;
        $data['shop_id'] = $this->M_user->get_user_shop($user_id);
        $data['receive_date'] = date('Y-m-d h:m:s');
        $data['vat'] = $this->M_product->get_total_vat_cart($user_id, $client_id, $shop_id);
        $data['sub_total'] = $this->M_product->get_sub_total_sum_cart($user_id, $client_id, $shop_id);
        $data['total'] = $this->M_product->get_total_sum_cart($user_id, $client_id, $shop_id);
        $data['tendered'] = str_replace([',', ' '], '', $this->input->post('tendered'));
        $data['change'] = $data['tendered'] - $data['total'];
        $data['client_id'] = $client_id;
        $data['payment_type_id'] = $payment_type_id;
        $data['details'] = $details;
        $data['balance'] = $data['total'] - $data['tendered'];
        $this->db->insert('tbl_receives', $data);
        $receive_id = $this->db->insert_id();

        foreach ($products as $row) {
            $receive_detail_data['product_id'] = $row['product_id'];
            $receive_detail_data['price'] = $row['price'];
            $receive_detail_data['qty'] = $row['qty'];
            $receive_detail_data['vat'] = $row['vat'];
            $receive_detail_data['total'] = $row['total'];
            $receive_detail_data['sub_total'] = $row['sub_total'];
            $receive_detail_data['receive_id'] = $receive_id;
            $receive_detail_data['client_id'] = $row['client_id'];
            $receive_detail_data['receive_date'] = date('Y-m-d H:i:s');
            $receive_detail_data['shop_id'] = $row['shop_id'];
            $receive_detail_data['user_id'] = $row['user_id'];
            $this->db->insert('tbl_receive_details', $receive_detail_data);
            $old_qty = $this->M_product->get_qty1($row['product_id'], $row['shop_id']);
            $new_qty = $old_qty - $row['qty'];
            $this->db->where('product_id', $row['product_id']);
            $this->db->where('shop_id', $row['shop_id']);
            $this->db->update('tbl_quantities', array('qty' => $new_qty));
        }

        $datap['receive_id'] = $receive_id;
        $datap['user_id'] = $user_id;
        $datap['shop_id'] = $this->M_user->get_user_shop($user_id);
        $datap['client_id'] = $client_id;
        $datap['payment_date'] = date('Y-m-d h:m:s');
        $datap['total_bill'] = $this->M_product->get_total_sum_cart($user_id, $client_id, $shop_id);
        $datap['payment_amount'] = str_replace([',', ' '], '', $this->input->post('tendered'));
        $datap['payment_type_id'] = $payment_type_id;
        $this->db->insert('tbl_payments', $datap);


        $this->db->where('user_id', $user_id);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('client_id', $client_id);
        $this->db->delete('tbl_cart_receives');
        // redirect("receive/receipt/" . $receive_id . '/' . $client_id);
        $receipt_data = $this->M_product->get_receives_details($user_id, $client_id, $shop_id, $receive_id);
        //return json_encode($receipt);
        $receipt_html =  $this->load->view('receive/_receipt', $receipt_data, true);
        echo $receipt_html;

    }


    function receipt($param = "")
    {
        $data['receive_id'] = $param;
        $data["page_title"] = "Receipt";
        $data['page_name'] = "pos";
        $this->load->view('receive/_receipt', $data);
    }
}