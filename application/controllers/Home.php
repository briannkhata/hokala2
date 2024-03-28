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
		$password = MD5($this->input->post('password'));
		$user = $this->M_user->get_user_to_login($username, $password);

		if ($user->num_rows() > 0) {
			$row = $user->row();

			$data = [
				'name' => $row->name,
				'user_id' => $row->user_id,
				'email' => $row->username,
				'role' => $row->role,
				'shift_id' =>$this->M_shift->get_current_shift(),
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

	function logout(){
		session_destroy();
		$this->load->view('_login');
		redirect('Home','refresh');
    }


}