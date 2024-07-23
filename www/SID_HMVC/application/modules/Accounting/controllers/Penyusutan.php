<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Penyusutan extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('penyusutan_model');
	}

	public function index() {		
		//$linkaccount = $this->get_ListPerkiraan();
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'penyusutan',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/penyusutan_view'
 				//'linkaccount' =>$linkaccount
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function get_penyusutan() {
		$list = $this->penyusutan_model->getpenyusutan();
		$data = array();
		$no = 0;
        foreach ($list as $value) {
            $no++;
            $row = array();
            //'noid, namaaktiva, usiaekonomis, penyusutanbulan_I, penyusutanbulan_II, totalharga, akumpenyusutan, nilaibuku'
			$row['noid'] = $value->noid;
			$row['namaaktiva'] = $value->namaaktiva;
			$row['totalharga'] = $value->totalharga;
			$row['usiaekonomis'] = $value->usiaekonomis;
			$row['penyusutanbulan_I'] = $value->penyusutanbulan_I;
			$row['penyusutanbulan_II'] = $value->penyusutanbulan_II;
			$row['akumpenyusutan'] = $value->akumpenyusutan;
			$row['nilaibuku'] = $value->nilaibuku;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->penyusutan_model->count_all(),
						"recordsFiltered" => $this->penyusutan_model->count_all(),
						"data" => $data
				);
		//output to json format
		echo json_encode($output);
	}

	public function save_penyusutan() {
		$hasil = $this->penyusutan_model->savepenyusutan();
		echo json_encode($hasil);
	}
}
?>