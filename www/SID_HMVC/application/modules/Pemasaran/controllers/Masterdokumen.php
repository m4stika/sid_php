<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Masterdokumen extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('MY_Model','masterdoc');		
		$this->masterdoc->table = 'masterdokumen';
		$this->masterdoc->column_index = 'noid';
		$this->masterdoc->column_select = 'noid, namadokumen, dokumenumum, dokumenpegawai, dokumenprofesional, dokumenwiraswasta';
		$this->masterdoc->column_order = array('','noid','namadokumen'); //set column field database for datatable orderable
		$this->masterdoc->column_search = array('noid','namadokumen');
		$this->masterdoc->order = array('noid' => 'asc'); // default order 
	}

	public function index() {
	 	$data = array(				
				'title'		=> 'SID | Master Dokumen & Progress',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'masterdokumen', 				
 				'isi' 		=> 'Pemasaran/master_dokumen_progress_view'
 				//'datatable' => $this->get_list()
 			);
	 	$this->template->admin_template($data);
	}

	public function get_list() //Request Data untuk tampilan Grid Datatable
	{
		$list = $this->masterdoc->get_datatables();
		$data = array();
		$no = $_POST['start'];		
        foreach ($list	as $value) { 
			$no++;
        	$value->action = $no;
        	$data[] = $value;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->masterdoc->count_all(),
						"recordsFiltered" => $this->masterdoc->count_filtered(),
						"data" => $data
				);
		//output to json format
		echo json_encode($output);
	}

	public function get_record() //Request Data untuk keperluan Editing
	{
		$data =  $this->masterdoc->find_id($_POST['noid']);			
		$output = array('hasil' => 'OK', 
						'data' => $data
			);		
		echo json_encode($output);
	}	

	public function set_crud()
	{
		//$this->load->helper('array');
		//$colinsert = elements(array('namadokumen','','',''),$_POST)
		$colinsert                       = array();
		$colinsert["namadokumen"]        = $this->input->post('namadokumen');
		$colinsert["dokumenumum"]        = 0;
		$colinsert["dokumenpegawai"]     = 0;
		$colinsert["dokumenprofesional"] = 0;
		$colinsert["dokumenwiraswasta"]  = 0;
		if(!empty($this->input->post('check_list'))) {
			$checked_count = $this->input->post('check_list');
			foreach ($this->input->post('check_list') as $value) {
				//$res = $value;
				if ($value == "1") {$colinsert["dokumenumum"] = 1;}
				elseif ($value == "2") {$colinsert["dokumenpegawai"] = 1;}
				elseif ($value == "3") {$colinsert["dokumenprofesional"] = 1;}
				elseif ($value == "4") {$colinsert["dokumenwiraswasta"] = 1;}
			};
		};
		switch ($this->input->post('status')) {
			case 'new':
				//proses Penyimpanan Data Baru
				$output = $this->masterdoc->insert($colinsert);
				break;
			case 'edit':
				//proses Penyimpanan Data hasil koreksi
				$output = $this->masterdoc->update($this->input->post('noid'), $colinsert);
				break;
			default:
				//proses Penyimpanan Data Baru dari hasil Copy
				$output = $this->masterdoc->insert($colinsert);
				break;
		}
		
		echo json_encode($output);
	}

	public function set_delete() //Proses Delete Data
	{
		$hasil =  $this->masterdoc->delete($_POST['noid']);
		echo json_encode(array("status" => $hasil));
	}	
}	