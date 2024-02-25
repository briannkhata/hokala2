<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$data['page_title'] = "Login";
		//$this->db->truncate('tbl_audited_assets_temp');
		$this->load->view('_login', $data);
	}

	function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user = $this->M_user->get_user_to_login($username, $password);

		if ($user->num_rows() > 0) {
			$row = $user->row();

			$data = [
				'firstname' => $row->firstname,
				'surname' => $row->surname,
				'status' => $row->status,
				'user_id' => $row->user_id,
				'email' => $row->username,
				'role_id' => $row->role_id,
				'name' => $row->firstname . ' ' . $row->surname,
				'user_login'=>1
			];
			$this->session->set_userdata($data);
			redirect('Dashboard');
		} else {
			$data['page_title'] = 'Login';
			$this->session->set_flashdata('message', 'Invalid Username or Password');
			$this->load->view('_login', $data);
		}
	}


	function save()
	{
		$data['first_name'] = $this->input->post('first_name');
		$data['surname'] = $this->input->post('surname');
		$data['username'] = $this->input->post('email');
		$data['password'] = md5($this->input->post('password'));
		$data['gender'] = $this->input->post('gender');
		$data['role_id'] = $this->input->post('role_id');
		$data['centreID'] = $this->input->post('centreID');
		$data['address'] = $this->input->post('address');
		$data['empNo'] = $this->input->post('empNo');
		$data['added_by']= $this->session->userdata('user_id');
		$this->db->insert('tbl_users', $data);
		$this->session->set_flashdata('Message', 'Employee added successful!');
		redirect('User');
	}

	function logout(){
		session_destroy();
		$this->load->view('_login');
		redirect('Home','refresh');
    }


}