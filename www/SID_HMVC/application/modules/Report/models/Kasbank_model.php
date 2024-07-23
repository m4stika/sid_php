<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasbank_model extends Base_model {
	function __construct()
    {
        parent::__construct();
    }

    function get_SaldoawalKB($rekid)
	{
		$this->db->select('ifnull(saldoakhir,0) as saldoakhir')
				 ->where('rekid', $rekid)
				 ->where('tanggal <=', $this->input->post('periode'))
				 ->order_by('tanggal','desc')
				 ->limit(1);
		$query = $this->db->get('bukuharian');
		if ($query->num_rows() > 0) {$hasil = $query->row()->saldoakhir;}
		else {$hasil = 0;}

		return $hasil;
	}

	function get_KasbankHeader()
	{
		$query = $this->db->select('noid, kasbanktype, nojurnal, nomorcek, tglentry, description as namabank, totaltransaksi', FALSE)
				->where('noid', $this->input->post('linkid'))
				->get('vkasbank');
		return $query->row();
	}

	function get_Buktitransaksi_KB()
	{
		$query = $this->db->select('remark, accountno, description, amount', FALSE)
				->where('idkasbank', $this->input->post('linkid'))
				->get('vrinciankasbank');
		return $query->result();
	}

	function get_AccountHeader()
	{
		$this->db->select('rekid, classacc, parentkey, keyvalue, accountno, description');
		// $this->db->where_in('rekid', array(31,743));
		$this->db->where_in('rekid', array(10,11));
		$this->db->order_by('accountno','asc');
		$query = $this->db->get('perkiraan');
		return $query->result();
	}

	function get_RekapKasbankHeader($parentkey, $haslinkid)
	{
		//$this->db->distinct('rekid, parentkey, keyvalue, accountno, description');
		$this->db->select('rekid, kasbanktype, parentkey, keyvalue, accountno, description');
		if ($haslinkid == 0) {
			$this->db->where('parentkey', $parentkey);
		} else {
			$this->db->where('rekid', $this->input->post('linkid'));
		}

		$this->db->group_by('rekid, kasbanktype, parentkey, keyvalue, accountno, description');
		$this->db->order_by('accountno, kasbanktype','asc');
		$query = $this->db->get('vkasbank');
		return $query->result();
	}

	function get_RekapKasbankDetil($rekid, $kasbanktype)
	{
		$this->db->select('r.accountno, r.description, r.amount');
		$this->db->from('vrinciankasbank r');
		$this->db->join('kasbank k','k.noid = r.idkasbank');
		$this->db->where('k.rekid', $rekid);
		$this->db->where('k.kasbanktype', $kasbanktype);
		$this->db->where('k.tglentry >=', $this->input->post('periode'));
		$this->db->where('k.tglentry <=', $this->input->post('periode1'));
		$this->db->order_by('k.kasbanktype, r.accountno','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_RekapPerkodeakunDetil($rekid, $kasbanktype)
	{

		$this->db->select('r.accountno, r.description, sum(r.amount) as amount')
				 ->from('vrinciankasbank r')
				 ->join('kasbank k','k.noid = r.idkasbank')
				 ->where('k.rekid', $rekid)
				 ->where('k.kasbanktype', $kasbanktype)
				 ->where('k.tglentry >=', $this->input->post('periode'))
				 ->where('k.tglentry <=', $this->input->post('periode1'))
				 ->group_by('r.accountno, r.description')
				 ->order_by('k.kasbanktype, r.accountno','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_infobukuharian() {
		$this->db->select('rekid, classacc, levelacc, parentkey, keyvalue, accountno, description, 0 as saldoawal, 0 as debet, 0 as kredit, 0 as saldoakhir')
				//  ->where_in('rekid', array(31,743))
				 ->where_in('rekid', array(10,11))
				 ->or_where('classacc', 2)
				//  ->where('classacc', 2)
				 ->order_by('accountno','asc');
		$query = $this->db->get('perkiraan');
		$account = $query->result();
		// echo json_encode($account);


		$getMutasi = function($rekid) {
			$this->db->select('sum(mutasidebet) as debet, sum(mutasikredit) as kredit')
				 ->where('rekid', $rekid)
				 ->where('tanggal >=', $this->input->post('periode'))
				 ->where('tanggal <=', $this->input->post('periode1'));
			$query = $this->db->get('bukuharian');
			return $query->row();
		};



		$accountHeader = array("kas"=>array("index"=>-1, "keyvalue"=>""),
							   "bank"=>array("index"=>-1, "keyvalue"=>"")
								);
		$indexbank = -1;
		foreach ($account as $key => $value) {
			if ($value->classacc == 0) {
				// if ($value->rekid == 31) {
				if ($value->rekid == 10) {
					$accountHeader['kas']['index'] = $key;
					$accountHeader['kas']['keyvalue'] = $value->keyvalue;
				} else {
					$accountHeader['bank']['index'] = $key;
					$accountHeader['bank']['keyvalue'] = $value->keyvalue;
				}
				continue;
			}
			$account[$key]->saldoawal = $this->get_SaldoawalKB($value->rekid);
			$mutasi = $getMutasi($value->rekid);

			$account[$key]->debet = $mutasi->debet;
			$account[$key]->kredit = $mutasi->kredit;
			$account[$key]->saldoakhir = $account[$key]->saldoawal + $mutasi->debet - $mutasi->kredit;

			if ($value->parentkey == $accountHeader['kas']['keyvalue']) {
				$account[$accountHeader['kas']['index']]->saldoawal += $account[$key]->saldoawal;
				$account[$accountHeader['kas']['index']]->debet += $account[$key]->debet;
				$account[$accountHeader['kas']['index']]->kredit += $account[$key]->kredit;
				$account[$accountHeader['kas']['index']]->saldoakhir += $account[$key]->saldoakhir;
			} else {
				$account[$accountHeader['bank']['index']]->saldoawal += $account[$key]->saldoawal;
				$account[$accountHeader['bank']['index']]->debet += $account[$key]->debet;
				$account[$accountHeader['bank']['index']]->kredit += $account[$key]->kredit;
				$account[$accountHeader['bank']['index']]->saldoakhir += $account[$key]->saldoakhir;
			}
		}

		return $account;
	}

	function get_lapbukuharianHeader($rekid)
	{
		$this->db->select('noid, kasbanktype, nokasbank, nojurnal, tglentry, uraian, case when kasbanktype in (0,2) then totaltransaksi else 0 end as penerimaan, case when kasbanktype in (1,3) then totaltransaksi else 0 end as pengeluaran')
				 ->where('rekid', $rekid)
				 ->where('tglentry >=', $this->input->post('periode'))
				 ->where('tglentry <=', $this->input->post('periode1'))
				 ->order_by('tglentry','asc');
		$query = $this->db->get('vkasbank');
		return $query->result();
	}

	function get_lapbukuharianDetil($noid)
	{
		$this->db->select('accountno, remark, amount')
				 ->where('idkasbank', $noid)
				 ->order_by('indexvalue','asc');
		$query = $this->db->get('vrinciankasbank');
		return $query->result();
	}

	function get_chartofaccount() //($limit, $start)
	{
		$this->db->select('accountno, description, openingbalance, case when debitacc = 1 then transbalance else 0 end as debet, case when debitacc = 1 then transbalance else 0 end as kredit, balancedue, rekid, keyvalue,  classacc, levelacc', FALSE)
				 ->order_by('keyvalue','asc');
				 //->limit($limit, $start);
		$query = $this->db->get('perkiraan');
		return $query->result();
	}
}
?>