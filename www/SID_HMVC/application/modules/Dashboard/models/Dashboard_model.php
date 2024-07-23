<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//'Open', 'Lock', 'Akad Kredit', 'Closed', 'Cancel'

class Dashboard_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();	
	}

	public function getkontrak($search = "") {
		$this->db->select('noid, nopesanan, namapemesan, typerumah, hargajual');
		//$this->db->where('classacc !=',0);
		if ($search != "") {
			$this->db->group_start();
			$this->db->like('nopesanan',$search);
			$this->db->or_like('namapemesan',$search);
			$this->db->group_end();
		}
		$this->db->order_by('namapemesan','asc');
		$this->db->limit(20);
		$query = $this->db->get('vpemesanan');
		return $query->result();
	}

	public function getkwitansi($search = "") {
		$this->db->select('noid, idpemesanan, namapemesan, nokwitansi, totalbayar');
		//$this->db->where('classacc !=',0);
		if ($search != "") {
			$this->db->group_start();
			$this->db->like('nokwitansi',$search);
			$this->db->or_like('namapemesan',$search);
			$this->db->group_end();
		}
		$this->db->order_by('nokwitansi','asc');
		$this->db->limit(20);
		$query = $this->db->get('vkwitansi');
		return $query->result();
	}

	public function getjournal($search = "") {
		$this->db->select('journalid, bulan, tahun, journalno, journalremark, dueamount');
		//$this->db->where('classacc !=',0);
		if ($search != "") {
			$this->db->group_start();
			$this->db->like('journalno',$search);
			$this->db->or_like('journalremark',$search);
			$this->db->group_end();
		}
		$this->db->order_by('journalno','asc');
		$this->db->limit(20);
		$query = $this->db->get('journal');
		return $query->result();
	}

	public function getkasbank($search = "") {
		$this->db->select('noid, kasbanktype, nojurnal, uraian, totaltransaksi');
		if ($search != "") {
			$this->db->group_start();
			$this->db->like('nojurnal',$search);
			$this->db->or_like('uraian',$search);
			$this->db->group_end();
		}
		$this->db->order_by('noid','asc');
		$this->db->limit(20);
		$query = $this->db->get('vkasbank');
		return $query->result();
	}

	public function getperkiraankb($search = "") {
		$this->db->select('rekid, parentkey, keyvalue, accountno, description');
		$this->db->where('left(parentkey,5)','10101');
		$this->db->or_where('left(parentkey,5)','10102');
		if ($search != "") {
			$this->db->group_start();
			$this->db->like('description',$search);
			$this->db->or_like('accountno',$search);
			$this->db->group_end();
		}
		$this->db->order_by('accountno','asc');
		$this->db->limit(20);
		$query = $this->db->get('perkiraan');
		return $query->result();
	}

	public function getperkiraan($search = "") {
		$this->db->select('rekid, parentkey, keyvalue, accountno, description');
		if ($search != "") {
			$this->db->group_start();
			$this->db->like('description',$search);
			$this->db->or_like('accountno',$search);
			$this->db->group_end();
		}
		$this->db->order_by('accountno','asc');
		$this->db->limit(20);
		$query = $this->db->get('perkiraan');
		return $query->result();
	}
}	