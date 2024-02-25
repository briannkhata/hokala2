<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct(){
        parent::__construct();
    }

	function check_session(){
		if ($this->session->userdata('user_login') != 1)//not logged in
		redirect(base_url(), 'refresh');
	}

	public function index(){
		$this->check_session();
		$data['page_title'] = "Dashboard";
		$this->load->view('dashboard/_dashboard',$data);
	}



	
}