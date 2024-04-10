<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends CI_Controller
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
		$data['page_title'] = "Settings";
		$this->load->view('config/_config', $data);
	}

	function save()
	{
		$id = $this->input->post('id');
		$data['company'] = $this->input->post('company');
		$data['email'] = $this->input->post('email');
		$data['alt_email'] = $this->input->post('alt_email');
		$data['phone'] = $this->input->post('phone');
		$data['alt_phone'] = $this->input->post('alt_phone');
		$data['address'] = $this->input->post('address');
		$data['vat_status'] = $this->input->post('vat_status');
		$data['vat'] = $this->input->post('vat');

		if (!empty($_FILES['logo']['name'])) {
			$uploadDir = './assets/uploads/';
			$uploadFile = $uploadDir . basename($_FILES['logo']['name']);
			$imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
			$allowedTypes = array('jpg', 'jpeg', 'png');
			if (in_array($imageFileType, $allowedTypes)) {
				if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
					$data['logo'] = $uploadFile;
				} else {
					$this->session->set_flashdata('error', 'Error uploading file!');
					redirect('Config');
				}
			} else {
				$this->session->set_flashdata('error', 'Invalid file type. Allowed types: JPG, JPEG, PNG');
				redirect('Config');
			}
		}

		$this->db->where('id', $id);
		$this->db->update('tbl_settings', $data);
		$this->session->set_flashdata('message', 'Settings Successfully!');
		redirect('Config');
	}

}