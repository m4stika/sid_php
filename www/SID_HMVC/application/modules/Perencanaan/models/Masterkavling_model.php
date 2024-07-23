<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterkavling_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();		
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'masterkavling';
		$this->column_index = 'noid';
		$this->column_select = 'noid, blok, nokavling, idtyperumah, typerumah, keterangan,  luasbangunan, luastanah, kelebihantanah, sudut, hadapjalan, fasum, statusbooking';
		$this->column_order = array('','noid','noid', 'blok', 'nokavling', 'keterangan', 'typerumah'); //set column field database for datatable orderable
		$this->column_search = array('noid','noid', 'blok', 'nokavling', 'keterangan', 'typerumah'); //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->order = array('typerumah' => 'asc'); // default order 
	}
}
