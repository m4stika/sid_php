<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Karyawan extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('karyawan_model');
	}

	public function index() {		
		$data = array(				
				'title'		=> 'SID | Pemasaran',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'karyawan',
 				'isi' 		=> 'Pemasaran/karyawan_view'
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function get_list() {
		$list = $this->karyawan_model->get_datatables();
		$data = array();
		$no = $_POST['start'];		
        foreach ($list as $value) {
            $no++;
            $value->action = $no;
			$data[] = $value;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->karyawan_model->count_all(),
						"recordsFiltered" => $this->karyawan_model->count_filtered(),
						"data" => $data
				);

		//output to json format
		echo json_encode($output);
	}

	public function delete_record() {
		$hasil = $this->karyawan_model->delete($this->input->post('noid'));
		$hasil = ($hasil == false) ? 'error' : 'OK';
		echo json_encode($hasil);
	}

	public function save_record() {
		parse_str($this->input->post('record'), $data);
		// $colinset = array("nama"=>$this->input->post('nama'),"alamat"=>$this->input->post('alamat'), "nohp"=>$this->input->post('nohp'), "notelp"=>$this->input->post('notelp'), "jabatan"=>$this->input->post('jabatan'));

		if ($data['flag'] == 0 || $data['flag'] == 2) {
			unset($data['flag']);
			unset($data['noid']);
			$hasil = $this->karyawan_model->insert($data);
		} else {
			$noid = $data['noid'];
			unset($data['noid']);
			unset($data['flag']);
			$hasil = $this->karyawan_model->update($noid,$data);
		}

		$hasil = ($hasil > 0) ? 'OK' : 'error';
		echo json_encode($hasil);
	}
}
?>	