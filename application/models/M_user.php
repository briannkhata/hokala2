<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_months()
	{
		$this->db->select('*');
		$this->db->from('tbl_months');
		$query = $this->db->get()->result_array();
		return $query;
	}

	function get_month_name($month_id)
	{
		$this->db->select('*');
		$this->db->where('month_id', $month_id);
		$result = $this->db->get('tbl_months')->row();
		if ($result == NULL) {
			return "";
		} else {
			return $result->month;
		}
	}

	function get_years()
	{
		$this->db->select('*');
		$this->db->from('tbl_years');
		$query = $this->db->get()->result_array();
		return $query;
	}

	function get_users()
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('user_id !=', $this->session->userdata('user_id'));
		$query = $this->db->get()->result_array();
		return $query;
	}

	function get_user_by_id($user_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get()->result_array();
		return $query;
	}

	function get_user_to_login($username, $password)
	{
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->where('deleted', 0);
		$query = $this->db->get();
		return $query;
	}


	function get_name($user_id)
	{
		$this->db->select('name');
		$this->db->where('user_id', $user_id);
		$result = $this->db->get('tbl_users')->row();
		if ($result == NULL) {
			return "";
		} else {
			return $result->name;
		}
	}

	function get_user_shop($user_id)
	{
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$result = $this->db->get('tbl_users')->row();
		if ($result == NULL) {
			return "";
		} else {
			return $result->shop_id;
		}
	}

	function get_shop_address()
	{
		$this->db->select('address, phone, alt_phone, logo,company,email,alt_email');
		$this->db->from('tbl_settings');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	function get_user_id($user_id)
	{
		return $this->get_column_value($user_id, 'user_id');
	}

	function get_emp_no($user_id)
	{
		return $this->get_column_value($user_id, 'emp_no');
	}

	function get_firstname($user_id)
	{
		return $this->get_column_value($user_id, 'firstname');
	}

	function get_surname($user_id)
	{
		return $this->get_column_value($user_id, 'surname');
	}

	function get_phone($user_id)
	{
		return $this->get_column_value($user_id, 'phone');
	}

	function get_centre_id($user_id)
	{
		return $this->get_column_value($user_id, 'centre_id');
	}

	function get_username($user_id)
	{
		return $this->get_column_value($user_id, 'username');
	}

	function get_password($user_id)
	{
		return $this->get_column_value($user_id, 'password');
	}

	function get_deleted($user_id)
	{
		return $this->get_column_value($user_id, 'deleted');
	}

	function get_role_id($user_id)
	{
		return $this->get_column_value($user_id, 'role_id');
	}

	function get_gender($user_id)
	{
		return $this->get_column_value($user_id, 'gender');
	}

	function get_address($user_id)
	{
		return $this->get_column_value($user_id, 'address');
	}

	function get_added_by($user_id)
	{
		return $this->get_column_value($user_id, 'added_by');
	}

	// Generic function to retrieve a specific column value
	private function get_column_value($user_id, $column_name)
	{
		$this->db->select($column_name);
		$this->db->where('user_id', $user_id);
		$result = $this->db->get('tbl_users')->row();
		return ($result != NULL) ? $result->$column_name : "";
	}
}


