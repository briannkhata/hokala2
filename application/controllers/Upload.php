<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
///date_default_timezone_set('Asia/Kolkata');
//require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Upload extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		// Load Model
		$this->load->model('User_model', 'user');
		$this->ip_address    = $_SERVER['REMOTE_ADDR'];
		$this->datetime 	    = date("Y-m-d H:i:s");
	}
	
	public function index() {
	    $this->load->view("index");
	}
	
	public function display() {
    	$data 	= [];
    	$data ["result"] = $this->user->get_all();
    	$this->load->view("index", $data);
    }

	public function import() {
		$path 		= 'documents';
		$json 		= [];
		$this->upload_config($path);
		if (!$this->upload->do_upload('file')) {
			$json = [
				//'error_message' => showErrorMessage($this->upload->display_errors()),
			];
		} else {
			$file_data 	= $this->upload->data();
			$file_name 	= $path.$file_data['file_name'];
			$arr_file 	= explode('.', $file_name);
			$extension 	= end($arr_file);
			if('csv' == $extension) {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} else {
				$reader 	= new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet 	= $reader->load($file_name);
			$sheet_data 	= $spreadsheet->getActiveSheet()->toArray();
			$list 			= [];
			foreach($sheet_data as $key => $val) {
				if($key != 0) {
					$result 	= $this->user->get(["country_code" => $val[2], "mobile" => $val[3]]);
					if($result) {
					} else {
						$list [] = [
							'name'					=> $val[0],
							'country_code'			=> $val[1],
							'mobile'				=> $val[2],
							'email'					=> $val[3],
							'city'					=> $val[4],
							'ip_address'			=> $this->ip_address,
							'created_at' 			=> $this->datetime,
							'status'				=> "1",
						];
					}
				}
			}
			if(file_exists($file_name))
				unlink($file_name);
			if(count($list) > 0) {
				$result 	= $this->user->add_batch($list);
				if($result) {
					$json = [
						//'success_message' 	=> showSuccessMessage("All Entries are imported successfully."),
					];
				} else {
					$json = [
						//'error_message' 	=> showErrorMessage("Something went wrong. Please try again.")
					];
				}
			} else {
				$json = [
					//'error_message' => showErrorMessage("No new record is found."),
				];
			}
		}
		echo json_encode($json);
	}

	public function upload_config($path) {
		if (!is_dir($path)) 
			mkdir($path, 0777, TRUE);		
		$config['upload_path'] 		= './'.$path;		
		$config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096; 
		$this->load->library('upload', $config);
	}
}