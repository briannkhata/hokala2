<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	public function __construct(){
        parent::__construct();
		if ($this->session->userdata("user_login") != 1) {
            redirect(base_url(), "refresh");
        }
    }

	function index(){
		$data['page_title'] = "Departments";
		$data['fetch_data'] = $this->M_department->get_departments();
		$data['menu_id'] = $this->M_role->get_menu_id_by_name('department');
		$this->load->view('department/_list',$data);
	}

	function get_department_form_data(){
        $data['department_name'] = $this->input->post('department_name');
		$data['centre_id'] = $this->input->post('centre_id');
		return $data;
    }

	function get_department_db_data($update_id){
		$query = $this->M_department->get_department_by_id($update_id);
		foreach ($query as $row) {
		  $data['department_name'] = $row['department_name'];
		  $data['centre_id'] = $row['centre_id'];
		}
		return $data;
	}

	function read(){
		$update_id = $this->uri->segment(3);
		if(!isset($update_id)){
			$update_id = $this->input->post('update_id',$update_id);
		}
		if(is_numeric($update_id)){
			$data = $this->get_department_db_data($update_id);
			$data['update_id'] = $update_id;
		}
		else{
			$data = $this->get_department_form_data();
		}
		$data['page_title'] = "Create Department";
		$this->load->view('department/_form',$data);			
	}

	function save(){
		$data = $this->get_department_form_data();
		$update_id = $this->input->post('update_id', TRUE);
        
		if (isset($update_id)){
			$this->db->where('department_id',$update_id);
			$this->db->update('tbl_departments',$data);
		 }else{
			$this->db->insert('tbl_departments',$data);
		}
			if($update_id !=''):
    			redirect('Department');
			else:
				redirect('Department/create');
			endif;
			$this->session->set_flashdata('message','Department Saved Successfully!');
	}

	function delete($department_id){
		$data['deleted'] = 1;
		$this->db->where('department_id',$department_id);
        $this->db->update('tbl_departments',$data);
    	$this->session->set_flashdata('message','Department Removed Successfully!');
		redirect('Department');
	}

}
