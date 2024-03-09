<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
		$data['page_title'] = "User List";
		$this->load->view('user/_list', $data);
	}

	function config()
	{
		$data['page_title'] = "Configurations";
		$this->load->view('user/_config', $data);
	}

	function get_user_form_data(){
		$data['name'] = $this->input->post('name');
		$data['phone'] = $this->input->post('phone');
		$data['username'] = $this->input->post('username');
		$data['role'] = $this->input->post('role');
		$data['added_by'] = $this->session->userdata('user_id');
		return $data;
    }

	function get_user_db_data($update_id){
		$query = $this->M_user->get_user_by_id($update_id);
		foreach ($query as $row) {
			$data['name'] = $row['name'];
			$data['phone'] = $row['phone'];
			$data['username'] = $row['username'];
			$data['role'] = $row['role'];
		}
		return $data;
	}

	function read(){
		$update_id = $this->uri->segment(3);
		if(!isset($update_id)){
			$update_id = $this->input->post('update_id',$update_id);
		}
		if(is_numeric($update_id)){
			$data = $this->get_user_db_data($update_id);
			$data['update_id'] = $update_id;
		}
		else{
			$data = $this->get_user_form_data();
		}

		$data['page_title'] = "Create User";
		$this->load->view('user/_form',$data);			
	}

	function change_password(){
		$data['page_title'] = "Change Password";
		$this->load->view('user/_change_password',$data);			
	}

	function save_password_change(){
		$data['password'] = MD5($this->input->post('password')); 
		$this->db->where('user_id',$this->session->userdata('user_id'));
		$this->db->update('tbl_users',$data);
		redirect('User');
		$this->session->set_flashdata('message','Password changed successfully!');
	}

	function save(){
		$data = $this->get_user_form_data();
		$update_id = $this->input->post('update_id', TRUE);
        
		if (!empty($_FILES['photo']['name'])) {
			$upload_dir = './uploads/users/'; 
			$uploaded_file = $upload_dir . basename($_FILES['photo']['name']);
			if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaded_file)) {
				$data['photo'] = $uploaded_file;
			} else {
				//$error = "File upload failed. Please try again.";
				// Handle the upload error (e.g., show an error message)
				//$this->session->set_flashdata('error', $error);
				//redirect('User/create');
			}
		}

		if (!empty($this->input->post('password'))) {
			$data['password'] = MD5($this->input->post('password')); 
		}


		if (isset($update_id)){
			$this->db->where('user_id',$update_id);
			$this->db->update('tbl_users',$data);
		 }else{
			$this->db->insert('tbl_users',$data);
		}
			if($update_id !=''):
    			redirect('User');
			else:
				redirect('User/read');
			endif;
			$this->session->set_flashdata('message','User saved successfully!');
	}

	function delete($param=""){
		$data['deleted'] = 1;
		$this->db->where('user_id',$param);
        $this->db->update('tbl_users',$data);
    	$this->session->set_flashdata('message','User removed successfully!');
		redirect('User');
	}


	function save_settings(){
		$id = $this->input->post('id');
		$data['company'] = $this->input->post('company');
		$data['email'] = $this->input->post('email');
		$data['alt_email'] = $this->input->post('alt_email');
		$data['phone'] = $this->input->post('phone');
		$data['alt_phone'] = $this->input->post('alt_phone');
		$data['address'] = $this->input->post('address');
		$this->db->where('id',$id);
		$this->db->update('tbl_settings',$data);
    	$this->session->set_flashdata('message','Settings Successfully!');
		redirect('User/config');
    }

}