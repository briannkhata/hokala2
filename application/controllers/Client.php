<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
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
		$data['page_title'] = "Clients";
		$this->load->view('client/_list', $data);
	}
	function get_client_form_data()
	{
		$data['name'] = $this->input->post('name');
		$data['address'] = $this->input->post('address');
		$data['phone'] = $this->input->post('phone');
		return $data;
	}
	
	function save_client()
	{
		$data = $this->get_client_form_data();
		$this->db->insert('tbl_clients', $data);
		$client_id = $this->db->insert_id();
		$response = array(
			'status' => 'success',
			'client_id' => $client_id
		);
		return json_encode($response);
	}

	function get_client_db_data($update_id)
	{
		$query = $this->M_client->get_client_by_id($update_id);
		foreach ($query as $row) {
			$data['name'] = $row['name'];
			$data['address'] = $row['address'];
			$data['phone'] = $row['phone'];
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
			$data = $this->get_client_db_data($update_id);
			$data['update_id'] = $update_id;
		} else {
			$data = $this->get_client_form_data();
		}

		$data['page_title'] = "Create client";
		$this->load->view('client/_form', $data);
	}

	function save()
	{
		$data = $this->get_client_form_data();
		$update_id = $this->input->post('update_id', TRUE);

		if (isset($update_id)) {
			$this->db->where('client_id', $update_id);
			$this->db->update('tbl_clients', $data);
		} else {
			$this->db->insert('tbl_clients', $data);
		}
		if ($update_id != ''):
			redirect('Client');
		else:
			redirect('Client/read');
		endif;
		$this->session->set_flashdata('message', 'Client saved successfully!');
	}

	function delete($client_id)
	{
		$data['deleted'] = 1;
		$this->db->where('client_id', $client_id);
		$this->db->update('tbl_clients', $data);
		$this->session->set_flashdata('message', 'Client removed successfully!');
		redirect('Client');
	}

	function view($param = '')
	{
		$data['page_title'] = "Client Details";
		$data['client_id'] = $param;
		$this->load->view('client/_details', $data);
	}

}
