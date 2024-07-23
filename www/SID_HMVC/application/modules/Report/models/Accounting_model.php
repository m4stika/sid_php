<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounting_model extends Base_model {
	function __construct()
    {
        parent::__construct();
    }

	function get_chartofaccount() //($limit, $start)
	{
		$this->db->select('accountno, description, openingbalance, case when debitacc = 1 then transbalance else 0 end as debet, case when debitacc = 1 then transbalance else 0 end as kredit, balancedue, rekid, keyvalue,  classacc, levelacc', FALSE)
				 ->order_by('keyvalue','asc');
				 //->limit($limit, $start);
		$query = $this->db->get('perkiraan');
		return $query->result();
	}



	function get_GLjournalHeader()
	{
		$this->db->select('journalid, journaldate, journalno, journalremark, dueamount')
				 ->where('bulan', $this->input->post('bulan'))
				 ->where('tahun', $this->input->post('tahun'));
		if ($this->input->post('groupby') >= 0)	{
			$this->db->where('journalgroup', $this->input->post('groupby'));
		}
		$this->db->order_by('journaldate, journalno','asc');
		$query = $this->db->get('journal');
		return $query->result();
	}

	function get_GLjournalDetil($journalid)
	{
		$this->db->select('accountno, description, case when debitpos = 1 then amount else 0 end as debit, case when debitpos = 0 then amount else 0 end as credit', FALSE)
				 ->where('journalid', $journalid)
				 ->order_by('indexvalue','asc');
		$query = $this->db->get('vjournaldetail');
		return $query->result();
	}

	function get_GLbukubesar($parentkey)
	{
		$this->db->select('v.accountno, v.parentkey, v.keyvalue, v.description, v.journaldate, v.remark,
					Case When v.debitpos = 1 Then case when v.classacc = 0 then 0 else v.amount end else 0 end as debit,
					Case When v.debitpos = 0 Then case when v.classacc = 0 then 0 else v.amount end else 0 end as credit,
					v.debitpos, v.debitacc, p.accountno as parentaccountno, p.description as parentdescription,
					v.journalno, ifnull(b.saldoawal,0) as saldoawal, ifnull(b.saldoakhir,0) as saldoakhir', FALSE)
				 ->from('vjournaldetail v')
				 ->join('perkiraan p','p.keyvalue = v.parentkey')
				 ->join('bukubesar b','b.rekid = v.rekid and b.bulanbuku = 3 and b.tahunbuku = 2017','left')
				 ->where('bulan', $this->input->post('bulan'))
				 ->where('tahun', $this->input->post('tahun'))
				 ->like('v.keyvalue',$parentkey,'after')
				 ->order_by(' v.ParentKey, v.KeyValue, v.JournalDate, v.DateofPosting','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_GLNeracaSaldo()
	{
		$this->db->select('tahunbuku*100+bulanbuku as bulantahun, groupacc, accountno, classacc, description,
							Sum(Case When classacc = 0 Then 0 else MutasiDebet end) as debit,
							Sum(Case When classacc = 0 Then 0 else MutasiKredit end) as credit ', FALSE)
				 ->from('vbukubesar v')
				 ->where('bulanbuku', $this->input->post('bulan'))
				 ->where('tahunbuku', $this->input->post('tahun'))
				 ->group_start()
				 ->where('levelacc',0)
				 ->or_where('classacc <>',0)
				 ->group_end()
				 ->group_by('classacc, groupacc, accountno, description')
				 ->order_by('accountno','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_GLNeracaLajur()
	{
		$this->db->select('tahunbuku*100+bulanbuku as bulantahun, groupacc, accountno, classacc, description,
						Sum(Case When classacc = 0 Then 0 else MutasiDebet end) as debit,
						Sum(Case When classacc = 0 Then 0 else MutasiKredit end) as credit,
						0 as debetadjust, 0 as kreditadjust,
						Sum(Case When (BalanceSheetAcc = 1) then
								Case when ClassAcc = 0 Then 0 else MutasiDebet end
							else 0 end) as debetneraca,
						Sum(Case When (BalanceSheetAcc = 1) then
								Case when ClassAcc = 0 Then 0 else MutasiKredit end
							else 0 end) as kreditneraca,
						Sum(Case When (BalanceSheetAcc = 0) then
								Case when ClassAcc = 0 Then 0 else MutasiDebet end
							else 0 end) as debetlabarugi,
						Sum(Case When (BalanceSheetAcc = 0) then
								Case when ClassAcc = 0 Then 0 else MutasiKredit end
							else 0 end) as kreditlabarugi', FALSE)
				 ->from('vbukubesar v')
				 ->where('bulanbuku', $this->input->post('bulan'))
				 ->where('tahunbuku', $this->input->post('tahun'))
				 ->group_start()
				 ->where('levelacc',0)
				 ->or_where('classacc <>',0)
				 ->group_end()
				 ->group_by('classacc, groupacc, accountno, description')
				 ->order_by('accountno','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_GLLabarugi()
	{
		$call_procedure ="CALL labarugi({$this->input->post('bulan')}, {$this->input->post('tahun')}, {$this->input->post('groupby')})";
    	$query = $this->db->query($call_procedure);
		//$query = $this->db->call_function("labarugi",$this->input->post('bulan'),$this->input->post('tahun'),6);
		return $query->result();
	}

	function get_GLNeraca()
	{
		$call_procedure ="CALL neraca({$this->input->post('bulan')}, {$this->input->post('tahun')}, {$this->input->post('groupby')})";
    	$query = $this->db->query($call_procedure);
		//$query = $this->db->call_function("labarugi",$this->input->post('bulan'),$this->input->post('tahun'),6);
		return $query->result();
	}

	function get_GLfixedasset()
	{
		$this->db->select('noid, namaaktiva, bulanperolehan, tahunperolehan, bulansusut, tahunsusut, usiaekonomis, totalharga, penyusutanbulan_I, penyusutanbulan_II, akumpenyusutan, nilaibuku', FALSE)
				 ->order_by('namaaktiva','asc');
		$query = $this->db->get('vfixedasset');
		return $query->result();
	}


}