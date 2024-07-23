<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Openingbalance_model extends MY_Model {
	//'OB' --Opening Balance
    //'GJ' --General Journal          
    //'AK' --Akad Kredit        
    //'IV' --Inventory           
    //'CB' --Kas & Bank          
	//'FA' --FixedAsset        
	//'BT' --Pembatalan Kontrak    
	//'TK' --Tunai Keras/Bertahap    
    //'OT' --other       

	public function __construct()
	{
		parent::__construct();	
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'journal';
		$this->column_index = 'journalid';
		$this->column_select = '*';
		$this->column_where = array();
		$this->column_order = array('journalid'); 
		$this->column_search = array('journalid','accountno','description');
		$this->order = array('accountno' => 'asc'); // default order 
		$this->hasSelect = false;
	}

	public function getOpeningbalance() {
		
		$this->load->model('journal_model');
		$parameter = $this->journal_model->getLastjournalNo(0);

		$this->db->select("journalid, bulan, tahun, autonum, journalno, DATE_FORMAT(journaldate,'%d %m %Y') as  journaldate, journalremark, dueamount, status, journalgroup")
				 ->where('bulan',$parameter['bulanbuku'])
				 ->where('tahun',$parameter['tahunbuku'])
				 ->where('status',0)
				 ->where('journalgroup',0);
		$query = $this->db->get('journal');
		$result = $query->result_array();
		$hasRecord = (count($result) > 0);
		if ($hasRecord) {
			$journal = $result[0];
		} else {
			$journal = array("journalid" => -1,
							 "bulan" => $parameter['bulanbuku'],
							 "tahun" => $parameter['tahunbuku'],
							 "autonum" => $parameter['autoNumber'],
							 "journalno" => $parameter['journalNo'],
							 "journalgrup" => 0,
							 "journaldate" => '',
							 "journalremark" => 'Account Opening Balance',
							 "dueamount" => 0,
							 "status" => 0,
				);
		}
		

		if ($hasRecord) {
			$this->db->select("indexvalue, rekid, accountno, description, remark, IF(debitacc = 1, amount, 0) as debit, IF(debitacc = 0, amount, 0) as credit")
				 	 ->where('journalid',$journal['journalid']);
			$query = $this->db->get('vjournaldetail');
			$result = $query->result();
			$data = array();
			$no = 0;
	        foreach ($result as $value) {
	            $no++;
	            $row = array("action"=>$value->rekid == 305 ? "lock" : "delete",
	            			 "rekid" => $value->rekid,
	            			 "accountno" => $value->accountno,
	            			 "description" => $value->description,
	            			 "remark" => $value->remark,
	            			 "debit" => $value->debit,
	            			 "credit" => $value->credit);				
				$data[] = $row;
			}
			$journal['detail'] = $data;
		} else {
			$query = $this->db->select('accountno, description')
							  ->where('rekid',305)
							  ->get('perkiraan');
			$ikhtirarLR = $query->result_array()[0];
			$journal['detail'] = array(0 => array("action"=>"lock",
						            			 "rekid" => 305,
						            			 "accountno" => $ikhtirarLR['accountno'],
						            			 "description" => $ikhtirarLR['description'],
						            			 "remark" => 'Account Opening Balance',
						            			 "debit" => 0,
						            			 "credit" => 0));
		}
		
		$journal['hasrecord'] = $hasRecord ? 1 : 0;

		return $journal;
	}
}
?>