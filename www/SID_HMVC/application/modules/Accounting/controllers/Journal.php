<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Journal extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('journal_model');
	}

	public function index() {		
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'journal',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/journal_view',
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function Extract_index() {		
		$data = array(				
				'title'		=> 'SID | Accounting',
				'page' 		=> 'accounting', 
 				'content'	=> 'extract',
 				'isi' 		=> 'Accounting/accounting_page',
 				'pagecontent' => 'Accounting/journal_extract',
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function get_journal() {
		$output =  $this->journal_model->getJournal();
		echo json_encode($output);
	}

	public function save_journal() {
		$output =  $this->journal_model->saveJournal();
		echo json_encode($output);
	}

	public function get_LastjournalNo() {
		$output = $this->journal_model->getLastjournalNo($this->input->post('journalgroup'));
		echo json_encode($output); 
	}

	public function get_Listjurnal() {
		$list = $this->journal_model->getListjurnal();
		$no=0;
		$data = array();
		foreach ($list as $value) {
            $no++;
            $row = array();
			($value->status < 3) ? $row['action'] = $this->template->add_dropdown(0,$no) : $row['action'] =  $this->template->add_dropdown(1,$no);
			//$row['action'] = 'delete';
			$row['journalid'] = $value->journalid;
			$row['journalgroup'] = $value->journalgroup;
			$row['journalno'] = $value->journalno;
			$row['journaldate'] = $value->journaldate;
			$row['dueamount'] = $value->dueamount;
			$row['journalremark'] = $value->journalremark;
			$row['status'] = $value->status;
			 $data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->journal_model->count_all(),
						"recordsFiltered" => $this->journal_model->count_filtered(),
						"data" => $data
				);
		$this->journal_model->resetVar();

		//output to json format
		echo json_encode($output);
	}
}	