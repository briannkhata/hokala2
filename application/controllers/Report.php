<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata("user_login") != 1) {
			redirect(base_url(), "refresh");
		}
	}

	function receivings_report()
	{
		$data['page_title'] = "Sales Report";
		$this->load->view('report/_receiving_report', $data);
	}

	function filter_receivings()
	{
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");
		$data['fetch_data'] = $this->M_report->get_receivings_by_date($start_date, $end_date);
		$data['page_title'] = "Receivings Report | ". date('d F Y',strtotime($start_date)) ." To ".date('d F Y',strtotime($end_date));
		$this->load->view('report/_refresh_receivings', $data);
	}

	function sales_report()
	{
		$data['page_title'] = "Sales Report";
		$this->load->view('report/_sales_report', $data);
	}

	function filter_sales()
	{
		$start_date = $this->input->post("start_date");
		$end_date = $this->input->post("end_date");
		$data['fetch_data'] = $this->M_report->get_sales_by_date($start_date, $end_date);
		$data['page_title'] = "Sales Report | ". date('d F Y',strtotime($start_date)) ." To ".date('d F Y',strtotime($end_date));
		$this->load->view('report/_refresh_sales', $data);
	}
	function inventory_report()
	{
		$data['page_title'] = "Inventory Report";
		$this->load->view('report/_inventory_report', $data);
	}

	function filter_inventory_report()
	{
		$data['shop_id'] = $this->input->post("shop_id");
		$data['warehouse_id'] = $this->input->post("warehouse_id");
		$data['page_title'] = "Inventory Report";
		$this->load->view('report/_refresh_inventory_report', $data);
	}

	function expired()
	{
		$data['page_title'] = "Expired Products";
		$this->load->view('report/_expired', $data);
	}

	function expiring()
	{
		$data['page_title'] = "Expiring Products";
		$this->load->view('report/_expiring', $data);
	}

	function running_low()
	{
		$data['page_title'] = "Running Low Products";
		$this->load->view('report/_running_low', $data);
	}

	function depleted()
	{
		$data['page_title'] = "Depleted Products";
		$this->load->view('report/_depleted', $data);
	}

}
