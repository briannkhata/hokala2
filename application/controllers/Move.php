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
        $move_cart = $this->M_move->get_cart($this->session->userdata('user_id'));
        $move_to = $this->input->post("move_to");
        $from_shop = $this->input->post("from_shop");
        $to_shop = $this->input->post("to_shop");
        $from_wh = $this->input->post("from_wh");
        $to_wh = $this->input->post("to_wh");
        $receiver = $this->input->post("receiver");
        $description = $this->input->post("description");

        if($move_to == 1){// shop to shop
            
        }

        if($move_to == 2){//shop to warehouse
            
        }

        if($move_to == 3){ //warehouse to warehouse
            
        }

        if($move_to == 4){//warehouse to shop
            
        }

       if(count($move_cart) >0){

        foreach ($move_cart as $row) {
            $ata['user_id'] = $row['user_id'];
            $data['product_id'] = $row['product_id'];
            $data['qty'] = $row['qty'];
            $data['from_shop'] = $row['from_shop'];
            $data['to_shop'] = $row['to_shop'];
            $data['receiver'] = $row['receiver'];
            $data['from_wh'] = $row['from_wh'];
            $data['to_wh'] = $row['to_wh'];
            $data['description'] = $row['description'];
            $data['date_moved'] = date('Y-m-d H:i:s');

            $old_from_shop_qty = $this->M_move->get_shop_qty($row['product_id'],$from_shop);
            $old_to_shop_qty = $this->M_move->get_shop_qty($row['product_id'],$to_shop);
            $old_from_wh_qty = $this->M_move->get_warehouse_qty($row['product_id'],$from_wh);
            $old_to_wh_qty = $this->M_move->get_qty1($row['product_id'],$to_wh);

            $new_from_shop_qty = $new_from_shop_qty - $row['qty'] ;
            $new_to_shop_qty = $new_to_shop_qty + $row['qty']; 
            $new_from_wh_qty = $new_from_wh_qty - $row['qty'];
            $new_to_wh_qty = $new_to_wh_qty + $row['qty']; 

            $this->db->insert('tbl_stock_movements', $data);

            // Update move quantity
            $this->db->where('product_id', $row['product_id']);
            $this->db->where('shop_id', $from_shop);
            $this->db->update('tbl_quantities', array('qty' => $new_from_shop_qty));

            $this->db->where('product_id', $row['product_id']);
            $this->db->where('shop_id', $to_shop);
            $this->db->update('tbl_quantities', array('qty' => $new_to_shop_qty));

            $this->db->where('product_id', $row['product_id']);
            $this->db->where('warehouse_id', $from_wh);
            $this->db->update('tbl_quantities', array('wqty'=>$new_from_wh_qty));

            $this->db->where('product_id', $row['product_id']);
            $this->db->where('warehouse_id', $to_wh);
            $this->db->update('tbl_quantities', array('wqty'=>$new_to_wh_qty));
        }
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->delete('tbl_move_cart');
            echo json_encode(array('success' => true, 'message' => 'Products moved successfully!!!'));
    }else{
        echo json_encode(array('success' => true, 'message' => 'No data Found'));

    }
        
    }

}