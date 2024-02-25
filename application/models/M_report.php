<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_assets($centre_id, $category_id = null, $department_id = null, $donor_id = null, $deleted = null, $missing = null, $new = null)
    {

        $this->db->where('audit_state', 'av');

        if ($category_id !== null) {
            $this->db->where('category_id', $category_id);
        }

        if ($category_id !== null) {
            $this->db->where('category_id', $category_id);
        }
        if ($department_id !== null) {
            $this->db->where('department_id', $department_id);
        }
        if ($donor_id !== null) {
            $this->db->where('donor_id', $donor_id);
        }

        if ($deleted !== null) {
            $this->db->where('deleted', 1);
        }

        if ($missing !== null) {
            $this->db->where('audit_status', "ms");
        }

        if ($new !== null) {
            $currentYear = date('Y');
            $startDate = date('Y-m-d', strtotime("$currentYear-01-01"));
            $endDate = date('Y-m-d', strtotime("$currentYear-03-31"));
            $this->db->where('purchase_date >=', $startDate);
            $this->db->where('purchase_date <=', $endDate);
        }

        $query = $this->db->get('tbl_assets');
        return $query->result_array();
    }

    function get_disposed_assets($centre_id, $category_id = null, $department_id = null, $donor_id = null)
    {
        $this->db->where('dispose_state', 'yes');
        $this->db->where('deleted', 0);

        if ($category_id !== null) {
            $this->db->where('category_id', $category_id);
        }

        if ($category_id !== null) {
            $this->db->where('category_id', $category_id);
        }
        if ($department_id !== null) {
            $this->db->where('department_id', $department_id);
        }
        if ($donor_id !== null) {
            $this->db->where('donor_id', $donor_id);
        }

        $query = $this->db->get('tbl_assets');
        return $query->result_array();
    }

    function get_missing_assets($centre_id, $category_id = null, $department_id = null, $donor_id = null)
    {
        $this->db->where('audit_status', "ms");
        $this->db->where('deleted', 0);

        if ($category_id !== null) {
            $this->db->where('category_id', $category_id);
        }

        if ($category_id !== null) {
            $this->db->where('category_id', $category_id);
        }
        if ($department_id !== null) {
            $this->db->where('department_id', $department_id);
        }
        if ($donor_id !== null) {
            $this->db->where('donor_id', $donor_id);
        }

        $query = $this->db->get('tbl_assets');
        return $query->result_array();
    }

    /** recorded cost of asset during asset depreciation (Run dep) */
    function get_quarter_depreciated_asset_cost($start_date, $end_date)
    {
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->from('tbl_asset_depreciations');
        $query = $this->db->get();
        return $query->result_array();
    }
    /** addition cost */
    function get_quarter_depreciated_asset_addition($start_date, $end_date)
    {
        $this->db->where('tbl_asset_register.asset_status', 'active');
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_register.asset_purchasedDate >=', $start_date);
        $this->db->where('tbl_asset_register.asset_purchasedDate <=', $end_date);
        $this->db->from('tbl_asset_depreciations');
        $this->db->join('tbl_asset_register', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }
    //difference/reminder of revaluated asset
    function get_reval_assets($start_date, $end_date)
    {
        $this->db->where('tbl_asset_register.asset_status', 'active');
        $this->db->where('tbl_revaluation.reval_date >=', $start_date);
        $this->db->where('tbl_revaluation.reval_date <=', $end_date);
        $this->db->from('tbl_revaluation');
        $this->db->join('tbl_asset_register', 'tbl_asset_register.asset_id = tbl_revaluation.asset_id');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_asset_register.category_id');
        $query = $this->db->get();
        return $query->result_array();
    }
    //cost of disposed asset
    function get_cost_of_disposed_asset($start_date, $end_date)
    {
        $this->db->where('tbl_asset_register.dispose_state', 'disposed');
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_register.dispose_approved_date >=', $start_date);
        $this->db->where('tbl_asset_register.dispose_approved_date <=', $end_date);
        $this->db->from('tbl_asset_depreciations');
        $this->db->join('tbl_asset_register', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_asset_depreciations.category_id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }

    //accumulated depreciation of disposed asset
    function get_accum_dep_of_disposed_asset($start_date)
    {
        $this->db->where('tbl_asset_register.dispose_state', 'disposed');
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $start_date);
        //$this->db->select_sum('cost_price');
        $this->db->from('tbl_asset_depreciations');
        $this->db->join('tbl_asset_register', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_asset_depreciations.category_id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }

    function fetch_accum_dep_of_disposed_asset($end_date)
    {
        //$this->db->select_sum('quarter_dep');
        $this->db->where('dispose_state', 'disposed');
        $this->db->where('fy_start_month <', $end_date);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        //$this->db->join('tbl_category', 'tbl_category.category_id = tbl_asset_depreciations.category_id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
        //$query = $this->db->query("SELECT SUM(d.quarter_dep) AS total FROM tbl_asset_register a INNER JOIN tbl_asset_depreciations d ON a.asset_id = d.asset_id WHERE a.dispose_state ='disposed' AND d.fy_start_month < '" . $end_date . "'");
        //return $query->result_array();
    }


    function sum_quarter_depreciated_asset_cost($start_date, $end_date)
    {
        //$this->db->where('tbl_asset_register.asset_status', 'active');
        //$this->db->select_sum('cost_price');
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->from('tbl_asset_depreciations');
        $this->db->join('tbl_asset_register', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id', 'LEFT');
        $this->db->join('tbl_category', 'tbl_category.category_id = tbl_asset_depreciations.category_id', 'LEFT');
        $query = $this->db->get();
        return $query->result_array();
    }

    /** expense report */
    function get_asset_quarter_accum_dep($asset_id, $date)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('asset_id', $asset_id);
        $this->db->where('fy_start_month <', $date);
        $result = $this->db->get('tbl_asset_depreciations')->row();
        return $result->quarter_dep;
    }

    function get_asset_disposed_date($asset_id, $date)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('asset_id', $asset_id);
        $this->db->where('fy_start_month <', $date);
        $result = $this->db->get('tbl_asset_depreciations')->row();
        return $result->quarter_dep;
    }
    /**Audit report */
    function get_audit_list($start_date, $end_date)
    {
        $this->db->select('*');
        $this->db->where('audit_status', 'Finished');
        $this->db->where('audit_finish_date >=', $start_date);
        $this->db->where('audit_finish_date <=', $end_date);
        $query = $this->db->get('tbl_audit_transactions');
        return $query->result_array();
    }

    public function count_audit_total_assets()
    {
        $this->db->where('asset_status', 'active');
        $this->db->where('dispose_state', 'no');
        $this->db->from('tbl_asset_register');
        return $this->db->count_all_results();
    }

    public function count_audit_disposed_assets_afta_audit_start_date($start_date)
    {
        $this->db->where('asset_status', 'active');
        $this->db->where('dispose_state', 'disposed');
        $this->db->where('dispose_approved_date >', $start_date);
        $this->db->from('tbl_asset_register');
        return $this->db->count_all_results();
    }

    function get_audit_cost_centre($id)
    {
        $this->db->select('centreID,centre_name');
        $this->db->where('centreID', $id);
        $result = $this->db->get('tbl_costcentre')->row();
        return $result->centre_name;
    }

    public function count_audit_centre_total_assets($centre_id)
    {
        $this->db->where('asset_status', 'active');
        $this->db->where('dispose_state', 'no');
        $this->db->where('centre_id', $centre_id);
        $this->db->from('tbl_asset_register');
        return $this->db->count_all_results();
    }

    public function count_audit_centre_disposed_assets_afta_audit_start_date($centre_id, $start_date)
    {
        $this->db->where('asset_status', 'active');
        $this->db->where('dispose_state', 'disposed');
        $this->db->where('centre_id', $centre_id);
        $this->db->where('dispose_approved_date >', $start_date);
        $this->db->from('tbl_asset_register');
        return $this->db->count_all_results();
    }

    public function count_centre_total_audited_assets($start_date, $end_date, $centre_id, $no)
    {
        $this->db->where('date_posted >=', $start_date);
        $this->db->where('date_posted <=', $end_date);
        $this->db->where('centre_ID', $centre_id);
        $this->db->where('auditNo', $no);
        $this->db->from('tbl_audited_assets');
        //$this->db->join('tbl_asset_register', 'tbl_asset_register.asset_id = tbl_audited_assets.asset_id');
        $this->db->join('tbl_audit_transactions', 'tbl_audited_assets.auditNo = tbl_audit_transactions.auditID');
        return $this->db->count_all_results();
    }

    public function count_audit_centre_missing_assets($centre_id)
    {
        $this->db->where('asset_status', 'missing');
        //$this->db->where('date_posted >=', $start_date);
        //$this->db->where('date_posted <=', $end_date);
        $this->db->where('centre_id', $centre_id);
        $this->db->from('tbl_asset_register');
        //$this->db->join('tbl_audited_assets', 'tbl_asset_register.asset_id = tbl_audited_assets.asset_id');
        return $this->db->count_all_results();
    }

    function get_audit_user_name($id)
    {
        $this->db->select('user_id,first_name');
        $this->db->where('user_id', $id);
        $result = $this->db->get('tbl_users')->row();
        return $result->first_name;
    }

    function count_asset_quarter_dep_duplicate($start_date, $end_date, $cat_id)
    {
        $query = $this->db->query("SELECT a.asset_id,a.asset_purchasedDate,a.category_id,d.asset_id,COUNT(d.asset_id),d.fy_start_month FROM tbl_asset_register a JOIN tbl_asset_depreciations d ON a.asset_id = d.asset_id WHERE a.asset_purchasedDate BETWEEN '$start_date' AND '$end_date' AND d.fy_start_month BETWEEN '$start_date' AND '$end_date' AND a.category_id = $cat_id GROUP BY d.asset_id HAVING COUNT(d.asset_id) > 1");
        return $query->num_rows();
    }

    function get_new_asset_quarter_charge($start_date, $end_date, $cat_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('tbl_asset_register.asset_purchasedDate >=', $start_date);
        $this->db->where('tbl_asset_register.asset_purchasedDate <=', $end_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->quarter_dep;
        }
    }

    function get_old_asset_quarter_charge($start_date, $end_date, $cat_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('tbl_asset_register.asset_purchasedDate <', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->quarter_dep;
        }
    }

    function count_asset_quarter_dep_duplicate_centre($start_date, $end_date, $cat_id, $centre_id)
    {
        $query = $this->db->query("SELECT a.asset_id,a.asset_purchasedDate,a.category_id,a.centre_id,d.asset_id,COUNT(d.asset_id),d.fy_start_month FROM tbl_asset_register a JOIN tbl_asset_depreciations d ON a.asset_id = d.asset_id WHERE a.asset_purchasedDate BETWEEN '$start_date' AND '$end_date' AND d.fy_start_month BETWEEN '$start_date' AND '$end_date' AND a.category_id = $cat_id AND a.centre_id = $centre_id GROUP BY d.asset_id HAVING COUNT(d.asset_id) > 1");
        return $query->num_rows();
    }

    function count_prev_quarter_disposed_assets($start_date, $cat_id)
    {
        $query = $this->db->query("SELECT category_id FROM tbl_asset_register WHERE dispose_state = 'disposed' AND dispose_approved_date < '$start_date' AND category_id = $cat_id");
        return $query->num_rows();
    }

    function get_new_asset_quarter_charge_centre($start_date, $end_date, $cat_id, $centre_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('tbl_asset_register.asset_purchasedDate >=', $start_date);
        $this->db->where('tbl_asset_register.asset_purchasedDate <=', $end_date);
        $this->db->where('tbl_asset_register.centre_id =', $centre_id);
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->quarter_dep;
        }
    }

    function get_old_asset_quarter_charge_centre($start_date, $end_date, $cat_id, $centre_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('tbl_asset_register.asset_purchasedDate <', $start_date);
        $this->db->where('tbl_asset_register.centre_id =', $centre_id);
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->quarter_dep;
        }
    }
    /**annual summary additional assets */
    function get_quarter_additional_assets($start_date, $end_date, $cat_id)
    {
        $this->db->select_sum('cost_price');
        $this->db->where('tbl_asset_register.asset_purchasedDate >=', $start_date);
        $this->db->where('tbl_asset_register.asset_purchasedDate <=', $end_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->cost_price;
        }
    }

    function get_quarter_additional_assets_centre($start_date, $end_date, $cat_id, $centre_id)
    {
        $this->db->select_sum('cost_price');
        $this->db->where('tbl_asset_register.asset_purchasedDate >=', $start_date);
        $this->db->where('tbl_asset_register.asset_purchasedDate <=', $end_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->where('tbl_asset_register.centre_id =', $centre_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->cost_price;
        }
    }

    function count_selected_quarter_disposed_assets($start_date, $end_date, $cat_id)
    {
        //$query = $this->db->query("SELECT category_id FROM tbl_asset_register WHERE category_id = 2 AND dispose_state = 'disposed' AND dispose_approved_date BETWEEN '2022-07-01' AND '2022-09-30'");
        $query = $this->db->query("SELECT * FROM tbl_asset_register WHERE dispose_state = 'disposed' AND category_id = $cat_id AND dispose_approved_date BETWEEN '$start_date' AND '$end_date'");
        return $query->num_rows();
    }

    function sum_current_quarter_disposed_assets($start_date, $end_date, $cat_id)
    {
        $this->db->select_sum('cost_price');
        $this->db->where('tbl_asset_register.dispose_state =', 'disposed');
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        //$this->db->where('tbl_asset_register.centre_id =', $centre_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->cost_price;
        }
    }

    //this is used when back dating report bcoz at this time it was not disposed
    function count_future_disposed_assets($start_date, $cat_id)
    {
        $query = $this->db->query("SELECT * FROM tbl_asset_register WHERE dispose_state = 'disposed' AND category_id = $cat_id AND dispose_approved_date > '$start_date'");
        return $query->num_rows();
    }

    function sum_future_quarter_disposed_assets($start_date, $cat_id)
    {
        $this->db->select_sum('asset_costprice');
        //$this->db->distinct('cost_price');
        $this->db->where('dispose_state =', 'disposed');
        $this->db->where('dispose_approved_date >', $start_date);
        $this->db->where('category_id =', $cat_id);
        $this->db->group_by('asset_id');
        //$this->db->where('tbl_asset_register.centre_id =', $centre_id);
        $this->db->from('tbl_asset_register');
        //$this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return 0;
        } else {
            return $result->asset_costprice;
        }
    }
    //for accumulated depreciation when disposed asset is excluded after selected quarter is back dated
    function sum_future_quarter_dep_assets($start_date, $cat_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('dispose_state =', 'disposed');
        $this->db->where('dispose_approved_date >', $start_date);
        $this->db->where('fy_start_month <', $start_date);
        $this->db->where('category_id =', $cat_id);
        $this->db->group_by('asset_id');
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return 0;
        } else {
            return $result->quarter_dep;
        }
    }
    /** centre */
    function count_centre_prev_quarter_disposed_assets($start_date, $cat_id, $centre_id)
    {
        //$query = $this->db->query("SELECT category_id FROM tbl_asset_register WHERE category_id = 2 AND dispose_state = 'disposed' AND dispose_approved_date BETWEEN '2022-07-01' AND '2022-09-30'");
        $query = $this->db->query("SELECT category_id,centre_id FROM tbl_asset_register WHERE dispose_state = 'disposed' AND dispose_approved_date < '$start_date' AND category_id = $cat_id AND centre_id = $centre_id");
        return $query->num_rows();
    }
    function count_centre_selected_quarter_disposed_assets($start_date, $end_date, $cat_id, $centre_id)
    {
        //$query = $this->db->query("SELECT category_id FROM tbl_asset_register WHERE category_id = 2 AND dispose_state = 'disposed' AND dispose_approved_date BETWEEN '2022-07-01' AND '2022-09-30'");
        $query = $this->db->query("SELECT * FROM tbl_asset_register WHERE dispose_state = 'disposed' AND category_id = $cat_id AND dispose_approved_date BETWEEN '$start_date' AND '$end_date' AND centre_id = $centre_id");
        return $query->num_rows();
    }

    function sum_centre_current_quarter_disposed_assets($start_date, $end_date, $cat_id, $centre_id)
    {
        $this->db->select_sum('cost_price');
        $this->db->where('tbl_asset_register.dispose_state =', 'disposed');
        $this->db->where('tbl_asset_depreciations.fy_start_month >=', $start_date);
        $this->db->where('tbl_asset_depreciations.fy_start_month <=', $end_date);
        $this->db->where('tbl_asset_depreciations.category_id =', $cat_id);
        $this->db->where('tbl_asset_register.centre_id =', $centre_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return "";
        } else {
            return $result->cost_price;
        }
    }

    //this is used when back dating report bcoz at this time it was not disposed
    function count_future_disposed_assets_centre($start_date, $cat_id, $centre_id)
    {
        $query = $this->db->query("SELECT * FROM tbl_asset_register WHERE dispose_state = 'disposed' AND category_id = $cat_id AND dispose_approved_date > '$start_date' AND centre_id = $centre_id");
        return $query->num_rows();
    }

    function sum_future_quarter_disposed_assets_centre($end_date, $cat_id, $centre_id)
    {
        $this->db->select_sum('asset_costprice');
        //$this->db->distinct('cost_price');
        $this->db->where('dispose_state =', 'disposed');
        $this->db->where('dispose_approved_date >', $end_date);
        $this->db->where('category_id =', $cat_id);
        $this->db->group_by('asset_id');
        $this->db->where('centre_id =', $centre_id);
        $this->db->from('tbl_asset_register');
        //$this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return 0;
        } else {
            return $result->asset_costprice;
        }
    }
    //for accumulated depreciation when disposed asset is excluded after selected quarter is back dated
    function sum_future_quarter_dep_assets_centre($start_date, $cat_id, $centre_id)
    {
        $this->db->select_sum('quarter_dep');
        $this->db->where('dispose_state =', 'disposed');
        $this->db->where('dispose_approved_date >', $start_date);
        $this->db->where('fy_start_month <', $start_date);
        $this->db->where('category_id =', $cat_id);
        $this->db->group_by('asset_id');
        $this->db->where('centre_id =', $centre_id);
        $this->db->from('tbl_asset_register');
        $this->db->join('tbl_asset_depreciations', 'tbl_asset_register.asset_id = tbl_asset_depreciations.asset_id');
        $result = $this->db->get()->row();
        if ($result == NULL) {
            return 0;
        } else {
            return $result->quarter_dep;
        }
    }


}
