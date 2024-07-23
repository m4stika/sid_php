<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Assign extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('assign_model');
	}

	public function index() {		
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'assign',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/journal_assign',
 			);
	 	$this->template->admin_template($data);
	}

	public function get_assign() {
		$param = (object) $this->input->post();
		$list = $this->assign_model->getassign($param);
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

	public function get_assign_detail() {
		//$param = (object) $this->input->post();
		$output = $this->assign_model->getassign_detail($this->input->post('linkid'));
		echo json_encode($output);
	}

	public function save_assign() {
		$result = $this->assign_model->saveassign();
		echo json_encode($result);
	}
}
?>	