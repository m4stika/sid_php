<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();	
		$this->reset_param();
	}

	public function reset_param() {
		$this->table = 'kwitansi';
		$this->column_index = 'noid';
		$this->column_select = '*';
		$this->column_order = array(); 
		$this->column_search = array();
		$this->order = array('noid' => 'asc'); // default order 	
	}

	public function get_history($arWhere)
	{
		$this->table = 'vkwitansi';
		$this->column_order = array('','noid','tglbayar','keterangan', 'description', 'totalbayar');
		$this->column_search = array('','noid','keterangan', 'description', 'totalbayar');
		$this->order = array('tglbayar' => 'asc');
		$hasil = $this->get_datatables($arWhere);		
		return $hasil;
	}

	private function get_kwitansiNo()
	{
		//var $idcompany, $lastno;
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
    	$bulan = $array_bulan[date('n')];
    	$tahun = date('Y');

		$this->db->select('companyid')->from('parameter');
		$idcompany = $this->db->get()->row()->companyid;
		$lastno = $this->db->select_max('noid','maxnoid')->get('kwitansi')->row()->maxnoid+1;
		//$lastno1 = (!empty($lastno)) ? $lastno++ : 1;

		$nokwitansi = str_pad($lastno,5,'0',STR_PAD_LEFT).'/'.$idcompany.'/'.$bulan.'/'.$tahun;
		return $nokwitansi;
	}

	public function save_kwitansi() {
		$nokwitansi = $this->get_kwitansiNo();
		$colinsert                       = array();
		$this->reset_param();
		$colinsert['idpemesanan'] 	= $this->input->post('idpemesanan');
		$colinsert['nokwitansi'] 	= $nokwitansi;
		$colinsert['nobukti'] 	= $this->input->post('nobukti');
		$colinsert['tglbayar'] 	= $this->input->post('tglpembayaran');
		$colinsert['totalbayar'] 	= $this->input->post('total');
		$colinsert['keterangan'] 	= $this->input->post('keterangan');
		$colinsert['accbank'] 	= $this->input->post('accbank');
		$colinsert['kodeupdated'] 	= 'O';
		$colinsert['statusbatal'] 	= 0;
		$colinsert['statuspengembalian'] 	= 'O';

		$output = $this->insert($colinsert); //Insert Header Kwitansi

		if ($output > 0) { //Save Rincian Kwitansi
			$sukses = false;
			$colinsert                       = array();
			$arPenerimaan = array();
			$colupdate = array();
			$CI =& get_instance();
         	$CI->load->model('perencanaan/typerumah_model');
			//$this->load->model('perencanaan/typerumah_model');
			$linkacc = $this->typerumah_model->get_linkaccount($this->input->post('idtyperumah'));
			//$linkacc = modules::run('perencanaan/typerumah/get_linkaccount',$this->input->post('idtyperumah'));

			if ($this->input->post('bookingfee') > 0) {
				$data = array(0, $this->input->post('bookingfee'), 'Pembayaran booking Fee', $linkacc->bookingfeeacc1);
				$arPenerimaan[] = $data;
				$items = array('field' => 'bookingfeeonp', 'value' => $this->input->post('bookingfee'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['bookingfeeonp'] = $this->input->post('bookingfee');
			} 
			if ($this->input->post('uangmuka') > 0) {
				$data = array(1, $this->input->post('uangmuka'), 'Pembayaran Uang Muka', $linkacc->uangmukaacc1);
				$arPenerimaan[] = $data;
				$items = array('field' => 'uangmukaonp', 'value' => $this->input->post('uangmuka'), 'inc' => true );
				$colupdate[] = $items;
				$items = array('field' => 'bayaruangmukake', 'value' => 1, 'inc' => true );
				$colupdate[] = $items;
				$items = array('field' => 'tglbayaruangmuka', 'value' => $this->input->post('tglpembayaran'), 'inc' => false );
				$colupdate[] = $items;
				//$colupdate['uangmukaonp'] = $this->input->post('uangmuka');
				//$colupdate['bayaruangmukake'] = 1;
				//$colupdate['tglbayaruangmuka'] = $this->input->post('tglpembayaran');
			}
			if ($this->input->post('hargaklt') > 0) {
				$data = array(2, $this->input->post('hargaklt'), 'Pembayaran Kelebihan Tanah', $linkacc->kltacc1);
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargakltonp', 'value' => $this->input->post('hargaklt'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargakltonp'] = $this->input->post('hargaklt');
			}
			if ($this->input->post('hargasudut') > 0) {
				$data = array(3, $this->input->post('hargasudut'), 'Pembayaran Harga Sudut', $linkacc->posisisudutacc1);
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargasudutonp', 'value' => $this->input->post('hargasudut'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargasudutonp'] = $this->input->post('hargasudut');
			}
			if ($this->input->post('hargahadapjalan') > 0) {
				$data = array(4, $this->input->post('hargahadapjalan'), 'Pembayaran Hadap Jalan');
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargahadapjalanonp', 'value' => $this->input->post('hargahadapjalan'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargahadapjalanonp'] = $this->input->post('hargahadapjalan');
			}
			if ($this->input->post('hargafasum') > 0) {
				$data = array(5, $this->input->post('hargafasum'), 'Pembayaran Posisi Taman');
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargafasumonp', 'value' => $this->input->post('hargafasum'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargafasumonp'] = $this->input->post('hargafasum');
			}
			if ($this->input->post('hargaredesign') > 0) {
				$data = array(6, $this->input->post('hargaredesign'), 'Pembayaran Redesign Bangunan');
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargaredesignonp', 'value' => $this->input->post('hargaredesign'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargaredesignonp'] = $this->input->post('hargaredesign');
			}
			if ($this->input->post('hargatambahkwalitas') > 0) {
				$data = array(7, $this->input->post('hargatambahkwalitas'), 'Pembayaran Tambah Kwalitas');
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargatambahkwonp', 'value' => $this->input->post('hargatambahkwalitas'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargatambahkwonp'] = $this->input->post('hargatambahkwalitas');
			}
			if ($this->input->post('hargapekerjaantambah') > 0) {
				$data = array(8, $this->input->post('hargapekerjaantambah'), 'Pembayaran Penambahan Kontruksi');
				$arPenerimaan[] = $data;
				$items = array('field' => 'hargakerjatambahonp', 'value' => $this->input->post('hargapekerjaantambah'), 'inc' => true );
				$colupdate[] = $items;
				//$colupdate['hargakerjatambahonp'] = $this->input->post('hargapekerjaantambah');
			}
			if ($this->input->post('totalangsuran') > 0) {
				$data = array(9, $this->input->post('totalangsuran'), 'Pembayaran Angsuran');
				$arPenerimaan[] = $data;
				$items = array('field' => 'totalhargaonp', 'value' => $this->input->post('totalangsuran'), 'inc' => true );
				$colupdate[] = $items;
				$items = array('field' => 'bayarangsuranke', 'value' => 1, 'inc' => true );
				$colupdate[] = $items;
				$items = array('field' => 'tglbayarangsuran', 'value' => $this->input->post('tglpembayaran'), 'inc' => false );
				$colupdate[] = $items;
				//$colupdate['totalhargaonp'] = $this->input->post('totalangsuran');
				//$colupdate['bayarangsuranke'] = 1;
				//$colupdate['tglbayarangsuran'] = $this->input->post('tglpembayaran');
			}

			$nourut = 1;
			$noid = $output;
			foreach ($arPenerimaan as $key => $value) {
				$colinsert['noid'] 	= $noid;
				$colinsert['nourut'] 	= $nourut;
				$colinsert['jenispenerimaan'] 	= $value[0];
				$colinsert['jumlahbayar'] 	= $value[1];
				$colinsert['keterangan'] 	= $value[2];
				$colinsert['linkacc'] 	= $value[3];

				$this->table = 'rinciankwitansi';
				$output = $this->insert($colinsert);  //Insert Header Kwitansi
				$this->table = 'kwitansi';
				// $this->save_rinciankwitansi($colinsert);
				$sukses = true;
				$nourut++;
			}
		} // end of rincian kwitansi
		
		//----------- UPDATE PEMESANAN 
		if ($sukses) {
			$this->table = 'pemesanan';
			$this->column_index = 'noid';
			$this->update_col($this->input->post('idpemesanan'), $colupdate);
			$this->reset_param();
		}
		return $sukses;
	}

	public function get_kwitansi($noid) {
		$this->table = 'vkwitansi';
		$this->column_select = "noid, nokwitansi, DATE_FORMAT(tglbayar,'%d %M %Y') as tglbayar, namapemesan, alamatpemesan, alamatpemesan1, keterangan, description, totalbayar, CONCAT(0) as totterbilang";
		return $this->find_id($noid);
		$this->reset_param();
	}

	public function get_kwitansiHeader($noid) {
		$this->table = 'vkwitansi';
		$this->column_select = "noid, nokwitansi, DATE_FORMAT(tglbayar,'%d %M %Y') as tglkwitansi, idpemesanan, nopesanan, namapemesan, alamatpemesan, idkavling, blok, nokavling, idtyperumah, typerumah, kettyperumah, keterangan, rekid, accountno, description, totalbayar, kodeupdated, statusbatal, statustransaksi";
		return $this->find_id($noid);
		$this->reset_param();
	}

	public function get_kwitansiDetail($noid) {
		$sql = "noid, jenispenerimaan, jumlahbayar, keterangan, linkacc, accountno, description";
		$query = $this->db->select($sql)->from('vrinciankwitansi')->where('noid',$noid)->order_by('nourut','asc')->get();
		return $query->result();
	}

	public function save_batalkwitansi() {
		$sukses = false;
		//return $_POST['noid'];

		$this->table = 'kwitansi';
		$this->column_select = "idpemesanan, kodeupdated";
		$datarecord =  $this->find_id($_POST['noid']);
		$this->reset_param();

		//$query = $this->db->select('idpemesanan, kodeupdated')->from('kwitansi')->where('noid',$_POST['noid'])->get();
		//$datarecord = $query->result_array();
		//$datarecord = (count($datarecord) > 0) ? $datarecord : Null;
		if ($datarecord == null) return false;

		//return $datarecord['idpemesanan'];

		if ($datarecord['kodeupdated'] == 'O') { //Status Transaksi OPEN masih bisa di delete
			$idpemesanan = $datarecord['idpemesanan'];
			$this->db->select('noid, jenispenerimaan, jumlahbayar')->from('rinciankwitansi')->where('noid',$_POST['noid']);
			$rincian = $this->db->get()->result();
			
			$this->db->reset_query();
			$sukses = $this->db->where('noid',$_POST['noid'])->delete('rinciankwitansi');
			if ($sukses) {
				$this->db->reset_query();
				$sukses = $this->db->where('noid',$_POST['noid'])->delete('kwitansi');
			}

			if ($sukses) { //Update Pemesanan
				$arrjenispenerimaan = array(0=>"bookingfeeonp", "uangmukaonp", "hargakltonp", "hargasudutonp", "hargahadapjalanonp", "hargafasumonp", "hargaredesignonp", "hargatambahkwonp", "hargakerjatambahonp", "totalangsuranonp");

				$colupdate = array();

				foreach ($rincian as $value) {
					$items = array('field' => $arrjenispenerimaan[$value->jenispenerimaan], 'value' => $value->jumlahbayar, 'dec' => true );
					$colupdate[] = $items;
					if ($value->jenispenerimaan == 1) { //Uang Muka
						$items = array('field' => 'bayaruangmukake', 'value' => 1, 'dec' => true );
						$colupdate[] = $items;
					}
					if ($value->jenispenerimaan == 9) { // Total Angsuran
						$items = array('field' => 'bayarangsuranke', 'value' => 1, 'dec' => true );
						$colupdate[] = $items;
					} 
				};
				$this->table = 'pemesanan';
				$this->column_index = 'noid';
				$sukses = $this->update_col($idpemesanan, $colupdate);
				$this->reset_param();

				//$sukses = $this->update_pemesanan($idpemesanan, $colupdate);
				unset($arrjenispenerimaan);
				unset($colupdate);
			} //end of update pemesanan
		} //end of transaksi OPEN
		else { //transaksi Status = "Closed" tidak bisa di delete
			$colupdate = array();
			$colupdate['idkwitansi'] = $_POST['noid'];
			$colupdate['idpemesanan'] = $_POST['idpemesanan'];
			$colupdate['nobukti'] = $_POST['nobukti'];
			$colupdate['nocek'] = $_POST['nomorcek'];
			$colupdate['tglbatal'] = $_POST['tglbatal'];
			$colupdate['totalbatal'] = $_POST['totalbayar'];
			$colupdate['keterangan'] = $_POST['alasanbatal'];
			$colupdate['kodeupdated'] = "O";
			$colupdate['accbank'] = $_POST['cbbankout'];

			$this->table = 'kwitansibtl';
			$hasil = $this->insert($colupdate);
			unset($colupdate);
			
			$sukses = ($hasil > 0) ? true : false;

			if ($sukses) { //Update Kwitansi Status Batal = 1
				$this->column_index = 'noid';
				$this->table = 'kwitansi';
				$sukses = $this->update($_POST['noid'], array('statusbatal'=>1));
				
				// $this->db->where('noid',$_POST['noid'])
				// 		->set('statusbatal',1)
				// 		->update('kwitansi');

			}

		}

		return $sukses;
	}

}
