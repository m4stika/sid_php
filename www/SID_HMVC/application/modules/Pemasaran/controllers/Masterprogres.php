<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Masterprogres extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('MY_Model','masterprogres');
		$this->masterprogres->table = 'masterprogreskpr';
		$this->masterprogres->column_index = 'noid';
		$this->masterprogres->column_select = 'noid, namaprogres';
		$this->masterprogres->column_order = array('','noid','namaprogres'); //set column field database for datatable orderable
		$this->masterprogres->column_search = array('noid','namaprogres');
		$this->masterprogres->order = array('noid' => 'asc'); // default order 
	}

	public function get_list()
	{		
		$list = $this->masterprogres->get_datatables();				
		$data = array();
		$no = $_POST['start'];		
        foreach ($list	as $value) {
			$no++;
			$value->action = $no;
			
			//memasukan array ke variable $data
			$data[] = $value;				
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->masterprogres->count_all(),
						"recordsFiltered" => $this->masterprogres->count_filtered(),
						"data" => $data
				);
		//output to json format
		echo json_encode($output);
	}

	public function get_record() //Request Data untuk keperluan Editing
	{
		$data =  $this->masterprogres->find_id($_POST['noid']);			
		$output = array('hasil' => 'OK', 
						'data' => $data
			);		
		echo json_encode($output);
	}	

	public function set_crud()
	{
		$colinsert                       = array();
		$colinsert["namaprogres"]        = $this->input->post('namaprogres');				
		switch ($this->input->post('status')) {
			case 'new':
				//proses Penyimpanan Data Baru
				$output = $this->masterprogres->insert($colinsert);
				break;
			case 'edit':
				//proses Penyimpanan Data hasil koreksi
				$output = $this->masterprogres->update($this->input->post('noid'), $colinsert);
				break;
			default:
				//proses Penyimpanan Data Baru dari hasil Copy
				$output = $this->masterprogres->insert($colinsert);
				break;
		}
		
		echo json_encode($output);
	}

	public function set_delete() //Proses Delete Data
	{
		$hasil =  $this->masterprogres->delete($_POST['noid']);
		echo json_encode(array("status" => $hasil));
	}	
}	