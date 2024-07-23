<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();	
		$this->reset_param();
	}

	public function reset_param() {
		$this->table = 'pemesanan';
		//$this->vtable = 'vpemesanan';
		$this->column_index = 'noid';
		$this->column_select = '*';
		$this->column_order = array('','noid', 'nopesanan', 'polapembayaran', 'statustransaksi', 'namapemesan','blok','nokavling','typerumah','hargajual');//, 'nokavling','typerumah','ketStatusbooking');
		$this->column_search = array('noid','nopesanan','namapemesan', 'blok', 'nokavling','typerumah');
		$this->order = array('noid' => 'asc'); // default order 
	}

	public function getlist_dokumenpemesanan($id = -1, $type = 0) 
	{		
		switch ($type) {
			case 0: //Pegawai
				$where = array('dokumenpegawai' => 1);
				break;
			case 1: //Profesional
				$where = array('dokumenprofesional' => 1);
				break;
			default:
				$where = array('dokumenwiraswasta' => 1);
				break;
		}

		if ($id == -1) {
			$this->db->select('noid, namadokumen, 0 as status,  "" as tglpenyerahan')->from('masterdokumen')->where('dokumenumum',1)->or_where($where);
		} else {
			$this->db->select('m.noid, m.namadokumen, d.status, d.tglpenyerahan')->from('masterdokumen m')->join('dokumenpemesanan d', 'd.noiddokumen = m.noid and d.noidpemesanan = '.$id, 'left')->where('dokumenumum',1)->or_where($where);
		}
		
		$query = $this->db->get();
		return $query->result();
	}

	public function get_listpemesanan()
	{
		$this->table = 'vpemesanan';
		$this->column_select = 'noid, nopesanan, namapemesan, keterangan';		
		$hasil = $this->find_all();
		$this->reset_param();
		return $hasil;
	}

	public function save_doc($data)
	{
		$this->table = 'dokumenpemesanan';
		$hasil = $this->insert($data);
		$this->table = 'pemesanan';
		return $hasil;
	}

	public function delete_doc_by_id($id)
	{
		$this->table = 'dokumenpemesanan';
		//$this->column_index = 'noidpemesanan';
		$idwhere = array('noidpemesanan' => $id);
		$rowcount = $this->count_all($idwhere);
		$this->reset_param();
		if ($rowcount <= 0) return true;
		return $this->delete($id);
	}

	public function delete_pemesananbyID($noid = -1) {
		$this->db->select('nokavling')->from('pemesanan')->where('noid',$noid);
		$idkavling = $this->db->get()->row()->nokavling;

		//hapus dokumen pemesanan
		$this->db->where('noidpemesanan',$noid)->delete('dokumenpemesanan');
		$this->db->reset_query();

		//hapus data pemesanan
		$this->db->where('noid',$noid)->delete('pemesanan');
		$this->db->reset_query();

		//Kembalikan Statusbooking Kavling ke status Open
		$this->db->where('noid',$idkavling)->set('statusbooking',0)->update('masterkavling');
		$this->db->reset_query();
		
		return true;
	}

	public function pembatalan() {
		//noid,idpemesanan,nobukti,tglbatal,keterangan,uangmuka,klt,sudut,hadapjalan,fasum,redesign,tambahkw,kerjatambah,total,accbank,kodeupdated,kodeupdatedgl,hargadasar
		$colinsert = array();
		$colinsert['idpemesanan'] = $this->input->post('noid');
		$colinsert['nobukti'] = $this->input->post('nobukti');
		$colinsert['tglbatal'] = $this->input->post('tglbatal');
		$colinsert['keterangan'] = $this->input->post('alasanbatal');
		$colinsert['uangmuka'] = intval($this->input->post('uangmuka'));
		$colinsert['klt'] = intval($this->input->post('hargaklt'));
		$colinsert['sudut'] = intval($this->input->post('hargasudut'));
		$colinsert['hadapjalan'] = intval($this->input->post('hargahadapjalan'));
		$colinsert['fasum'] = intval($this->input->post('hargafasum'));
		$colinsert['redesign'] = intval($this->input->post('hargaredesign'));
		$colinsert['tambahkw'] = intval($this->input->post('hargatambahkwalitas'));
		$colinsert['kerjatambah'] = intval($this->input->post('hargapekerjaantambah'));
		$colinsert['hargadasar'] = intval($this->input->post('totalangsuran'));
		$colinsert['total'] = intval($this->input->post('total'));
		$colinsert['accbank'] = $this->input->post('cbbankout');
		$this->table = 'pembatalan';
		$output = $this->pemesanan_model->insert($colinsert);

		if ($output) {
			$this->db->where('noid',$this->input->post('noid'))->set('statustransaksi',4)->update('pemesanan');
			$this->db->reset_query();
			
			$this->db->where('noid',$this->input->post('nokavling'))->set('statusbooking',0)->update('masterkavling');
			$this->db->reset_query();
		}

		return $output;

		// if ($this->input->post('total') == 0) {
		// 	return false;
		// } else {
		// 	return true;
		// }
	}

	// private function set_StatusBooking($noid=-1, $status = 0) {
	// 	$this->where('noid',$noid)->set('statusbooking',$status)->update('masterkavling');
	// }

	public function save_pemesanan() {
			//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'
			$colinsert                       = array();
			
			//return $detail;

			$colinsert["namapemesan"]        = $this->input->post('namapemesan');			
			$colinsert["alamatpemesan"]      = $this->input->post('alamatpemesan');
			$colinsert["rtrwpemesan"]      = $this->input->post('rtrwpemesan');
			$colinsert["kelurahanpemesan"]      = $this->input->post('kelurahanpemesan');
			$colinsert["kecamatanpemesan"]      = $this->input->post('kecamatanpemesan');
			$colinsert["kabupatenpemesan"]      = $this->input->post('kabupatenpemesan');
			$colinsert["telprumahpemesan"]      = $this->input->post('telprumahpemesan');
			$colinsert["telpkantorpemesan"]      = $this->input->post('telpkantorpemesan');
			$colinsert["hp1pemesan"]      = $this->input->post('hp1pemesan');
			$colinsert["hp2pemesan"]      = $this->input->post('hp2pemesan');
			$colinsert["namapasangan"]      = $this->input->post('namapasangan');
			$colinsert["alamatpasangan"]      = $this->input->post('alamatpasangan');
			$colinsert["rtrwpasangan"]      = $this->input->post('rtrwpasangan');
			$colinsert["kelurahanpasangan"]      = $this->input->post('kelurahanpasangan');
			$colinsert["kecamatanpasangan"]      = $this->input->post('kecamatanpasangan');
			$colinsert["kabupatenpasangan"]      = $this->input->post('kabupatenpasangan');
			$colinsert["telprumahpasangan"]      = $this->input->post('telprumahpasangan');
			$colinsert["telpkantorpasangan"]      = $this->input->post('telpkantorpasangan');
			$colinsert["hp1pasangan"]      = $this->input->post('hp1pasangan');
			$colinsert["hp2pasangan"]      = $this->input->post('hp2pasangan');
			$colinsert["nokavling"]      = $this->input->post('nokavling');
			$colinsert["nopesanan"]      = $this->input->post('nopesanan');
			$colinsert["tglpesanan"]      = $this->input->post('tgl_pesanan');
			$colinsert["jenispesanan"]      = $this->input->post('typekonsumen');
			$colinsert["polapembayaran"]      = $this->input->post('polabayar');
			$colinsert["hargajual"]      = $this->input->post('hargajual');
			$colinsert["diskon"]      = $this->input->post('diskon');
			$colinsert["hargaklt"]      = $this->input->post('hargaklt');
			
			
			if(!empty($this->input->post('check_list'))) {
				$checked_count = $this->input->post('check_list');
				foreach ($this->input->post('check_list') as $value) {
					if ($value == "1") {$colinsert["hargasudut"] = $this->input->post('hargasudut');}
					elseif ($value == "2") {$colinsert["hargahadapjalan"] = $this->input->post('hargahadapjalan');}
					elseif ($value == "3") {$colinsert["hargafasum"] = $this->input->post('hargafasum');}
					elseif ($value == "4") {$colinsert["redesignbangunan"] = 1;$colinsert["hargaredesign"] = $this->input->post('hargaredesign');}
					elseif ($value == "5") {$colinsert["tambahkwalitas"] = 1; $colinsert["hargatambahkwalitas"] = $this->input->post('hargatambahkwalitas');}
					elseif ($value == "6") {$colinsert["pekerjaantambah"] = 1; $colinsert["hargapekerjaantambah"] = $this->input->post('hargapekerjaantambah');}
				};
			};
			$colinsert["totalharga"]      = $this->input->post('totalharga');
			$colinsert["bookingfee"]      = $this->input->post('bookingfee');
			$colinsert["totaluangmuka"]      = $this->input->post('totaluangmuka');
			$colinsert["plafonkpr"]      = $this->input->post('plafonkpr');
			$colinsert["hpp"]      = $this->input->post('hpp');
			if ($colinsert["polapembayaran"] == 0) //KPR
			{
				$colinsert["totalangsuran"] = 0;
				$colinsert["lamaangsuran"] = 0;
				$colinsert["nilaiangsuran"] = 0;
			} else {
				$colinsert["totalangsuran"] = intval($this->input->post('totalharga')) - intval($this->input->post('totaluangmuka'));
				$colinsert["lamaangsuran"] = $this->input->post('lamaangsuran');
				$colinsert["nilaiangsuran"] = $this->input->post('nilaiangsuran');
			}

			switch ($this->input->post('crud')) {
				case 'new':
					//proses Penyimpanan Data Baru
					$output = $this->insert($colinsert);
					break;
				case 'edit':
					//Kembalikan Statusbooking Kavling ke status Open
					$this->db->where('noid',$this->input->post('nokavling'))->set('statusbooking',0)->update('masterkavling');
					$this->db->reset_query();

					//proses Penyimpanan Data hasil koreksi
					$this->update($this->input->post('noidpemesanan'), $colinsert);
					$output = $this->input->post('noidpemesanan');
					break;
				default:
					//proses Penyimpanan Data Baru dari hasil Copy
					$output = $this->insert($colinsert);
					break;
			}
			$colinsert = array();

			if ($output > 0) { //Save Dokumen Pemesanan
				 $noidpemesanan = $output;
				 $detail = json_decode($this->input->post('detail'),true);
				 if(isset($detail)) {
				 	if ($this->input->post('crud') == "edit") //Hapus data dokumen pemesanan sebelumnya
				 		{
				 			//$this->delete_doc_by_id($this->input->post('noidpemesanan'));
				 			$this->db->where('noidpemesanan',$this->input->post('noidpemesanan'))->delete('dokumenpemesanan');
				 			$this->db->reset_query();
				 			$noidpemesanan = $this->input->post('noidpemesanan');
				 		}
					foreach ($detail as $key => $value)
					{
						$detail[$key]['noidpemesanan'] = $noidpemesanan;
						$detail[$key]['status'] = ($detail[$key]['diserahkan'] == 'Belum') ? 0 : 1;
						unset($detail[$key]['no']);
						unset($detail[$key]['namadoc']);
						unset($detail[$key]['diserahkan']);
						if ($detail[$key]['tglpenyerahan'] == '') {unset($detail[$key]['tglpenyerahan']);}
					}//foreach
					$this->table = 'dokumenpemesanan';
					$lastID = $this->insert_batch($detail);
					$this->table = 'pemesanan';
				}//if

				//Set Statusbooking (Masterkavling) = Lock
				$this->db->where('noid',$this->input->post('nokavling'))->set('statusbooking',1)->update('masterkavling');
			}
		return $output;
	}

	public function save_akad() {
		//'Open', 'Lock', 'Akad Jual Beli', 'Closed', 'Cancel'
		$detail = json_decode($this->input->post('detail'),true);
		$hasil = false;
		if (isset($detail)) {
			$this->table = 'akadkredit';
			$this->insert_batch($detail);
			$hasil = true;
		}
		

		//Update Data Pemesanan
		$this->table = 'pemesanan';
		$this->column_index = 'noid';
		$colupdate = array();
		$colupdate['tglakadkredit'] = $this->input->post('tglakad');
		$colupdate['statustransaksi'] = 2;
		if ($this->input->post('polapembayaran') == 0) { //KPR
			$colupdate['retensikpr'] = intval($this->input->post('retensikpr'));
			$colupdate['accbankretensi'] = $this->input->post('accbankretensi');
			$colupdate['realisasikpr'] = intval($this->input->post('realisasikpr'));
			$colupdate['accbankkpr'] = $this->input->post('accbankkpr');
		}
		$hasil = $this->update($this->input->post('noid'), $colupdate);
		$this->reset_param();
		$colupdate = array();
		$detail = null;

		//Set Statusbooking (Masterkavling) = Akad
		if ($hasil) 
			$this->db->where('noid',$this->input->post('nokavling'))->set('statusbooking',2)->update('masterkavling');

		return $hasil;
	}


}
