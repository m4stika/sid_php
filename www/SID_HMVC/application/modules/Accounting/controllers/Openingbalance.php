<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Openingbalance extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('openingbalance_model');
	}

	public function index() {		
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'openingbalance',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/opening-ballance-view',
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function get_openingbalance() {
		$output = $this->openingbalance_model->getOpeningbalance();
		echo json_encode($output);
	}

	public function save_journal() {
		$this->load->model('journal_model');
		$output =  $this->journal_model->saveJournal();
		echo json_encode($output);
	}
}
?>