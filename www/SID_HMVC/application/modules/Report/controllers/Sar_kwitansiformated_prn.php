<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sar_kwitansiformated_prn extends MX_Controller {

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
		$dataheader = "";
        $data = "
        	<div class='kwitansibody padding-15mm'>
	        	<div class='row'>
	        		<div class='col-offset-3 col-3 value'>{$kwitansi->nokwitansi}</div>
	        		<div class='col-offset-3 col-3 value'>".date_format(date_create($kwitansi->tglbayar), "d-M-Y")."</div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-12 caption inline'></div>
	        	</div>
	        	<div class='row'>
	        		<div class='col-offset-3 col-9 value'>{$kwitansi->namapemesan}</div>
	        	</div>
	        	<div class='row'>	        		
					<div class='col-offset-3 col-9 value'>{$kwitansi->alamatpemesan}</div>
					<div class='col-offset-3 col-9 value inline'></div>
	        	</div>
	        	<div class='row'>	        		
	        		<div class='col-offset-3 col-9'>
	        		<div class='boxterbilang1'>
	        			<span class='textterbilang'>// ".$this->sidlib->terbilang($kwitansi->totalbayar)." Rupiah //</span>
	        		</div>
	        		</div>
	        	</div>
	        	<div class='row'>	        		
					<div class='col-offset-3 col-9 value'>{$kwitansi->keterangan}</div>
					<div class='col-offset-3 col-9 value inline'></div>
					<div class='col-offset-3 col-9 value inline'></div>
	        	</div>
	        	<div class='row'>	        		
					<div class='col-offset-3 col-9 value'>{$kwitansi->bank}</div>
					<div class='col-offset-3 col-9 value inline'></div>
	        	</div>
	        	<div class='row'>
		        		<div class='col-8'>		        			
			        		<div class='col-offset-4 col-7'>
			        		<div class='boxterbilang1'>
			        			<span class='textterbilang'>Rp. ".$this->sidlib->my_format($kwitansi->totalbayar).",-</span>
			        		</div></div>
		        		</div>
		        		<div class='col-4'>
			        		<div class='col-12 caption text-center'><br/><br/><br/></div>
			        		<div class='col-12 value text-center'>({$kwitansi->namapemesan})</div>
			        	</div>
	        	</div>
        	</div>
        	";
        $data .= "
        	<div class='row'>
        		
        	</div>
        	<div class='row'>
        		
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
