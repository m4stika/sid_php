<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Fixedasset extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('fixedasset_model');
	}

	public function index() {		
		$linkaccount = $this->get_ListPerkiraan();
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'fixedasset',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/fixedasset_view',
 				'linkaccount' =>$linkaccount
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function get_ListPerkiraan() {
		$list =  $this->fixedasset_model->getListPerkiraan();
		$states = array("success","info","danger","warning");
		$options = "";
		if (count($list)) {
			foreach ($list as $value) {
				$description = "<span class='label label-{$states[rand(0, 3)]}'> {$value->accountno} </span> {$value->description}";
				$options .= "<option value = '{$value->rekid}' 
								data-value='{\"rekid\":\"{$value->rekid}\",
											 \"accountno\":\"{$value->accountno}\",
											 \"description\":\"{$value->description}\"
											}' 
								data-content=\"{$description} 
										\">
							</option>";
			}
		};
		unset($list, $states);
		return $options;
	}

	public function get_fixedasset_list() {
		$list = $this->fixedasset_model->get_datatables();
		$data = array();
		$no = $_POST['start'];		
        foreach ($list as $value) {
            $no++;
            $row = array();
			$row['action'] = $this->template->add_dropdown(0,$no);
			$row['noid'] = $value->noid;
			$row['namaaktiva'] = $value->namaaktiva;
			$row['bulanperolehan'] = $value->bulanperolehan;
			$row['tahunperolehan'] = $value->tahunperolehan;
			$row['totalharga'] = $value->totalharga;
			$row['usiaekonomis'] = $value->usiaekonomis;
			$row['penyusutanbulan_I'] = $value->penyusutanbulan_I;
			$row['penyusutanbulan_II'] = $value->penyusutanbulan_II;
			$row['akumpenyusutan'] = $value->akumpenyusutan;
			$row['nilaibuku'] = $value->nilaibuku;

			//add html for action
			// $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$typerumah->noid."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
			// 	  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$typerumah->noid."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" =>  $this->fixedasset_model->count_all(),
						"recordsFiltered" => $this->fixedasset_model->count_filtered(),
						"data" => $data
				);
		//output to json format
		echo json_encode($output);
	}

	public function get_fixedasset_detail() {
		$list = $this->fixedasset_model->getfixedasset_detail($this->input->post('id'));
		$no = 0;
		$data = array();
		foreach ($list as $value) {
            $no++;
            $row = array();
   //          $row[] = $no;
			// $row[] = $value->bulansusut;
			// $row[] = $value->tahunsusut;
			// $row[] = $value->tglpenyusutan;
			// $row[] = $value->penyusutan;
			// $row[] = $value->nilaibuku;
			$row['no'] = $no;
			$row['bulansusut'] = $value->bulansusut;
			$row['tahunsusut'] = $value->tahunsusut;
			$row['tglpenyusutan'] = $value->tglpenyusutan;
			$row['penyusutan'] = $value->penyusutan;
			$row['nilaibuku'] = $value->nilaibuku;
			$data[] = $row;
		}
		// $output = array(
		// 				"draw" => $_POST['draw'],
		// 				"recordsTotal" => 10,// $this->fixedasset_model->count_all(),
		// 				"recordsFiltered" =>10,// $this->fixedasset_model->count_filtered(),
		// 				"data" => $data
		// 		);
		echo json_encode($data);
	}

	public function get_fixedasset() {
		$output = $this->fixedasset_model->getfixedasset($this->input->post('id'));
		echo json_encode($output);
	}

	public function save_fixedasset() {
		$output = $this->fixedasset_model->savefixedasset($this->input->post('record'));
		echo json_encode($output);
	}

	public function delete_fixedasset() {
		$output = $this->fixedasset_model->deletefixedasset($this->input->post('noid'));
		echo json_encode($output);
	}
}
?>