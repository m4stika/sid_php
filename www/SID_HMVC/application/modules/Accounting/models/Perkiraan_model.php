<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Perkiraan_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();	
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'perkiraan';
		$this->column_index = 'rekid';
		$this->column_select = '*';
		$this->column_where = array();
		$this->column_order = array('rekid'); 
		$this->column_search = array('rekid','accountno','description');
		$this->order = array('accountno' => 'asc'); // default order 
		$this->hasSelect = false;
	}

	public function get_newAccountNo($key = -1) {
		// Select @Result = isnull(Max(isnull(KeyValue,0)),0) from Perkiraan where ParentKey = @ParentKey  
// set @Result = right(@result,2) + 1  
// select rtrim(@ParentKey)+replicate('0',2-len(@Result))+rtrim(@result) as Hasil
		
		$lastno = $this->db->select_max('keyvalue','maxkey')->where('parentkey',$key)
							->get('perkiraan')
							->row()
							->maxkey;
		$lastno = (!empty($lastno)) ? $lastno : 1;
		$hasil = (strlen($lastno) >= 2) ? substr($lastno, -2)  : 0;
		//($hasil == 0) ? $hasil : 
		$hasil++;
		$hasil = $key.str_pad($hasil,2,'0',STR_PAD_LEFT);
		return $hasil;
	}

	public function get_ListPerkiraanParent($parentkey = -1) {
		$this->db->select('rekid, parentkey, keyvalue, accountno, description, groupacc, classacc, levelacc, balancesheetacc, debitacc, openingbalance, transbalance, balancedue')->where('parentkey',$parentkey);
		$query =  $this->db->get('perkiraan');
		return $query->result();
	}

	public function get_ListPerkiraanKey($keyvalue = -1) {
		if ($keyvalue == -1) return null;
		$this->db->select('rekid, parentkey, keyvalue, accountno, description, groupacc, classacc, levelacc, balancesheetacc, debitacc, openingbalance, transbalance, balancedue')->where('keyvalue',$keyvalue);
		$query =  $this->db->get('perkiraan');
		$result = $query->result_array();
        return (count($result) > 0 ? $result[0] : NULL);
	}

	public function save_PerkiraanItem($data) {
		$flag = $data['flag'];
		$rekid = $data['rekid'];
		unset($data['flag']);
		unset($data['autonumber']);
		unset($data['rekid']);

		if ($flag == 0 || $flag == 2) { //New & Copy
			$output = $this->insert($data);
			//$output = 'YES';
		} else {
			$output = $this->update($rekid, $data);
			//$output = 'OK';
		}

		return $output;
	}

	private function getinfo($id) {
		if (!$this->db->error()['code'] == 0) {
		    $result = $this->db->error()['message']; //'Error! ['.$this->db->error().']';
		} else if (!$this->db->affected_rows()) {
		    $result = 'Error not found';
		} else {
		    $result = 'Success';
		};
		return $result;
	}

	public function delete_PerkiraanItem($data) {
		if($data['levelacc'] == 5) { //Hapus Perkiraan Detail
			//return $data;
			$this->db->delete('perkiraan',array('rekid'=>$data['rekid']));
			$result = $this->getinfo($data['rekid']);
			return $result;
		} else { //hapus perkiraan dan semua turunanya
			//return $data;
			$this->db->like('parentkey',$data['keyvalue'],'after');
			$this->db->delete('perkiraan');
			//$this->db->delete('perkiraan',array('parentkey >='=>$data['keyvalue']));
			$info = $this->getinfo($data['keyvalue']);
			$hasil = false;
			//return $info;

			if ($info == 'Success' || $info == 'Error not found') $hasil = true;
			
			if ($hasil == true ) { //sukses delete turunan perkiraan
				$this->db->reset_query();
				$this->db->delete('perkiraan',array('rekid'=>$data['rekid']));
				$info = $this->getinfo($data['rekid']);
				return $info;
			} else return $info;
		}
	}

	public function get_SearchAccountList($search = "") {
		$this->db->select('rekid, accountno, description, groupacc, classacc, debitacc, balancesheetacc');
		$this->db->where('classacc !=',0);//->like('description',$search);
			if ($search != "") {
				$this->db->group_start();
				$this->db->like('description',$search,'after');
				$this->db->group_end();
			}
		$this->db->order_by('description','asc');
		$this->db->limit(30);
		$query = $this->db->get('perkiraan');
		return $query->result();
	}

}	