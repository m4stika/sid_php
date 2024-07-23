<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_kwitansiblank_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();		
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Pemasaran_model','report_model');
	}

	public function index() {
		$kwitansi = $this->report_model->get_Printkwitansi();
		$parameter = $this->report_model->get_parameter();
		$caption = 'KUITANSI';
		$orientation = 'A5 landscape';
		$source = base_url()."assets/pages/img/logo-harmony2.png";
		$dataheader = 
        	"
	            <div class='page-logo'>
	                <img alt='' src='{$source}' />
	            </div>
	            <div class='page-title'>
	                <p class='kwitansi'>{$parameter->company}</p>
	            </div>
	            <br/>
            ";
        $data = "
        	<div class='titlekwitansi'>KUITANSI</div>";
        $data .= "
        	<div class='kwitansibody'>
	        	<div class='row'>
	        		<div class='col-3 caption'>Nomor</div>
	        		<div class='col-3 valueunderline'>{$kwitansi->nokwitansi}</div>
	        		<div class='col-offset-1 col-2 caption'>Tanggal</div>
	        		<div class='col-3 valueunderline'>".date_format(date_create($kwitansi->tglbayar), "d-M-Y")."</div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-12 caption'>Telah Terima Dari</div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-3 caption'>Nama</div>
	        		<div class='col-9 valueunderline'>{$kwitansi->namapemesan}</div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-3 caption'>Alamat</div>
					<div class='col-9 valueunderline'>{$kwitansi->alamatpemesan}</div>
					<div class='col-offset-3 col-9 valueunderline inline'></div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-3 caption'>Terbilang</div>
	        		<div class='col-9 boxterbilang'><span class='textterbilang'>//".$this->sidlib->terbilang($kwitansi->totalbayar)." Rupiah //</span></div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-3 caption'>Untuk Pembayaran</div>
					<div class='col-9 valueunderline'>{$kwitansi->keterangan}</div>
					<div class='col-offset-3 col-9 valueunderline inline'></div>
					<div class='col-offset-3 col-9 valueunderline inline'></div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-3 caption'>Keterangan</div>
					<div class='col-9 valueunderline'>{$kwitansi->bank}</div>
					<div class='col-offset-3 col-9 valueunderline inline'></div>
	        	</div>
	        	<div class='row'>
		        		<div class='col-8'>
		        			<span class='col-4 caption'>Terbilang<br/></span>
			        		<div class='col-7 boxterbilang'><span class='textterbilang'>Rp. ".$this->sidlib->my_format($kwitansi->totalbayar).",-</span></div>
		        		</div>
		        		<div class='col-4'>
			        		<div class='col-12 caption text-center'>Yang Menerima<br/><br/><br/></div>
			        		<div class='col-12 valueunderline text-center'>({$kwitansi->namapemesan})</div>
			        	</div>
	        	</div>
        	</div>
        	";
        $data .= "
        	<div class='row footerkwitansi'>
        		<div class='col-12'>
        			<div class='col-6'>
        				<p>Kantor Proyek : </p>
        				<p>Jl. Prof Suharso Tembalang Kota Semarang</p>
        				<p>Telp. (024) 76581122, Fax. (024) 76581122 </p>
        			</div>
        			<div class='col-6 text-center'>
        				<p>HARMONI GROUP</p>
        				<p>Kantor Pusat : Jl. Bukit Cinere, Komp. Perum Graha Bukit</p>
        				<p>Kav. No.9 Cinere Kota Depok</p>
        				<p>Telp. 021 7532364, Fax. 021 7532376</p>
        			</div>
        		</div>
        	</div>
        	<div class='row kwitansilampiran'>
        		<p>1. Lembar putih untuk konsumen</p>
		        <p>2. Lembar merah untuk keuangan</p>
		        <p>3. Lembar biru untuk pemasaran</p>
        	</div>
        	";
	
	$data = array('title'		=> $caption,
					  'record'		=> $data,
					  'header'=>$dataheader,
					  'orientation' => $orientation
					  );
		$this->load->view('Report/laporan_print',$data);
    }
}	
