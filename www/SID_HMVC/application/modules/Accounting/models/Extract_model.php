<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Extract_model extends MY_Model {
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
		//$this->load->model('journal_model');
	}

	private function resetVar() {
		$this->table = 'journal';
		$this->column_index = 'journalid';
		$this->column_select = '*';
		$this->column_where = array();
		$this->column_order = array('journalid'); 
		$this->column_search = array('journalid','accountno','description');
		$this->order = array('accountno' => 'asc'); // default order 
		$this->hasSelect = false;
	}

	private function getLastjournalNo($group) {
		$query = $this->db->select('bulanbuku, tahunbuku, tahunbuku*100+bulanbuku as blthbuku', FALSE)->limit(1)->get('parameter');
		$parameter = $query->result_array()[0];

		$lastno = $this->db->select_max('autonum','maxnumber')->where('journalGroup',$group)
							->get('journal')
							->row()
							->maxnumber;
		$lastno = (!empty($lastno)) ? $lastno + 1 : 1;
		$journalNo = self::groupCode[$group].'-'.str_pad($lastno,6,'0',STR_PAD_LEFT);
		return (object) array('autoNumber'=>$lastno, 'journalNo' => $journalNo, 'bulanbuku'=>$parameter['bulanbuku'], 'tahunbuku'=>$parameter['tahunbuku'], 'blthbuku'=>$parameter['blthbuku']);
	}

	private function getAccount($rekid) {
		$query = $this->db->select('rekid, accountno, description')->from('perkiraan')->where('rekid',$rekid)->get();
		return (object) $query->result_array()[0];
	}

	private function getdetail_akad($noid) {
		$this->db->select('noid, idtyperumah, nopesanan, namapemesan, polapembayaran,
					bookingfee,hargaklt,hargasudut,hargahadapjalan,hargafasum,hargaredesign,hargatambahkwalitas,hargapekerjaantambah,
					totalharga,totaluangmuka, retensikpr, 
					bookingfeebyr+bookingfeeonp as bookingfeebyr, lunasuangmuka+uangmukaonp as uangmukabyr,
					hargasudutbyr+hargasudutonp as hargasudutbyr, hargahadapjalanbyr+hargahadapjalanonp as hargahadapjalanbyr,
					hargakltbyr+hargakltonp as hargakltbyr, hargafasumbyr+hargafasumonp as hargafasumbyr, 
					hargaredesignbyr+hargaredesignonp as hargaredesignbyr, hargatambahkwbyr+hargatambahkwonp as hargatambahkwbyr,
					hargakerjatambahbyr+hargakerjatambahonp as hargakerjatambahbyr, totalhargabyr+totalhargaonp as totaltunaibyr, hpp, 
					totalbayartitipan, totalbayaronp, totalhutang', FALSE)
				->from('vpemesanan')
				->where('noid =', $noid);
		$record = $this->db->get()->row();
		$compileAll = "";
		$hasil = array();
		if (! isset($record)) return $hasil;

		$getsql = function($compile, $linkid, $idtyperumah, $amount = 0, $debitacc = 1) {
			$sql = "k.rekid, k.accountno, k.description, {$amount} as amount, {$debitacc} as debitacc";
			$this->db->select($sql,FALSE)
						->from('typerumah t')
						->join('perkiraan k', 'k.rekid = '. $linkid, FALSE)
						->where('t.noid',$idtyperumah, FALSE)
						->get();
			//return $this->db->last_query();
			if ($compile != "") {
				$compile .= " UNION ".$this->db->last_query();
			} else $compile = $this->db->last_query();
			return $compile;
		};

		if ($record->retensikpr > 0) {
			$this->db->select('k.rekid, k.accountno, k.description, amount, 1 as debitacc')
						->from('akadkredit a')
						->join('perkiraan k', 'k.rekid = a.linkacc')
						->where('a.idpemesanan',$noid)
						->get();
			$compileAll = $this->db->last_query();

			$this->db->select('k.rekid, k.accountno, k.description, retensikpr as amount, 0 as debitacc')
						->from('vpemesanan p')
						->join('typerumah t', 't.noid = p.idtyperumah')
						->join('perkiraan k', 'k.rekid = t.PenerimaanKprAcc')
						->where('p.noid',$noid)
						->get();
			if ($compileAll != "") {
				$compileAll .= " UNION ".$this->db->last_query();
			} else $compileAll = $this->db->last_query();
		}

		//Jurnal Balik Pembayaran Konsumen dari Titipan menjadi Pendapatan
		if ($record->bookingfeebyr > 0) {
			$compileAll = $getsql($compileAll, 't.bookingfeeacc1', $record->idtyperumah, $record->bookingfeebyr);
		}
		if ($record->uangmukabyr > 0) {
			$compileAll = $getsql($compileAll, 't.UangMukaAcc1', $record->idtyperumah, $record->uangmukabyr);
		}
		if ($record->hargakltbyr > 0) {
			$compileAll = $getsql($compileAll, 't.KLTAcc1', $record->idtyperumah, $record->hargakltbyr);
		}
		if ($record->hargasudutbyr > 0) {
			$compileAll = $getsql($compileAll, 't.posisisudutAcc1', $record->idtyperumah, $record->hargasudutbyr);
		}
		if ($record->hargahadapjalanbyr > 0) {
			$compileAll = $getsql($compileAll, 't.HadapJlnUtamaAcc1', $record->idtyperumah, $record->hargahadapjalanbyr);
		}
		if ($record->hargafasumbyr > 0) {
			$compileAll = $getsql($compileAll, 't.HadapFasumAcc1', $record->idtyperumah, $record->hargafasumbyr);
		}
		if ($record->hargaredesignbyr > 0) {
			$compileAll = $getsql($compileAll, 't.RedesignBangunanAcc1', $record->idtyperumah, $record->hargaredesignbyr);
		}
		if ($record->hargatambahkwbyr > 0) {
			$compileAll = $getsql($compileAll, 't.TambahKwalitasAcc1', $record->idtyperumah, $record->hargatambahkwbyr);
		}
		if ($record->hargakerjatambahbyr > 0) {
			$compileAll = $getsql($compileAll, 't.PekerjaanTambahAcc1', $record->idtyperumah, $record->hargakerjatambahbyr);
		}
		if ($record->totaltunaibyr > 0) {
			$compileAll = $getsql($compileAll, 't.HargaJualAcc1', $record->idtyperumah, $record->totaltunaibyr);
		}

		//Jurnal Semua pembayaran yang belum lunas ke PIUTANG
		$totalhutang = (float) $record->totalhutang - ((float) $record->totalbayartitipan + (float) $record->totalbayaronp);
		if ($totalhutang > 0) {
			$compileAll = $getsql($compileAll, 't.PiutangAcc1', $record->idtyperumah, $totalhutang);
		}

		//jurnal Pendapatan semua yg sudah lunas
		//Jurnal Balik Pembayaran Konsumen dari Titipan menjadi Pendapatan
		if ($record->bookingfee > 0) {
			$compileAll = $getsql($compileAll, 't.bookingfeeacc', $record->idtyperumah, $record->bookingfee, 0);
		}
		if ($record->totaluangmuka > 0) {
			$compileAll = $getsql($compileAll, 't.UangMukaAcc', $record->idtyperumah, $record->totaluangmuka, 0);
		}
		if ($record->hargaklt > 0) {
			$compileAll = $getsql($compileAll, 't.KLTAcc', $record->idtyperumah, $record->hargaklt, 0);
		}
		if ($record->hargasudut > 0) {
			$compileAll = $getsql($compileAll, 't.posisisudutAcc', $record->idtyperumah, $record->hargasudut, 0);
		}
		if ($record->hargahadapjalan > 0) {
			$compileAll = $getsql($compileAll, 't.HadapJlnUtamaAcc', $record->idtyperumah, $record->hargahadapjalan, 0);
		}
		if ($record->hargafasum > 0) {
			$compileAll = $getsql($compileAll, 't.HadapFasumAcc', $record->idtyperumah, $record->hargafasum, 0);
		}
		if ($record->hargaredesign > 0) {
			$compileAll = $getsql($compileAll, 't.RedesignBangunanAcc', $record->idtyperumah, $record->hargaredesign, 0);
		}
		if ($record->hargatambahkwalitas > 0) {
			$compileAll = $getsql($compileAll, 't.TambahKwalitasAcc', $record->idtyperumah, $record->hargatambahkwalitas, 0);
		}
		if ($record->hargapekerjaantambah > 0) {
			$compileAll = $getsql($compileAll, 't.PekerjaanTambahAcc', $record->idtyperumah, $record->hargapekerjaantambah, 0);
		}
		if ($record->polapembayaran != 0) {
			$compileAll = $getsql($compileAll, 't.HargaJualAcc', $record->idtyperumah, $record->totalharga, 0);
		}

		//Journal HPP vs Persediaan
		if ($record->hpp > 0) {
			$compileAll = $getsql($compileAll, 't.HPPAcc', $record->idtyperumah, $record->hpp);
			$compileAll = $getsql($compileAll, 't.PersediaanAcc', $record->idtyperumah, $record->hpp, 0);
		}

		if ($compileAll == "") return $hasil;

		$query = $this->db->query($compileAll);
		$hasil = $query->result();

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
		 	$row['debit'] = ($value->debitacc == 1) ? $value->amount : 0;
		 	$row['credit'] = ($value->debitacc == 0) ? $value->amount : 0;
		 	$data[] = $row;
		}
		return $data;
	}

	private function getdetail_kasbank($noid) {
		$query = $this->db->select('kasbanktype')->from('kasbank')->where('noid',$noid)->get();
		$row = $query->row();
		$debitacc = ($row->kasbanktype == 0 || $row->kasbanktype == 2) ? 1 : 0;
		$creditacc = ($debitacc == 1) ? 0 : 1;

		$this->db->select("noid, rekid, accountno, description, uraian, {$debitacc} as debitacc, totaltransaksi as amount", FALSE)
				 ->from('vkasbank')
				 ->where('noid =',$noid)
				 ->get();
		$queryH = $this->db->last_query();

		$this->db->select("idkasbank as noid, rekid, accountno, description, remark as  uraian, {$creditacc} as debitacc, amount")
				 ->from('vrinciankasbank')
				 ->where('idkasbank =',$noid)
				 ->get();
		$queryD = $this->db->last_query();

		$queryall = ($debitacc == 1) ? $queryH ." UNION " .$queryD : $queryD ." UNION " .$queryH;
		$query = $this->db->query($queryall);
		$list = $query->result();

		$no = 0;
		$output = array();
		foreach ($list as $value) {
		 	$no++;
		 	$row = array();
		 	$row['indexvalue'] = $no;
		 	$row['rekid'] = $value->rekid;
		 	$row['accountno'] = $value->accountno;
		 	$row['description'] = $value->description;
		 	$row['remark'] = $value->uraian;
		 	$row['debitacc'] = $value->debitacc;
		 	$row['debit'] = ($value->debitacc == 1) ? $value->amount : 0;
		 	$row['credit'] = ($value->debitacc == 0) ? $value->amount : 0;
		 	$output[] = $row;
		};
		return $output;
	} //end of getdetail_kasbank

	private function getdetail_pembatalan($noid) {
		$this->db->select('noid,idpemesanan,nopesanan,namapemesan,nobukti,tglbatal,keterangan,uangmuka,klt,sudut,hadapjalan,fasum,
			redesign,tambahkw,kerjatambah,hargadasar, totalpengembalian,accbank,accountno,description,kodeupdated,kodeupdatedgl, 
			bookingfeebyr, uangmukabyr, kltbyr,sudutbyr,hadapjalanbyr,fasumbyr,redesignbyr,tambahkwbyr,kerjatambahbyr,totalhargabyr,
			totalbayartitipan, uangmukaacc, kltacc, posisisudutacc,hadapjlnutamaacc,hadapfasumacc,redesignbangunanacc,tambahkwalitasacc,
			pekerjaantambahacc, hargajualacc, bookingfeeacc, uangmukaacc1, kltacc1, posisisudutacc1, hadapjlnutamaacc1, hadapfasumacc1, 
			redesignbangunanacc1, tambahkwalitasacc1, pekerjaantambahacc1, hargajualacc1, bookingfeeacc1, polapembayaran', FALSE)
				->from('vpembatalan')
				->where('noid =', $noid);
		$record = $this->db->get()->row();
		$compileAll = "";
		$hasil = array();
		if (! isset($record)) return $hasil;

		$getsql = function($compile, $linkid, $amount = 0, $debitacc = 1) {
			$sql = "rekid, accountno, description, {$amount} as amount, {$debitacc} as debitacc";
			$this->db->select($sql,FALSE)
						->from('perkiraan')
						->where('rekid',$linkid)
						->get();
			if ($compile != "") {
				$compile .= " UNION ".$this->db->last_query();
			} else $compile = $this->db->last_query();
			return $compile;
		};

		//Jurnal Balik Pembayaran Konsumen dari Titipan menjadi Pendapatan
		if ($record->bookingfeebyr > 0) {
			$compileAll = $getsql($compileAll, $record->bookingfeeacc1, $record->bookingfeebyr);
		}
		if ($record->uangmukabyr > $record->uangmuka) {
			$compileAll = $getsql($compileAll, $record->uangmukaacc1, $record->uangmukabyr - $record->uangmuka);
		}
		if ($record->kltbyr > $record->klt) {
			$compileAll = $getsql($compileAll, $record->kltacc1, $record->kltbyr - $record->klt);
		}
		if ($record->sudutbyr > $record->sudut) {
			$compileAll = $getsql($compileAll, $record->posisisudutacc1, $record->sudutbyr - $record->sudut);
		}
		if ($record->hadapjalanbyr > $record->hadapjalan) {
			$compileAll = $getsql($compileAll, $record->hadapjlnutamaacc1, $record->hadapjalanbyr - $record->hadapjalan);
		}
		if ($record->fasumbyr > $record->fasum) {
			$compileAll = $getsql($compileAll, $record->hadapfasumacc1, $record->fasumbyr - $record->fasum);
		}
		if ($record->redesignbyr > $record->redesign) {
			$compileAll = $getsql($compileAll, $record->redesignbangunanacc1, $record->redesignbyr - $record->redesign);
		}
		if ($record->tambahkwbyr > $record->tambahkw) {
			$compileAll = $getsql($compileAll, $record->tambahkwalitasacc1, $record->tambahkwbyr - $record->tambahkw);
		}
		if ($record->kerjatambahbyr > $record->kerjatambah) {
			$compileAll = $getsql($compileAll, $record->pekerjaantambahacc1, $record->kerjatambahbyr - $record->kerjatambah);
		}
		if ($record->totalhargabyr > $record->hargadasar) {
			$compileAll = $getsql($compileAll, $record->hargajualacc1, $record->totalhargabyr - $record->hargadasar);
		}

		
		//Jurnal Balik Pembayaran Konsumen yang tidak di kembalikan dari Titipan menjadi Pendapatan
		if ($record->bookingfeebyr > 0) {
			$compileAll = $getsql($compileAll, $record->bookingfeeacc, $record->bookingfeebyr, 0);
		}
		if ($record->uangmukabyr > $record->uangmuka) {
			$compileAll = $getsql($compileAll, $record->uangmukaacc, $record->uangmukabyr - $record->uangmuka);
		}
		if ($record->kltbyr > $record->klt) {
			$compileAll = $getsql($compileAll, $record->kltacc, $record->kltbyr - $record->klt);
		}
		if ($record->sudutbyr > $record->sudut) {
			$compileAll = $getsql($compileAll, $record->posisisudutacc, $record->sudutbyr - $record->sudut);
		}
		if ($record->hadapjalanbyr > $record->hadapjalan) {
			$compileAll = $getsql($compileAll, $record->hadapjlnutamaacc, $record->hadapjalanbyr - $record->hadapjalan);
		}
		if ($record->fasumbyr > $record->fasum) {
			$compileAll = $getsql($compileAll, $record->hadapfasumacc, $record->fasumbyr - $record->fasum);
		}
		if ($record->redesignbyr > $record->redesign) {
			$compileAll = $getsql($compileAll, $record->redesignbangunanacc, $record->redesignbyr - $record->redesign);
		}
		if ($record->tambahkwbyr > $record->tambahkw) {
			$compileAll = $getsql($compileAll, $record->tambahkwalitasacc, $record->tambahkwbyr - $record->tambahkw);
		}
		if ($record->kerjatambahbyr > $record->kerjatambah) {
			$compileAll = $getsql($compileAll, $record->pekerjaantambahacc, $record->kerjatambahbyr - $record->kerjatambah);
		}
		if ($record->totalhargabyr > $record->hargadasar) {
			$compileAll = $getsql($compileAll, $record->hargajualacc, $record->totalhargabyr - $record->hargadasar);
		}

		if ($compileAll == "") return $hasil;

		$query = $this->db->query($compileAll);
		$hasil = $query->result();

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
		 	$row['debit'] = ($value->debitacc == 1) ? $value->amount : 0;
		 	$row['credit'] = ($value->debitacc == 0) ? $value->amount : 0;
		 	$data[] = $row;
		}
		return $data;
	} //end of getdetail_Pembatalan

	public function getextract_detail($param) {
		$data = array();
		
		switch ($param->group) {
			case 2: //Akad
				$data = $this->getdetail_akad($param->linkid);
				break;

			case 4: //Kasbank
				$data = $this->getdetail_kasbank($param->linkid);
				break;

			case 5: //Penyusutan
				$query = $this->db->select('akunbiaya, accakumulasi, penyusutanbulan_I, penyusutanbulan_II, akumpenyusutan, nilaibuku')->from('fixedasset')->where('noid',$param->linkid)->get();
				//$linkacc = (object) $query->result_array()[0];
				$linkacc = $query->row();

				$penyusutantemp = (float) $linkacc->akumpenyusutan;
				$penyusutantemp = ($penyusutantemp <= 0) ? (float) $linkacc->penyusutanbulan_I : (float) $linkacc->penyusutanbulan_II;
				$penyusutantemp = ($penyusutantemp > (float) $linkacc->nilaibuku) ? (float) $linkacc->nilaibuku : $penyusutantemp;
				
				for ($i=1; $i <= 2; $i++) { 
				 	$row = array();
				 	$account = ($i == 1) ? $this->getAccount($linkacc->akunbiaya) : $this->getAccount($linkacc->accakumulasi);
				 	$row['indexvalue'] = $i;
				 	$row['rekid'] = $account->rekid;
				 	$row['accountno'] = $account->accountno;
				 	$row['description'] = $account->description;
				 	$row['debit'] = ($i == 1) ? $penyusutantemp : 0;
				 	$row['credit'] = ($i == 2) ? $penyusutantemp : 0;
				 	$data[] = $row;
				};
				break;

			case 6: //Pembatalan Pemesanan
				$data = $this->getdetail_pembatalan($param->linkid);
				break;
			default:
				# code...
				break;
		}
		
		return $data;
	}

	public function getextract($param) {
		/*--------------- Extract Penyusutan -----------*/
		$journal_penyusutan = function() use ($param) {			
			$parameter = $this->getLastjournalNo($param->sourceid);
			$blthparam = $param->tahun*100+$param->bulan;

			$get_penyusutan_query = function($sum = false) use($blthparam) {
				$sql = "SUM(CASE WHEN bulanproses is null THEN penyusutanbulan_I WHEN penyusutanbulan_II > nilaibuku THEN nilaibuku ELSE penyusutanbulan_II END) AS total";
				if ($sum === true) {
					$this->db->select($sql, FALSE);
				} else {
					$this->db->select('noid, namaaktiva, penyusutanbulan_I, penyusutanbulan_II, akumpenyusutan, nilaibuku');
				}
				return $this->db->from('fixedasset')
								->where('tahunsusut*100+bulansusut <=',$blthparam,FALSE)
								->where('nilaibuku !=',0)
								->group_start()
								->where('tanggalproses is null',null, false)
								->or_where('tahunproses*100+bulanproses <',$blthparam,FALSE)
								->group_end();   
			
			};

			$get_penyusutan_query();
			$list = $this->db->limit($_POST['length'], $_POST['start'])->get()->result();

			$get_penyusutan_query();
			$countall = $this->db->count_all_results();

			//$get_penyusutan_query();
			$countallFiltered = $countall;// $this->db->count_all_results();

			$get_penyusutan_query(true);
			$grandtotal = $this->db->get()->result_array();
			$grandtotal = (count($grandtotal) > 0 ? $grandtotal[0] : 0);
			$grandtotal = $grandtotal['total'];
			
			
			$data = array();
			$no = 0;
			foreach ($list as $value) {
				$journalheader = array();
				
				$penyusutantemp = (float) $value->akumpenyusutan;
				$penyusutantemp = ($penyusutantemp <= 0) ? (float) $value->penyusutanbulan_I : (float) $value->penyusutanbulan_II;
				$penyusutantemp = ($penyusutantemp > (float) $value->nilaibuku) ? (float) $value->nilaibuku : $penyusutantemp;

			    $journaldate = $param->tahun.'-'.$param->bulan.'-28';
				$journalNo = self::groupCode[$param->sourceid].'-'.str_pad($parameter->autoNumber+$no+$_POST['start'],6,'0',STR_PAD_LEFT);

				$journalheader['linkid'] = $value->noid;
				$journalheader['bulan'] = $param->bulan;
				$journalheader['tahun'] = $param->tahun;
				$journalheader['journalgroup'] = $param->sourceid;
				$journalheader['journalgroupdesc'] = self::groupDesc[$param->sourceid] ;
				$journalheader['autonum'] = $parameter->autoNumber+$no+$_POST['start'];
				$journalheader['journalno'] = $journalNo;
				$journalheader['journaldate'] = $journaldate; // date("Y-n-j");
				$journalheader['journalremark'] = 'Penyusutan '.$value->namaaktiva. ' #'.$value->noid;
				$journalheader['dueamount'] = $penyusutantemp;
				$journalheader['status'] = 0;
				
				$data[] = $journalheader;

				$no++;
			}

			return array("data"=>$data, 'countall'=>$countall, 'countallFiltered'=>$countallFiltered, 'grandtotal'=>$grandtotal);
		};
		/*--------- end of Sub Extract Penyusutan*/

		/*-------------- Extract AKAD ---------------*/
		$journal_akad = function () use ($param) {
			$parameter = $this->getLastjournalNo($param->sourceid);
			$queryHeader = function($sum = false) use ($param) {
				$this->db->reset_query();
				$sql = "SUM(totalhutang + retensikpr + hpp) AS total";

				if ($sum === true) {
					$this->db->select($sql, FALSE);
				} else {
					$this->db->select('noid, nopesanan, tglpesanan, namapemesan, tglakadkredit, totalhutang + retensikpr + hpp as amount', FALSE);
				}
				return $this->db->from('vpemesanan')
								->where('statustransaksi <=',2)
								->where('tglakadkredit >=',$param->tanggalfrom)
								->where('tglakadkredit <=',$param->tanggalto);
			};

			$queryHeader();
			$list = $this->db->limit($_POST['length'], $_POST['start'])->get()->result();

			$queryHeader();
			$countall = $this->db->count_all_results();

			//$queryHeader();
			$countallFiltered = $countall;

			$queryHeader(true);
			$grandtotal = $this->db->get()->result_array();
			$grandtotal = (count($grandtotal) > 0 ? $grandtotal[0] : 0);
			$grandtotal = $grandtotal['total'];

			$data = array();
			$no = 0;
			foreach ($list as $value) {
				$journalheader = array();
				
			    $journaldate = $param->tahun.'-'.$param->bulan.'-28';
				$journalNo = self::groupCode[$param->sourceid].'-'.str_pad($parameter->autoNumber+$no+$_POST['start'],6,'0',STR_PAD_LEFT);

				$journalheader['linkid'] = $value->noid;
				$journalheader['bulan'] = $param->bulan;
				$journalheader['tahun'] = $param->tahun;
				$journalheader['journalgroup'] = $param->sourceid;
				$journalheader['journalgroupdesc'] = self::groupDesc[$param->sourceid] ;
				$journalheader['autonum'] = $parameter->autoNumber+$no+$_POST['start'];
				$journalheader['journalno'] = $journalNo;
				$journalheader['journaldate'] = $value->tglakadkredit;
				$journalheader['journalremark'] = 'Akad Jual Beli #'.$value->nopesanan.' a/n: '.$value->namapemesan;
				$journalheader['dueamount'] = (float) $value->amount;
				$journalheader['status'] = 0;
				
				$data[] = $journalheader;

				$no++;
			}

			return array("data"=>$data, 'countall'=>$countall, 'countallFiltered'=>$countallFiltered, 'grandtotal'=>$grandtotal);
		};
		/*--------- end of Sub Extract AKAD*/

		/*-------------- Extract Kas-bank ---------------*/
		$journal_kasbank = function () use ($param) {
			$parameter = $this->getLastjournalNo($param->sourceid);
			$queryHeader = function($sum = false) use ($param) {
				$this->db->reset_query();
				$sql = "SUM(totaltransaksi) AS total";

				if ($sum === true) {
					$this->db->select($sql, FALSE);
				} else {
					$this->db->select('noid, rekid, accountno, description, nojurnal, tglentry, uraian, totaltransaksi as amount', FALSE);
				}
				return $this->db->from('vkasbank')
								->where('statusverifikasi =',3)
								->where('tglentry >=',$param->tanggalfrom)
								->where('tglentry <=',$param->tanggalto);
			};

			$queryHeader();
			$list = $this->db->limit($_POST['length'], $_POST['start'])->get()->result();

			$queryHeader();
			$countall = $this->db->count_all_results();

			//$queryHeader();
			$countallFiltered = $countall;

			$queryHeader(true);
			$grandtotal = $this->db->get()->result_array();
			$grandtotal = (count($grandtotal) > 0 ? $grandtotal[0] : 0);
			$grandtotal = $grandtotal['total'];

			$data = array();
			$no = 0;
			foreach ($list as $value) {
				$journalheader = array();
				
			    $journaldate = $param->tahun.'-'.$param->bulan.'-28';
				$journalNo = self::groupCode[$param->sourceid].'-'.str_pad($parameter->autoNumber+$no+$_POST['start'],6,'0',STR_PAD_LEFT);

				$journalheader['linkid'] = $value->noid;
				$journalheader['bulan'] = $param->bulan;
				$journalheader['tahun'] = $param->tahun;
				$journalheader['journalgroup'] = $param->sourceid;
				$journalheader['journalgroupdesc'] = self::groupDesc[$param->sourceid] ;
				$journalheader['autonum'] = $parameter->autoNumber+$no+$_POST['start'];
				$journalheader['journalno'] = $journalNo;
				$journalheader['journaldate'] = $value->tglentry;
				$journalheader['journalremark'] = $value->uraian. ' #'.$value->noid;
				$journalheader['dueamount'] = (float) $value->amount;
				$journalheader['status'] = 0;
				
				$data[] = $journalheader;

				$no++;
			}

			return array("data"=>$data, 'countall'=>$countall, 'countallFiltered'=>$countallFiltered, 'grandtotal'=>$grandtotal);
		};
		/*--------- end of Sub Extract Kasbank*/

		/*-------------- Extract PEMBATALAN ---------------*/
		$journal_pembatalan = function () use ($param) {
			$parameter = $this->getLastjournalNo($param->sourceid);
			$queryHeader = function($sum = false) use ($param) {
				$this->db->reset_query();
				$sql = "SUM(totalbayartitipan - totalpengembalian) AS total";

				if ($sum === true) {
					$this->db->select($sql, FALSE);
				} else {
					$this->db->select('noid, idpemesanan, tglbatal, namapemesan, totalbayartitipan, totalpengembalian, totalbayartitipan - totalpengembalian as amount', FALSE);
				}
				return $this->db->from('vpembatalan')
								->where('kodeupdatedGL =','O')
								->where('tglbatal >=',$param->tanggalfrom)
								->where('tglbatal <=',$param->tanggalto)
								->where('totalbayartitipan > totalpengembalian');
			};

			$queryHeader();
			$list = $this->db->limit($_POST['length'], $_POST['start'])->get()->result();

			$queryHeader();
			$countall = $this->db->count_all_results();

			//$queryHeader();
			$countallFiltered = $countall;

			$queryHeader(true);
			$grandtotal = $this->db->get()->result_array();
			$grandtotal = (count($grandtotal) > 0 ? $grandtotal[0] : 0);
			$grandtotal = $grandtotal['total'];

			$data = array();
			$no = 0;
			foreach ($list as $value) {
				$journalheader = array();
				
			    $journaldate = $param->tahun.'-'.$param->bulan.'-28';
				$journalNo = self::groupCode[$param->sourceid].'-'.str_pad($parameter->autoNumber+$no+$_POST['start'],6,'0',STR_PAD_LEFT);

				$journalheader['linkid'] = $value->noid;
				$journalheader['bulan'] = $param->bulan;
				$journalheader['tahun'] = $param->tahun;
				$journalheader['journalgroup'] = $param->sourceid;
				$journalheader['journalgroupdesc'] = self::groupDesc[$param->sourceid] ;
				$journalheader['autonum'] = $parameter->autoNumber+$no+$_POST['start'];
				$journalheader['journalno'] = $journalNo;
				$journalheader['journaldate'] = $value->tglbatal;
				$journalheader['journalremark'] = 'Pembatalan #'.$value->noid.' a/n: '.$value->namapemesan;
				$journalheader['dueamount'] = (float) $value->amount;
				$journalheader['status'] = 0;
				
				$data[] = $journalheader;

				$no++;
			}

			return array("data"=>$data, 'countall'=>$countall, 'countallFiltered'=>$countallFiltered, 'grandtotal'=>$grandtotal);
		};
		/*--------- end of Sub Extract PEMBATALAN*/

		/*========== START EXTRACT ==============*/
		$output = array("data"=>'', 'countall'=>0, 'countallFiltered'=>0, 'grandtotal'=>0); 

		switch ($param->sourceid) {
			case 2: //Akad Jual Beli
				$output = $journal_akad();
				break;
			case 4: //Kas-Bank
				$output = $journal_kasbank();
				break;
			case 5: //Penyusutan
				$output = $journal_penyusutan();
				break;
			case 6: //Pembatalan Pemesanan
				$output = $journal_pembatalan();
				break;
			
			default:
				# code...
				break;
		}
		/*========== END OF EXTRACT ==============*/

		return $output;
	}

	public function saveextract() {
		/*---------- Block Save Penyusutan----------*/
		$save_detail_penyusutan = function($record, $journalid) {
			$output = 0;
			$query = $this->db->select('akunbiaya, accakumulasi, nilaibuku')->from('fixedasset')->where('noid',$record->linkid)->get();
			$linkacc = $query->result_array()[0];
			
			//Insert Journal Detail
			$this->table = 'journaldetil';
			$data = array();
			for ($i=1; $i <= 2; $i++) { 
			 	$row = array();
			 	$row['indexvalue'] = $i;
			 	$row['journalId'] = $journalid;
			 	$row['debitacc'] = ($i == 1) ? 1 : 0;
			 	$row['amount'] = $record->dueamount;
			 	$row['remark'] = $record->journalremark;
			 	$row['rekid'] = ($i == 1) ? $linkacc['akunbiaya'] : $linkacc['accakumulasi'];
			 	$data[] = $row;
			};
			$this->insert_batch($data);
			$this->table = 'journal';
			$output = 1;

			//Insert Penyusutan
			$data = array();
			$this->table = 'susutfixasset';
			$data['bulansusut'] = $record->bulan;
			$data['tahunsusut'] = $record->tahun;
			$data['noaktiva'] = $record->linkid;
			$data['penyusutan'] = $record->dueamount;
			$data['tglpenyusutan'] = $record->journaldate;
			$data['nilaibuku'] = (float) $linkacc['nilaibuku'] - (float) $record->dueamount;
			$this->insert($data);
			$output = 1;

			//Update FixedAsset
			$this->db->set('akumpenyusutan',"akumpenyusutan + {$record->dueamount}",FALSE)
					 ->set('nilaibuku',"nilaibuku - {$record->dueamount}",FALSE)
					 ->set('bulanproses',$record->bulan)
					 ->set('tahunproses',$record->tahun)
					 ->set('tanggalproses',date("Y-n-j"))
					 ->where('noid',$record->linkid)	
					 ->update('fixedasset');
			$output = 1;

			$this->resetVar();
			return $output;
		}; //End Of Save Penyusutan

		//*---------- Block Save Detail Akad----------*/
		$save_detail_akad = function($record, $journalid) {
			$journal = $this->getdetail_akad($record->linkid);
			$data = array();
			$no = 0;
			$output = 0;

			//Insert Journal Detail
			$this->table = 'journaldetil';
			foreach ($journal as $value) {
				$value = (object) $value;
				$row = array();
				$no++;
			 	$row['indexvalue'] = $no;
			 	$row['journalId'] = $journalid;
			 	$row['debitacc'] = $value->debitacc;
			 	$row['amount'] = ($value->debitacc == 1) ? $value->debit : $value->credit;
			 	$row['remark'] = $record->journalremark;
			 	$row['rekid'] = $value->rekid;
			 	$data[] = $row;
			}
			$this->insert_batch($data);

			//Update Pemesanan
			$this->db->set('statustransaksi',3)
					 ->set('Prosesakadkb',2)
					 ->where('noid',$record->linkid)	
					 ->update('pemesanan');
			$output = 1;
			return $output;
		}; //End Of Save Detail Akad

		//*---------- Block Save Detail Kasbank----------*/
		$save_detail_kasbank = function($record, $journalid) {
			$journal = $this->getdetail_kasbank($record->linkid);
			$data = array();
			$no = 0;
			$output = 0;

			//Insert Journal Detail
			$this->table = 'journaldetil';
			foreach ($journal as $value) {
				$value = (object) $value;
				$row = array();
				$no++;
			 	$row['indexvalue'] = $no;
			 	$row['journalid'] = $journalid;
			 	$row['debitacc'] = $value->debitacc;
			 	$row['amount'] = ($value->debitacc == 1) ? $value->debit : $value->credit;
			 	$row['remark'] = $value->remark;
			 	$row['rekid'] = $value->rekid;
			 	$data[] = $row;
			}
			$this->insert_batch($data);

			//Update Status Kasbank
			$this->db->set('statusverifikasi',5)
					 ->where('noid',$record->linkid)	
					 ->update('kasbank');
			$output = 1;
			return $output;
		}; //End Of Save Detail Kasbank

		//*---------- Block Save Detail Pembatalan----------*/
		$save_detail_pembatalan = function($record, $journalid) {
			$journal = $this->getdetail_pembatalan($record->linkid);
			$data = array();
			$no = 0;
			$output = 0;

			//Insert Journal Detail
			$this->table = 'journaldetil';
			foreach ($journal as $value) {
				$value = (object) $value;
				$row = array();
				$no++;
			 	$row['indexvalue'] = $no;
			 	$row['journalid'] = $journalid;
			 	$row['debitacc'] = $value->debitacc;
			 	$row['amount'] = ($value->debitacc == 1) ? $value->debit : $value->credit;
			 	$row['remark'] = $record->journalremark;
			 	$row['rekid'] = $value->rekid;
			 	$data[] = $row;
			}
			$this->insert_batch($data);

			//Update Status Kasbank
			$this->db->set('kodeupdatedgl','C')
					 ->where('noid',$record->linkid)	
					 ->update('pembatalan');
			$output = 1;
			return $output;
		}; //End Of Save Detail Pembatalan

		$list = json_decode($this->input->post('record'));
		$no = 0;
		$parameter = $this->getLastjournalNo($list[0]->journalgroup);
		foreach ($list as $key => $value) {
			$journalNo = self::groupCode[$value->journalgroup].'-'.str_pad($parameter->autoNumber+$no,6,'0',STR_PAD_LEFT);
			$hasil = 0;

			$colinsert = array();
			$colinsert['bulan'] = $value->bulan;
			$colinsert['tahun'] = $value->tahun;
			$colinsert['journalgroup'] = $value->journalgroup;
			$colinsert['autonum'] = $parameter->autoNumber+$no;
			$colinsert['journalno'] = $journalNo;
			$colinsert['journaldate'] = $value->journaldate;
			$colinsert['journalremark'] = $value->journalremark;
			$colinsert['dueamount'] = $value->dueamount;
			$colinsert['dateofposting'] = date("Y-n-j");
			$colinsert['status'] = 0;
			
			//Insert Journal Header
			$this->table = 'journal';
			$lastid = $this->insert($colinsert);
			//$lastid = 10;
			if ($lastid > 0) {
				switch ($value->journalgroup) {
					case 2: //Akad Jual-Beli
						$hasil = $save_detail_akad($value, $lastid);
						break;
					case 4: //Kas-Bank
						$hasil = $save_detail_kasbank($value, $lastid);
						break;
					case 5: //Penyusutan
						$hasil = $save_detail_penyusutan($value, $lastid);
						break;
					case 6: //Pembatalan Pesanan
						$hasil = $save_detail_pembatalan($value, $lastid);
						break;
					default:
						# code...
						break;
				}
			}
			$no++;
		}
		//return $hasil;
		return ($hasil == 1) ? 'OK' : 'error';
	}
}

?>	