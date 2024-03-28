<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {

	function __construct(){
        parent::__construct();
		if ($this->session->userdata("user_login") != 1) {
            redirect(base_url(), "refresh");
        }
    }

	function index(){
		$data['page_title'] = "Roles";
		$this->load->view('role/_role_list',$data);
	}

	function get_cat_form_data(){
        $data['role'] = $this->input->post('role');
		return $data;
    }

	function get_cat_db_data($update_id){
		$query = $this->M_role->get_role_by_id($update_id);
		foreach ($query as $row) {
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
			$data = $this->get_cat_db_data($update_id);
			$data['update_id'] = $update_id;
		}
		else{
			$data = $this->get_cat_form_data();
		}
		$data['page_title'] = "Create Role";
		$this->load->view('role/_add_role',$data);			
	}

	function save(){
		$data = $this->get_cat_form_data();
		$update_id = $this->input->post('update_id', TRUE);
        
		if (isset($update_id)){
			$this->db->where('role_id',$update_id);
			$this->db->update('tbl_roles',$data);
		 }else{
			$this->db->insert('tbl_roles',$data);
		}
			if($update_id !=''):
    			redirect('Role');
			else:
				redirect('Role/read');
			endif;
			$this->session->set_flashdata('message','Role saved successfully!');
	}

	function delete($param=""){
		$data['deleted'] = 1;
		$this->db->where('role_id',$param);
        $this->db->update('tbl_role',$data);
    	$this->session->set_flashdata('message','Role removed successfully!');
		redirect('Role');
	}


}
