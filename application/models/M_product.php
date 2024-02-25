<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_product extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all_products()
    {
        $this->db->where('deleted', 0);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_qty($product_id)
    {
        $this->db->select('qty');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_quantities');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return 0;
        }
    }

    function get_prouct_in_cart($product_id)
    {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_cart')->result_array();
        return $query;
    }

    function get_cart_id_by_product_id($product_id)
    {
        $this->db->select('cart_id');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_cart');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->cart_id;
        } else {
            return '';
        }
    }

    function get_cart_qty($cart_id)
    {
        $this->db->select('qty');
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('tbl_cart');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->qty;
        } else {
            return '';
        }
    }

    function get_cart_price($cart_id)
    {
        $this->db->select('price');
        $this->db->where('cart_id', $cart_id);
        $query = $this->db->get('tbl_cart');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->price;
        } else {
            return '';
        }
    }

    function get_total_sum_cart()
    {
        $this->db->select_sum('total');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $result = $this->db->get('tbl_cart')->row();
        return $result->total ?? 0;
    }

    function get_total_vat_cart()
    {
        $this->db->select_sum('vat');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $result = $this->db->get('tbl_cart')->row();
        return $result->vat ?? 0;
    }


    function get_products_by_centre_id($centre_id)
    {
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'no');
        $this->db->where('audit_state', 'av');
        $this->db->where('centre_id', $centre_id);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_product_by_barcode_centre($barcode, $centre_id)
    {
        $this->db->where('deleted', 0);
        $this->db->where('barcode', $barcode);
        //$this->db->where('centre_id', $centre_id);
        $this->db->where('dispose_state', 'no');
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_product_by_cart_id($cart_id)
    {
        $this->db->where('cart_id', $cart_id);
        $this->db->from('tbl_cart');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_products_from_audited_transactions1()
    {
        $this->db->where('tbl_audit_transactions.status', '');
        $this->db->where('tbl_audit_transactions.user_id', '');
        $this->db->select('tbl_audited_products.*, tbl_audit_transactions.transaction_id')
            ->from('tbl_audited_products')
            ->join('tbl_audit_transactions', 'tbl_audit_transactions.transaction_id = tbl_audited_products.transaction_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cart()
    {
        return $this->db->select('*')->from('tbl_cart')->where('user_id', $this->session->userdata('user_id'))->order_by('cart_id', 'desc')->get()->result_array();
    }



    function get_products_bought_within_selected_qota($end_date)
    {
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'no');
        $this->db->where('purchase_date <', $end_date);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_number_of_depreciations_per_product($product_id, $selected_year)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('financial_year', $selected_year);
        $this->db->from('tbl_product_depreciations');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_number_of_depreciations_per_qota($product_id, $quarter_start_month, $quarter_end_month)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('fy_start_month >=', $quarter_start_month);
        $this->db->where('fy_start_month <=', $quarter_end_month);
        $query = $this->db->get('tbl_product_depreciations');
        return $query->result_array();
    }

    function get_product_accumulated_depreciation($product_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_product_depreciations')->row();
        return $result->quarter_dep;
    }


    function get_category_depreciate_rate($category_id)
    {
        $this->db->select('dep_percentage');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get('tbl_category');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->dep_percentage;
        } else {
            return 0;
        }
    }

    function get_product_by_barcode($barcode)
    {
        $this->db->where('deleted', 0);
        $this->db->where('barcode', $barcode);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_price($product_id)
    {
        $this->db->select('selling_price');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_products');
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->selling_price;
        } else {
            return 0;
        }
    }

    function get_products_by_category($category_id)
    {
        $this->db->where('deleted', 0);
        $this->db->where('category_id', $category_id);
        $this->db->from('tbl_products');
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_products()
    {
        $this->db->where('deleted', 0);
        $this->db->from('tbl_products');
        $this->db->order_by('product_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_to_be_audited_products($limit = null, $offset = null)
    {
        $this->db->select('tbl_products.*');
        $this->db->from('tbl_products');
        $this->db->where('tbl_products.deleted', 0);
        $this->db->join('tbl_audited_products', 'tbl_products.product_id = tbl_audited_products.product_id', 'left');
        $currentYear = date('Y');
        //$this->db->where("YEAR(tbl_audited_products.date_posted) != $currentYear");   
        $this->db->order_by('tbl_products.product_id', 'DESC');
        $this->db->group_by('tbl_products.barcode');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_paused_audited_products()
    {
        $this->db->select('*');
        $this->db->from('tbl_audit_transactions');
        $this->db->where('status', "paused");
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_paused_to_continue($transaction_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_audited_products');
        $this->db->where('transaction_id', $transaction_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    //function get_paused_audited_products($limit = null, $offset = null) {
    function get_paused_audited_products1($limit = null, $offset = null)
    {
        $this->db->select('tbl_products.*');
        $this->db->from('tbl_products');
        $this->db->where('tbl_products.deleted', 0);
        $this->db->where('tbl_audit_transactions.audit_status', "paused");
        $this->db->join('tbl_audit_transactions', 'tbl_products.product_id = tbl_audit_transactions.product_id', 'left');
        $currentYear = date('Y');
        //$this->db->where("YEAR(tbl_audited_products.date_posted) != $currentYear");   
        $this->db->order_by('tbl_products.product_id', 'DESC');
        $this->db->group_by('tbl_products.barcode');
        //if ($limit) {
        //$this->db->limit($limit, $offset);
        // }
        $query = $this->db->get();
        return $query->result_array();
    }

    //function get_finished_audited_products($limit = null, $offset = null) {
    function get_finished_audited_products()
    {
        $this->db->select('tbl_products.*');
        $this->db->from('tbl_products');
        $this->db->where('tbl_products.deleted', 0);
        $this->db->where('tbl_audit_transactions.audit_status', "Finished");
        $this->db->join('tbl_audit_transactions', 'tbl_products.product_id = tbl_audit_transactions.product_id', 'left');
        $currentYear = date('Y');
        //$this->db->where("YEAR(tbl_audited_products.date_posted) != $currentYear");   
        $this->db->order_by('tbl_products.product_id', 'DESC');
        $this->db->group_by('tbl_products.barcode');
        // if ($limit) {
        //$this->db->limit($limit, $offset);
        //}
        $query = $this->db->get();
        return $query->result_array();
    }



    function get_new_products()
    {
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $this->db->where('YEAR(purchase_date)', date('Y'));
        $this->db->from('tbl_products');
        $this->db->order_by('product_id', 'DESC');
        $this->db->group_by('barcode');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_missing_products()
    {
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'ms');
        $this->db->where('dispose_state', 'no');
        $this->db->from('tbl_products');
        $this->db->order_by('product_id', 'DESC');
        $this->db->group_by('barcode');
        $query = $this->db->get();
        return $query->result_array();
    }


    function check_category_existance($cat_name)
    {
        $this->db->where('category_name', $cat_name);
        $query = $this->db->get('tbl_categories');
        return $query->num_rows();
    }
    function get_product_accum_dep($id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('product_id', $id);
        $result = $this->db->get('tbl_product_depreciations')->row();
        return $result->quarter_dep;
    }

    function get_products_disposed($limit = null, $offset = null)
    {
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'disposed');
        $this->db->where('audit_state', 'av');
        $this->db->from('tbl_products');
        $this->db->order_by('product_id', 'DESC');
        $this->db->group_by('barcode');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_pending_disposal()
    {
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'pending');
        $this->db->order_by('product_id', 'DESC');
        $query = $this->db->get('tbl_products');
        return $query->result_array();
    }

    function get_donor_id($product_id)
    {
        $this->db->select('donor_id');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        return $result->donor_id;
    }

    function get_category_id($product_id)
    {
        $this->db->select('category_id');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->result_array();
        if (!empty($result)) {
            return $result[0]['category_id'];
        }
        return null;
    }

    function get_centre_id($product_id)
    {
        $this->db->select('centre_id');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        return $result->centre_id;
    }

    function get_last_inserted_centres_id()
    {
        $this->db->select_max('centre_id');
        $result = $this->db->get('tbl_centres')->row();
        return $result->centre_id;
    }

    /** department/product user */
    public function check_department_existance($dep_name)
    {
        $this->db->where('department_name', $dep_name);
        $query = $this->db->get('tbl_department');
        return $query->num_rows();
    }

    function get_department_id($product_id)
    {
        $this->db->select('department_id');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        return $result->department_id;
    }

    function get_last_inserted_department_id()
    {
        $this->db->select_max('departmentID');
        $result = $this->db->get('tbl_department')->row();
        return $result->departmentID;
    }

    /** donor */
    public function check_donor_existance($donor_name)
    {
        $this->db->where('donor_name', $donor_name);
        $query = $this->db->get('tbl_donors');
        return $query->num_rows();
    }



    function get_last_inserted_donor_id()
    {
        $this->db->select_max('donorID');
        $result = $this->db->get('tbl_donors')->row();
        return $result->donorID;
    }


    /** product */
    public function check_product_existance($barcode, $product_name, $centre_id)
    {
        $this->db->where('barcode', $barcode);
        $this->db->where('product_name', $product_name);
        $this->db->where('centre_id', $centre_id);
        $this->db->where('deleted', 0);
        $this->db->where('tag_state', 'Yes');
        $query = $this->db->get('tbl_products');
        return $query->num_rows();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('tbl_product_depreciations', $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {

            return 0;
        }
    }

    function insert_batch_products($data)
    {
        $this->db->insert_batch('tbl_products', $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {

            return 0;
        }
    }

    /** product list/register functions refer to MY_Controller */

    public function save($data)
    {
        $this->db->insert('client_info', $data);
        return $this->db->insert_id();
    }

    /** run depreciation functions */
    public function count_number_of_product_dep($product_id, $year)
    {
        $this->db->where('product_id', $product_id);
        $this->db->where('financial_year', $year);
        $query = $this->db->get('tbl_product_depreciations');
        return $query->num_rows();
    }

    function count_number_of_product_dep_quarter($id, $sdate, $edate)
    {
        $query = $this->db->query("SELECT product_id FROM tbl_product_depreciations WHERE product_id = $id AND fy_start_month BETWEEN '$sdate' AND '$edate'");
        return $query->num_rows();
    }

    function get_product_remaining_years($id)
    {
        $this->db->select('no_years_remaining');
        $this->db->where('product_id', $id);
        $result = $this->db->get('tbl_products')->row();
        return $result->no_years_remaining;
    }

    public function update_product_remaining_years($where, $data)
    {
        $this->db->update('tbl_products', $data, $where);
        return $this->db->affected_rows();
    }

    function get_product_cat_dep_rate($cat_id)
    {
        $this->db->select('dep_percentage');
        $this->db->where('category_id', $cat_id);
        $result = $this->db->get('tbl_category')->row();
        return $result->dep_percentage;
    }

    public function update_product_accum_dep_and_nbv($where, $data)
    {
        $this->db->update('tbl_products', $data, $where);
        return $this->db->affected_rows();
    }

    /** register ajax */

    function pending_query()
    {
        $this->db->where(array('deleted' => 0, 'dispose_state' => 'pending'));
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("product_name", $_POST["search"]["value"]);
            $this->db->or_like("barcode", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('product_id', 'DESC');
        }
    }

    function pending_datatables()
    {
        $this->pending_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('deleted', 0);
        //$this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'pending');
        $query = $this->db->get();
        return $query->result();
    }

    function get_pending_filtered_data()
    {
        $this->pending_query();
        $this->db->where('deleted', 0);
        //$this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'pending');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_pending_data()
    {
        $this->db->select("*");
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'pending');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function disposed_query()
    {
        $this->db->where(array('deleted' => 0, 'dispose_state' => 'disposed'));
        $this->db->from($this->table);
        if (isset($_POST["search"]["value"])) {
            $this->db->like("product_name", $_POST["search"]["value"]);
            $this->db->or_like("barcode", $_POST["search"]["value"]);
        }
        if (isset($_POST["order"])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('dispose_req_date', 'DESC');
        }
    }

    function disposed_datatables()
    {
        $this->disposed_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'disposed');
        //$this->db->order_by('product_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    function get_disposed_filtered_data()
    {
        $this->disposed_query();
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'disposed');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_disposed_data()
    {
        $this->db->select("*");
        $this->db->where('deleted', 0);
        $this->db->where('dispose_state', 'disposed');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    function get_reval_filtered_data()
    {
        $this->reval_query();
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_reval_data()
    {
        $this->db->select("*");
        $this->db->where('deleted', 0);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /** get donor products */
    function make_donor_products_query($donor_id)
    {
        $this->db->where('tbl_products.deleted', 0);
        $this->db->where('tbl_products.audit_state', 'av');
        $this->db->where('tbl_products.dispose_state', 'no');
        $this->db->where('tbl_products.donor_id', $donor_id);
        $this->db->from('tbl_products');
        $this->db->join('tbl_centres', 'tbl_centres.centre_id = tbl_products.centre_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_products.category_id', 'LEFT');
        $this->db->join('tbl_department', 'tbl_department.departmentID = tbl_products.product_user', 'LEFT');
        if (isset($_POST["order"])) {
            //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        } else {
            $this->db->order_by('product_id', 'DESC');
        }
    }

    function make_donor_products_datatables($donor_id)
    {
        $this->make_donor_products_query($donor_id);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->result();
    }

    function get_donor_products_filtered_data($donor_id)
    {

        $this->make_donor_products_query($donor_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_donor_products_all_data($donor_id)
    {
        $this->make_donor_products_query($donor_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        return $this->db->count_all_results();
    }

    /** get products by category */
    function make_category_products_query($cat_id)
    {
        $this->db->where('tbl_products.deleted', 0);
        $this->db->where('tbl_products.audit_state', 'av');
        $this->db->where('tbl_products.dispose_state', 'no');
        $this->db->where('tbl_products.category_id', $cat_id);
        $this->db->from('tbl_products');
        $this->db->join('tbl_centres', 'tbl_centres.centre_id = tbl_products.centre_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_products.category_id', 'LEFT');
        $this->db->join('tbl_department', 'tbl_department.departmentID = tbl_products.product_user', 'LEFT');
        if (isset($_POST["order"])) {
            //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        } else {
            $this->db->order_by('product_id', 'DESC');
        }
    }

    function make_category_products_datatables($cat_id)
    {
        $this->make_category_products_query($cat_id);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->result();
    }

    function get_category_products_filtered_data($cat_id)
    {

        $this->make_category_products_query($cat_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_category_products_all_data($cat_id)
    {
        $this->make_category_products_query($cat_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        return $this->db->count_all_results();
    }

    function get_cost_price($product_id)
    {
        $this->db->select('cost_price');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->cost_price;
        }
    }

    function get_deleted_or_not($product_id)
    {
        $this->db->select('deleted');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->deleted;
        }
    }

    function get_barcode($product_id)
    {
        $this->db->select('barcode');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->barcode;
        }
    }

    function get_name($product_id)
    {
        $this->db->select('name');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->name;
        }
    }

    function get_net_book_value($product_id)
    {
        $this->db->select('net_book_value');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->net_book_value;
        }
    }


    function get_product_centre_name($id)
    {
        $this->db->select('centre_name');
        $this->db->where('centre_id', $id);
        $result = $this->db->get('tbl_centres')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->centre_name;
        }
    }

    function get_life_span($product_id)
    {
        $this->db->select('life_span');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('tbl_products')->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->life_span;
        }
    }

    function get_product_user_name($id)
    {
        $this->db->select('department_name');
        $this->db->where('departmentID', $id);
        $result = $this->db->get('tbl_department')->row();
        return $result->department_name;
    }

    /** get products by user */
    function make_department_products_query($dep_id)
    {
        $this->db->where('tbl_products.deleted', 0);
        $this->db->where('tbl_products.audit_state', 'av');
        $this->db->where('tbl_products.dispose_state', 'no');
        $this->db->where('tbl_products.product_user', $dep_id);
        $this->db->from('tbl_products');
        $this->db->join('tbl_centres', 'tbl_centres.centre_id = tbl_products.centre_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_products.category_id', 'LEFT');
        $this->db->join('tbl_department', 'tbl_department.departmentID = tbl_products.product_user', 'LEFT');
        if (isset($_POST["order"])) {
            //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        } else {
            $this->db->order_by('product_id', 'DESC');
        }
    }

    function get_product_by_id($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_products');
        return $query->result_array();
    }

    function make_department_products_datatables($dep_id)
    {
        $this->make_department_products_query($dep_id);
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->result();
    }

    function get_department_products_filtered_data($dep_id)
    {

        $this->make_department_products_query($dep_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_department_products_all_data($dep_id)
    {
        $this->make_department_products_query($dep_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        $this->db->where('dispose_state', 'no');
        return $this->db->count_all_results();
    }

    /** get audited/verified products by audit id */
    function make_audited_products_query($audit_id)
    {
        $this->db->where('tbl_products.deleted', 0);
        $this->db->where('tbl_products.audit_state', 'av');
        $this->db->where('tbl_products.dispose_state', 'no');
        $this->db->where('tbl_audited_products.auditNo', $audit_id);
        $this->db->from('tbl_products');
        $this->db->join('tbl_audited_products', 'tbl_audited_products.product_id = tbl_products.product_id', 'LEFT');
        $this->db->join('tbl_centres', 'tbl_centres.centre_id = tbl_products.centre_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_products.category_id', 'LEFT');
        $this->db->join('tbl_department', 'tbl_department.departmentID = tbl_products.product_user', 'LEFT');
        if (isset($_POST["order"])) {
            //$this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
        } else {
            $this->db->order_by('product_id', 'DESC');
        }
    }

    function get_revaluations_by_product_id($product_id)
    {
        $this->db->where('product_id', $product_id);
        $this->db->from('tbl_revaluations');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_product_users($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_product_users');
        return $query->result_array();
    }

    function get_product_photos($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('tbl_product_photos');
        return $query->result_array();
    }

    function get_product_cost_centres()
    {
        $this->db->where('centre_deleted', 0);
        //$this->db->order_by('centre_id', 'DESC');
        $this->db->order_by('centre_name', 'ASC');
        $query = $this->db->get('tbl_centres');
        return $query->result_array();
    }

    function get_product_categories()
    {
        $this->db->where('category_deleted', 0);
        $this->db->order_by('category_id', 'DESC');
        $query = $this->db->get('tbl_category');
        return $query->result_array();

    }

    function get_revaluated_products()
    {
        $this->db->where(array('deleted' => 0, 'audit_state' => 'av'));
        $this->db->from('tbl_products');
        $this->db->join('tbl_revaluations', 'tbl_products.product_id = tbl_revaluations.product_id');
        $this->db->order_by('tbl_products.product_id', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_audited_products_filtered_data($audit_id)
    {
        $this->make_audited_products_query($audit_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        //$this->db->where('dispose_state', 'no');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_audited_products_all_data($audit_id)
    {
        $this->make_audited_products_query($audit_id);
        $this->db->where('deleted', 0);
        $this->db->where('audit_state', 'av');
        //$this->db->where('dispose_state', 'no');
        return $this->db->count_all_results();
    }




}
