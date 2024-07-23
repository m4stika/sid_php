<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Kasbank_model extends MY_Model {
	public function __construct()
	{
		parent::__construct();
		$this->resetVar();
	}

	public function resetVar() {
		$this->table = 'kasbank';
		$this->column_index = 'noid';
		$this->column_select = '*';
		$this->column_where = array();
		$this->column_order = array('noid');
		$this->column_search = array('noid','kasbanktype1');
		$this->order = array('noid' => 'asc'); // default order
		$this->hasSelect = false;
	}

	public function getbanklist($parentkey = null, $classacc = 2) {
		$this->kasbank_model->table = 'perkiraan';
		$this->kasbank_model->column_select = 'rekid, accountno, description';

		$this->db->select('rekid, accountno, description')->where('classacc',$classacc);

		if ($parentkey !== null) {
			$this->db->where('parentkey =',$parentkey);
		}
		$this->db->order_by('accountno');

		$query = $this->db->get('perkiraan');

		return $query->result();
	}

	public function get_AccountList($parentkey = null, $classacc = 2, $parentlike = false) {
		$this->db->select('rekid, accountno, description')->from('perkiraan')->where('classacc', $classacc);
		if ($parentkey) {
			if ($parentlike) {
				$this->db->like('parentkey',$parentkey,'after');
			} else $this->db->where('parentkey',$parentkey);
		}
		$query = $this->db->get();
		return $query->result();
	}



	private function get_kasbanknumber($flag = 0)
	{
		//$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");

    	$arflag = array('KI','KO','BI','BO');
    	$tanggal = date('d');
    	$bulan = date('n');
    	$tahun = date('Y');

		$lastno = $this->db->select_max('noid','maxnoid')
							->get('kasbank')
							->row()
							->maxnoid+1;
		$lastno = (!empty($lastno)) ? $lastno : 1;

		$nokasbank = $tahun.str_pad($bulan,2,'0',STR_PAD_LEFT).str_pad($tanggal,2,'0',STR_PAD_LEFT).'/'. str_pad($lastno,6,'0',STR_PAD_LEFT) .'/'.$arflag[$flag];
		return $nokasbank;
	}

	private function get_journalnumber($kasbanktype = 0, $rekid = -1)
	{
		//0004/KK-O/20151226

    	$bankcode = '';
    	$tanggal = date('d');
    	$bulan = date('n');
    	$tahun = date('Y');

		$this->db->select('bankcode')->from('perkiraan')->where('rekid',$rekid);
		$bankcode = $this->db->get()->row()->bankcode;
		$InOut = ($kasbanktype == 0 || $kasbanktype == 2) ? 'I' : 'O';
		$lastno = $this->db->select_max('left(nojurnal,4)','maxnojurnal')
							->where("kasbanktype",$kasbanktype)
							->where("nojurnal IS NOT NULL")
							->get('kasbank')
							->row()
							->maxnojurnal+1;
		$lastno = (!empty($lastno)) ? $lastno : 1;

		$nojurnal = str_pad($lastno,4,'0',STR_PAD_LEFT).'/'.$bankcode.'-'.$InOut.'/'.$tahun.str_pad($bulan,2,'0',STR_PAD_LEFT).str_pad($tanggal,2,'0',STR_PAD_LEFT);

		return $nojurnal;
	}

	private function get_saldoawal($rekid, $tanggal) {
		$this->db->reset_query();
		$saldoawal = $this->db->select('saldoakhir')
									->from('bukuharian')
									->where(array('rekid'=>$rekid, 'tanggal <'=>$tanggal))
									->order_by('tanggal','DESC')
									->limit(1)
									->get()->row()->saldoakhir;
		$saldoawal = ($saldoawal) ? $saldoawal : 0;
		$this->db->reset_query();
		return $saldoawal;
	}

	private function createBukuHarian($tanggal) {
		$this->table = 'bukuharian';
		$listKB = $this->db->select('rekid')->from('perkiraan')->where('classacc',2)->get()->result();
		foreach ($listKB as $value) {
			//cek apakah sudah ada bukuharian pada tanggal tersebut
			$this->db->from('bukuharian')
								->where("rekid",$value->rekid)
								->where("tanggal",$tanggal);
			$hasil = $this->db->count_all_results();

			//tambahkan data baru jika belum ada bukuharian
			if (!$hasil > 0) {
				$saldoawal = $this->get_saldoawal($value->rekid, $tanggal);
				$this->insert(array('rekid'=>$value->rekid, 'tanggal'=>$tanggal, 'saldoawal'=>$saldoawal));//, 'saldoakhir'=>$saldoawal));
			}
			$this->db->reset_query();
		}
	}

	private function recalculate($rekid, $tanggal, $debit, $totaltransaksi, $databaru = 1) {
		$this->createBukuHarian($tanggal);
		$mutasidebet = array('name' =>'mutasidebet', 'value' => ($debit == 1) ? $totaltransaksi : 0);
		$mutasikredit = array('name' =>'mutasikredit', 'value' => ($debit == 0) ? $totaltransaksi : 0);

		$sukses = false;
		$this->db->reset_query();

		while ($sukses == false) {
			$saldoawal = $this->get_saldoawal($rekid, $tanggal);
			if ($databaru == 1) {
				$this->db->where(array("rekid" => $rekid, "tanggal" => $tanggal))
						->set("saldoawal", $saldoawal)
						->set($mutasidebet['name'], "${mutasidebet['name']} + ${mutasidebet['value']}",false)
						->set($mutasikredit['name'], "${mutasikredit['name']} + ${mutasikredit['value']}",false)
						->update('bukuharian');
			} else {
				$this->db->where(array("rekid" => $rekid, "tanggal" => $tanggal))
						->set("saldoawal",$saldoawal)
						->set($mutasidebet['name'], "${mutasidebet['name']} - ${mutasidebet['value']}",false)
						->set($mutasikredit['name'], "${mutasikredit['name']} - ${mutasikredit['value']}",false)
						->update('bukuharian');
			}
			$databaru = 1;
			$mutasidebet['value'] = 0;
			$mutasikredit['value'] = 0;

			$this->db->reset_query();
			$tanggalnew =  $this->db->select('tanggal')
									->from('bukuharian')
									->where(array('rekid'=>$rekid, 'tanggal >'=>$tanggal))
							->order_by('tanggal','asc')
							->limit(1)
							->get()->row();

			if ($tanggalnew) {
				$tanggal = $tanggalnew->tanggal;
			} else {
				$sukses = true;
			}

			//$sukses = ($tanggal) ? false : true;
		}
	}

	public function save_JurnalKB() {
		//noid,kasbanktype,nokasbank,cabang,rekid,nobukti,nomorcek,nojurnal,tgltransaksi,tglentry,uraian,totaltransaksi,statusverifikasi
		//Save Header Kasbank
		$listHeader = $_POST;// $this->input->post();
		$colinsert = array();

		$colinsert['kasbanktype'] = $this->input->post('kasbanktype');
		if ($this->input->post('statusKB') == 'Bank') {$colinsert['kasbanktype'] = $this->input->post('kasbanktype') + 2;}
		$colinsert['nokasbank'] = $this->get_kasbanknumber($colinsert['kasbanktype']);
		$colinsert['rekid'] = ($colinsert['kasbanktype'] <= 1) ? $this->input->post('rekidkas') : $this->input->post('rekidbank');
		$colinsert['nobukti'] = $this->input->post('nobukti');
		$colinsert['nomorcek'] = $this->input->post('nomorcek');
		//$colinsert['nojurnal'] = '-';
		$colinsert['tgltransaksi'] = $this->input->post('tgltransaksi');
		$colinsert['tglentry'] = $this->input->post('tgltransaksi');
		$colinsert['uraian'] = $this->input->post('uraian');
		$colinsert['totaltransaksi'] = $this->input->post('totaltransaksi');;
		$colinsert['statusverifikasi'] = 0;
		$this->table = 'kasbank';
		$this->column_index = 'noid';

		switch ($this->input->post('crud')) {
			case 'new':
			case 'copy':
				$lastID = $this->insert($colinsert);
				$hasil = ($lastID>0) ? "Header OK" : "Error";
				break;
			default: //edit
				$lastID = $this->input->post('noid');
				$ret = $this->update($lastID, $colinsert);
				$hasil = ($ret > true) ? "Header OK" : "Error";
				break;
		}


		if ($lastID > 0) { //Save Rincian Kasbank
			$list = json_decode($_POST['detail'],true);

			// Hapus Rincian Sebelumnya
			$this->column_index = 'idkasbank';
			$this->table = 'rinciankasbank';
			$this->delete($lastID);

			//Save Rincian Kasbank yang baru
			$i = 0;
			foreach ($list as $key => $value) {
				$i++;
				//$new  = array('idkasbank' => 101, 'indexvalue' => $i);

				//add subitem
				$list[$key]['idkasbank'] = $lastID;
				$list[$key]['indexvalue'] = $i;

				//Delete Sub item description
				unset($list[$key]['action']);
				unset($list[$key]['description']);
			}
			$lastID = $this->insert_batch($list);
			$this->table = 'kasbank';
			$hasil = "Sukses Menyimpan Data";
		}

		unset($colinsert, $list);
		$this->resetVar();

		return $hasil;


	}

	public function get_Listjurnal() {
		$this->table = 'vkasbank';
		//k.noid, k.kasbanktype, k.nokasbank, k.rekid, p.accountno, p.description, k.nobukti, k.nomorcek, k.nojurnal, k.tgltransaksi, k.tglentry, k.uraian, k.totaltransaksi, k.statusverifikasi
		$this->column_search = array('noid','statusverifikasi1','kasbanktype1');
		$this->column_order = array('','noid','statusverifikasi','tgltransaksi','accountno','totaltransaksi','uraian');
		$this->order = array('noid'=>'asc');
		$this->column_select = 'noid, rekid, accountno, description, nokasbank, tgltransaksi, totaltransaksi, uraian, statusverifikasi';
		$this->column_where = array();
		//$this->column_where = array('classacc =' => 2);
		$hasil = $this->get_datatables();
		// $this->resetVar();
		return $hasil;
	}

	public function get_listAssign() {
		$this->table = 'vkasbank';
		//k.noid, k.kasbanktype, k.nokasbank, k.rekid, p.accountno, p.description, k.nobukti, k.nomorcek, k.nojurnal, k.tgltransaksi, k.tglentry, k.uraian, k.totaltransaksi, k.statusverifikasi
		$this->column_search = array('noid','statusverifikasi1','kasbanktype1');
		$this->column_order = array('','noid','statusverifikasi','tgltransaksi','accountno','totaltransaksi');
		$this->order = array('noid'=>'asc');
		$this->column_select = 'noid, rekid, accountno, description, nokasbank, tgltransaksi, totaltransaksi, statusverifikasi';
		$this->column_where = array();
		//$this->column_where = array('classacc =' => 2);
		$hasil = $this->get_datatables();
		// $this->resetVar();
		return $hasil;
	}

	public function assign_jurnal() {
		$hasil = '';
		foreach ($_REQUEST['id'] as $value) {
			$this->column_select = 'noid, kasbanktype, rekid, tgltransaksi, nojurnal, totaltransaksi, statusverifikasi';
			$this->table = 'kasbank';
			$this->column_index = 'noid';
			$rec = $this->find_id($value);
			if ($rec['statusverifikasi'] < 2) { //abaikan jika status sudah pimpinan dan Closed
				if ($rec['statusverifikasi'] == 1) { //ver kasir
					$jurnalnumber =  $this->get_journalnumber($rec['kasbanktype'], $rec['rekid']);

					//Update Status Verifikasi + 1
					$this->update($value, array("statusverifikasi" => $rec['statusverifikasi']+1, "nojurnal" => $jurnalnumber));
				} else {
					//Update Status Verifikasi + 1
					$this->update($value, array("statusverifikasi" => $rec['statusverifikasi']+1));
				}

				$hasil .= 'id: '.$value.' Sukses ;';
			} else if ($rec['statusverifikasi'] == 2) { //verifikasi pimpinan
				$this->update($value, array("statusverifikasi" => $rec['statusverifikasi']+1));
				$debitpos = ($rec['kasbanktype'] == 0 || $rec['kasbanktype'] == 2) ? 1 : 0;
				$this->recalculate($rec['rekid'], $rec['tgltransaksi'], $debitpos, $rec['totaltransaksi'], 1);
				$hasil .= 'id: '.$value.' Sukses ;';
			} else {
				$hasil .= 'id: '.$value.' Skip ;';
			}
		}
		return $hasil;
	}

	public function get_jurnalHeader() {
		$this->table = 'vkasbank';
		//k.noid, k.kasbanktype, k.nokasbank, k.rekid, p.accountno, p.description, k.nobukti, k.nomorcek, k.nojurnal, k.tgltransaksi, k.tglentry, k.uraian, k.totaltransaksi, k.statusverifikasi
		//$this->column_search = array('noid','statusverifikasi1','kasbanktype1');
		//$this->column_order = array('','noid','statusverifikasi','tgltransaksi','accountno','totaltransaksi','uraian');
		$this->column_select = "noid,kasbanktype,kasbanktype1,nokasbank,rekid,accountno,description,nobukti,nomorcek,nojurnal,DATE_FORMAT(tgltransaksi,'%d/%c/%Y') as tgltransaksi, DATE_FORMAT(tglentry,'%d/%c/%Y') as tglentry, tgltransaksi as tgltransaksi1, uraian,totaltransaksi,statusverifikasi,statusverifikasi1";
		$this->column_index = 'noid';
		$this->column_where = array('noid =' => $_POST['noid']);
		//$this->column_where = array('classacc =' => 2);
		$hasil = $this->find_id($_POST['noid']);
		$this->resetVar();
		return $hasil;
	}

	public function get_jurnalDetail() {
		$this->table = 'vrinciankasbank';
		//k.noid, k.kasbanktype, k.nokasbank, k.rekid, p.accountno, p.description, k.nobukti, k.nomorcek, k.nojurnal, k.tgltransaksi, k.tglentry, k.uraian, k.totaltransaksi, k.statusverifikasi
		//$this->column_search = array('noid','statusverifikasi1','kasbanktype1');
		//$this->column_order = array('','noid','statusverifikasi','tgltransaksi','accountno','totaltransaksi','uraian');
		$this->order = array('indexvalue'=>'asc');
		$this->column_select = 'idkasbank, rekid, accountno, description, remark, amount';
		$this->column_index = 'idkasbank';
		//$where = "idkasbank='1027'";
		$this->column_where = array('idkasbank =' => $_POST['noid']);
		//$this->column_where = array('classacc =' => 2);
		$hasil = $this->find_where('indexvalue');
		$this->resetVar();
		return $hasil;
	}

	public function get_listextract() {
		// 1=>"Pembayaran", 2=>"Batal Bayar", 3=>"Akad Jual Beli", 4=>"Pembatalan Pemesanan", 5=>"Pencairan Insentif"
		$flag = (isset($_POST['flag'])) ? $_POST['flag'] : 1;
		//$flag = $_POST['flag'];
		$hasil = array();

		switch ($flag) {
			case 1:

				$this->table = 'vkwitansi';
				$this->column_search = array('noid');
				$this->column_order = array('','noid');
				$this->order = array('noid'=>'asc');
				$this->column_select = 'noid, rekid, accountno, description, TglBayar as tgltransaksi, TglBayar as tglentry, nobukti, Keterangan as uraian, "-" as nomorcek, totalbayar as totaltransaksi, 0 as statusverifikasi';
				$this->column_where = array();
				$hasil['list'] = $this->get_datatables(array('kodeupdated'=>'O'));
				$hasil['total_rec_all'] = $this->count_all(array('kodeupdated'=>'O'));
				$hasil['total_filtered'] = $this->count_filtered(array('kodeupdated'=>'O'));
				break;
			case 2:
				$this->table = 'vkwitansibtl';
				$this->column_search = array('noid');
				$this->column_order = array('','noid');
				$this->order = array('noid'=>'asc');
				$this->column_select = 'noid, rekid, accountno, description, tglbatal as tgltransaksi, tglbatal as tglentry, nobukti, Keterangan as uraian, nomorcek, totaltransaksi, 0 as statusverifikasi';
				//$this->column_select = 'noid, 2 as kasbanktype, rekid, accountno, description, TglBayar as tgltransaksi, TglBayar as tglentry, nobukti, Keterangan as uraian, "-" as nomorcek, totalbayar as totaltransaksi, 0 as statusverifikasi';
				$this->column_where = array();
				$hasil['list'] = $this->get_datatables(array('kodeupdated'=>'O'));
				$hasil['total_rec_all'] = $this->count_all(array('kodeupdated'=>'O'));
				$hasil['total_filtered'] = $this->count_filtered(array('kodeupdated'=>'O'));
				break;
			case 3:
				$this->hasSelect = true;
				$sql = "m.noid, rekid, accountno, description, tglakadkredit as tgltransaksi, tglakadkredit as tglentry, m.nopesanan as nobukti, '-' as nomorcek, CONCAT('Akad Kredit #',m.nopesanan,' a/n : ',namapemesan) as uraian, realisasikpr as totaltransaksi, 0 as statusverifikasi";

				$this->db->select($sql)->from('pemesanan m')
									   ->join('perkiraan p','p.rekid = m.accbankkpr')
									   ->where(array('m.statustransaksi'=>2, 'm.prosesakadkb'=>0, 'polapembayaran'=>0));
				$hasil['total_rec_all'] = $this->db->count_all_results();

				$this->db->select($sql)->from('pemesanan m')
									   ->join('perkiraan p','p.rekid = m.accbankkpr')
									   ->where(array('m.statustransaksi'=>2, 'm.prosesakadkb'=>0, 'polapembayaran'=>0));
				$hasil['list'] = $this->get_datatables();

				$this->db->select($sql)->from('pemesanan m')
									   ->join('perkiraan p','p.rekid = m.accbankkpr')
									   ->where(array('m.statustransaksi'=>2, 'm.prosesakadkb'=>0, 'polapembayaran'=>0));
				$hasil['total_filtered'] = $this->count_filtered();
				break;
			case 4:

 				$this->hasSelect = true;
 				$sql = "b.noid, p.rekid, p.accountno, p.description, tglbatal as tgltransaksi, tglbatal as tglentry, b.nobukti, '-' as nomorcek, CONCAT('Pembatalan #',m.nopesanan,' a/n : ',namapemesan) as uraian, b.total as totaltransaksi, 0 as statusverifikasi";
				//$this->db->reset_query();

				$this->db->select($sql)->from('pembatalan b')
									   ->join('pemesanan m','m.noid = b.IDPemesanan','inner')
									   ->join('perkiraan p','p.rekid = b.accbank','inner')
									   ->where(array('m.statustransaksi'=>4, 'b.kodeupdated'=>'O'));
				$hasil['total_rec_all'] = $this->db->count_all_results();

				$this->db->select($sql)->from('pembatalan b')
									   ->join('vpemesanan m','m.noid = b.IDPemesanan')
									   ->join('perkiraan p','p.rekid = b.accbank')
									   ->where(array('m.statustransaksi'=>4, 'b.kodeupdated'=>'O'));
				$hasil['total_filtered'] = $this->count_filtered();

				$this->db->select($sql)->from('pembatalan b')
									   ->join('vpemesanan m','m.noid = b.IDPemesanan')
									   ->join('perkiraan p','p.rekid = b.accbank')
									   ->where(array('m.statustransaksi'=>4, 'b.kodeupdated'=>'O'));
				$hasil['list'] = $this->get_datatables();

				break;
			default:
				break;
		}
		// $this->resetVar();
		return $hasil;
	}

	public function get_extractDetail() {
		// 1=>"Pembayaran", 2=>"Batal Bayar", 3=>"Akad Jual Beli", 4=>"Pembatalan Pemesanan", 5=>"Pencairan Insentif"
		$flag = isset($_POST['flag']) ? $_POST['flag'] : 1;
		switch ($flag) {
			case 1: //
				$hasil = $this->db->select('noid, linkacc as rekid, accountno, description, keterangan, jumlahbayar as amount')->from('vrinciankwitansi')
						 ->where('noid =', $_POST['noid'])
						 ->order_by('nourut','asc')
						 ->get()->result();
				break;
			case 2 :
				$this->db->select('idkwitansi')->from('kwitansibtl')->where('noid =', $_POST['noid']);
				$nokwitansi = $this->db->get()->row()->idkwitansi;

				$hasil = $this->db->select('noid, linkacc as rekid, accountno, description, keterangan, jumlahbayar  as amount')->from('vrinciankwitansi')
						 ->where('noid =', $nokwitansi)
						 ->order_by('nourut','asc')
						 ->get()->result();
				break;
			case 3 :
				$hasil = $this->db->select('m.noid, PenerimaanKPRAcc as rekid, p.accountno, p.description, CONCAT("Akad Jual Beli #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, m.RealisasiKPR as  amount')
						 ->from('pemesanan m')
						 ->join('MasterKavling k', 'k.noid = m.NoKavling')
						 ->join('TypeRumah t', 't.noid = k.TypeRumah')
						 ->join('perkiraan p', 'p.rekid = t.PenerimaanKPRAcc')
						 ->where('m.noid =', $_POST['noid'])
						 ->get()->result();
				break;
			default:
				$this->db->select('noid, uangmuka, klt, sudut, hadapjalan, fasum, redesign, tambahkw, kerjatambah, total')
						 ->from('pembatalan')->where('noid =', $_POST['noid']);
				$record = $this->db->get()->row();
				$compileAll = "";

				if (isset($record)) {
					if ($record->uangmuka > 0 ) {
						$this->db->select('noid, uangmukaacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan UM #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, uangmuka as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.uangmukaacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						$compileAll = $this->db->last_query();
					}
					if ($record->klt > 0 ) {
						$this->db->select('noid, kltacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan KLT #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, klt as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.kltacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}
					if ($record->sudut > 0 ) {
						$this->db->select('noid, posisisudutacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan Sudut #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, sudut as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.posisisudutacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}
					if ($record->hadapjalan > 0 ) {
						$this->db->select('noid, hadapjlnutamaacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan hadap jalan #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, hadapjalan as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.hadapjlnutamaacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}
					if ($record->fasum > 0 ) {
						$this->db->select('noid, hadapfasumacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan fasum #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, fasum as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.hadapfasumacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}
					if ($record->redesign > 0 ) {
						$this->db->select('noid, redesignbangunanacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan Redesign Bangunan #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, redesign as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.redesignbangunanacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}
					if ($record->tambahkw > 0 ) {
						$this->db->select('noid, tambahkwalitasacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan Tambah Kwalitas #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, tambahkw as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.tambahkwalitasacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}
					if ($record->kerjatambah > 0 ) {
						$this->db->select('noid, pekerjaantambahacc1 as rekid, p.accountno, p.description, CONCAT("Pembatalan Tambah kontruksi #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as keterangan, kerjatambah as amount')
							 ->from('vpembatalan b')
							 ->join('perkiraan p', 'p.rekid = b.pekerjaantambahacc1')
							 ->where('noid =', $record->noid)
							 ->get();
							 //->result();
						if ($compileAll != "") {
							$compileAll .= " UNION ".$this->db->last_query();
						} else $compileAll = $this->db->last_query();
						//$compileKLT = $this->db->last_query();
					}


					$query = $this->db->query($compileAll);
					//from("($compileUM UNION $compileKLT)");
					$hasil = $query->result();

				} else $hasil = array();

				break;
		}
		return $hasil;
	}

	public function insertJurnalExtract() {
		// 1=>"Pembayaran", 2=>"Batal Bayar", 3=>"Akad Jual Beli", 4=>"Pembatalan Pemesanan", 5=>"Pencairan Insentif"
		$kasbanktype = array(2,2,3,2,3,3); //0 = Kas-in; 1= Kas-Out; 2 = Bank-IN; 3 = Bank-Out
		$jenisextract = $_REQUEST["customActionFlag"];
		$hasil = false;

		switch ($jenisextract) {
			case 1: //Penerimaan Pembayaran
				foreach ($_REQUEST["id"] as $value) {
					//Insert Header Kasbank
					$sql = '0 as cabang, accbank as rekid, nobukti, "" as nomorcek, tglbayar as tgltransaksi, tglbayar as tglentry, keterangan as uraian, totalbayar as totaltransaksi, 0 as statusverifikasi';
					$colinsert = $this->db->select($sql)->from('kwitansi')->where('noid',$value)->get()->row_array();
					$colinsert['kasbanktype'] = $kasbanktype[$jenisextract];
					$colinsert['nokasbank'] = $this->get_kasbanknumber($kasbanktype[$jenisextract]);
					$this->table = 'kasbank';
					$lastID = $this->insert($colinsert);

					if ($lastID > 0) { //Insert Rincian Kasbank
						$colinsert = [];
						$sql = 'linkacc as rekid, accountno as accno, jumlahbayar as amount, keterangan as remark';
						$colinsert = $this->db->select($sql)->from('vrinciankwitansi')->where('noid',$value)->get()->result_array();
						$no = 0;
						foreach ($colinsert as $key => $row) {
							$no++;
							$colinsert[$key]['idkasbank'] = $lastID;
							$colinsert[$key]['indexvalue'] = $no;
						}
						$this->table = 'rinciankasbank';
						$lastID = $this->insert_batch($colinsert);
						$hasil = true;
					}

					if ($hasil == true) { //udpate Kasbank status
						$this->db->where('noid',$value)->set("kodeupdated","C")->update('kwitansi');
					}
				};

				break;
			case 2: //Batal Bayar
				foreach ($_REQUEST["id"] as $value) {
					//Insert Header Kasbank
					$sql = '0 as cabang, accbank as rekid, nobukti, nocek as nomorcek, tglbatal as tgltransaksi, tglbatal as tglentry, keterangan as uraian, totalbatal as totaltransaksi, 0 as statusverifikasi';
					$colinsert = $this->db->select($sql)->from('kwitansibtl')->where('noid',$value)->get()->row_array();
					$colinsert['kasbanktype'] = $kasbanktype[$jenisextract];
					$colinsert['nokasbank'] = $this->get_kasbanknumber($kasbanktype[$jenisextract]);
					$this->table = 'kasbank';
					$lastID = $this->insert($colinsert);

					if ($lastID > 0) { //Insert Rincian Kasbank
						$this->db->select('idkwitansi')->from('kwitansibtl')->where('noid =', $value);
						$nokwitansi = $this->db->get()->row()->idkwitansi;

						$colinsert = [];
						$sql = 'linkacc as rekid, accountno as accno, jumlahbayar as amount, keterangan as remark';
						$colinsert = $this->db->select($sql)->from('vrinciankwitansi')->where('noid',$nokwitansi)->get()->result_array();
						$no = 0;
						foreach ($colinsert as $key => $row) {
							$no++;
							$colinsert[$key]['idkasbank'] = $lastID;
							$colinsert[$key]['indexvalue'] = $no;
						}
						$this->table = 'rinciankasbank';
						$lastID = $this->insert_batch($colinsert);
						$hasil = true;
					}

					if ($hasil == true) { //udpate Kasbank status
						$this->db->where('noid',$value)->set("kodeupdated","C")->update('kwitansibtl');
					}
				};
				break;
			case 3: //Akad Jual Beli
				foreach ($_REQUEST["id"] as $value) {
					//Insert Header Kasbank
					$sql = "0 as cabang, p.rekid, m.nopesanan as nobukti, '-' as nomorcek, tglakadkredit as tgltransaksi, tglakadkredit as tglentry, CONCAT('Akad Kredit #',m.nopesanan,' a/n : ',namapemesan)  as uraian, realisasikpr as totaltransaksi, 0 as statusverifikasi";
					$colinsert = $this->db->select($sql)->from('pemesanan m')
									   ->join('perkiraan p','p.rekid = m.accbankkpr')
									   ->where('m.noid',$value)->get()->row_array();

					$colinsert['kasbanktype'] = $kasbanktype[$jenisextract];
					$colinsert['nokasbank'] = $this->get_kasbanknumber($kasbanktype[$jenisextract]);
					$this->table = 'kasbank';
					$lastID = $this->insert($colinsert);

					if ($lastID > 0) { //Insert Rincian Kasbank
						$sql = 'PenerimaanKPRAcc as rekid, p.accountno as accno, m.RealisasiKPR as amount, CONCAT("Akad Jual Beli #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
						$colinsert = $this->db->select($sql)->from('pemesanan m')
											  ->join('MasterKavling k', 'k.noid = m.NoKavling')
											  ->join('TypeRumah t', 't.noid = k.TypeRumah')
											  ->join('perkiraan p', 'p.rekid = t.PenerimaanKPRAcc')
											  ->where('m.noid =', $value)
											  ->get()->result_array();

						$no = 0;
						foreach ($colinsert as $key => $row) {
							$no++;
							$colinsert[$key]['idkasbank'] = $lastID;
							$colinsert[$key]['indexvalue'] = $no;
						}
						$this->table = 'rinciankasbank';
						$lastID = $this->insert_batch($colinsert);
						$hasil = true;
					}

					if ($hasil == true) { //udpate Kasbank status
						$this->db->where('noid',$value)
								 ->set("prosesakadkb",1) //sudah Extract KB
								 ->set("statustransaksi",3) //Status CLOSED
								 ->update('pemesanan');
					}
				};
				break;
			case 4: //Pembatalan Pesanan
				foreach ($_REQUEST["id"] as $value) {
					//Insert Header Kasbank
					$sql = "0 as cabang, p.rekid, b.nobukti, '-' as nomorcek,, tglbatal as tgltransaksi, tglbatal as tglentry, CONCAT('Pembatalan #',m.nopesanan,' a/n : ',namapemesan) as uraian, b.total as totaltransaksi, 0 as statusverifikasi";

					$colinsert = $this->db->select($sql)->from('pembatalan b')
										   ->join('pemesanan m','m.noid = b.IDPemesanan','inner')
										   ->join('perkiraan p','p.rekid = b.accbank','inner')
										   ->where('b.noid',$value)
										   ->get()->row_array();

					$colinsert['kasbanktype'] = $kasbanktype[$jenisextract];
					$colinsert['nokasbank'] = $this->get_kasbanknumber($kasbanktype[$jenisextract]);
					$this->table = 'kasbank';
					$lastID = $this->insert($colinsert);

					if ($lastID > 0) { //Insert Rincian Kasbank
						$this->db->select('noid, uangmuka, klt, sudut, hadapjalan, fasum, redesign, tambahkw, kerjatambah, total')
						 		 ->from('pembatalan')->where('noid =', $value);
						$record = $this->db->get()->row();

						$compileAll = "";

						if (isset($record)) {
							if ($record->uangmuka > 0 ) {
								$sql = 'uangmukaacc1 as rekid, p.accountno as accno, uangmuka as amount, CONCAT("Pembatalan UM #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
										  ->join('perkiraan p', 'p.rekid = b.uangmukaacc1')
										  ->where('noid =', $record->noid)
										  ->get();
								$compileAll = $this->db->last_query();
							}
							if ($record->klt > 0 ) {
								$sql = 'kltacc1 as rekid, p.accountno as accno, klt as amount, CONCAT("Pembatalan KLT #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
										 ->join('perkiraan p', 'p.rekid = b.kltacc1')
										 ->where('noid =', $record->noid)
										 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
							if ($record->sudut > 0 ) {
								$sql = 'posisisudutacc1 as rekid, p.accountno as accno, sudut as amount, CONCAT("Pembatalan Sudut #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
										 ->join('perkiraan p', 'p.rekid = b.posisisudutacc1')
										 ->where('noid =', $record->noid)
										 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
							if ($record->hadapjalan > 0 ) {
								$sql = 'hadapjlnutamaacc1 as rekid, p.accountno as accno, hadapjalan as amount, CONCAT("Pembatalan hadap jalan #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
									 ->join('perkiraan p', 'p.rekid = b.hadapjlnutamaacc1')
									 ->where('noid =', $record->noid)
									 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
							if ($record->fasum > 0 ) {
								$sql = 'hadapfasumacc1 as rekid, p.accountno as accno, fasum as amount, CONCAT("Pembatalan fasum #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
										 ->join('perkiraan p', 'p.rekid = b.hadapfasumacc1')
										 ->where('noid =', $record->noid)
										 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
							if ($record->redesign > 0 ) {
								$sql = 'redesignbangunanacc1 as rekid, p.accountno as accno, redesign as amount, CONCAT("Pembatalan Redesign Bangunan #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
										 ->join('perkiraan p', 'p.rekid = b.redesignbangunanacc1')
										 ->where('noid =', $record->noid)
										 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
							if ($record->tambahkw > 0 ) {
								$sql = 'tambahkwalitasacc1 as rekid, p.accountno as accno, tambahkw as amount, CONCAT("Pembatalan Tambah Kwalitas #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
									 ->join('perkiraan p', 'p.rekid = b.tambahkwalitasacc1')
									 ->where('noid =', $record->noid)
									 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
							if ($record->kerjatambah > 0 ) {
								$sql = 'pekerjaantambahacc1 as rekid, p.accountno as accno, kerjatambah as amount, CONCAT("Pembatalan Tambah kontruksi #",COALESCE(nopesanan,"")," a/n : ",namapemesan) as remark';
								$this->db->select($sql)->from('vpembatalan b')
										 ->join('perkiraan p', 'p.rekid = b.pekerjaantambahacc1')
										 ->where('noid =', $record->noid)
										 ->get();
								if ($compileAll != "") {
									$compileAll .= " UNION ".$this->db->last_query();
								} else $compileAll = $this->db->last_query();
							}
						}
						$query = $this->db->query($compileAll);
						$colinsert = $query->result_array();

						$no = 0;
						foreach ($colinsert as $key => $row) {
							$no++;
							$colinsert[$key]['idkasbank'] = $lastID;
							$colinsert[$key]['indexvalue'] = $no;
						}
						$this->table = 'rinciankasbank';
						$lastID = $this->insert_batch($colinsert);
						$hasil = true;
					}

					if ($hasil == true) { //udpate Pembatalan status
						$this->db->where('noid',$value)
								 ->set("kodeupdated","C") //Kodeupdated = Closed
								 ->update('pembatalan');
					}
				};
				break;
			default: //Pencairan Insentif
				# code...
				break;
		}
		return $hasil;
	}
}
?>