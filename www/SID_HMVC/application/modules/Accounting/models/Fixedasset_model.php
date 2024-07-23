<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fixedasset_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();	
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'fixedasset';
		$this->column_index = 'noid';
		$this->column_select = 'noid, namaaktiva, bulanperolehan, tahunperolehan, usiaekonomis, penyusutanbulan_I, penyusutanbulan_II, totalharga, akumpenyusutan, nilaibuku';
		$this->column_where = array();
		$this->column_order = array('','noid','namaaktiva','','totalharga','usiaekonomis','','akumpenyusutan','nilaibuku'); 
		$this->column_search = array('noid','namaaktiva');
		$this->order = array('noid' => 'asc'); // default order 
		$this->hasSelect = false;
	}

	public function getfixedasset($id) {
		$this->table = 'vfixedasset';
		$this->column_select = 'noid, namaaktiva, bulanperolehan, tahunperolehan, harga, qty, totalharga, usiaekonomis, penyusutanbulan_I, penyusutanbulan_II, bulansusut, tahunsusut, akumpenyusutan, nilaibuku, accaktiva, accaktiva_accountno, accaktiva_description, accakumulasi, accakumulasi_accountno, accakumulasi_description, akunbiaya, akunbiaya_accountno, akunbiaya_description';
		$output = $this->find_id($id);
		$this->resetVar();
		return $output;
	}

	public function getfixedasset_detail($id) {
		$this->table = 'susutfixasset';
		$this->column_index = 'noaktiva';
		$this->column_select = 'bulansusut, tahunsusut, tglpenyusutan, penyusutan, nilaibuku';
		$output = $this->find_result($id);
		$this->resetVar();
		return $output;
	}

	public function getListPerkiraan() {
		$this->db->select('rekid, accountno, description')->where('classacc',1);
		$query =  $this->db->get('perkiraan');
		return $query->result();
	}

	public function savefixedasset($data) {
		$data = json_decode($data);
		$noid = $data->noid;
		$flag = $data->flag;
		$output = 'error';
		//$this->table = 'fixedasset';

		unset($data->flag);
		unset($data->noid);
		unset($data->accaktiva_accountno);
		unset($data->accaktiva_description);
		unset($data->accakumulasi_accountno);
		unset($data->accakumulasi_description);
		unset($data->akunbiaya_accountno);
		unset($data->akunbiaya_description);
		if ($flag == 0 || $flag == 2) {
			//New & Copy
			$this->insert($data);
			$output = 'OK';
		} else {
			//Editing
			$this->update($noid, $data);
			$output = 'OK';
		}
		return $output;
	}

	public function deletefixedasset($id) {
		//$this->table = 'fixedassets';
		$hasil = $this->delete($id);
		$hasil = ($hasil == false) ? 'error' : 'OK';
		return $hasil;
	}
}
?>	