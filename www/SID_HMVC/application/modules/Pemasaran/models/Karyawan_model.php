<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();	
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'karyawan';
		$this->column_index = 'noid';
		$this->column_select = 'noid, nama, alamat, notelp, nohp, jabatan';
		$this->column_where = array();
		$this->column_order = array('','noid','nama','alamat','notelp','nohp','jabatan'); 
		$this->column_search = array('noid','nama','alamat');
		$this->order = array('noid' => 'asc'); // default order 
		$this->hasSelect = false;
	}
}
?>	