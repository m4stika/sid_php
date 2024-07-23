<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Typerumah_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();	
		$this->table = 'typerumah';
		//$this->vtable = 'typerumah';
		$this->column_index = 'noid';
		$this->column_select = 'noid, typerumah, keterangan , luasbangunan,luastanah';
		$this->column_order = array('','noid','typerumah','keterangan','luasbangunan','luastanah'); //set column field database for datatable orderable
		$this->column_search = array('','noid','typerumah','keterangan'); //set column field database for datatable searchable just firstname , lastname , address are searchable
		$this->order = array('typerumah' => 'asc'); // default order 
	}

	public function get_linkaccount($noid)
	{
		$this->column_select = 'noid,typerumah,penerimaankpracc,bookingfeeacc,uangmukaacc,kltacc, posisisudutacc, hadapjlnutamaacc,hadapfasumacc,redesignbangunanacc,tambahkwalitasacc,pekerjaantambahacc,hargajualacc,bookingfeeacc1, uangmukaacc1, kltacc1,posisisudutacc1,hadapjlnutamaacc1,hadapfasumacc1,redesignbangunanacc1,tambahkwalitasacc1,pekerjaantambahacc1, hargajualacc1,piutangacc1, hppacc,persediaanacc,plafonkpr';
		return $this->find_row_id($noid);
	}

	public function get_list() {
		$this->column_select = 'noid,typerumah,keterangan,luasbangunan,luastanah,hargajual,bookingfee,hargaklt,hargasudut,
				hargahadapjalan,hargafasum,diskon,uangmuka, hpp, plafonkpr';
		return $this->find_all();
	}

	public function get_list_export() {
		$this->column_select = 'noid,typerumah as "type rumah",keterangan,luasbangunan as "Luas Bangungan",luastanah as "luas tanah",hargajual as "harga jual",bookingfee as "booking fee",hargaklt as "harga KLT",hargasudut as "harga sudut",
				hargahadapjalan as "H. hadap jln",hargafasum as "harga fasum",diskon,uangmuka as "uang muka", hpp, plafonkpr as "plafon KPR"';
		return $this->find_all_array();
	}

}
