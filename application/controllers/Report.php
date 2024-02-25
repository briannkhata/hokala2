<?php
defined('BASEPATH') or exit('No direct script access allowed');
//increase memory usage
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata("user_login") != 1) {
			redirect(base_url(), "refresh");
		}
	}

	function asset()
	{
		$data['page_title'] = "Asset Report";
		$this->load->view('report/_asset', $data);
	}

	function asset_filter()
	{
		$missing = $this->input->post("missing");
		$deleted = $this->input->post("deleted");
		$new = $this->input->post("new");
		$centre_id = $this->input->post("centre_id");
		$category_id = $this->input->post("category_id");
		$department_id = $this->input->post("department_id");
		$donor_id = $this->input->post("donor_id");
		$data['fetch_data'] = $this->M_report->get_assets($missing,$deleted,$new,$centre_id,$category_id,$department_id,$donor_id);
		$data['page_title'] = "Asset Report";
		$this->load->view('report/_refresh_assets', $data);
	}

	function disposed()
	{
		$data['page_title'] = "Disposed Assets";
		$this->load->view('report/_disposed', $data);
	}

	function refresh_disposed()
	{
		$centre_id = $this->input->post("centre_id");
		$category_id = $this->input->post("category_id");
		$department_id = $this->input->post("department_id");
		$donor_id = $this->input->post("donor_id");
		$data['fetch_data'] = $this->M_report->get_disposed_assets($centre_id,$category_id,$department_id,$donor_id);
		$data['page_title'] = "Disposed Assets Report";
		$this->load->view('report/_refresh_disposed', $data);
	}

	function missing()
	{
		$data['page_title'] = "Missing Assets";
		$this->load->view('report/_missing', $data);
	}

	function refresh_missing()
	{
		$centre_id = $this->input->post("centre_id");
		$category_id = $this->input->post("category_id");
		$department_id = $this->input->post("department_id");
		$donor_id = $this->input->post("donor_id");
		$data['fetch_data'] = $this->M_report->get_missing_assets($centre_id,$category_id,$department_id,$donor_id);
		$data['page_title'] = "Missing Assets Report";
		$this->load->view('report/_refresh_missing', $data);
	}


	function select_quarter()
	{
		//The "n" format character gives us the month number without any zeros
		$month = date("n");
		//find quarter number of the year
		$quarter_no = ceil($month / 3);
		$data['quarter_number'] = $quarter_no;
		$data['page_title'] = "Quarter Report";
		$this->load->view('report/_quarter_options', $data);
	}

	function refresh_qtr_sum()
	{
		//The "n" format character gives us the month number without any zeros
		$month = date("n");
		//find quarter number of the year
		$quarter_no = ceil($month / 3);
		$data['quarter_number'] = $quarter_no;
		$data['page_title'] = "Quarter Report";
		$this->load->view('report/_refresh_qtr_sum', $data);
	}

	function quarter_summary()
	{
		$selected_year = $this->input->post('year');
		$posted_quarter_number = $this->input->post('quarter');
		$selected_centre = $this->input->post('cost_centre');

		if ($posted_quarter_number == 1) {
			#first quater Jan-March
			$Quater_name = "1st Quarter Summary";
			$quarter_start_month = $selected_year . "-01-01";
			$quarter_end_month = $selected_year . "-03-31";
			//prev quarter
			$prev_yr = $selected_year - 1;
			$prev_quarter_start_month = $prev_yr . "-10-01";
			$prev_quarter_end_month = $prev_yr . "-12-31";
		}
		if ($posted_quarter_number == 2) {
			#second quater April-June
			$Quater_name = "2nd Quarter Summary";
			$quarter_start_month = $selected_year . "-04-01";
			$quarter_end_month = $selected_year . "-06-30";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-01-01";
			$prev_quarter_end_month = $selected_year . "-03-31";
		}
		if ($posted_quarter_number == 3) {
			#third quater July-September
			$Quater_name = "3rd Quarter Summary";
			$quarter_start_month = $selected_year . "-07-01";
			$quarter_end_month = $selected_year . "-09-30";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-04-01";
			$prev_quarter_end_month = $selected_year . "-06-30";
		}

		if ($posted_quarter_number == 4) {
			#third quater October-December
			$Quater_name = "4th Quarter Summary";
			$quarter_start_month = $selected_year . "-10-01";
			$quarter_end_month = $selected_year . "-12-31";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-07-01";
			$prev_quarter_end_month = $selected_year . "-09-30";
		}
		$data['quarter_number'] = $posted_quarter_number;
		$data['quarter_name'] = $Quater_name;
		$data['prev_quarter_start_date'] = $prev_quarter_start_month;
		$data['prev_quarter_end_date'] = $prev_quarter_end_month;
		// $data['quarter_number'] = $yearQuarter;
		$data['posted_year'] = $selected_year;
		$data['start_date'] = $quarter_start_month;
		$data['end_date'] = $quarter_end_month;
		$data['centre_id'] = $selected_centre;
		$data['cats'] = $this->M_category->get_categories();
		//cost of assets
		$data['costs'] = $this->M_report->get_quarter_depreciated_asset_cost($quarter_start_month, $quarter_end_month);
		//assets added within quarter
		$data['additions'] = $this->M_report->get_quarter_depreciated_asset_addition($quarter_start_month, $quarter_end_month);
		//$data['additions'] = $this->db->select('c.category_id,a.category_id,a.asset_costprice,a.asset_purchasedDate')->from('tbl_category c')->join('tbl_asset_register a', 'c.category_id = a.category_id')->where(array('asset_purchasedDate >=' => $quarter_start_month, 'a.asset_purchasedDate <=' => $quarter_end_month, 'asset_status' => 'active'))->get()->result_array();
		//Revaluation
		$data['valuations'] = $this->M_report->get_reval_assets($quarter_start_month, $quarter_end_month);
		//cost of disposed assets
		$data['disposals'] = $this->M_report->get_cost_of_disposed_asset($quarter_start_month, $quarter_end_month);
		//DEPRECIATION
		//accumulated depreciation brought forward from previous quarter

		$data['accum_deps'] = $this->db
			->select('a.asset_id, a.asset_status, c.category_id, d.category_id, d.quarter_dep, d.fy_start_month, d.fy_end_month')
			->from('tbl_category c')
			->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')
			->join('tbl_asset_register a', 'a.asset_id = d.asset_id') // Corrected join condition
			->where("a.asset_status", 'active')
			->where("d.fy_start_month >=", $prev_quarter_start_month)
			->where("d.fy_end_month <=", $prev_quarter_end_month)
			->get()
			->result_array();

		$data['charges'] = $this->db
			->select('a.asset_id, a.asset_status, c.category_id, d.category_id, d.quarter_dep, d.fy_start_month, d.fy_end_month')
			->from('tbl_category c')
			->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')
			->join('tbl_asset_register a', 'a.asset_id = d.asset_id') // Corrected join condition
			->where('a.asset_status', 'active')
			->where('d.fy_start_month >=', $quarter_start_month)
			->where('d.fy_end_month <=', $quarter_end_month)
			->get()
			->result_array();



		//$data['accum_deps'] = $this->db->select('a.asset_id,a.asset_status,c.category_id,category_id,d.category_id,d.quarter_dep,d.fy_start_month,d.fy_end_month')->from('tbl_category c')->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')->join('tbl_asset_register a', 'a.asset_id = category_id')->where("a.asset_status =", 'active', "d.fy_start_month >=", $prev_quarter_start_month, "d.fy_start_month <=", $prev_quarter_end_month)->get()->result_array();
		//depreciation of current quarter /charge
		//$data['charges'] = $this->db->select('a.asset_id,a.asset_status,c.category_id,category_id,d.category_id,d.quarter_dep,d.fy_start_month,d.fy_end_month')->from('tbl_category c')->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')->join('tbl_asset_register a', 'a.asset_id = category_id')->where("a.asset_status =", 'active', "d.fy_start_month >=", $quarter_start_month, "d.fy_start_month <=", $quarter_end_month)->get()->result_array();
		//Accum Depreciation of Revaluated assets
		$data['accum_revalued'] = $this->M_report->get_reval_assets($quarter_start_month, $quarter_end_month);
		//Accum Depreciation of disposed asset
		$data['accum_disposed'] = $this->M_report->fetch_accum_dep_of_disposed_asset($quarter_end_month);
		$data['page_title'] = "Quarter Summary";
		//check centre id
		if ($selected_centre > 0) {
			//cost centre selected
			$this->load->view('report/_quarter_summary_centre', $data);
		} else {
			// No centre selected
			$this->load->view('report/_quarter_summary', $data);
		}
	}

	public function select_year()
	{
		$data['page_title'] = "Select Year";
		$this->load->view('report/_annual_options', $data);
	}

	function annual_summary()
	{
		$year = $this->input->post('year');
		$selected_centre = $this->input->post('cost_centre');
		$start_date = $year . "-01-01";
		$end_date = $year . "-12-31";
		$march_end = $year . "-03-31";
		$data['report_title'] = "Annual Summary";
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		//first quarter
		$data['jan_bengin'] = $start_date;
		$data['march_end'] = $march_end;
		//prev year
		$prev_yr = $year - 1;
		$prev_year_start_month = $prev_yr . "-01-01";
		$prev_year_end_month = $prev_yr . "-12-31";
		$data['prev_year_start_month'] = $prev_year_start_month;
		$data['prev_year_end_month'] = $prev_year_end_month;
		$data['posted_year'] = $year;
		//The "n" format character gives us the month number without any zeros
		$month = date("n");
		//find quarter number of the year
		$Quarter_num = ceil($month / 3);
		/** determine the quarter which user is */
		if ($Quarter_num == 1) {
			#first quater Jan-March
			$quarter_start_month = $year . "-01-01";
			$quarter_end_month = $year . "-03-31";
			//prev quarter
			$prev_yr = $year - 1;
			$prev_quarter_start_month = $prev_yr . "-10-01";
			$prev_quarter_end_month = $prev_yr . "-12-31";
		}
		if ($Quarter_num == 2) {
			#second quater April-June
			$quarter_start_month = $year . "-04-01";
			$quarter_end_month = $year . "-06-30";
			//prev quarter
			$prev_quarter_start_month = $year . "-01-01";
			$prev_quarter_end_month = $year . "-03-31";
		}
		if ($Quarter_num == 3) {
			#third quater July-September
			$quarter_start_month = $year . "-07-01";
			$quarter_end_month = $year . "-09-30";
			//prev quarter
			$prev_quarter_start_month = $year . "-04-01";
			$prev_quarter_end_month = $year . "-06-30";
		}

		if ($Quarter_num == 4) {
			#third quater October-December
			$quarter_start_month = $year . "-10-01";
			$quarter_end_month = $year . "-12-31";
			//prev quarter
			$prev_quarter_start_month = $year . "-07-01";
			$prev_quarter_end_month = $year . "-09-30";
		}
		//last quarter of previous year
		$data['cur_yr_last_qota_first_day'] = $prev_quarter_start_month;
		$data['cur_yr_last_qota_last_day'] = $prev_quarter_end_month;
		$data['selected_year'] = $year;
		$data['centre_id'] = $selected_centre;
		//Categories
		$data['cats'] = $this->M_category->get_categories();
		//cost of assets
		$data['costs'] = $this->M_report->get_quarter_depreciated_asset_cost($start_date, $march_end);
		//assets added within year
		$data['additions'] = $this->M_report->get_quarter_depreciated_asset_addition($start_date, $end_date);
		//$data['additions'] = $this->db->select('c.category_id,a.category_id,a.asset_costprice,a.asset_purchasedDate')->from('tbl_category c')->join('tbl_asset_register a', 'c.category_id = a.category_id')->where(array('asset_purchasedDate >=' => $start_date, 'a.asset_purchasedDate <=' => $end_date, 'asset_status' => 'active'))->get()->result_array();
		//Revaluation
		$data['valuations'] = $this->M_report->get_reval_assets($start_date, $end_date);
		//cost of disposed assets
		//$data['disposals']= $this->M_report->get_cost_of_disposed_asset($start_date,$march_end);

		$data['disposals'] = $this->db->select('c.category_id, a.asset_id, a.category_id, a.asset_costprice, d.asset_id, a.dispose_approved_date')
			->from('tbl_category c')
			->join('tbl_asset_register a', 'c.category_id = a.category_id')
			->join('tbl_asset_depreciations d', 'a.asset_id = d.asset_id')
			->where('a.dispose_state', 'disposed')
			->where('a.dispose_approved_date >=', $start_date)
			->where('a.dispose_approved_date <=', $end_date)->get()->result_array();

		$data['accum_deps'] = $this->db->select('a.asset_id, a.asset_status, c.category_id, d.asset_id, d.category_id, d.quarter_dep, d.fy_start_month, d.fy_end_month')
			->from('tbl_category c')
			->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')
			->join('tbl_asset_register a', 'a.asset_id = d.asset_id')
			->where('a.asset_status', 'active')
			->where('d.fy_start_month >=', $prev_year_start_month)
			->where('d.fy_start_month <=', $prev_year_end_month)->get()->result_array();

		$data['charges'] = $this->db->select('a.asset_id, a.asset_status, c.category_id, d.asset_id, d.category_id, d.quarter_dep, d.fy_start_month, d.fy_end_month')
			->from('tbl_category c')
			->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')
			->join('tbl_asset_register a', 'a.asset_id = d.asset_id')
			->where('a.asset_status', 'active')
			->where('d.fy_start_month >=', $start_date)
			->where('d.fy_start_month <=', $end_date)->get()->result_array();


		//$data['disposals'] = $this->db->select('c.category_id,a.asset_id,a.category_id,a.asset_costprice,d.asset_id,a.dispose_approved_date')->from('tbl_category c')->join('tbl_asset_register a', 'c.category_id = a.category_id')->join('tbl_asset_depreciations d', 'a.asset_id = category_id')->where(array('a.dispose_state' => 'disposed', 'a.dispose_approved_date >=' => $start_date, 'a.dispose_approved_date <=' => $end_date))->get()->result_array();
		//accumulated depreciation brought forward from previous quarter
		//$data['accum_deps'] = $this->db->select('a.asset_id,a.asset_status,c.category_id,d.asset_id,d.category_id,d.quarter_dep,d.fy_start_month,d.fy_end_month')->from('tbl_category c')->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')->join('tbl_asset_register a', 'a.asset_id = category_id')->where("a.asset_status =", 'active', "d.fy_start_month >=", $prev_year_start_month = $prev_yr, "d.fy_start_month <=", $prev_year_end_month)->get()->result_array();
		//depreciation of current quarter /charge
		//$data['charges'] = $this->db->select('a.asset_id,a.asset_status,c.category_id,d.asset_id,d.category_id,d.quarter_dep,d.fy_start_month,d.fy_end_month')->from('tbl_category c')->join('tbl_asset_depreciations d', 'c.category_id = d.category_id')->join('tbl_asset_register a', 'a.asset_id = category_id')->where("a.asset_status =", 'active', "d.fy_start_month >=", $start_date, "d.fy_start_month <=", $end_date)->get()->result_array();
		//Accum Depreciation of Revaluated assets
		$data['accum_revalued'] = $this->M_report->get_reval_assets($start_date, $end_date);
		//Accum Depreciation of disposed asset
		$data['accum_disposals'] = $this->M_report->fetch_accum_dep_of_disposed_asset($start_date);
		$data['page_title'] = "Annual Report";
		//check centre id
		if ($selected_centre > 0) {
			//cost centre selected
			$this->load->view('report/_annual_summary_centre', $data);
		} else {
			// No centre selected
			$this->load->view('report/_annual_summary', $data);
		}

	}
	/** static dep expense report*/
	public function dep_expense()
	{
		$selected_year = $this->input->post('year');
		$posted_quarter_number = $this->input->post('quarter');

		if ($posted_quarter_number == 1) {
			#first quater Jan-March
			$Quater_name = "First Quarter";
			$quarter_start_month = $selected_year . "-01-01";
			$quarter_end_month = $selected_year . "-03-31";
			//prev quarter
			$prev_yr = $selected_year - 1;
			$prev_quarter_start_month = $prev_yr . "-10-01";
			$prev_quarter_end_month = $prev_yr . "-12-31";
		}
		if ($posted_quarter_number == 2) {
			#second quater April-June
			$Quater_name = "Second Quarter";
			$quarter_start_month = $selected_year . "-04-01";
			$quarter_end_month = $selected_year . "-06-30";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-01-01";
			$prev_quarter_end_month = $selected_year . "-03-31";
		}
		if ($posted_quarter_number == 3) {
			#third quater July-September
			$Quater_name = "Third Quarter";
			$quarter_start_month = $selected_year . "-07-01";
			$quarter_end_month = $selected_year . "-09-30";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-04-01";
			$prev_quarter_end_month = $selected_year . "-06-30";
		}

		if ($posted_quarter_number == 4) {
			#third quater October-December
			$Quater_name = "Fourth Quarter";
			$quarter_start_month = $selected_year . "-10-01";
			$quarter_end_month = $selected_year . "-12-31";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-07-01";
			$prev_quarter_end_month = $selected_year . "-09-30";
		}
		$data['quarter_number'] = $posted_quarter_number;
		$data['quarter_name'] = $Quater_name;
		$data['chaka'] = $selected_year;
		$data['prev_quarter_start_date'] = $prev_quarter_start_month;
		$data['prev_quarter_end_date'] = $prev_quarter_end_month;
		$data['start_date'] = $quarter_start_month;
		$data['end_date'] = $quarter_end_month;
		$this->load->view('report/_expense_summary', $data);
	}

	/** ajax depreciation expense Report */
	function select_expense_quarter()
	{
		//The "n" format character gives us the month number without any zeros
		$month = date("n");
		//find quarter number of the year
		$quarter_no = ceil($month / 3);
		$data['quarter_number'] = $quarter_no;
		$data['page_title'] = "Expense Quarter";
		$this->load->view('report/_quarter_expense_options', $data);
	}

	public function quarter_dep_expense()
	{
		$selected_year = $this->input->post('year');
		$posted_quarter_number = $this->input->post('quarter');
		$cost_centre_id = $this->input->post('cost_centre');
		if ($posted_quarter_number == 1) {
			#first quater Jan-March
			$Quater_name = "1st Quarter";
			$quarter_start_month = $selected_year . "-01-01";
			$quarter_end_month = $selected_year . "-03-31";
			//prev quarter
			$prev_yr = $selected_year - 1;
			$prev_quarter_start_month = $prev_yr . "-10-01";
			$prev_quarter_end_month = $prev_yr . "-12-31";
		}
		if ($posted_quarter_number == 2) {
			#second quater April-June
			$Quater_name = "2nd Quarter";
			$quarter_start_month = $selected_year . "-04-01";
			$quarter_end_month = $selected_year . "-06-30";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-01-01";
			$prev_quarter_end_month = $selected_year . "-03-31";
		}
		if ($posted_quarter_number == 3) {
			#third quater July-September
			$Quater_name = "3rd Quarter";
			$quarter_start_month = $selected_year . "-07-01";
			$quarter_end_month = $selected_year . "-09-30";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-04-01";
			$prev_quarter_end_month = $selected_year . "-06-30";
		}

		if ($posted_quarter_number == 4) {
			#third quater October-December
			$Quater_name = "4th Quarter";
			$quarter_start_month = $selected_year . "-10-01";
			$quarter_end_month = $selected_year . "-12-31";
			//prev quarter
			$prev_quarter_start_month = $selected_year . "-07-01";
			$prev_quarter_end_month = $selected_year . "-09-30";
		}
		$data['quarter_number'] = $posted_quarter_number;
		$data['quarter_name'] = $Quater_name;
		$data['chaka'] = $selected_year;
		$data['prev_quarter_start_date'] = $prev_quarter_start_month;
		$data['prev_quarter_end_date'] = $prev_quarter_end_month;
		$data['start_date'] = $quarter_start_month;
		$data['end_date'] = $quarter_end_month;
		$data['cost_centre_id'] = $cost_centre_id;
		$data['page_title'] = "Quarter Expense Register";
		if ($cost_centre_id > 0) {
			//centre selected
			$this->load->view('report/_quarter_expense_register_centre', $data);
		} else {
			//All centres
			//$this->load->view('_expense_summary_ajax', $data);
			$this->load->view('report/_quarter_expense_register', $data);
		}
	}

	function quarter_dep_expense_assets()
	{
		$quarter_start_month = $this->input->post('kota_s_date');
		$quarter_end_month = $this->input->post('kota_e_date');

		$active_assets = $this->M_report->make_quarter_dep_expense_datatables($quarter_end_month);
		$disposed_assets = $this->M_report->make_quarter_dep_expense_asset_disposed_datatables($quarter_start_month);
		$fetch_data = array_merge($active_assets, $disposed_assets);
		$data = array();
		foreach ($fetch_data as $row) {
			$sub_array = array();
			//$sub_array[] = '<img src="'.base_url().'uploads/'.$row->asset_photo.'" class="img-thumbnail" width="50" height="35" />';  
			$sub_array[] = $row->asset_barcode;
			$sub_array[] = $row->asset_name;
			$sub_array[] = $row->asset_manufacture;
			$sub_array[] = $row->asset_serialNo;
			$sub_array[] = $row->asset_model;
			$sub_array[] = $row->asset_regNo;
			$sub_array[] = $row->chasis_no;
			$sub_array[] = $row->asset_engineNo;
			$sub_array[] = $this->M_report->get_category_id_name($row->category_id);
			$sub_array[] = $this->M_report->get_asset_centre_name($row->asset_costcentre);
			$sub_array[] = $this->M_report->get_asset_user_name($row->asset_user);
			$sub_array[] = $this->M_report->get_asset_donor_name($row->donor_id);
			$sub_array[] = date('d-M-Y', strtotime($row->asset_purchasedDate));
			$cost = $this->M_report->get_asset_expense_cost($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($cost, 2); //cost as BQ
			$addition = $this->M_report->get_asset_expense_addtion($row->asset_id, $quarter_start_month, $quarter_end_month);
			//addittion within Q
			$sub_array[] = number_format($addition, 2);
			//valuation
			$valuation = $this->M_report->get_asset_expense_valuation($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($valuation, 2);
			//disposals
			$disposed = $this->M_report->get_asset_expense_disposal($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed, 2);
			//value by end of quarter
			$cost_as_end_of = ($cost + $addition + $valuation) - $disposed;
			$sub_array[] = number_format($cost_as_end_of, 2);
			//Accum Dep brought 4ward from prev Quarter
			$accum_dep = $this->M_report->get_asset_expense_accum_dep($row->asset_id, $quarter_start_month);
			$sub_array[] = number_format($accum_dep, 2);
			//Dep charge for the Quarter
			$dep_charge = $this->M_report->get_asset_expense_dep_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_charge, 2);
			//Depreciation of revalued assets for the Quarter
			$dep_reval = $this->M_report->get_asset_expense_dep_reval($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_reval, 2);
			//disposed charge (charge of disposed asset)
			$disposed_charge = $this->M_report->get_asset_expense_disposed_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed_charge, 2);
			//Total Dep by end of Quarter
			$dep_as_end_of = (($accum_dep + $dep_charge) - $dep_reval) - $disposed_charge;
			$sub_array[] = number_format($dep_as_end_of, 2);
			//NBV
			$nbv = $cost_as_end_of - $dep_as_end_of;
			$sub_array[] = number_format($nbv, 2);
			/**duplicates */
			//$sub_array[] = $row->chasis_no;
			/** */
			$data[] = $sub_array;
		}
		//add active and disposed assets
		$active_total = $this->M_report->get_all_quarter_dep_expense_data($quarter_end_month);
		$active_total_filtered = $this->M_report->get_filtered_quarter_dep_expense_data($quarter_end_month);
		//disposed
		$disposed_total = $this->M_report->get_all_quarter_dep_expense_asset_disposed_data($quarter_start_month);
		$disposed_total_filtered = $this->M_report->get_filtered_quarter_dep_expense_asset_disposed_data($quarter_start_month);
		//sumation
		$active_plus_disposed_total = $active_total + $disposed_total;
		$active_plus_disposed_total_filtered = $active_total_filtered + $disposed_total_filtered;
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $active_plus_disposed_total,
			"recordsFiltered" => $active_plus_disposed_total_filtered,
			"data" => $data
		);
		echo json_encode($output);

	}

	function quarter_dep_expense_assets_centre()
	{
		//get posted quarter number
		$quarter_start_month = $this->input->post('kota_s_date');
		$quarter_end_month = $this->input->post('kota_e_date');
		$cost_centre_id = $this->input->post('cost_centre_id');
		$active_assets = $this->M_report->make_centre_quarter_dep_expense_datatables($cost_centre_id);
		$disposed_assets = $this->M_report->make_quarter_dep_expense_asset_disposed_datatables($quarter_start_month, $cost_centre_id);
		$fetch_data = array_merge($active_assets, $disposed_assets);
		$data = array();
		foreach ($fetch_data as $row) {
			$sub_array = array();
			//$sub_array[] = '<img src="'.base_url().'uploads/'.$row->asset_photo.'" class="img-thumbnail" width="50" height="35" />';  
			$sub_array[] = $row->asset_barcode;
			$sub_array[] = $row->asset_name;
			$sub_array[] = $row->asset_manufacture;
			$sub_array[] = $row->asset_serialNo;
			$sub_array[] = $row->asset_model;
			$sub_array[] = $row->asset_regNo;
			$sub_array[] = $row->chasis_no;
			$sub_array[] = $row->asset_engineNo;
			$sub_array[] = $this->M_report->get_category_id_name($row->category_id);
			$sub_array[] = $this->M_report->get_asset_centre_name($row->asset_costcentre);
			$sub_array[] = $this->M_report->get_asset_user_name($row->asset_user);
			$sub_array[] = $this->M_report->get_asset_donor_name($row->donor_id);
			$sub_array[] = date('d-M-Y', strtotime($row->asset_purchasedDate));
			$cost = $this->M_report->get_asset_expense_cost($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($cost, 2); //cost as BQ
			$addition = $this->M_report->get_asset_expense_addtion($row->asset_id, $quarter_start_month, $quarter_end_month);
			//addittion within Q
			$sub_array[] = number_format($addition, 2);
			//valuation
			$valuation = $this->M_report->get_asset_expense_valuation($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($valuation, 2);
			//disposals
			$disposed = $this->M_report->get_asset_expense_disposal($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed, 2);
			//value by end of quarter
			$cost_as_end_of = ($cost + $addition + $valuation) - $disposed;
			$sub_array[] = number_format($cost_as_end_of, 2);
			//Accum Dep brought 4ward from prev Quarter
			$accum_dep = $this->M_report->get_asset_expense_accum_dep($row->asset_id, $quarter_start_month);
			$sub_array[] = number_format($accum_dep, 2);
			//Dep charge for the Quarter
			$dep_charge = $this->M_report->get_asset_expense_dep_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_charge, 2);
			//Depreciation of revalued assets for the Quarter
			$dep_reval = $this->M_report->get_asset_expense_dep_reval($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_reval, 2);
			//disposed charge (charge of disposed asset)
			$disposed_charge = $this->M_report->get_asset_expense_disposed_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed_charge, 2);
			//Total Dep by end of Quarter
			$dep_as_end_of = (($accum_dep + $dep_charge) - $dep_reval) - $disposed_charge;
			$sub_array[] = number_format($dep_as_end_of, 2);
			//NBV
			$nbv = $cost_as_end_of - $dep_as_end_of;
			$sub_array[] = number_format($nbv, 2);
			$data[] = $sub_array;
		}
		//add active and disposed assets
		$active_total_centre = $this->M_report->get_all_centre_quarter_dep_expense_data($cost_centre_id);
		$active_total_filtered_centre = $this->M_report->get_filtered_centre_quarter_dep_expense_data($cost_centre_id);
		//disposed
		$disposed_total_centre = $this->M_report->get_all_centre_quarter_dep_expense_asset_disposed_data($quarter_start_month, $cost_centre_id);
		$disposed_total_filtered_centre = $this->M_report->get_filtered_centre_quarter_dep_expense_asset_disposed_data($quarter_start_month, $cost_centre_id);
		//sumation
		$active_plus_disposed_total_centre = $active_total_centre + $disposed_total_centre;
		$active_plus_disposed_total_filtered_centre = $active_total_filtered_centre + $disposed_total_filtered_centre;

		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $active_plus_disposed_total_centre,//$this->M_report->get_all_centre_quarter_dep_expense_data($cost_centre_id),
			"recordsFiltered" => $active_plus_disposed_total_filtered_centre,//$this->M_report->get_filtered_centre_quarter_dep_expense_data($cost_centre_id),
			"data" => $data
		);
		echo json_encode($output);
	}
	/** annual dep expenses*/
	public function select_expense_annual()
	{
		//The "n" format character gives us the month number without any zeros
		$month = date("n");
		//find quarter number of the year
		$quarter_no = ceil($month / 3);
		$data['quarter_number'] = $quarter_no;
		$this->load->view('_annual_expense_options', $data);
	}

	public function annual_dep_expense_ajax()
	{
		$selected_year = $this->input->post('year');
		$cost_centre_id = $this->input->post('cost_centre');
		$start_date = $selected_year . "-01-01";
		$end_date = $selected_year . "-12-31";
		$data['chaka'] = $selected_year;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['cost_centre_id'] = $cost_centre_id;
		if ($cost_centre_id > 0) {
			//centre selected
			$this->load->view('_annual_expense_register_centre', $data);
		} else {
			//All centres
			$this->load->view('_annual_expense_register', $data);
		}
	}

	function annual_dep_expense_assets()
	{
		$quarter_start_month = $this->input->post('kota_s_date');
		$quarter_end_month = $this->input->post('kota_e_date');

		$active_assets = $this->M_report->make_quarter_dep_expense_datatables($quarter_end_month);
		$disposed_assets = $this->M_report->make_quarter_dep_expense_asset_disposed_datatables($quarter_start_month);
		$fetch_data = array_merge($active_assets, $disposed_assets);
		$data = array();
		foreach ($fetch_data as $row) {
			$sub_array = array();
			//$sub_array[] = '<img src="'.base_url().'uploads/'.$row->asset_photo.'" class="img-thumbnail" width="50" height="35" />';  
			$sub_array[] = $row->asset_barcode;
			$sub_array[] = $row->asset_name;
			$sub_array[] = $row->asset_manufacture;
			$sub_array[] = $row->asset_serialNo;
			$sub_array[] = $row->asset_model;
			$sub_array[] = $row->asset_regNo;
			$sub_array[] = $row->chasis_no;
			$sub_array[] = $row->asset_engineNo;
			$sub_array[] = $this->M_report->get_category_id_name($row->category_id);
			$sub_array[] = $this->M_report->get_asset_centre_name($row->asset_costcentre);
			$sub_array[] = $this->M_report->get_asset_user_name($row->asset_user);
			$sub_array[] = $this->M_report->get_asset_donor_name($row->donor_id);
			$sub_array[] = date('d-M-Y', strtotime($row->asset_purchasedDate));
			$cost = $this->M_report->get_asset_expense_cost($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($cost, 2); //cost as BQ
			$addition = $this->M_report->get_asset_expense_addtion($row->asset_id, $quarter_start_month, $quarter_end_month);
			//addittion within Q
			$sub_array[] = number_format($addition, 2);
			//valuation
			$valuation = $this->M_report->get_asset_expense_valuation($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($valuation, 2);
			//disposals
			$disposed = $this->M_report->get_asset_expense_disposal($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed, 2);
			//value by end of quarter
			$cost_as_end_of = ($cost + $addition + $valuation) - $disposed;
			$sub_array[] = number_format($cost_as_end_of, 2);
			/** Depreciation */
			//Accum Dep brought 4ward from prev Quarter
			$accum_dep = $this->M_report->get_asset_expense_accum_dep($row->asset_id, $quarter_start_month);
			$sub_array[] = number_format($accum_dep, 2);
			//Dep charge for the Quarter
			$dep_charge = $this->M_report->get_asset_expense_dep_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_charge, 2);
			//Depreciation of revalued assets for the Quarter
			$dep_reval = $this->M_report->get_asset_expense_dep_reval($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_reval, 2);
			//disposed charge (charge of disposed asset)
			$disposed_charge = $this->M_report->get_asset_expense_disposed_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed_charge, 2);
			//Total Dep by end of Quarter
			$dep_as_end_of = (($accum_dep + $dep_charge) - $dep_reval) - $disposed_charge;
			$sub_array[] = number_format($dep_as_end_of, 2);
			//NBV
			$nbv = $cost_as_end_of - $dep_as_end_of;
			$sub_array[] = number_format($nbv, 2);
			$data[] = $sub_array;
		}
		//add active and disposed assets
		$active_total = $this->M_report->get_all_quarter_dep_expense_data($quarter_end_month);
		$active_total_filtered = $this->M_report->get_filtered_quarter_dep_expense_data($quarter_end_month);
		//disposed
		$disposed_total = $this->M_report->get_all_quarter_dep_expense_asset_disposed_data($quarter_start_month);
		$disposed_total_filtered = $this->M_report->get_filtered_quarter_dep_expense_asset_disposed_data($quarter_start_month);
		//sumation
		$active_plus_disposed_total = $active_total + $disposed_total;
		$active_plus_disposed_total_filtered = $active_total_filtered + $disposed_total_filtered;
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $active_plus_disposed_total,
			"recordsFiltered" => $active_plus_disposed_total_filtered,
			"data" => $data
		);
		echo json_encode($output);

	}

	function annual_dep_expense_assets_centre()
	{
		//get posted quarter number
		$quarter_start_month = $this->input->post('kota_s_date');
		$quarter_end_month = $this->input->post('kota_e_date');
		$cost_centre_id = $this->input->post('cost_centre_id');
		$active_assets = $this->M_report->make_centre_quarter_dep_expense_datatables($cost_centre_id);
		$disposed_assets = $this->M_report->make_quarter_dep_expense_asset_disposed_datatables($quarter_start_month, $cost_centre_id);
		$fetch_data = array_merge($active_assets, $disposed_assets);
		$data = array();
		foreach ($fetch_data as $row) {
			$sub_array = array();
			//$sub_array[] = '<img src="'.base_url().'uploads/'.$row->asset_photo.'" class="img-thumbnail" width="50" height="35" />';  
			$sub_array[] = $row->asset_barcode;
			$sub_array[] = $row->asset_name;
			$sub_array[] = $row->asset_manufacture;
			$sub_array[] = $row->asset_serialNo;
			$sub_array[] = $row->asset_model;
			$sub_array[] = $row->asset_regNo;
			$sub_array[] = $row->chasis_no;
			$sub_array[] = $row->asset_engineNo;
			$sub_array[] = $this->M_report->get_category_id_name($row->category_id);
			$sub_array[] = $this->M_report->get_asset_centre_name($row->asset_costcentre);
			$sub_array[] = $this->M_report->get_asset_user_name($row->asset_user);
			$sub_array[] = $this->M_report->get_asset_donor_name($row->donor_id);
			$sub_array[] = date('d-M-Y', strtotime($row->asset_purchasedDate));
			$cost = $this->M_report->get_asset_expense_cost($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($cost, 2); //cost as BQ
			$addition = $this->M_report->get_asset_expense_addtion($row->asset_id, $quarter_start_month, $quarter_end_month);
			//addittion within Q
			$sub_array[] = number_format($addition, 2);
			//valuation
			$valuation = $this->M_report->get_asset_expense_valuation($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($valuation, 2);
			//disposals
			$disposed = $this->M_report->get_asset_expense_disposal($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed, 2);
			//value by end of quarter
			$cost_as_end_of = ($cost + $addition + $valuation) - $disposed;
			$sub_array[] = number_format($cost_as_end_of, 2);
			//Accum Dep brought 4ward from prev Quarter
			$accum_dep = $this->M_report->get_asset_expense_accum_dep($row->asset_id, $quarter_start_month);
			$sub_array[] = number_format($accum_dep, 2);
			//Dep charge for the Quarter
			$dep_charge = $this->M_report->get_asset_expense_dep_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_charge, 2);
			//Depreciation of revalued assets for the Quarter
			$dep_reval = $this->M_report->get_asset_expense_dep_reval($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($dep_reval, 2);
			//disposed charge (charge of disposed asset)
			$disposed_charge = $this->M_report->get_asset_expense_disposed_charge($row->asset_id, $quarter_start_month, $quarter_end_month);
			$sub_array[] = number_format($disposed_charge, 2);
			//Total Dep by end of Quarter
			$dep_as_end_of = (($accum_dep + $dep_charge) - $dep_reval) - $disposed_charge;
			$sub_array[] = number_format($dep_as_end_of, 2);
			//NBV
			$nbv = $cost_as_end_of - $dep_as_end_of;
			$sub_array[] = number_format($nbv, 2);
			$data[] = $sub_array;
		}
		//add active and disposed assets
		$active_total_centre = $this->M_report->get_all_centre_quarter_dep_expense_data($cost_centre_id);
		$active_total_filtered_centre = $this->M_report->get_filtered_centre_quarter_dep_expense_data($cost_centre_id);
		//disposed
		$disposed_total_centre = $this->M_report->get_all_centre_quarter_dep_expense_asset_disposed_data($quarter_start_month, $cost_centre_id);
		$disposed_total_filtered_centre = $this->M_report->get_filtered_centre_quarter_dep_expense_asset_disposed_data($quarter_start_month, $cost_centre_id);
		//sumation
		$active_plus_disposed_total_centre = $active_total_centre + $disposed_total_centre;
		$active_plus_disposed_total_filtered_centre = $active_total_filtered_centre + $disposed_total_filtered_centre;

		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $active_plus_disposed_total_centre,//$this->M_report->get_all_centre_quarter_dep_expense_data($cost_centre_id),
			"recordsFiltered" => $active_plus_disposed_total_filtered_centre,//$this->M_report->get_filtered_centre_quarter_dep_expense_data($cost_centre_id),
			"data" => $data
		);
		echo json_encode($output);
	}


	/** Audit report */
	public function select_range()
	{
		$this->load->view('_audit_range');
	}

	public function audit_summary()
	{
		$from_date_mysql_format = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('from_date'))));
		$to_date_mysql_format = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('to_date'))));
		$data['title'] = "Audit report";
		$data['start_date'] = $from_date_mysql_format; //$this->input->post('from_date');
		$data['end_date'] = $to_date_mysql_format; //$this->input->post('to_date');
		$data['audits'] = $this->M_report->get_audit_list($from_date_mysql_format, $to_date_mysql_format);
		$this->load->view('_audit_summary', $data);
	}

	public function export_to_excel()
	{
		//if(isset($_POST["file_content"]))
		///{
		$temporary_html_file = './tmp_html/' . time() . '.html';
		//$nemu = "audit";
		//$temporary_html_file = base_url('uploads/'.$nemu.'.html');//'./tmp_html/'.$nemu.'.html';
		file_put_contents($temporary_html_file, $_POST["file_content"]);

		$reader = IOFactory::createReader('Html');

		$spreadsheet = $reader->load($temporary_html_file);

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

		$filename = time() . '.xlsx';

		$writer->save($filename);

		header('Content-Type: application/x-www-form-urlencoded');

		header('Content-Transfer-Encoding: Binary');

		header("Content-disposition: attachment; filename=\"" . $filename . "\"");

		readfile($filename);

		unlink($temporary_html_file);

		unlink($filename);

		exit;
		//}
	}

}
