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

        if (empty($qty)) {
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
            $this->db->where("id", $update_id);
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
        $this->delete('tbl_audited_products_temp');
        echo json_encode(array('success' => true, 'message' => 'Audit Cancelled successfully!!!'));
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
        $this->db->insert('tbl_sales', $data);
        $sale_id = $this->db->insert_id();
        foreach ($products as $row) {
            $data0['product_id'] = $row['product_id'];
            $data0['price'] = $row['price'];
            $data0['qty'] = $row['qty'];
            $data0['vat'] = $row['vat'];
            $data0['total'] = $row['total'];
            $data0['sale_id'] = $sale_id;
            $data['sale_date'] = date('Y-m-d h:m:ss');
            $this->db->insert('tbl_sale_details', $data0);

            $av['qty'] = $this->M_product->get_qty1($row['product_id']) - $row['qty'];
            $this->db->where('product_id', $row['product_id']);
            $this->db->update('tbl_products', $av);
        }

        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->delete('tbl_cart');
        echo json_encode(array('success' => true, 'message' => 'Sale Finished successfully!!!'));
    }



    function refreshfinished()
    {
        $this->load->view("product/_refreshpaused");
    }

    function refreshDisposal()
    {
        $this->load->view("product/_refresh_disposal");
    }

    function refreshpaused()
    {
        $this->load->view("product/_refreshfinished");
    }
    function start_audit()
    {
        $productIds = $this->input->post('product_id');
        foreach ($productIds as $product_id) {
            $data['user_id'] = $this->session->userdata('user_id');
            $data['product_id'] = $product_id;
            $data['audit_date'] = date('Y-m-d');
            $data['audit_status'] = "paused";
            $this->db->insert('tbl_audit_transactions', $data);
        }
        echo json_encode(array('status' => 'success', 'message' => 'product Pushed to the audit section successfully!!!'));
    }

    function approve_disposal()
    {
        $productIds = $this->input->post('product_id');
        if (empty($productIds)) {
            echo json_encode(array('status' => 'error', 'message' => 'No products selected for disposal.'));
            return;
        }
        foreach ($productIds as $product_id) {
            $data["dispose_state"] = "disposed";
            $data['dispose_approved_by'] = $this->session->userdata('user_id');
            $data['dispose_approved_date'] = date('Y-m-d hm:mm:ss');
            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_products', $data);
        }
        echo json_encode(array('status' => 'success', 'message' => 'products Disposed successfully!!!'));
    }

    function reject_disposal()
    {
        $productIds = $this->input->post('product_id');
        if (empty($productIds)) {
            echo json_encode(array('status' => 'error', 'message' => 'No products selected for disposal.'));
            return;
        }
        foreach ($productIds as $product_id) {
            $data["dispose_state"] = "no";
            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_products', $data);
        }
        echo json_encode(array('status' => 'success', 'message' => 'products Disposal REJECTED successfully!!!'));
    }


    function run_option()
    {
        $quarter_no = ceil(date("n") / 3);
        $data["quarter_number"] = $quarter_no;
        $this->load->view("_dep_run_option", $data);
    }

    function run_quarter_dep()
    {
        $selected_quarter = $this->input->post("quarter");
        $selected_year = $this->input->post("year");
        //$today_date = date('Y-m-d');
        //get all products and put them in array
        //product list of particular category
        //$list =  $this->db->select('id,category_id,net_book_value,cost_price,purchase_date')->from('tbl_products')->where('category_id =',2)->get()->result_array();
        //all regardless category
        //query products bought b4 end of selected quarter
        if ($selected_quarter == 1) {
            #first quater Jan-March
            $kota_start_date = $selected_year . "-01-01";
            $kota_end_date = $selected_year . "-03-31";
        }
        if ($selected_quarter == 2) {
            #second quater April-June
            $kota_start_date = $selected_year . "-04-01";
            $kota_end_date = $selected_year . "-06-30";
        }
        if ($selected_quarter == 3) {
            #third quater July-September
            $kota_start_date = $selected_year . "-07-01";
            $kota_end_date = $selected_year . "-09-30";
        }
        if ($selected_quarter == 4) {
            #fourth quater October-December
            $kota_start_date = $selected_year . "-10-01";
            $kota_end_date = $selected_year . "-12-31";
        }
        $yr_last_month = $selected_year . "-12-31";
        $list = $this->M_product->get_products_bought_within_selected_qota($kota_end_date);
        foreach ($list as $row) {
            $dep_count = count($this->M_product->get_number_of_depreciations_per_product($row["product_id"], $selected_year));
            if ($dep_count > 3) {
                //product has been depreciated 4 times /depreciation has run for 4 quarters
                //reduce uselful life (life span) by 1
                /*$life = $this->M_product->get_remaining_years($row['id']);
                $remainder = $life - 1;
                //update remainig column
                $remData = array(
                'no_years_remaining'=>$remainder
                );
        $this->M_product->update_remaining_years(array('id' => $row['id']), $remData);*/
            } else {
                //product has not depreciated for current quarter so depreciate
                //define quarter dates
                if ($selected_quarter == 1) {
                    #first quater Jan-March
                    $quarter_start_month = $selected_year . "-01-01";
                    $quarter_end_month = $selected_year . "-03-31";
                    $num_days = 90;
                }
                if ($selected_quarter == 2) {
                    #second quater April-June
                    $quarter_start_month = $selected_year . "-04-01";
                    $quarter_end_month = $selected_year . "-06-30";
                    $num_days = 180;
                }
                if ($selected_quarter == 3) {
                    #third quater July-September
                    $quarter_start_month = $selected_year . "-07-01";
                    $quarter_end_month = $selected_year . "-09-30";
                    $num_days = 270;
                }
                if ($selected_quarter == 4) {
                    #fourth quater October-December
                    $quarter_start_month = $selected_year . "-10-01";
                    $quarter_end_month = $selected_year . "-12-31";
                    $num_days = 360;
                }
                $qurater_count = count(
                    $this->M_product->get_number_of_depreciations_per_qota(
                        $row["product_id"],
                        $quarter_start_month,
                        $quarter_end_month
                    )
                );
                if ($qurater_count == 0) {
                    //get dep rate from category using the product category ID
                    $dep_rate = $this->M_product->get_category_depreciate_rate($row["category_id"]);
                    //convert dep rate to decimal
                    //$dep_rate_in_decimal = $row['dep_percentage'] / 100;
                    $dep_rate_in_decimal = $dep_rate / 100;
                    //year dep
                    $year_dep = $row["cost_price"] * $dep_rate_in_decimal;
                    //day dep amount
                    $day_dep = $year_dep / 360;
                    //Monthly dep amount
                    $month_dep = $year_dep / 12;
                    //Quarter dep amount
                    $quarter_dep = $month_dep * 3;
                    //
                    $curr_nbv = $row["cost_price"] - $year_dep;
                    //use selected quarter to check if product has already depreciated for that quarter
                    // 0 = first quarter, 1 = second quarter, 2 = third quarter, 3 = fourth quarter
                    #insert product
                    //insert data into db for each product when its not available for particular quarter
                    //depreciate multiple(Full depreciation) times for same quarter if purdate is within selected quarter
                    if (
                        $row["purchase_date"] >=
                        $selected_year . "-01-01" &&
                        $row["purchase_date"] <= $selected_year . "-03-31"
                    ) {
                        //product purchased in first quarter
                        //Get the month number of the date
                        $month = date(
                            "n",
                            strtotime($row["purchase_date"])
                        );
                        //find quarter in which given date is
                        $yearQuarter = ceil($month / 3);
                        if ($yearQuarter == $selected_quarter) {
                            //purdate is equal to selected quarter
                            for ($x = 1; $x <= 1; $x++) {
                                $data["product_id"] = $row["product_id"];
                                $data["category_id"] = $row["category_id"];
                                $data["cost_price"] = $row["cost_price"];
                                $data["dep_rate"] = $dep_rate;
                                //$data['dep_rate'] = $row['dep_percentage'];
                                $data["day_dep"] = $day_dep;
                                $data["month_dep"] = $month_dep;
                                $data["quarter_dep"] = $quarter_dep;
                                $data["yr_dep"] = $year_dep;
                                $data["yr_nbv"] = $curr_nbv;
                                $data["fy_start_month"] = $quarter_start_month;
                                $data["fy_end_month"] = $quarter_end_month;
                                $data["no_days_elapsed"] = $num_days;
                                $data["financial_year"] = $selected_year;
                                $data["quarter_reval_state"] = 1;
                                $this->db->insert(
                                    "tbl_product_depreciations",
                                    $data
                                );
                            }
                        } else {
                            //purdate is equal to selected quarter
                            $data["id"] = $row["id"];
                            $data["category_id"] = $row["category_id"];
                            $data["cost_price"] = $row["cost_price"];
                            $data["dep_rate"] = $dep_rate;
                            //$data['dep_rate'] = $row['dep_percentage'];
                            $data["day_dep"] = $day_dep;
                            $data["month_dep"] = $month_dep;
                            $data["quarter_dep"] = $quarter_dep;
                            $data["yr_dep"] = $year_dep;
                            $data["yr_nbv"] = $curr_nbv;
                            $data["fy_start_month"] = $quarter_start_month;
                            $data["fy_end_month"] = $quarter_end_month;
                            $data["no_days_elapsed"] = $num_days;
                            $data["financial_year"] = $selected_year;
                            $data["quarter_reval_state"] = 1;
                            $this->db->insert("tbl_product_depreciations", $data);
                        }
                    } elseif (
                        $row["purchase_date"] >=
                        $selected_year . "-04-01" &&
                        $row["purchase_date"] <= $selected_year . "-06-30"
                    ) {
                        //2Q
                        //Get the month number of the date
                        $month = date(
                            "n",
                            strtotime($row["purchase_date"])
                        );
                        //find quarter in which given date is
                        $yearQuarter = ceil($month / 3);
                        if ($yearQuarter == $selected_quarter) {
                            //purdate is equal to selected quarter
                            for ($x = 1; $x <= 2; $x++) {
                                $data["product_id"] = $row["product_id"];
                                $data["category_id"] = $row["category_id"];
                                $data["cost_price"] = $row["cost_price"];
                                $data["dep_rate"] = $dep_rate;
                                //$data['dep_rate'] = $row['dep_percentage'];
                                $data["day_dep"] = $day_dep;
                                $data["month_dep"] = $month_dep;
                                $data["quarter_dep"] = $quarter_dep;
                                $data["yr_dep"] = $year_dep;
                                $data["yr_nbv"] = $curr_nbv;
                                $data["fy_start_month"] = $quarter_start_month;
                                $data["fy_end_month"] = $quarter_end_month;
                                $data["no_days_elapsed"] = $num_days;
                                $data["financial_year"] = $selected_year;
                                $data["quarter_reval_state"] = 1;
                                $this->db->insert(
                                    "tbl_product_depreciations",
                                    $data
                                );
                            }
                        } else {
                            //purdate is equal to selected quarter
                            $data["product_id"] = $row["product_id"];
                            $data["category_id"] = $row["category_id"];
                            $data["cost_price"] = $row["cost_price"];
                            $data["dep_rate"] = $dep_rate;
                            //$data['dep_rate'] = $row['dep_percentage'];
                            $data["day_dep"] = $day_dep;
                            $data["month_dep"] = $month_dep;
                            $data["quarter_dep"] = $quarter_dep;
                            $data["yr_dep"] = $year_dep;
                            $data["yr_nbv"] = $curr_nbv;
                            $data["fy_start_month"] = $quarter_start_month;
                            $data["fy_end_month"] = $quarter_end_month;
                            $data["no_days_elapsed"] = $num_days;
                            $data["financial_year"] = $selected_year;
                            $data["quarter_reval_state"] = 1;
                            $this->db->insert("tbl_product_depreciations", $data);
                        }
                    } elseif (
                        $row["purchase_date"] >=
                        $selected_year . "-07-01" &&
                        $row["purchase_date"] <= $selected_year . "-09-30"
                    ) {
                        //3Q
                        //Get the month number of the date
                        $month = date(
                            "n",
                            strtotime($row["purchase_date"])
                        );
                        //find quarter in which given date is
                        $yearQuarter = ceil($month / 3);
                        if ($yearQuarter == $selected_quarter) {
                            //purdate is equal to selected quarter
                            for ($x = 1; $x <= 3; $x++) {
                                $data["product_id"] = $row["product_id"];
                                $data["category_id"] = $row["category_id"];
                                $data["cost_price"] = $row["cost_price"];
                                $data["dep_rate"] = $dep_rate;
                                //$data['dep_rate'] = $row['dep_percentage'];
                                $data["day_dep"] = $day_dep;
                                $data["month_dep"] = $month_dep;
                                $data["quarter_dep"] = $quarter_dep;
                                $data["yr_dep"] = $year_dep;
                                $data["yr_nbv"] = $curr_nbv;
                                $data["fy_start_month"] = $quarter_start_month;
                                $data["fy_end_month"] = $quarter_end_month;
                                $data["no_days_elapsed"] = $num_days;
                                $data["financial_year"] = $selected_year;
                                $data["quarter_reval_state"] = 1;
                                $this->db->insert(
                                    "tbl_product_depreciations",
                                    $data
                                );
                            }
                        } else {
                            //purdate is equal to selected quarter
                            $data["product_id"] = $row["product_id"];
                            $data["category_id"] = $row["category_id"];
                            $data["cost_price"] = $row["cost_price"];
                            $data["dep_rate"] = $dep_rate;
                            //$data['dep_rate'] = $row['dep_percentage'];
                            $data["day_dep"] = $day_dep;
                            $data["month_dep"] = $month_dep;
                            $data["quarter_dep"] = $quarter_dep;
                            $data["yr_dep"] = $year_dep;
                            $data["yr_nbv"] = $curr_nbv;
                            $data["fy_start_month"] = $quarter_start_month;
                            $data["fy_end_month"] = $quarter_end_month;
                            $data["no_days_elapsed"] = $num_days;
                            $data["financial_year"] = $selected_year;
                            $data["quarter_reval_state"] = 1;
                            $this->db->insert("tbl_product_depreciations", $data);
                        }
                    } elseif (
                        $row["purchase_date"] >=
                        $selected_year . "-10-01" &&
                        $row["purchase_date"] <= $selected_year . "-12-31"
                    ) {
                        //4Q
                        //Get the month number of the date
                        $month = date(
                            "n",
                            strtotime($row["purchase_date"])
                        );
                        //find quarter in which given date is
                        $yearQuarter = ceil($month / 3);
                        if ($yearQuarter == $selected_quarter) {
                            //purdate is equal to selected quarter
                            for ($x = 1; $x <= 4; $x++) {
                                $data["product_id"] = $row["product_id"];
                                $data["category_id"] = $row["category_id"];
                                $data["cost_price"] = $row["cost_price"];
                                $data["dep_rate"] = $dep_rate;
                                //$data['dep_rate'] = $row['dep_percentage'];
                                $data["day_dep"] = $day_dep;
                                $data["month_dep"] = $month_dep;
                                $data["quarter_dep"] = $quarter_dep;
                                $data["yr_dep"] = $year_dep;
                                $data["yr_nbv"] = $curr_nbv;
                                $data["fy_start_month"] = $quarter_start_month;
                                $data["fy_end_month"] = $quarter_end_month;
                                $data["no_days_elapsed"] = $num_days;
                                $data["financial_year"] = $selected_year;
                                $data["quarter_reval_state"] = 1;
                                $this->db->insert("tbl_product_depreciations", $data);
                            }
                        } else {
                            //purdate is equal to selected quarter
                            $data["product_id"] = $row["product_id"];
                            $data["category_id"] = $row["category_id"];
                            $data["cost_price"] = $row["cost_price"];
                            $data["dep_rate"] = $dep_rate;
                            //$data['dep_rate'] = $row['dep_percentage'];
                            $data["day_dep"] = $day_dep;
                            $data["month_dep"] = $month_dep;
                            $data["quarter_dep"] = $quarter_dep;
                            $data["yr_dep"] = $year_dep;
                            $data["yr_nbv"] = $curr_nbv;
                            $data["fy_start_month"] = $quarter_start_month;
                            $data["fy_end_month"] = $quarter_end_month;
                            $data["no_days_elapsed"] = $num_days;
                            $data["financial_year"] = $selected_year;
                            $data["quarter_reval_state"] = 1;
                            $this->db->insert("tbl_product_depreciations", $data);
                        }
                    } else {
                        //Not within selected quarter and below
                        $data["product_id"] = $row["product_id"];
                        $data["category_id"] = $row["category_id"];
                        $data["cost_price"] = $row["cost_price"];
                        $data["dep_rate"] = $dep_rate;
                        //$data['dep_rate'] = $row['dep_percentage'];
                        $data["day_dep"] = $day_dep;
                        $data["month_dep"] = $month_dep;
                        $data["quarter_dep"] = $quarter_dep;
                        $data["yr_dep"] = $year_dep;
                        $data["yr_nbv"] = $curr_nbv;
                        $data["fy_start_month"] = $quarter_start_month;
                        $data["fy_end_month"] = $quarter_end_month;
                        $data["no_days_elapsed"] = $num_days;
                        $data["financial_year"] = $selected_year;
                        $data["quarter_reval_state"] = 1;
                        $this->db->insert("tbl_product_depreciations", $data);
                    }
                    //batch insert
                    /*$data[] = array(
                        'id'=> $row['id'],
                        'category_id'=> $row['category_id'],
                        'cost_price'=> $row['cost_price'],
                        //'dep_rate'=> $dep_rate,
                        'dep_rate'=> $row['dep_percentage'],
                        'day_dep'=> $day_dep,
                        'month_dep'=> $month_dep,
                        'quarter_dep'=> $quarter_dep,
                        'yr_dep'=> $year_dep,
                        'yr_nbv'=> $curr_nbv,
                        'fy_start_month'=> $quarter_start_month,
                        'fy_end_month'=> $quarter_end_month,
                        'no_days_elapsed'=> $num_days,
                        'financial_year'=> $selected_year,
                        'quarter_reval_state' => 1
                    );*/
                } else {
                    //do not insert bcoz product is already depreciated for that quarter
                } //product quarter count
            } //end check if products is already in depreciation table
            //get accum dep amount
            $acum_dep = $this->M_product->get_product_accumulated_depreciation($row["product_id"]);
            //calc NBV
            $nbv = $row["cost_price"] - $acum_dep; // net book value
            //update accumulated dep and NBV for an product
            $productData = [
                "accum_dep" => $acum_dep,
                "net_book_value" => $nbv,
            ];
            $this->db->where('product_id', $row["product_id"]);
            $this->db->update('tbl_products', $productData);
        } //end $list
        echo json_encode(array('status' => 'success', 'message' => 'Depreciation done successfully!!!'));
    }

    function missing()
    {
        $data["page_title"] = "Missing products";
        $data['menu_id'] = $this->M_role->get_menu_id_by_name('missing');
        $this->load->view("product/_missing", $data);
    }

    function refreshMissing()
    {
        $this->load->view("product/_refresh_missing");
    }

    function recall()
    {
        $productIds = $this->input->post('product_id');
        if (empty($productIds)) {
            echo json_encode(array('status' => 'error', 'message' => 'No products selected for recall.'));
            return;
        }
        foreach ($productIds as $product_id) {
            $data["audit_state"] = "av";
            $data["deleted"] = "0";
            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_products', $data);
        }
        echo json_encode(array('status' => 'success', 'message' => 'products recalled successfully!!!'));
    }

    function revalued()
    {
        $data["page_title"] = "Revalued products";
        $data["fetch_data"] = $this->M_product->get_revaluated_products();
        $data['menu_id'] = $this->M_role->get_menu_id_by_name('revalued');
        $this->load->view("product/_revalued", $data);
    }


    function view_audit_products($audit_id)
    {
        $this->load->view("_register_by_audit");
    }

}