<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	function __construct(){
        parent::__construct();
		if ($this->session->userdata("user_login") != 1) {
            redirect(base_url(), "refresh");
        }
    }

	function index(){
		$data['page_title'] = "Suppliers";
		$this->load->view('supplier/_list',$data);
	}

	function get_supplier_form_data(){
        $data['name'] = $this->input->post('name');
		$data['address'] = $this->input->post('address');
		$data['phone'] = $this->input->post('phone');
		return $data;
    }

	function get_supplier_db_data($update_id){
		$query = $this->M_supplier->get_supplier_by_id($update_id);
		foreach ($query as $row) {
		  $data['name'] = $row['name'];
		  $data['address'] = $row['address'];
		  $data['phone'] = $row['phone'];
		}
		return $data;
	}

	function read(){
		$update_id = $this->uri->segment(3);
		if(!isset($update_id)){
			$update_id = $this->input->post('update_id',$update_id);
		}
		if(is_numeric($update_id)){
			$data = $this->get_supplier_db_data($update_id);
			$data['update_id'] = $update_id;
		}
		else{
			$data = $this->get_supplier_form_data();
		}

		$data['page_title'] = "Create supplier";
		$this->load->view('supplier/_form',$data);			
	}

	function save(){
		$data = $this->get_supplier_form_data();
		$update_id = $this->input->post('update_id', TRUE);
        
		if (isset($update_id)){
			$this->db->where('supplier_id',$update_id);
			$this->db->update('tbl_suppliers',$data);
		 }else{
			$this->db->insert('tbl_suppliers',$data);
		}
			if($update_id !=''):
    			redirect('Supplier');
			else:
				redirect('Supplier/read');
			endif;
			$this->session->set_flashdata('message','Supplier saved successfully!');
	}

	function delete($supplier_id){
		$data['deleted'] = 1;
		$this->db->where('supplier_id',$supplier_id);
        $this->db->update('tbl_suppliers',$data);
    	$this->session->set_flashdata('message','Supplier removed successfully!');
		redirect('Supplier');
	}

}
