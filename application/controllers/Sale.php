<?php
defined("BASEPATH") or exit("No direct script access allowed");

class product extends CI_Controller
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
        $data["page_title"] = "Product List";
        $this->load->view("product/_product_list", $data);
    }

    function receive_product()
    {
        $data["page_title"] = "Receive Product";
        $this->load->view("product/_receive_product", $data);
    }

    function save_receiving()
    {
        $data["product_id"] = $this->input->post("product_id");
        $data["qty"] = $this->input->post("qty");
        $data["cost_price"] = $this->input->post("cost_price");
        $data["selling_price"] = $this->input->post("selling_price");
        $data["expiry_date"] = $this->input->post("expiry_date");
        $data["receive_date"] = date("Y-m-d h:m:s:i");
        $this->db->insert("tbl_receivings", $data);

        $qty = $this->M_product->get_qty1($data["product_id"]);
        $data0["selling_price"] = $data["selling_price"];
        $data0["expiry_date"] = $data["expiry_date"];
        $data0["qty"] = $qty + $data["qty"];
        $this->db->where("product_id", $data["product_id"]);
        $this->db->update("tbl_products", $data0);
        redirect("Product/receive_product");
        $this->session->set_flashdata("message", "Product Received successfully!");
    }

    function pos()
    {
        $data["page_title"] = "Point of Sale";
        $this->load->view("product/_pos", $data);
    }

    function add_to_cart()
    {
        $barcode = trim($this->input->post('barcode'));

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

                $totalRow = ((($vat / 100) * ($price * $qty))) + ($price * $qty);
                $cart_data = array(
                    'qty' => $qty,
                    'vat' => (($vat / 100) * ($price * $qty)),
                    'total' => $totalRow,
                    'user_id' => $this->session->userdata('user_id')
                );
                $this->db->where('cart_id', $cart_id);
                $this->db->update('tbl_cart', $cart_data);

            } else {
                $qty = 1;
                $totalRow = ((($vat / 100) * ($this->M_product->get_price($product['product_id']) * $qty))) + ($this->M_product->get_price($product['product_id']) * $qty);
                $cart_data = array(
                    'product_id' => $product['product_id'],
                    'price' => $this->M_product->get_price($product['product_id']),
                    'qty' => $qty,
                    'vat' => (($vat / 100) * ($this->M_product->get_price($product['product_id']) * $qty)),
                    'total' => $totalRow,
                    'user_id' => $this->session->userdata('user_id')
                );
                $this->db->insert('tbl_cart', $cart_data);
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

        $product_info = $this->M_product->get_product_by_cart_id($cart_id);
        $vat = $this->db->get('tbl_settings')->row()->vat;
        if (!empty($product_info)) {
            $qty = $qtyNew;
            $product = $product_info[0];
            $totalRow = ((($vat / 100) * ($product['price'] * $qty))) + ($product['price'] * $qty);
            $cart_data = array(
                'qty' => $qty,
                'vat' => (($vat / 100) * ($product['price'] * $qty)),
                'total' => $totalRow,
                'user_id' => $this->session->userdata('user_id')
            );
            $this->db->where('cart_id', $cart_id);
            $this->db->update('tbl_cart', $cart_data);
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Product not found'));
        }
    }
    function get_form_data()
    {
        $data["name"] = $this->input->post("name");
        $data["barcode"] = $this->input->post("barcode");
        $data["category_id"] = $this->input->post("category_id");
        $data["desc"] = $this->input->post("desc");
        $data["cost_price"] = $this->input->post("cost_price");
        $data["selling_price"] = $this->input->post("selling_price");
        $data["supplier_id"] = $this->input->post("supplier_id");
        $data["reorder_level"] = $this->input->post("reorder_level");
        $data["expiry_date"] = $this->input->post("expiry_date");
        $data["qty"] = $this->input->post("qty");
        return $data;
    }

    function get_db_data($update_id)
    {
        $query = $this->M_product->get_product_by_id($update_id);
        foreach ($query as $row) {
            $data["name"] = $row["name"];
            $data["barcode"] = $row["barcode"];
            $data["category_id"] = $row["category_id"];
            $data["selling_price"] = $row["selling_price"];
            $data["cost_price"] = $row["cost_price"];
            $data["supplier_id"] = $row["supplier_id"];
            $data["reorder_level"] = $row["reorder_level"];
            $data["expiry_date"] = $row["expiry_date"];
            $data["qty"] = $row["qty"];
        }
        return $data;
    }

    function read()
    {
        $update_id = $this->uri->segment(3);
        if (!isset($update_id)) {
            $update_id = $this->input->post("update_id", $update_id);
        }
        if (is_numeric($update_id)) {
            $data = $this->get_db_data($update_id);
            $data["update_id"] = $update_id;
        } else {
            $data = $this->get_form_data();
        }
        $data["page_title"] = "Create product";
        $this->load->view("product/_add_product", $data);
    }

    function save()
    {
        $data = $this->get_form_data();
        $update_id = $this->input->post("update_id", true);
        if (isset($update_id)) {
            $data["modified_by"] = $this->session->userdata("user_id");
            $data["modified_date"] = date("Y-m-d");
            $this->db->where("product_id", $update_id);
            $this->db->update("tbl_products", $data);
        } else {
            $this->db->insert("tbl_products", $data);
        }
        if ($update_id != ""):
            redirect("Product");
        else:
            redirect("Product/read");
        endif;
        $this->session->set_flashdata("message", "product saved successfully!");
    }

    function delete($id)
    {
        $data["deleted"] = 1;
        $data["deleted_by"] = $this->session->userdata("user_id");
        $data["date_deleted"] = date("Y-m-d");
        $this->db->where("product_id", $id);
        $this->db->update("tbl_products", $data);
        $this->session->set_flashdata("message", "product Removed!");
        redirect("Product");
    }

    function delete_cart()
    {
        $cart_id = $this->input->post('cart_id');
        $this->db->where("cart_id", $cart_id);
        $this->db->delete("tbl_cart");
        return;
    }

    function refreshCart()
    {
        $this->load->view("product/_load_cart");
    }

    function refresh_total_bill()
    {
        $this->load->view("product/_load_total_bill");
    }

    function refresh_sub_total_bill()
    {
        $this->load->view("product/_load_sub_total");
    }

    function refresh_total_vat()
    {
        $this->load->view("product/_load_total_vat");
    }

    function cancel()
    {
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->delete('tbl_cart');
        echo json_encode(array('success' => true, 'message' => 'Cart cleared successfully!!!'));
    }


    function finish_sale()
    {
        $products = $this->M_product->get_cart();

        $data['user_id'] = $this->session->userdata('user_id');
        $data['sale_date'] = date('Y-m-d');
        $data['vat'] = $this->M_product->get_total_vat_cart();
        $data['total'] = $this->M_product->get_total_sum_cart();
        $data['sub'] = $data['total'] - $data['vat'];
        $data['tendered'] = $this->input->post('tendered');
        $data['change'] = $data['tendered'] - $data['total'];

        // Save sale data to tbl_sales
        $this->db->trans_start(); // Start transaction
        $this->db->insert('tbl_sales', $data);
        $sale_id = $this->db->insert_id();

        foreach ($products as $row) {
            // Prepare data for tbl_sale_details
            $sale_detail_data['product_id'] = $row['product_id'];
            $sale_detail_data['price'] = $row['price'];
            $sale_detail_data['qty'] = $row['qty'];
            $sale_detail_data['vat'] = $row['vat'];
            $sale_detail_data['total'] = $row['total'];
            $sale_detail_data['sale_id'] = $sale_id;
            $sale_detail_data['sale_date'] = date('Y-m-d H:i:s');

            // Save sale details to tbl_sale_details
            $this->db->insert('tbl_sale_details', $sale_detail_data);

            // Update product quantity
            $new_qty = $this->M_product->get_qty1($row['product_id']) - $row['qty'];
            $this->db->where('product_id', $row['product_id']);
            $this->db->update('tbl_products', array('qty' => $new_qty));
        }

        $this->db->trans_complete(); // Complete transaction

        if ($this->db->trans_status() === FALSE) {
        } else {
            // If transaction succeeds, delete cart and redirect to receipt
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->delete('tbl_cart');
            redirect("Product/receipt/" . $sale_id);
            //echo json_encode(array('success' => true, 'message' => 'Sale Finished successfully!!!'));
        }
    }


    function receipt($param = "")
    {
        $data['sale_id'] = $param;
        $data["page_title"] = "Receipt";
        $this->load->view('product/_receipt', $data);
    }





}