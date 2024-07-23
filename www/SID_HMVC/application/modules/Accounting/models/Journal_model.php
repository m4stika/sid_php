<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Journal_model extends MY_Model {
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

	public function getJournal() {
		$this->db->select("journalid, journalno, DATE_FORMAT(journaldate,'%d %m %Y') as  journaldate, journalremark, dueamount, status, journalgroup")
				 ->where('journalid',$this->input->post('id'));
		$query = $this->db->get('journal');
		$result = $query->result_array();
		$journal = count($result) > 0 ? $result[0] : NULL;

		if (!$journal == NULL) {
			//this->db->select("indexvalue, rekid, accountno, description, remark, IF(debitacc = 1, IFNULL(format(amount,2),0), 0) as debit, IF(debitacc = 0, IFNULL(format(amount,2),0), 0) as credit")

			$this->db->select("indexvalue, rekid, accountno, description, remark, IF(debitpos = 1, amount, 0) as debit, IF(debitpos = 0, amount, 0) as credit")
				 	 ->where('journalid',$this->input->post('id'));
			$query = $this->db->get('vjournaldetail');
			$result = $query->result();
			$data = array();
			$no = 0;
	        foreach ($result as $value) {
	            $no++;
	            $row = array();// $value;
				// $row[] = ($_POST['crud'] == 'edit') ? "<a class='lock label label-danger' data-value=''>lock</a>" : "<a class='delete label label-info' data-value=''>delete</a>";
				//$debit = $value->debit;
				$row['action'] = "lock"; // "<a class='lock label label-danger' data-value=''>lock</a>";
				$row['rekid'] = $value->rekid;
				$row['accountno'] = $value->accountno;
				$row['description'] = $value->description;
				$row['remark'] = $value->remark;
				// $row['debit'] = "<input type='text' class='mask_decimal' name='debit' data = '{$value->debit}' value='{$value->debit}'/>";
				// $row['credit'] = "<input type='text' class='mask_decimal' name='credit' value='{$value->credit}'/>";
				$row['debit'] = $value->debit;
				$row['credit'] = $value->credit;
				$data[] = $row;
			}
			$journal['detail'] = $data;
		}
		return $journal;
	}

	public function saveJournal() {
		$dataHeader = json_decode($this->input->post('datajson'));
		$detail = $dataHeader->detail;

		$colinsert = array();
		$colinsert['bulan'] = $dataHeader->bulan;
		$colinsert['tahun'] = $dataHeader->tahun;
		$colinsert['journalGroup'] = $dataHeader->journalGroup;
		$colinsert['autonum'] = $dataHeader->journalAutonum;
		$colinsert['journalNo'] = $dataHeader->journalNo;
		$colinsert['journaldate'] = $dataHeader->journaldate;
		$colinsert['journalRemark'] = $dataHeader->journalRemark;
		$colinsert['dueamount'] = $dataHeader->totalDebit;
		$colinsert['dateofposting'] = date("Y-n-j");
		$colinsert['status'] = 0;

		//handle New or Copy
		if ($dataHeader->journalFlag == 0 || $dataHeader->journalFlag == 2) {
			$lastid = $this->insert($colinsert);
		} else {
			//handle edit
			//$colinsert['journalid'] = $dataHeader->journalId;
			$sukses = $this->update($dataHeader->journalId, $colinsert);
			$lastid = 0;
			//if ($sukses == true)
			$lastid = $dataHeader->journalId;
		}


		if ($lastid > 0) {
			$this->table = 'journaldetil';
			//delete old record if editing
			if ($dataHeader->journalFlag == 1) {
				$this->delete($lastid);
			}

			//Insert Detail
			$data = array();
			$no = 0;
			foreach ($detail as $key => $value) {
			 	$row = array();
			 	$no++;
			 	$row['indexvalue'] = $no;
			 	$row['journalId'] = $lastid;
			 	$row['debitacc'] = ($value->debit > 0) ? 1 : 0;
			 	$row['amount'] = ($value->debit > 0) ? $value->debit : $value->credit;
			 	$row['remark'] = $value->remark;
			 	$row['rekid'] = $value->rekid;
			 	$data[] = $row;
			};

			$this->insert_batch($data);
			$this->table = 'journal';
		};
		return $lastid;
	}

	public function getLastjournalNo($group) {
		$groupDescription = array('OB', 'GJ', 'AK', 'IV', 'CB', 'FA', 'BT', 'TK', 'OT');

		$query = $this->db->select('bulanbuku, tahunbuku, tahunbuku*100+bulanbuku as blthbuku', FALSE)->limit(1)->get('parameter');
		$parameter = $query->result_array()[0];

		$lastno = $this->db->select_max('autonum','maxnumber')->where('journalGroup',$group)
							->get('journal')
							->row()
							->maxnumber;
		$lastno = (!empty($lastno)) ? $lastno + 1 : 1;
		$journalNo = $groupDescription[$group].'-'.str_pad($lastno,6,'0',STR_PAD_LEFT);
		return array('autoNumber'=>$lastno, 'journalNo' => $journalNo, 'bulanbuku'=>$parameter['bulanbuku'], 'tahunbuku'=>$parameter['tahunbuku'], 'blthbuku'=>$parameter['blthbuku']);
	}

	public function getListjurnal() {
		$this->table = 'journal';
		$this->column_search = array('journalid','status','journalgroup');
		$this->column_order = array('','journalid','status','journaldate','journalno','totaltransaksi','dueamount');
		$this->order = array('journalid'=>'asc');
		$this->column_select = 'journalid, journalgroup, journalno, journaldate, dueamount, journalremark, status';
		$this->column_where = array();
		$hasil = $this->get_datatables();
		return $hasil;
	}
}