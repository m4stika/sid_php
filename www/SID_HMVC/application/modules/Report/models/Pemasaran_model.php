<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pemasaran_model extends Base_model {
	function __construct()
    {
        parent::__construct();
    }

    function get_Sar_Hargajual() 
	{
		$query = $this->db->select('noid, typerumah, hargajual, bookingfee, diskon, uangmuka, plafonkpr, hargasudut, hargahadapjalan, hargafasum', FALSE)
				->order_by('noid', 'asc')
				->get('typerumah');
		return ($this->excel_output == 0) ? $query->result() : $query->result_array();
	}

	function get_Sar_Typerumah() 
	{
		$query = $this->db->select('noid, typerumah, keterangan, luasbangunan, luastanah, hargajual, bookingfee', FALSE)
				->order_by('noid', 'asc')
				->get('typerumah');
		return ($this->excel_output == 0) ? $query->result() : $query->result_array();
	}

	function get_Sar_DaftarKaryawan() 
	{
		$query = $this->db->select('noid, nama, alamat', FALSE)
				->order_by('noid', 'asc')
				->get('karyawan');
		
		return ($this->excel_output == 0) ? $query->result() : $query->result_array();
	}

	function get_Sar_Masterkavling() 
	{
		$this->db->select('noid, statusbooking, "" as statusbookingname, blok, nokavling, typerumah, luasbangunan, luastanah, kelebihantanah, sudut, hadapjalan, fasum', FALSE);
		if ($this->input->post('groupby') >= 0) {
			$this->db->where('statusbooking =', $this->input->post('groupby'));
		}
		
		$query = $this->db->order_by('statusbooking, blok', 'asc')
				->get('vmasterkavling');
		return ($this->excel_output == 0) ? $query->result() : $query->result_array();
	}

	function get_Sar_Kavlingpricelist() 
	{
		$this->db->select('noid, statusbooking, "" as statusbookingname, blok, nokavling, typerumah,  hargajual, diskon, hargakltm2, hargasudut, hargahadapjalan, hargafasum, totalharga, bookingfee, uangmuka', FALSE);
		if ($this->input->post('groupby') >= 0) {
			$this->db->where('statusbooking =', $this->input->post('groupby'));
		}
		
		$query = $this->db->order_by('statusbooking, blok', 'asc')
				->get('vmasterkavling');
		return ($this->excel_output == 0) ? $query->result() : $query->result_array();
	}

	function get_kontrak($noid = -1) 
	{
		$query = $this->db->select('*', FALSE)
				->where('noid', $noid)
				//->limit(1)
				->get('vpemesanan');
		return $query->row();
	}

	function get_kwitansi($noid = -1) 
	{
		$query = $this->db->select('nokwitansi, tglbayar, keterangan, description as bank, totalbayar', FALSE)
				->where('idpemesanan', $noid)
				->get('vkwitansi');
		return $query->result();
	}

	public function get_Printkwitansi() {
		$query = $this->db->select('noid, nokwitansi, tglbayar, namapemesan, alamatpemesan, alamatpemesan1, keterangan, description as bank, totalbayar', FALSE)
						->where('noid', $this->input->post('linkid'))
						->get('vkwitansi');
		return $query->row();
	}

	function get_dokumenpemesanan($noid = -1) 
	{
		$query = $this->db->select('namadokumen, status, tglpenyerahan', FALSE)
				->where('noidpemesanan', $noid)
				->get('vdokumenpemesanan');
		return $query->result();
	}

	function get_progreskpr($noid = -1) 
	{
		$query = $this->db->select('namaprogres, kelengkapan, tglprogres', FALSE)
				->from('progreskpr p')
				->join('masterprogreskpr m','m.noid = p.noidprogreskpr')
				->where('p.noidpemesanan', $noid)
				->get();
		return $query->result();
	}

	function get_penjualan() 
	{
		$query = $this->db->select('*', FALSE)
				->where('tgltransaksi >=', $this->input->post('periode'))
				->where('tgltransaksi <=', $this->input->post('periode1'))
				//->limit(1)
				->get('vpemesanan');
		return $query->result();
	}

	function get_RekapPenerimaanUang($orderby = 'jenispenerimaan, tglbayar') 
	{
		$query = $this->db->select('jenispenerimaan, namapenerimaan, tglbayar, count(*) as qty, sum(jumlahbayar) jumlahbayar', FALSE)
				->where('tglbayar >=', $this->input->post('periode'))
				->where('tglbayar <=', $this->input->post('periode1'))
				->group_by('jenispenerimaan, namapenerimaan, tglbayar')
				->order_by($orderby,'asc')
				->get('vrinciankwitansi');
		return $query->result();
	}

	function get_DaftarPenerimaanUang($orderby = 'jenispenerimaan, tglbayar') 
	{
		$query = $this->db->select('r.jenispenerimaan, r.namapenerimaan, r.tglbayar, r.nokwitansi, namapemesan, r.description, r.jumlahbayar', FALSE)
				->from('vrinciankwitansi r')
				->join('pemesanan m','m.noid = r.idpemesanan')
				->where('r.tglbayar >=', $this->input->post('periode'))
				->where('r.tglbayar <=', $this->input->post('periode1'))
				->order_by($orderby,'asc')
				->get();
		return $query->result();
	}

	function get_LapPembatalan() 
	{
		$query = $this->db->select('tglbatal, nopesanan, namapemesan, uangmuka, klt, sudut, hadapjalan, fasum, redesign, tambahkw, kerjatambah, hargadasar, totalpengembalian, uangmukabyr, kltbyr, sudutbyr, hadapjalanbyr, fasumbyr, redesignbyr, tambahkwbyr, kerjatambahbyr, totalhargabyr, totalbayartitipan', FALSE)
				->where('tglbatal >=', $this->input->post('periode'))
				->where('tglbatal <=', $this->input->post('periode1'))
				->order_by('tglbatal','asc')
				->get('vpembatalan');
		return $query->result();
	}

	function get_LapPembatalanKwitansi() 
	{
		$query = $this->db->select('tglbatal, nokwitansi, CONCAT("/",nopesanan) as nopesanan, namapemesan,  totaltransaksi', FALSE)
				->where('tglbatal >=', $this->input->post('periode'))
				->where('tglbatal <=', $this->input->post('periode1'))
				->order_by('tglbatal','asc')
				->get('vkwitansibtl');
		return ($this->excel_output == 0) ? $query->result() : $query->result_array();
	}

	function get_RekapitulasiUmurpiutang() 
	{
		$this->db->select('*', FALSE)
				->where('tgltransaksi >=', $this->input->post('periode'))
				->where('tgltransaksi <=', $this->input->post('periode1'));
			if ($this->input->post('groupby') >= 0) {
				$this->db->where('polapembayaran',$this->input->post('groupby'));
			}
		$query = $this->db->get('vpemesanan');
		return $query->result();
	}
}
?>