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
        $data["page_title"] = "Point of Sale";
        $data['page_name'] = "pos";
        $this->load->view("sale/_pos", $data);
    }

    function refresh_cart()
    {
        $user_id = $this->session->userdata('user_id');
        $shift_id = $this->session->userdata('shift_id');
        $shop_id = $this->M_user->get_user_shop($user_id);
        $barcode = trim($this->input->post('barcode'));
        $client_id = trim($this->input->post('client_id'));

        if (empty($barcode)) {
            echo json_encode(array('success' => false, 'message' => 'Barcode is required!!!'));
            return;
        }

        $product_info = $this->M_product->get_product_by_barcode($barcode);
        $vat = $this->db->get('tbl_settings')->row()->vat;
        if (!empty($product_info)) {
            $product = $product_info[0];
            $found = $this->M_product->get_prouct_in_cart($product['product_id']);
            if ($found) {
                $cart_id = $this->M_product->get_cart_id_by_product_id($product['product_id']);
                $qty = $this->M_product->get_cart_qty($cart_id) + 1;
                $price = $this->M_product->get_cart_price($cart_id);

                $sub_total = $price * $qty;
                $vat_amount = (($vat / 100) * $sub_total);
                $total = $vat_amount + $sub_total;
                $cart_data = array(
                    'qty' => $qty,
                    'vat' => $vat_amount,
                    'total' => $total,
                    'sub_total' => $sub_total
                    //'client_id' => $client_id
                );
                $this->db->where('cart_id', $cart_id);
                $this->db->update('tbl_cart_sales', $cart_data);

            } else {
                $qty = 1;
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
                    'shift_id' => $shift_id,
                    'shop_id' => $shop_id,
                    'client_id' => $client_id
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
        $this->load->view("sale/_load_cart");
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
        $products = $this->M_product->get_cart();

        $data['user_id'] = $this->session->userdata('user_id');
        $data['sale_date'] = date('Y-m-d h:m:s');
        $data['vat'] = $this->M_product->get_total_vat_cart();
        $data['sub_total'] = $this->M_product->get_sub_total_sum_cart();
        $data['total'] = $this->M_product->get_total_sum_cart();
        $data['tendered'] = $this->input->post('tendered');
        $data['change'] = $data['tendered'] - $data['total'];

        $this->db->trans_start();
        $this->db->insert('tbl_sales', $data);
        $sale_id = $this->db->insert_id();

        foreach ($products as $row) {
            $sale_detail_data['product_id'] = $row['product_id'];
            $sale_detail_data['price'] = $row['price'];
            $sale_detail_data['qty'] = $row['qty'];
            $sale_detail_data['vat'] = $row['vat'];
            $sale_detail_data['total'] = $row['total'];
            $sale_detail_data['sub_total'] = $row['sub_total'];
            $sale_detail_data['sale_id'] = $sale_id;
            $sale_detail_data['sale_date'] = date('Y-m-d H:i:s');
            $sale_detail_data['shop_id'] = $row['shop_id'];
            $this->db->insert('tbl_sale_details', $sale_detail_data);
            $old_qty = $this->M_product->get_qty1($row['product_id'],$row['shop_id']);
            $new_qty = $old_qty - $row['qty'];
            $this->db->where('product_id', $row['product_id']);
            $this->db->where('shop_id', $row['shop_id']);
            $this->db->update('tbl_quantities', array('qty' => $new_qty));
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
        } else {
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->delete('tbl_cart_sales');
            redirect("Sale/receipt/" . $sale_id);
        }
    }

    function receipt($param = "")
    {
        $data['sale_id'] = $param;
        $data["page_title"] = "Receipt";
        $data['page_name'] = "pos";
        $this->load->view('sale/_receipt', $data);
    }
}