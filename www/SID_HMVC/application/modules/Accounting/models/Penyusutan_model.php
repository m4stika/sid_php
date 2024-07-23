<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyusutan_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();	
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'fixedasset';
		$this->column_index = 'noid';
		$this->column_select = 'noid, namaaktiva, usiaekonomis, penyusutanbulan_I, penyusutanbulan_II, totalharga, akumpenyusutan, nilaibuku';
		$this->column_where = array();
		$this->column_order = array('','noid','namaaktiva','','totalharga','usiaekonomis','','akumpenyusutan','nilaibuku'); 
		$this->column_search = array('noid','namaaktiva');
		$this->order = array('noid' => 'asc'); // default order 
		$this->hasSelect = false;
	}

	function parseFloat($value) {
        return floatval(preg_replace('#^([-]*[0-9\.,\' ]+?)((\.|,){1}([0-9-]{1,3}))*$#e', "str_replace(array('.', ',', \"'\", ' '), '', '\\1') . '.\\4'", $value));
    }

	public function getpenyusutan() {
		$query = $this->db->select('bulanbuku, tahunbuku, tahunbuku*100+bulanbuku as blthbuku',FALSE)->limit(1)->get('parameter');
		$parameter = $query->result_array()[0];

		$output = $this->db->select($this->column_select)
						->where('tahunsusut*100+bulansusut <=',$parameter['blthbuku'],FALSE)
						->where('nilaibuku !=',0)
						->group_start()
						->where('tanggalproses is null',null, false)
						->or_where('tahunproses*100+bulanproses <',$parameter['blthbuku'],FALSE)
						->group_end()
						->get('fixedasset')
						->result();

		//$output = $this->find_all('noid','asc');
		return $output;
	}

	public function savepenyusutan() {
		$query = $this->db->select('bulanbuku, tahunbuku, tahunbuku*100+bulanbuku as blthbuku',FALSE)->limit(1)->get('parameter');
		$parameter = $query->result_array()[0];

		$list = $this->getpenyusutan();
		$colinsert = array();
		//$data = array();
		$this->table = 'susutfixasset';
		foreach ($list as $value) {
			$penyusutantemp = (int) $value->akumpenyusutan;
			$penyusutantemp = ($penyusutantemp === 0) ? (int) $value->penyusutanbulan_I : (int) $value->penyusutanbulan_II;
			$penyusutantemp = ($penyusutantemp > (int) $value->nilaibuku) ? (int) $value->nilaibuku : $penyusutantemp;

			// $tanggal = getdate();
			// $d = $todayh['mday'];
		 //    $m = $todayh['mon'];
		 //    $y = $todayh['year'];

		    $tglpenyusutan = $parameter['tahunbuku'].'-'.$parameter['bulanbuku'].'-28';

			$colinsert['bulansusut'] = $parameter['bulanbuku'];
			$colinsert['tahunsusut'] = $parameter['tahunbuku'];
			$colinsert['noaktiva'] = $value->noid;
			$colinsert['penyusutan'] = $penyusutantemp;
			$colinsert['tglpenyusutan'] = $tglpenyusutan; // date("Y-n-j");
			$colinsert['nilaibuku'] = (int) $value->nilaibuku - $penyusutantemp;
			
			//$data[] = $colinsert;

			$this->insert($colinsert);

			//Update FixedAsset
			$this->db->set('akumpenyusutan',"akumpenyusutan + $penyusutantemp",FALSE)
					 ->set('nilaibuku',"nilaibuku - $penyusutantemp",FALSE)
					 ->set('bulanproses',$parameter['bulanbuku'])
					 ->set('tahunproses',$parameter['tahunbuku'])
					 ->set('tanggalproses',date("Y-n-j"))
					 ->where('noid',$value->noid)	
					 ->update('fixedasset');
		}
		$this->resetVar();
		return 'OK';
	}
}
?>	