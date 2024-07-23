<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Extract extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('extract_model');
	}

	public function index() {		
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'extract',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/journal_extract',
 			);
	 	$this->template->admin_template($data);
	}

	public function get_extract() {
		$param = (object) $this->input->post();
		$list = $this->extract_model->getextract($param);
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $list['countall'],
						"recordsFiltered" => $list['countallFiltered'],
						"data" => $list['data'],
						"grandtotal" => $list['grandtotal']
						//"parameter" => $list['parameter']
				);
		
		echo json_encode($output);
	}

	public function get_extract_detail() {
		$param = (object) $this->input->post();
		$output = $this->extract_model->getextract_detail($param);
		echo json_encode($output);
	}

	public function save_extract() {
		$result = $this->extract_model->saveextract();
		echo json_encode($result);
	}
}
?>	