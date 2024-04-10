<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Move extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata("user_login") != 1) {
        //     redirect(base_url(), "refresh");
        // }
    }

    function api_test()
    {
        // API endpoint URL
        $api_url = 'https://catfact.ninja/fact';
        $this->curl->create($api_url);
        $this->curl->option('buffersize', 10);

        //  To support Different Browsers
        $this->curl->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');
        $this->curl->option('returntransfer', 1);
        $this->curl->option('followlocation', 1);
        $this->curl->option('HEADER', true);
        $this->curl->option(CURLOPT_RETURNTRANSFER, true);
        $this->curl->option(CURLOPT_HTTPGET, true);
        // $this->curl->http_header('Authorization: Bearer YOUR_ACCESS_TOKEN');
        $this->curl->http_header('Content-Type: application/json');

        // Execute the cURL request
        $this->curl->option('connecttimeout', 600);
        $response = $this->curl->execute();

        // Process API response
        if ($this->curl->error) {
            //$error_message = 
            json_decode($this->curl->error_message);
            // Handle error
        } else {
            //$api_data = 
            json_decode($response, true);
            // Process API data
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
            $found = $this->M_move->get_product_in_cart($move['product_id'], $user_id);
            if ($found) {
                $cart_id = $this->M_move->get_cart_id_by_product_id($move['product_id'], $user_id);
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

    function search_product()
    {
        $barcode = $this->input->post('barcode');
        $results = $this->M_move->searchProducts($barcode);
        echo json_encode($results);
    }

    function finish_moving()
    {
        $user_id = $this->session->userdata('user_id');
        $move_cart = $this->M_move->get_cart($user_id);
        $move_to = $this->input->post("move_to");
        $from_shop = $this->input->post("from_shop");
        $to_shop = $this->input->post("to_shop");
        $from_wh = $this->input->post("from_wh");
        $to_wh = $this->input->post("to_wh");

        if (empty($move_to)) {
            $this->session->set_flashdata("error", "Error!,Select the creteria of moving items e.g shop to shop!");
            redirect("Move");
        }

        switch ($move_to) {
            case 1: // Shop to Shop
                if (empty($from_shop)) {
                    $this->session->set_flashdata("error", "Please select the shop to move items from.");
                    redirect("Move");
                }
                if (empty($to_shop)) {
                    $this->session->set_flashdata("error", "Please select the shop to move items to.");
                    redirect("Move");
                }
                break;

            case 2: // Shop to Warehouse
                if (empty($from_shop)) {
                    $this->session->set_flashdata("error", "Please select the shop to move items from.");
                    redirect("Move");
                }
                if (empty($to_wh)) {
                    $this->session->set_flashdata("error", "Please select the warehouse to move items to.");
                    redirect("Move");
                }
                break;

            case 3: // Warehouse to Warehouse
                if (empty($from_wh)) {
                    $this->session->set_flashdata("error", "Please select the warehouse to move items from.");
                    redirect("Move");
                }
                if (empty($to_wh)) {
                    $this->session->set_flashdata("error", "Please select the warehouse to move items to.");
                    redirect("Move");
                }
                break;

            case 4: // Warehouse to Shop
                if (empty($from_wh)) {
                    $this->session->set_flashdata("error", "Please select the warehouse to move items from.");
                    redirect("Move");
                }
                if (empty($to_shop)) {
                    $this->session->set_flashdata("error", "Please select the shop to move items to.");
                    redirect("Move");
                }
                break;
        }


        $data['receiver'] = $this->input->post("receiver");
        $data['description'] = $this->input->post("description");
        $data['date_moved'] = date('Y-m-d H:i:s');
        $data['user_id'] = $user_id;

        if (count($move_cart) > 0) {

            foreach ($move_cart as $row) {
                $product_id = $row['product_id'];
                $qty = $row['qty'];
                $data['product_id'] = $product_id;
                $data['qty'] = $qty;

                $old_from_shop_qty = $this->M_move->get_shop_qty($product_id, $from_shop);
                $old_to_shop_qty = $this->M_move->get_shop_qty($product_id, $to_shop);
                $old_from_wh_qty = $this->M_move->get_warehouse_qty($product_id, $from_wh);
                $old_to_wh_qty = $this->M_move->get_warehouse_qty($product_id, $to_wh);

                $new_from_shop_qty = $old_from_shop_qty - $qty;
                $new_to_shop_qty = $old_to_shop_qty + $qty;
                $new_from_wh_qty = $old_from_wh_qty - $qty;
                $new_to_wh_qty = $old_to_wh_qty + $qty;

                // Update move quantity
                // if ($move_to == 1) {// shop to shop
                //     $data_from_shop = ['qty' => $new_from_shop_qty];
                //     $data_to_shop = ['qty' => $new_to_shop_qty];

                //     $where_from_shop = ['product_id' => $product_id, 'shop_id' => $from_shop];
                //     $where_to_shop = ['product_id' => $product_id, 'shop_id' => $to_shop];

                //     $this->db->update('tbl_quantities', $data_from_shop, $where_from_shop);
                //     $this->db->update('tbl_quantities', $data_to_shop, $where_to_shop);
                //     $data['from_shop'] = $from_shop;
                //     $data['to_shop'] = $to_shop;
                // }

                // if ($move_to == 2) {//shop to warehouse
                //     $this->db->where(['product_id' => $product_id, 'shop_id' => $from_shop])->update('tbl_quantities', ['qty' => $new_from_shop_qty]);
                //     $this->db->where(['product_id' => $product_id, 'warehouse_id' => $to_wh])->update('tbl_wh_quantities', ['qty' => $new_to_wh_qty]);
                //     $data['from_shop'] = $from_shop;
                //     $data['to_wh'] = $to_wh;
                // }

                // if ($move_to == 3) { //warehouse to warehouse
                //     $this->db->where(['product_id' => $product_id, 'warehouse_id' => $from_wh])->update('tbl_wh_quantities', ['qty' => $new_from_wh_qty]);
                //     $this->db->where(['product_id' => $product_id, 'warehouse_id' => $to_wh])->update('tbl_wh_quantities', ['qty' => $new_to_wh_qty]);
                //     $data['from_wh'] = $from_wh;
                //     $data['to_wh'] = $to_wh;
                // }

                // if ($move_to == 4) { //warehouse to shop
                //     $this->db->where(['product_id' => $product_id, 'warehouse_id' => $from_wh])->update('tbl_wh_quantities', ['qty' => $new_from_wh_qty]);
                //     $this->db->where(['product_id' => $product_id, 'shop_id' => $to_shop])->update('tbl_quantities', ['qty' => $new_to_shop_qty]);
                //     $data['from_wh'] = $from_wh;
                //     $data['to_shop'] = $to_shop;
                // }


                switch ($move_to) {
                    case 1: // Shop to Shop
                        $data_from_shop = ['qty' => $new_from_shop_qty];
                        $data_to_shop = ['qty' => $new_to_shop_qty];

                        $where_from_shop = ['product_id' => $product_id, 'shop_id' => $from_shop];
                        $where_to_shop = ['product_id' => $product_id, 'shop_id' => $to_shop];

                        $this->db->update('tbl_quantities', $data_from_shop, $where_from_shop);
                        $this->db->update('tbl_quantities', $data_to_shop, $where_to_shop);
                        $data['from_shop'] = $from_shop;
                        $data['to_shop'] = $to_shop;
                        break;

                    case 2: // Shop to Warehouse
                        $this->db->where(['product_id' => $product_id, 'shop_id' => $from_shop])->update('tbl_quantities', ['qty' => $new_from_shop_qty]);
                        $this->db->where(['product_id' => $product_id, 'warehouse_id' => $to_wh])->update('tbl_wh_quantities', ['qty' => $new_to_wh_qty]);
                        $data['from_shop'] = $from_shop;
                        $data['to_wh'] = $to_wh;
                        break;

                    case 3: // Warehouse to Warehouse
                        $this->db->where(['product_id' => $product_id, 'warehouse_id' => $from_wh])->update('tbl_wh_quantities', ['qty' => $new_from_wh_qty]);
                        $this->db->where(['product_id' => $product_id, 'warehouse_id' => $to_wh])->update('tbl_wh_quantities', ['qty' => $new_to_wh_qty]);
                        $data['from_wh'] = $from_wh;
                        $data['to_wh'] = $to_wh;
                        break;

                    case 4: // Warehouse to Shop
                        $this->db->where(['product_id' => $product_id, 'warehouse_id' => $from_wh])->update('tbl_wh_quantities', ['qty' => $new_from_wh_qty]);
                        $this->db->where(['product_id' => $product_id, 'shop_id' => $to_shop])->update('tbl_quantities', ['qty' => $new_to_shop_qty]);
                        $data['from_wh'] = $from_wh;
                        $data['to_shop'] = $to_shop;
                        break;
                }

                $this->db->insert('tbl_stock_movements', $data);
            }
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->delete('tbl_cart_move');
            $this->session->set_flashdata("message", "Products moved successfully!!!!");
            redirect("Move");
            //echo json_encode(array('success' => true, 'message' => 'Products moved successfully!!!'));
        } else {
            // echo json_encode(array('success' => true, 'message' => 'No data Found'));
            $this->session->set_flashdata("error", "Error moving Items,...No Products Found!!!!");
            redirect("Move");
        }

    }



}