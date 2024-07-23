<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class Pembayaran extends MY_Controller
{	
	public function __construct()
	{
		parent::__construct();		
		$this->load->model('pembayaran_model');
	}

	public function index($id = null, $induk = null) {		
		//$this->load->module('kasbank/kasbank');
		//$optionbank = $this->kasbank->get_banklist();
		$optionbank =  Modules::run('Kasbank/kasbank/get_banklist');// $this->get_pemesananlist();$this->get_banklist();
		//modules::run('module_name/method_name',$data); 
		
		$optionpemesan = Modules::run('Pemasaran/pemesanan/get_pemesananlist');// $this->get_pemesananlist();
		$data = array(				
				'title'		=> 'SID | Kwitansi',
				'page' 		=> 'pemasaran', 
 				'content'	=> 'kwitansi', 	
 				'optionpembayaran' => $optionpemesan,
 				'optionbank' => $optionbank,
 				'dataparent' => array("id" => $id, "induk" => $induk),
 				'isi' 		=> 'Pemasaran/pembayaran_page'
 			);
	 	$this->template->admin_template($data);	 	
	}

	public function getform_pembayaran()
	{
		$optionpemesan = Modules::run('Pemasaran/pemesanan/get_pemesananlist');// $this->get_pemesananlist();
		$optionbank =  Modules::run('Kasbank/kasbank/get_banklist');
		$data = array('optionpembayaran' => $optionpemesan,
					  'optionbank' => $optionbank,	
					  'judul' => 'pembayaran' 	
				 );

		return $this->load->view('pemasaran/pembayaran_form',$data); 
		//echo json_encode($this->load->view('pemasaran/pembayaran_form',$data));
	}

	public function getform_kwitansi()
	{
		$data = array('judul' => 'pembayaran' 	
				 );

		return $this->load->view('Pemasaran/kwitansi_form',$data); 
	}

	public function payment_history()
	{
		$idwhere = array('idpemesanan' => $_POST['idpemesanan'], 'statusbatal' => 0);
		$list = $this->pembayaran_model->get_history($idwhere);
		$data = array();
		$no = 0;
		//echo $list; die;
		foreach ($list as $value) {
			$no++;
			$ResultData = array();
			$ResultData[] = $no;
			$ResultData[] = $value->noid;
			$ResultData[] = $value->tglbayar;
			$ResultData[] = $value->keterangan;
			$ResultData[] = $value->description;
			$ResultData[] = $value->totalbayar;
			($value->kodeupdated == 'O') ? $ResultData[] = 'Open' : $ResultData[] = 'Closed';

			$data[] = $ResultData;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->pembayaran_model->count_all($idwhere),
						"recordsFiltered" => $this->pembayaran_model->count_filtered($idwhere),
						"data" => $data
				);

		$this->pembayaran_model->reset_param();

		//output to json format
		echo json_encode($output);
	}

	private function payment_validated()
	{				
		//$config = array(
			$config = array(
				array(
					'field' => 'tglpembayaran',
					'label' => 'Tgl Bayar',
					'rules' => 'required',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						)
					),
				array(
					'field' => 'nobukti',
					'label' => 'No. Bukti',
					'rules' => 'required',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						)
					),
				array(
					'field' => 'total',
					'label' => 'Total Bayar',
					'rules' => 'required',
					'errors' => array(
						'required' => 'anda harus mengisi item %s.',
						)
					)
				); 
		//);
		
		$this->form_validation->set_rules($config); 

		if ($this->form_validation->run() == FALSE) {
			//echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
			return false;
		} else {		
			return true;
		}

	}

	public function save_payment()
	{
		if ($this->payment_validated() == false) {
			echo json_encode(array("status" => FALSE, 'data' => validation_errors()));
		} else {
			$output = $this->pembayaran_model->save_kwitansi();
			echo json_encode(array("status" => $output, 'data' => 'sukses'));
			return false;
		}
	}

	public function kwitansiHeaderDetail() {
		$jenis = array(0=>"Penerimaan Booking Fee", "Penerimaan Uang Muka", "Penerimaan Kelebihan Tanah", "Penerimaan Sudut", "Penerimaan Hadap Jalan", "Penerimaan Uang Muka", "Penerimaan Fasum", "Penerimaan Redesign", "Penerimaan Penambahan Kwalitas", "Penerimaan Penambahan Kontruksi", "Penerimaan Uang Muka", "Penerimaan Angsuran");
		$header = $this->pembayaran_model->get_kwitansiHeader($_POST['noid']);
		$header['totalterbilang'] = '// '.$this->pembayaran_model->terbilang($header['totalbayar']).' Rupiah //';
		$header['totalbyr'] = 'Rp. '.number_format($header['totalbayar'], 0, ',','.').',-';
		$detail = $this->pembayaran_model->get_kwitansiDetail($_POST['noid']);
		$data = array();
		$no = 0; //$_POST['start'];
        foreach ($detail as $value) {
            $no++;
            $row = array();
			//($value->statusverifikasi < 3) ? $row[] = $this->template->add_dropdown(0,$no) : $row[] =  $this->template->add_dropdown(1,$no);
			$row[] = $no;//($_POST['crud'] == 'edit') ? "<a class='lock label label-danger' data-value=''>lock</a>" : "<a class='delete label label-info' data-value=''>delete</a>"; 
			$row[] = $jenis[$value->jenispenerimaan];
			$row[] = $value->keterangan;
			$row[] = $value->jumlahbayar;
			$data[] = $row;
		}
		$output = array("kwitansiDetail" => $data, "kwitansiHeader" => $header);
		
		//output to json format
		echo json_encode($output);
	}

	public function save_PembatalanKwitansi() {
		$hasil = $this->pembayaran_model->save_batalkwitansi();
		echo json_encode($hasil);
	}


	public function print_kwitansi() {
		
		$output = $this->pembayaran_model->get_kwitansi($_POST['noid']);
		$output['totalterbilang'] = '// '.$this->pembayaran_model->terbilang($output['totalbayar']).' Rupiah //';
		$output['totalbayar'] = 'Rp. '.number_format($output['totalbayar'], 0, ',','.').',-';
		echo json_encode($output);
	}
}