<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
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
		$data['page_title'] = "Categories";
		$this->load->view('category/_list', $data);
	}

	function get_cat_form_data()
	{
		$data['category'] = $this->input->post('category');
		$data['un_code'] = $this->input->post('un_code');
		$data['desc'] = $this->input->post('desc');
		return $data;
	}

	function get_cat_db_data($update_id)
	{
		$query = $this->M_category->get_category_by_id($update_id);
		foreach ($query as $row) {
			$data['category'] = $row['category'];
			$data['un_code'] = $row['un_code'];
			$data['desc'] = $row['desc'];
		}
		return $data;
	}

	function read()
	{
		$update_id = $this->uri->segment(3);
		if (!isset($update_id)) {
			$update_id = $this->input->post('update_id', $update_id);
		}
		if (is_numeric($update_id)) {
			$data = $this->get_cat_db_data($update_id);
			$data['update_id'] = $update_id;
		} else {
			$data = $this->get_cat_form_data();
		}
		$data['page_title'] = "Create Category";
		$this->load->view('category/_form', $data);
	}

	function save()
	{
		$data = $this->get_cat_form_data();
		$update_id = $this->input->post('update_id', TRUE);

		if (isset($update_id)) {
			$this->db->where('category_id', $update_id);
			$this->db->update('tbl_category', $data);
		} else {
			$this->db->insert('tbl_category', $data);
		}
		if ($update_id != ''):
			redirect('Category');
		else:
			redirect('Category/read');
		endif;
		$this->session->set_flashdata('message', 'Category saved successfully!');
	}

	function delete($param = "")
	{
		$data['deleted'] = 1;
		$this->db->where('category_id', $param);
		$this->db->update('tbl_category', $data);
		$this->session->set_flashdata('message', 'Category Removed successfully!');
		redirect('Category');
	}


}
