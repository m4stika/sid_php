<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kb_buktitransaksi_prn extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Sidlib','sidlib');
		$this->load->model('Kasbank_model','report_model');
	}

	public function index() {
		//$header = array('ID', 'Type','Harga Jual', 'Booking Fee', 'Diskon', 'Uang Muka','Plafon KPR','Sudut', 'Hadap Jalan','Fasum');
		$KBHeader = $this->report_model->get_KasbankHeader();
		// echo $this->input->post('linkid');
		$parameter = $this->report_model->get_parameter();
		//$dataheader = $this->sidlib->setHeader_prn($parameter);
		$caption = 'Bukti Transaksi Kasbank';
		$judul = ($KBHeader->kasbanktype == 0 | $KBHeader->kasbanktype == 2) ? "BUKTI PENERIMAAN" : "BUKTI PENGELUARAN";
		$orientation = 'A4';

		$dataheader = "
			<div class='row'>
				<div class='page-title-kb'>
					<div class='col-4'>
		        		<p class=''>{$parameter->company}</p>
				        <p>{$parameter->address}</p>
				        <p>{$parameter->city}</p>
				    </div>
				    <div class='col-4'>
				    	<p class=' title'>{$judul}</p>
				    	<p class=' subtitle'>{$KBHeader->namabank}</p>
				    </div>
				    <div class='col-4'>
				    	<div class='col-12'>
					    	<span class='caption'>No. Bukti : </span>
					    	<span class='value'>{$KBHeader->nojurnal}</span>
				    	</div>
				    	<div class='col-12 footer'>
					    	<span class='caption'>No. Cek : </span>
					    	<span class='value'>{$KBHeader->nomorcek}</span>
				    	</div>
				    </div>
				</div>
        	</div>
        	<hr>
        	";


		$data = "<table class='{$orientation}'>
				<thead class='nobgcolor'>
					<tr>
	        			<th colspan='4' class='text-left'>Terima Dari</th>
	        		</tr>
	        		<tr>
	        			<th colspan='2' width='70%' class='terbilang text-left'>Terbilang : // ".$this->sidlib->terbilang($KBHeader->totaltransaksi)." //</th>
	        			<th colspan='2' width='30%' class='terbilang'>RP : ".$this->sidlib->my_format($KBHeader->totaltransaksi)."</th>
	        		</tr>
	        		<tr>
	        			<th width='5%'>No</th>
	        			<th width='50%'>Uraian</th>
	        			<th width='20%'>Perkiraan</th>
	        			<th width='20%'>Nilai</th>
	        		</tr>
	        	</thead>
        		";
        $buktitransaksi = $this->report_model->get_Buktitransaksi_KB();
        $i = 0;
        $data .= "<tbody>";
        foreach($buktitransaksi as $value) {
	        $i++;
	        $data .= "
	        		<tr>
	        			<td class='text-center'>{$i}</td>
	        			<td>{$value->remark}</td>
	        			<td class='text-center'>{$value->accountno}</td>
	        			<td class='text-right'>".$this->sidlib->my_format($value->amount)."</td>
	        		</tr>
	        	";
    	}
    	$data .= "</tbody>";

        $data .= "</table>";
        $data .= "
        		<div class='row'>
        			<div class='text-right'>{$parameter->city}, ".date_format(date_create(), "d-M-Y")."</div>
        		</div>
        		<div class='row'>
        			<div class='col-12 text-center'>
        				<div class='col-4 assign'>
        					<p>Disetujui Oleh,</p>
        					<p class='footer1 center underline'>{$parameter->pimpinan}</p>
        					<p class='footer center'>{$parameter->pimpinantitle}</p>
        				</div>
        				<div class='col-4 assign'>
        					<p>Diperiksa Oleh,</p>
        					<p class='footer1 center underline'>{$parameter->accounting}</p>
        					<p class='footer center'>{$parameter->accountingtitle}</p>
        				</div>
        				<div class='col-4 assign'>
        					<p>Dibuat Oleh,</p>
        					<p class='footer1 center underline'>{$parameter->kasir}</p>
        					<p class='footer center'>{$parameter->kasirtitle}</p>
        				</div>
        			</div>
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
