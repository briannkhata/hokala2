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
        $data["page_title"] = "POS WINDOW";
        $this->load->view("sale/_pos", $data);
    }
    function refresh_cart()
    {

        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $client_id = $this->input->post('client_id');
        $sale_type = $this->input->post('sale_type');
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
            $found = $this->M_product->get_product_in_cart($product['product_id'], $user_id, $client_id, $shop_id);
            if ($found) {
                $unit_id = $this->M_product->get_unit_id($product['product_id']);
                $saleQTY = $this->M_unit->get_unit_qty($unit_id);
                $cart_id = $this->M_product->get_cart_id_by_product_id($product['product_id'], $user_id, $client_id, $shop_id);
                $qty = $this->M_product->get_cart_qty($cart_id) + $saleQTY;
                $price = $this->M_product->get_cart_price($cart_id);

                $sub_total = $price * $qty;
                $vat_amount = (($vat / 100) * $sub_total);
                $total = $vat_amount + $sub_total;
                $cart_data = array(
                    'qty' => $qty,
                    'vat' => $vat_amount,
                    'total' => $total,
                    'sub_total' => $sub_total
                );
                $this->db->where('cart_id', $cart_id);
                $this->db->update('tbl_cart_sales', $cart_data);

            } else {
                $unit_id = $this->M_product->get_unit_id($product['product_id']);
                $saleQTY = $this->M_unit->get_unit_qty($unit_id);
                $qty = $saleQTY;
                $sub_total = $this->M_product->get_price($product['product_id']) * $qty;
                $vat_amount = (($vat / 100) * $sub_total);
                $total = $vat_amount + $sub_total;
                $cart_data = array(
                    'product_id' => $product['product_id'],
                    'price' => $this->M_product->get_price($product['product_id']),
                    'qty' => $qty,
                    'vat' => $vat_amount,
                    'total' => $total,
                    'sub_total' => $sub_total,
                    'user_id' => $user_id,
                    'shop_id' => $shop_id,
                    'client_id' => $client_id,
                    'sale_type' => $sale_type
                );
                $this->db->insert('tbl_cart_sales', $cart_data);
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

        if (empty($qtyNew)) {
            echo json_encode(array('success' => false, 'message' => 'Quantity is required!!!'));
            return;
        }

        $product_info = $this->M_product->get_product_by_cart_id($cart_id);
        $vat = $this->db->get('tbl_settings')->row()->vat;
        if (!empty($product_info)) {
            $qty = $qtyNew;
            $product = $product_info[0];
            $sub_total = $product['price'] * $qty;
            $vat_amount = (($vat / 100) * $sub_total);
            $total = $vat_amount + $sub_total;
            $cart_data = array(
                'qty' => $qty,
                'vat' => $vat_amount,
                'total' => $total,
                'sub_total' => $sub_total
            );
            $this->db->where('cart_id', $cart_id);
            $this->db->update('tbl_cart_sales', $cart_data);
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }
    }


    function delete_cart()
    {
        $cart_id = $this->input->post('cart_id');
        $this->db->where("cart_id", $cart_id);
        $this->db->delete("tbl_cart_sales");
        return;
    }

    function refreshCart()
    {
        $client_id = $this->input->post('client_id');
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $data['cart'] = $this->M_product->get_cart($user_id, $client_id, $shop_id);
        $this->load->view("sale/_load_cart", $data);
    }

    function refresh_total_bill()
    {
        $this->load->view("sale/_load_total_bill");
    }

    function refresh_sub_total_bill()
    {
        $this->load->view("sale/_load_sub_total");
    }

    function refresh_total_vat()
    {
        $this->load->view("sale/_load_total_vat");
    }

    function cancel()
    {
        $user_id = $this->session->userdata('user_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $client_id = $this->input->post('client_id');
        $this->db->where('user_id', $user_id);
        $this->db->where('shop_id', $shop_id);
        $this->db->where('client_id', $client_id);
        $this->db->delete('tbl_cart_sales');
        echo json_encode(array('success' => true, 'message' => 'Cart cleared successfully!!!'));
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

        $sub_total = $this->M_product->get_sub_total_sum_cart($user_id, $client_id, $shop_id);
        $total_vat = $this->M_product->get_total_vat_cart($user_id, $client_id, $shop_id);
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


    function receipt($param = "")
    {
        $data['sale_id'] = $param;
        $data["page_title"] = "Receipt";
        $data['page_name'] = "pos";
        $this->load->view('sale/_receipt', $data);
    }
}