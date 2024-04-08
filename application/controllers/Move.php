<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Move extends CI_Controller
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
        $data["page_title"] = "Product To Move";
        $this->load->view("move/_pos", $data);
    }

    function refresh_cart()
    {
        $user_id = $this->session->userdata('user_id');
        $barcode = trim($this->input->post('barcode'));
        if (empty($barcode)) {
            echo json_encode(array('success' => false, 'message' => 'Barcode is required!!!'));
            return;
        }

        $move_info = $this->M_move->get_product_by_barcode($barcode);
        if (!empty($move_info)) {
            $move = $move_info[0];
            $found = $this->M_move->get_product_in_cart($move['product_id'],$user_id);
            if ($found) {
                $cart_id = $this->M_move->get_cart_id_by_product_id($move['product_id'],$user_id);
                $qty = $this->M_move->get_cart_qty($cart_id) + 1;
                $cart_data = array(
                    'qty' => $qty,
                    'user_id' => $this->session->userdata('user_id')
                );
                $this->db->where('cart_id', $cart_id);
                $this->db->update('tbl_cart_move', $cart_data);

            } else {
                $qty = 1;
                $cart_data = array(
                    'product_id' => $move['product_id'],
                    'qty' => $qty,
                    'user_id' => $this->session->userdata('user_id')
                );
                $this->db->insert('tbl_cart_move', $cart_data);
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
            echo json_encode(array('success' => false, 'message' => 'Barcode is required!!!'));
            return;
        }

        $move_info = $this->M_move->get_product_by_cart_id($cart_id);
        if (!empty($move_info)) {
            $qty = $qtyNew;
            $move = $move_info[0];
            $cart_data = array(
                'qty' => $qty,
            );
            $this->db->where('cart_id', $cart_id);
            $this->db->update('tbl_cart_move', $cart_data);
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }
    }

    function delete_cart()
    {
        $cart_id = $this->input->post('cart_id');
        $this->db->where("cart_id", $cart_id);
        $this->db->delete("tbl_cart_move");
        return;
    }

    function refreshCart()
    {
        $this->load->view("move/_load_cart");
    }

    function cancel()
    {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->delete('tbl_cart_move');
        echo json_encode(array('success' => true, 'message' => 'Cart cleared successfully!!!'));
    }

    function search_product() {
        $barcode = $this->input->post('barcode');
        $results = $this->M_move->searchProducts($barcode);
        echo json_encode($results);
    }


    function finish_sale()
    {
        $moves = $this->M_move->get_cart();

        $data['user_id'] = $this->session->userdata('user_id');
        $data['sale_date'] = date('Y-m-d');
        $data['vat'] = $this->M_move->get_total_vat_cart();
        $data['total'] = $this->M_move->get_total_sum_cart();
        $data['sub'] = $data['total'] - $data['vat'];
        $data['tendered'] = $this->input->post('tendered');
        $data['change'] = $data['tendered'] - $data['total'];

        // Save sale data to tbl_sales
        $this->db->trans_start(); // Start transaction
        $this->db->insert('tbl_sales', $data);
        $sale_id = $this->db->insert_id();

        foreach ($moves as $row) {
            // Prepare data for tbl_sale_details
            $sale_detail_data['move_id'] = $row['move_id'];
            $sale_detail_data['price'] = $row['price'];
            $sale_detail_data['qty'] = $row['qty'];
            $sale_detail_data['vat'] = $row['vat'];
            $sale_detail_data['total'] = $row['total'];
            $sale_detail_data['sale_id'] = $sale_id;
            $sale_detail_data['sale_date'] = date('Y-m-d H:i:s');

            // Save sale details to tbl_sale_details
            $this->db->insert('tbl_sale_details', $sale_detail_data);

            // Update move quantity
            $new_qty = $this->M_move->get_qty1($row['move_id']) - $row['qty'];
            $this->db->where('move_id', $row['move_id']);
            $this->db->update('tbl_moves', array('qty' => $new_qty));
        }

        $this->db->trans_complete(); // Complete transaction

        if ($this->db->trans_status() === FALSE) {
        } else {
            // If transaction succeeds, delete cart and redirect to receipt
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->delete('tbl_cart');
            redirect("move/receipt/" . $sale_id);
            //echo json_encode(array('success' => true, 'message' => 'Sale Finished successfully!!!'));
        }
    }

}