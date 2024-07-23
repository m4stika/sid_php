<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Assign_model extends MY_Model {
	//'OB' --Opening Balance
    //'GJ' --General Journal
    //'AK' --Akad Kredit
    //'IV' --Inventory
    //'CB' --Kas & Bank
	//'FA' --FixedAsset
	//'BT' --Pembatalan Kontrak
	//'TK' --Tunai Keras/Bertahap
    //'OT' --other

    const groupCode = array('OB', 'GJ', 'AK', 'IV', 'CB', 'FA', 'BT', 'TK', 'OT');
	const groupDesc = array('Opening Ballance', 'General Journal', 'Akad Jual-Beli', 'Inventory', 'Kas-Bank', 'Fixed Asset', 'Pembatalan', 'Tunai', 'Other');

	public function __construct()
	{
		parent::__construct();
		$this->resetVar();
	}

	private function resetVar() {
		$this->table = 'journal';
		$this->column_index = 'journalid';
		$this->column_select = 'journalid,bulan,tahun,journalgroup,autonum,journalno,journaldate,journalremark,dueamount,dateofposting,status';
		$this->column_where = array();
		$this->column_order = array('journalid');
		$this->column_search = array('journalid','accountno','description');
		$this->order = array('journalid' => 'asc'); // default order
		$this->hasSelect = false;
	}
	private function getParameter() {
		$query = $this->db->select('bulanbuku, tahunbuku, tahunbuku*100+bulanbuku as blthbuku', FALSE)->limit(1)->get('parameter');
		return $query->row();
	}

	public function getassign($param) {
		/*========== START EXTRACT ==============*/
		$output = array("data"=>'', 'countall'=>0, 'countallFiltered'=>0, 'grandtotal'=>0);
		$blthparam = $param->tahun*100+$param->bulan;
		$where = array('journalgroup' => $param->sourceid,
					   'status' => 0,
					   "'tahun*100+bulan' <=" => $blthparam,
					   'journaldate >=' => $param->tanggalfrom,
					   'journaldate <=' => $param->tanggalto);
		// $where = "journalgroup = {$param->sourceid} AND
		// 	      'tahun*100+bulan' <= {$blthparam} AND
		// 		  journaldate >= '{$param->tanggalfrom}' AND
		// 		  journaldate <= '{$param->tanggalto}'";

		$list = $this->get_datatables($where);

		$data = array();
		foreach ($list as $value) {
			$journalheader = array();

			$journalheader['linkid'] = $value->journalid;
			$journalheader['bulan'] = $value->bulan;
			$journalheader['tahun'] = $value->tahun;
			$journalheader['journalgroup'] = $value->journalgroup;
			$journalheader['journalgroupdesc'] = self::groupDesc[$value->journalgroup] ;
			$journalheader['autonum'] = $value->autonum;
			$journalheader['journalno'] = $value->journalno;
			$journalheader['journaldate'] = $value->journaldate;
			$journalheader['journalremark'] = $value->journalremark;
			$journalheader['dueamount'] = (float) $value->dueamount;
			$journalheader['status'] = $value->status;

			$data[] = $journalheader;
		}
		$recordsTotal = $this->count_all($where);
		$recordsFiltered = $this->count_filtered($where);
		$output = array("data"=>$data, 'countall'=>$recordsTotal, 'countallFiltered'=>$recordsFiltered, 'grandtotal'=>0);

		return $output;
	}

	public function getassign_detail($noid) {
		$hasil = $this->db->select('rekid, accountno, description, debitacc, debitpos, amount')
						  ->where('journalid',$noid)
						  ->get('vjournaldetail');
		$hasil = $hasil->result();

		$data = array();
		$no = 0;
		foreach ($hasil as $value) {
			$no++;
			$row = array();
		 	$row['indexvalue'] = $no;
		 	$row['rekid'] = $value->rekid;
		 	$row['accountno'] = $value->accountno;
		 	$row['description'] = $value->description;
		 	$row['debitacc'] = $value->debitacc;
		 	//$row['amount'] = $value->amount;
		 	$row['debit'] = ($value->debitpos == 1) ? $value->amount : 0;
		 	$row['credit'] = ($value->debitpos == 0) ? $value->amount : 0;
		 	$data[] = $row;
		}
		return $data;
	}

	private function reCalculate($item, $first = true) {
		$rekid = $item->rekid;
		$parameter = $this->getParameter();
		$generateLevel0 = function() use ($rekid, $parameter) {
			//---------- Generate HEADER LEVEL-0 jika belum ada Record pada buku besar u/ blth buku bersangkutan
			$this->db->from('bukubesar')
					->where("tahunbuku*100+bulanbuku",$parameter->blthbuku, FALSE);
			$hasil = $this->db->count_all_results();
			if (!$hasil > 0) {
 				$select = $this->db->select("{$parameter->bulanbuku} as bulanbuku, {$parameter->tahunbuku} as tahunbuku, rekid, 0 AS saldoawal, 0 as mutasidebet, 0 as mutasikredit, 0 as saldoakhir")
 									->where('parentkey',-1)
 									->get('perkiraan');

 				if ($select->num_rows()) {
	 				$this->db->insert_batch('bukubesar', $select->result_array());
 				}
			}
		}; //end of generateLevel0

		$generateBukubesar = function() use ($rekid, $parameter) {
			//------ Generate Acc dari detail sampai Header Level 5-1 untuk acc bersangkutan
			$recordExists = function($id, $blth) {
				$this->db->from('bukubesar')
					 ->where("rekid",$id)
					 ->where("tahunbuku*100+bulanbuku",$blth, FALSE);
				return ($this->db->count_all_results() > 0) ? true : false;
			};

			if ($recordExists($rekid, $parameter->blthbuku) == false) {
 				$parent = $this->db->select('rekid, parentkey')->where("rekid",$rekid)->get('perkiraan')->row();

				while ($parent->parentkey != '-1') {
					if ($parent->rekid == $rekid) {
						$this->db->insert('bukubesar',
	 							array('bulanbuku'=>$parameter->bulanbuku,
	 								  'tahunbuku'=>$parameter->tahunbuku,
	 								  'rekid'=>$parent->rekid,
	 								  'saldoawal'=>0,
	 								  'mutasidebet'=>0,
	 								  'mutasikredit'=>0,
	 								  'saldoakhir'=>0));
					} else {
						if ($recordExists($parent->rekid, $parameter->blthbuku) == false) {
							$this->db->insert('bukubesar',
	 							array('bulanbuku'=>$parameter->bulanbuku,
	 								  'tahunbuku'=>$parameter->tahunbuku,
	 								  'rekid'=>$parent->rekid,
	 								  'saldoawal'=>0,
	 								  'mutasidebet'=>0,
	 								  'mutasikredit'=>0,
	 								  'saldoakhir'=>0));
					 	}
					 }
					$parent = $this->db->select('rekid, parentkey')->where("keyvalue",$parent->parentkey)->get('perkiraan')->row();
				}
			}
		}; //end of generateBukuBesar

		$output = false;
		if ($first == true) {$generateLevel0();}
		$generateBukubesar();

		//Proses Update
		$parent = $this->db->select('rekid, parentkey, debitacc')->where("rekid",$rekid)->get('perkiraan')->row();
		while ($parent->parentkey != '-1') {
			$saldoawal = ($item->journalgroup == 0) ? $item->amount : 0;

			if ($saldoawal == 0) {
				$mutasidebet = ($item->journalgroup == 0) ? 0 : $item->amount;
				$mutasidebet = ($item->debitacc == 1) ? $item->amount : 0;
				$mutasikredit = ($item->journalgroup == 0) ? 0 : $item->amount;
				$mutasikredit = ($item->debitacc == 0) ? $item->amount : 0;
			} else {$mutasidebet = 0; $mutasikredit = 0;}


			//Update Mutasi
			$this->db->where('rekid',$parent->rekid)
					 ->where("tahunbuku*100+bulanbuku",$parameter->blthbuku, FALSE)
					 ->set('saldoawal', "saldoawal + {$saldoawal}", FALSE)
					 ->set('mutasidebet',"mutasidebet + {$mutasidebet}", FALSE)
					 ->set('mutasikredit', "mutasikredit + {$mutasikredit}", FALSE)
					 ->update('bukubesar');

			//Update Saldo Akhir
			$this->db->where('rekid',$parent->rekid)
					 ->where("tahunbuku*100+bulanbuku",$parameter->blthbuku, FALSE);
			if ($parent->debitacc == '1') {
				$this->db->set('saldoakhir', "saldoawal + mutasidebet - mutasikredit" , FALSE);
			} else {
				$this->db->set('saldoakhir', "saldoawal + mutasikredit - mutasidebet" , FALSE);
			}
				$this->db->update('bukubesar');

			$saldoawal = 0; $mutasidebet = 0; $mutasikredit = 0;
			$parent = $this->db->select('rekid, parentkey, debitacc')->where("keyvalue",$parent->parentkey)->get('perkiraan')->row();
		}
		$output = true;
		return $output;
	} //end of reCalculate

	public function saveassign() {
		$list = json_decode($this->input->post('record'));
		$hasil = false;
		//$data = array();
		foreach ($list as $value) {
			$detail = $this->db->select('rekid, accountno, description, debitacc, amount')
						  ->where('journalid',$value->linkid)
						  ->get('vjournaldetail')
						  ->result();
			$first = true;
			foreach ($detail as $item) {
				// $row = array();
				// $row['rekid'] = $item->rekid;
				// $row['accountno'] = $item->accountno;
				// $row['group'] = $value->journalgroup;
				// $data[] = $row;
				$item->journalgroup = $value->journalgroup;

				$hasil = $this->reCalculate($item, $first);
				$first = false;
			}

			//Update Status Pada Journal
			if ($hasil == true) {
				$this->db->where('journalid',$value->linkid)
						 ->set('status', 4)
						 ->update('journal');
			}
		}
		//return $data;
		return ($hasil == true) ? 'OK' : 'error';
	}
}
?>