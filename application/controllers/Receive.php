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
        $expiry_date = $this->input->post('expiry_date');
        $cost_price = str_replace([',', ' '], '', $this->input->post('cost_price'));
        $price = str_replace([',', ' '], '', $this->input->post('price'));

        if (empty($qtyNew) || $qtyNew <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Quantity must be greater than 0!!!'));
            return;
        }

        if (empty($cost_price) || $cost_price <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Cost Price must be greater than 0'));
            return;
        }

        if (empty($price) || $price <= 0) {
            echo json_encode(array('success' => false, 'message' => 'Selling Price must be greater than 0'));
            return;
        }

        $product_info = $this->M_receive->get_product_by_cart_id($cart_id);
        if (!empty($product_info)) {
            $qty = $qtyNew;
            $product = $product_info[0];
            $total_cost = $cost_price * $qty;
            $cart_data = array(
                'qty' => $qty,
                'price' => $price,
                'cost_price' => $cost_price,
                'total_cost' => $total_cost,
                'expiry_date' => $expiry_date
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
        $supplier_id = $this->input->post('supplier_id');
        $order_details = $this->input->post('order_details');
        $shop_id = $this->input->post('shop_id');
        $warehouse_id = $this->input->post('warehouse_id');

        if (!isset($shop_id) && !isset($warehouse_id)) {
            $this->session->set_flashdata("error", "Please select the the destination");
            redirect("Receive");
        }

        if (!isset($supplier_id)) {
            $this->session->set_flashdata("error", "Please select the Supplier");
            redirect("Receive");
        }

        $products = $this->M_receive->get_cart($user_id);
        if (count($products) <= 0) {
            $this->session->set_flashdata("error", "No data Found to Receive");
            redirect("Receive");
        }

        $data['user_id'] = $user_id;
        $data['shop_id'] = $shop_id;
        $data['warehouse_id'] = $warehouse_id;
        $data['supplier_id'] = $supplier_id;
        $data['order_details'] = $order_details;
        $data['receive_date'] = date('Y-m-d h:m:s');
        $data['total_cost'] = $this->M_receive->get_total_sum_cart($user_id);
        $this->db->insert('tbl_receivings', $data);
        $receive_id = $this->db->insert_id();

        foreach ($products as $row) {
            $receive_detail_data['product_id'] = $row['product_id'];
            $receive_detail_data['price'] = $row['price'];
            $receive_detail_data['qty'] = $row['qty'];
            $receive_detail_data['cost_price'] = $row['cost_price'];
            $receive_detail_data['total_cost'] = $row['total_cost'];
            $receive_detail_data['receive_id'] = $receive_id;
            $receive_detail_data['user_id'] = $row['user_id'];
            $receive_detail_data['receive_date'] = date('Y-m-d H:i:s');
            $receive_detail_data['expiry_date'] = $row['expiry_date'];
            $this->db->insert('tbl_receive_details', $receive_detail_data);

            //update products
            $this->db->where('product_id', $row['product_id']);
            $this->db->update('tbl_products', array('expiry_date' => $row['expiry_date'], 'selling_price' => $row['price']));

            if (isset($shop_id) && !isset($warehouse_id)) {
                $old_shop_qty = $this->M_move->get_shop_qty($row['product_id'], $shop_id);
                $new_shop_qty = $old_shop_qty + $row['qty'];
                $this->db->where('product_id', $row['product_id']);
                $this->db->where('shop_id', $shop_id);
                $this->db->update('tbl_quantities', array('qty' => $new_shop_qty));
            }

            if (!isset($shop_id) && isset($warehouse_id)) {
                $old_whs_qty = $this->M_move->get_warehouse_qty($row['product_id'], $warehouse_id);
                $new_wh_qty = $old_whs_qty + $row['qty'];
                $this->db->where('product_id', $row['product_id']);
                $this->db->where('warehouse_id', $warehouse_id);
                $this->db->update('tbl_wh_quantities', array('qty' => $new_wh_qty));
            }
        }

        $this->db->where('user_id', $user_id);
        $this->db->delete('tbl_cart_receive');
        $this->session->set_flashdata("message", "Products Received Successfully");
        redirect("Receive");

        // redirect("receive/receipt/" . $receive_id . '/' . $client_id);
        //$receipt_data = $this->M_product->get_receives_details($user_id, $client_id, $shop_id, $receive_id);
        //return json_encode($receipt);
        //$receipt_html =  $this->load->view('receive/_receipt', $receipt_data, true);
        //echo $receipt_html;

    }


    function receipt($param = "")
    {
        $data['receive_id'] = $param;
        $data["page_title"] = "Receipt";
        $data['page_name'] = "pos";
        $this->load->view('receive/_receipt', $data);
    }
}